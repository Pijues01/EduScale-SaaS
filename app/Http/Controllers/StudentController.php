<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\ClassRoutine;
use App\Models\Feedback;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\Material;
use App\Models\Notices;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;


class StudentController extends Controller
{

    // public function view()
    // {
    //     $user = User::where('unique_id', Auth::id())->first();
    //     return view('dashboard.student.student-dash', compact('user'));
    // }

    public function view()
    {
        $student = Auth::user();
        $student_info = Student::where('stu_id', $student->unique_id)
            ->with(['classLevel', 'branch'])
            ->firstOrFail();

        // Attendance data
        $attendance = Attendance::where('student_id', $student->unique_id)
            ->whereMonth('date', now()->month)
            ->get();


        $presentCount = $attendance->where('status', 'present')->count();
        $totalDays = now()->daysInMonth;
        $attendancePercentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100) : 0;

        // Recent notices
        $recentNotices = Notices::whereJsonContains('audience', 'students')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // dd($student,$student_info);
        // Today's classes from routine
        $todayClasses = ClassRoutine::where('class_level_id', $student_info->class)
            ->where('day_of_week', strtolower(now()->englishDayOfWeek))
            ->orderBy('start_time')
            ->with('subject')
            ->get();



        // Upcoming holidays
        $upcomingHolidays = Holiday::where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        $student = Student::where('stu_id', auth()->id())->first();
        $materials = Material::join('teacher', 'materials.teacher_id', '=', 'teacher.teacher_id')
                    ->where('materials.class_id', $student->class)
                    ->select('materials.*', 'teacher.name as teacher_name')
                    ->latest('materials.created_at')
                    ->paginate(10);
        // dd( $materials);
        // dd($student, $attendance, $presentCount, $totalDays, $attendancePercentage, $recentNotices, $todayClasses, $upcomingHolidays);
        return view('dashboard.student.student-dash', compact(
            'student',
            'attendancePercentage',
            'recentNotices',
            'todayClasses',
            'upcomingHolidays',
            'materials'
        ));
    }


    public function studentCalendarView()
    {
        $studentId = auth()->user()->unique_id; // or student_id based on your auth

        // Get all attendance records for this student
        $attendanceRecords = Attendance::where('student_id', $studentId)
            ->get(['date', 'status']);

        // Format for calendar (date => status)
        $attendanceDays = [];
        foreach ($attendanceRecords as $record) {
            $attendanceDays[$record->date] = $record->status ? 'Present' : 'Absent';
        }
        return view('dashboard.student.attendance-calendar', compact('attendanceDays'));
    }

    public function getStudentDateAttendance(Request $request)
    {
        $date = $request->date;
        $studentId = auth()->user()->unique_id; // or student_id based on your auth

        // Get day of week (Monday, Tuesday, etc.)
        $dayOfWeek = Carbon::parse($date)->englishDayOfWeek;

        // Get attendance for this student on this date
        $attendance = Attendance::with(['classRoutine.subject'])
            ->where('student_id', $studentId)
            ->where('date', $date)
            ->get();

        return view('dashboard.student.date-attendance', compact('attendance', 'date'));
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


    public function studentnotice()
    {
        $notices = Notices::whereJsonContains('audience', 'students')
            ->orderBy('created_at', 'desc')
            ->get();
        // $teacherNotices = Notices::whereJsonContains('audience', 'teachers')->get();
        // dd($teacherNotices);
        // dd($notices);
        return view('dashboard.student.studentnotice', compact('notices'));
    }

    public function allnoticegeneral()
    {
        $notices = Notices::whereJsonContains('audience', 'general')
            ->orderBy('created_at', 'desc')
            ->get();
        // $teacherNotices = Notices::whereJsonContains('audience', 'teachers')->get();
        // dd($teacherNotices);
        // dd($notices);
        return view('dashboard.student.studentnotice', compact('notices'));
    }

    public function noticeview($id)
    {
        $notice = Notices::findOrFail($id);
        // dd($notice);
        return view('dashboard.student.noticeview', compact('notice'));
    }

    public function feedbackIndex()
    {
        $feedbacks = Feedback::where('role_type', 'teacher')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        // $branches = Branch::all();
        // dd($feedbacks, $branches);
        return view('dashboard.feedback', compact('feedbacks'));
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
        $branch_id = Student::where('stu_id', auth()->id())->first()->branch_id;
        // dd($request,$branch_id);

        Feedback::create([
            'type' => $validated['type'],
            'role_type' => 'student',
            'user_id' => auth()->id(),
            'branch_id' =>  $branch_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending'
        ]);

        return back()->with('success', 'Your ' . $validated['type'] . ' has been submitted!');
    }

    public function classschedule(Request $request)
    {
        // dd(auth()->id());
        // Get the logged-in student
        $student = Student::where('stu_id', auth()->id())
            ->join('class_levels', 'student.class', '=', 'class_levels.id')
            ->firstOrFail();

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

        return view('dashboard.student.classschedule', [
            'weeklySchedule' => $weeklySchedule,
            'dailySchedule' => $dailySchedule,
            'currentDay' => $day,
            'student' => $student,
            'days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
        ]);
    }

    // public function holidays(Request $request)
    // {
    //     dd(auth()->id());
    //     $query = Holiday::with('branch')
    //         ->orderBy('date', 'asc');

    //     // Apply date range filter
    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         $query->whereBetween('date', [
    //             $request->start_date,
    //             $request->end_date
    //         ]);
    //     }
    //     // If only start date is provided
    //     elseif ($request->filled('start_date')) {
    //         $query->where('date', '>=', $request->start_date);
    //     }
    //     // If only end date is provided
    //     elseif ($request->filled('end_date')) {
    //         $query->where('date', '<=', $request->end_date);
    //     }

    //     // Apply branch filter
    //     if ($request->filled('branch_id')) {
    //         $query->where('branch_id', $request->branch_id);
    //     }

    //     // Apply recurring filter
    //     if ($request->filled('is_recurring') && in_array($request->is_recurring, ['0', '1'])) {
    //         $query->where('is_recurring', (bool)$request->is_recurring);
    //     }

    //     $holidays = $query->paginate(15);
    //     $branches = Branch::all(); // For filter dropdown

    //     return view('dashboard.holiday', compact('holidays', 'branches'));
    // }

    public function holidays(Request $request)
    {
        $query = Holiday::with('branch')
            ->orderBy('date', 'asc');

        // Get student's branch_id if exists
        // $studentBranchId = auth()->user()->student->branch_id ?? null;
        $studentBranchId = Student::where('stu_id', auth()->id())->first()->branch_id;
        // dd($studentBranchId);

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

        // Apply branch filter from request if provided
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        // If no branch filter in request, show student's branch holidays + all branches
        elseif ($studentBranchId) {
            $query->where(function ($q) use ($studentBranchId) {
                $q->where('branch_id', $studentBranchId)
                    ->orWhereNull('branch_id');
            });
        }

        // Apply recurring filter
        if ($request->filled('is_recurring') && in_array($request->is_recurring, ['0', '1'])) {
            $query->where('is_recurring', (bool)$request->is_recurring);
        }

        $holidays = $query->paginate(15);
        $branches = Branch::all(); // For filter dropdown

        return view('dashboard.holiday', compact('holidays', 'branches', 'studentBranchId'));
    }

    //Leave Application Section Start

    public function leavecreate()
    {
        $leaves = LeaveApplication::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('dashboard.leavecreate', compact('leaves'));
    }

    public function leavestore(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        LeaveApplication::create([
            'user_id' => auth()->id(),
            'type' => auth()->user()->role,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Leave application submitted successfully!');
    }




    public function materialsindex()
    {

        $student = Student::where('stu_id', auth()->id())->first();
        // $materials = Material::where('class_id', $student->class)
        //     ->latest()
        //     ->paginate(10);
        $materials = Material::join('teacher', 'materials.teacher_id', '=', 'teacher.teacher_id')
                    ->where('materials.class_id', $student->class)
                    ->select('materials.*', 'teacher.name as teacher_name')
                    ->latest('materials.created_at')
                    ->paginate(10);

        // dd($materials);

        return view('dashboard.student.materials.index', compact('materials'));
    }

    public function materialshow($id)
    {
        $material = Material::findOrFail($id); // Adjust model name as needed
        $teacher = Teacher::where('teacher_id', $material->teacher_id)->first();
        $stu_class = Student::where('stu_id', auth()->id())->first()->class;
        // dd($material, $teacher, $stu_class);
        // dd($material, $teacher);
        // Ensure teacher can only view their own materials
        if ((string) $material->class_id !== $stu_class) {
            abort(403, 'Unauthorized access');
        }

        return view('dashboard.student.materials.show', compact('material','teacher'));
    }


}
