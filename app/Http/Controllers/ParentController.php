<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\ClassRoutine;
use App\Models\Feedback;
use App\Models\Holiday;
use App\Models\Notices;
use App\Models\Objection;
use App\Models\Parents;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ParentController extends Controller
{

    // public function view()
    // {
    //     $user = User::where('unique_id', Auth::id())->first();
    //     return view('dashboard.parent.parent-dash', compact('user'));
    // }

    public function view()
    {
        $parent = Auth::user();

        // Get parent's children (students)
        $parentid = auth()->user()->unique_id;
        $parent = Parents::where('parent_id', $parentid)->first();

        // Validate and get student IDs
        $childIds = [];
        if (!empty($parent->stu_id)) {
            $childIds = array_filter(explode(',', $parent->stu_id));
            $childIds = array_map('trim', $childIds); // Remove any whitespace
        }

        $children = [];

        foreach ($childIds as $childId) {
            $child = Student::where('stu_id', $childId) // Assuming you have a student relationship
                ->first();

            if ($child) {
                $children[] = $child;
            }
        }

        // Calculate dashboard metrics
        $childrenCount = count($children);


        $newobjectionCount = Objection::whereIn('student_id', collect($children)->pluck('stu_id'))
            ->where('created_at', '>', now()->subDays(7))
            ->count();


        // Calculate attendance percentage (average of all children)
        $attendancePercentage = 0;
        if ($childrenCount > 0) {
            $totalAttendance = 0;
            foreach ($children as $child) {
                $attendance = Attendance::where('student_id', $child->id)
                    ->whereMonth('date', now()->month)
                    ->count();
                $totalDays = now()->daysInMonth;
                $child->attendance = $totalDays > 0 ? round(($attendance / $totalDays) * 100) : 0;
                $totalAttendance += $child->attendance;
            }
            $attendancePercentage = round($totalAttendance / $childrenCount);
        }



        // Get recent notices (for all children)
        $recentNotices = Notices::whereJsonContains('audience', 'parents')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming holidays
        $upcomingHolidays = Holiday::where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        // Count upcoming events (holidays + any other events you might have)
        $upcomingEventsCount = $upcomingHolidays->count();

        return view('dashboard.parent.parent-dash', compact(
            'childrenCount',
            'newobjectionCount',
            'attendancePercentage',
            'upcomingEventsCount',
            'children',
            'recentNotices',
            'upcomingHolidays'
        ));
    }





    public function parentChildrenList()
    {
        $parentid = auth()->user()->unique_id;
        $parent = Parents::where('parent_id', $parentid)->first();

        // Validate and get student IDs
        $childIds = [];
        if (!empty($parent->stu_id)) {
            $childIds = array_filter(explode(',', $parent->stu_id));
            $childIds = array_map('trim', $childIds); // Remove any whitespace
        }

        $children = [];

        foreach ($childIds as $childId) {
            $child = Student::where('stu_id', $childId) // Assuming you have a student relationship
                ->first();

            if ($child) {
                $children[] = $child;
            }
        }
        return view('dashboard.parent.children-list', compact('children'));
    }

    public function parentnotice()
    {
        $notices = Notices::whereJsonContains('audience', 'parents')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dashboard.parent.notice', compact('notices'));
    }

    public function generalnotice()
    {
        $notices = Notices::whereJsonContains('audience', 'general')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dashboard.parent.notice', compact('notices'));
    }

    public function noticeview($id)
    {
        $notice = Notices::findOrFail($id);
        return view('dashboard.parent.noticeview', compact('notice'));
    }

    public function feedbackIndex()
    {
        $feedbacks = Feedback::where('role_type', 'parent')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        $branches = Branch::all();
        return view('dashboard.feedback', compact('feedbacks', 'branches'));
    }

    public function storeFeedback(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'type' => 'required|in:feedback,objection,suggestion',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        Feedback::create([
            'type' => $validated['type'],
            'role_type' => 'parent',
            'user_id' => auth()->id(),
            'branch_id' => auth()->user()->branch_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'branch_id' => $validated['branch_id'] ?? null,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Your ' . $validated['type'] . ' has been submitted!');
    }

    public function holidays(Request $request)
    {
        $query = Holiday::with('branch')
            ->orderBy('date', 'asc');

        // Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [
                $request->start_date,
                $request->end_date
            ]);
        }
        // If only start date is provided
        elseif ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        // If only end date is provided
        elseif ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // Apply branch filter
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // Apply recurring filter
        if ($request->filled('is_recurring') && in_array($request->is_recurring, ['0', '1'])) {
            $query->where('is_recurring', (bool)$request->is_recurring);
        }

        $holidays = $query->paginate(15);
        $branches = Branch::all(); // For filter dropdown

        return view('dashboard.holiday', compact('holidays', 'branches'));
    }

    public function parentObjections()
    {
        // Get the authenticated parent
        $parentid = auth()->user()->unique_id;
        $parent = Parents::where('parent_id', $parentid)->first();

        // Validate and get student IDs
        $childIds = [];
        if (!empty($parent->stu_id)) {
            $childIds = array_filter(explode(',', $parent->stu_id));
            $childIds = array_map('trim', $childIds); // Remove any whitespace
        }

        // Get objections for these students
        $objections = collect([]); // Empty collection as fallback

        if (!empty($childIds)) {
            $objections = Objection::whereIn('student_id', $childIds)
                ->with([
                    'student' => function ($query) {
                        $query->select('stu_id', 'name', 'image');
                    },
                    'classLevel' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'branch' => function ($query) {
                        $query->select('id', 'branch_name');
                    },
                    'teacher' => function ($query) {
                        $query->select('teacher_id', 'name');
                    }
                ])
                ->where('approved', 1) // Only approved objections
                ->latest()
                ->get();
        }

        return view('dashboard.parent.objections', [
            'parent' => $parent,
            'objections' => $objections,
            'childIds' => $childIds // Pass to view for debugging
        ]);
    }

    public function classschedule(Request $request, $stu_id)
    {
        // dd($stu_id,$request->all());
        // dd(auth()->id());
        // Get the logged-in student
        $student = Student::where('stu_id', $stu_id)
            ->join('class_levels', 'student.class', '=', 'class_levels.id')
            ->select('student.*', 'class_levels.name as class_name')
            ->firstOrFail();

        // dd($student);

        // Get the class routines for the student's class level and branch
        $routines = ClassRoutine::with(['subject', 'teacher'])
            ->where('class_level_id', $student->class)
            ->where('branch_id', $student->branch_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        // Group by day for weekly view
        $weeklySchedule = $routines->groupBy('day_of_week');

        // Filter for daily view if day is specified
        $day = $request->get('day', now()->format('l'));
        $dailySchedule = $routines->where('day_of_week', $day)->sortBy('start_time');

        // dd($student,$routines,$weeklySchedule, $dailySchedule, $day);

        return view('dashboard.parent.classschedule', [
            'weeklySchedule' => $weeklySchedule,
            'dailySchedule' => $dailySchedule,
            'currentDay' => $day,
            'student' => $student,
            'days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
        ]);
    }


    //Attendence
    public function studentCalendarView($stu_id)
    {
        // dd($stu_id);
        $studentId = $stu_id; // or student_id based on your auth

        // Get all attendance records for this student
        $attendanceRecords = Attendance::where('student_id', $studentId)
            ->get(['date', 'status']);

        // Format for calendar (date => status)
        $attendanceDays = [];
        foreach ($attendanceRecords as $record) {
            $attendanceDays[$record->date] = $record->status ? 'Present' : 'Absent';
        }
        return view('dashboard.parent.attendance-calendar', compact('attendanceDays', 'studentId'));
    }

    public function getStudentDateAttendance(Request $request, $stu_id)
    {
        $date = $request->date;
        $studentId = $stu_id; // You should get this from the route or session

        // Get day of week (Monday, Tuesday, etc.)
        $dayOfWeek = Carbon::parse($date)->englishDayOfWeek;

        // Get attendance for this student on this date
        $attendance = Attendance::with(['classRoutine.subject'])
            ->where('student_id', $studentId)
            ->where('date', $date)
            ->get();

        return view('dashboard.parent.date-attendance', compact('attendance', 'date', 'studentId'));
    }

    protected function formatAttendanceTitle($attendances)
    {
        $presentCount = $attendances->where('status', 1)->count();
        $total = $attendances->count();
        return "{$presentCount}/{$total} Classes";
    }

    protected function getOverallStatus($attendances)
    {
        if ($attendances->every(fn($a) => $a->status == 1)) return 'present';
        if ($attendances->every(fn($a) => $a->status == 0)) return 'absent';
        return 'mixed';
    }

    protected function formatAttendanceDetails($attendances)
    {
        return $attendances->map(function ($a) {
            return [
                'subject' => $a->classRoutine->subject->name ?? 'Unknown Subject',
                'time' => ($a->classRoutine->start_time ?? '--:--') . ' - ' . ($a->classRoutine->end_time ?? '--:--'),
                'status' => $a->status ? 'Present' : 'Absent',
                'remarks' => $a->remarks ?: '-'
            ];
        });
    }
}
