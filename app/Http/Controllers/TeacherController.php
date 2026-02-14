<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ClassLevels;
use App\Models\ClassRoutine;
use App\Models\Feedback;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\Material;
use App\Models\Notices;
use App\Models\Objection;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    // public function dashboard()
    // {
    //     $user = User::where('unique_id', Auth::id())->first();
    //     return view('dashboard.teacher.teacher-dash', compact('user'));
    // }

    // public function dashboard()
    // {
    //     $teacher = Auth::user();



    //     // Get classes taught by this teacher
    //     $classes = ClassRoutine::where('teacher_id', $teacher->unique_id)
    //                     ->distinct('class_id')
    //                     ->with('class')
    //                     ->get()
    //                     ->pluck('class');



    //     // Get today's classes
    //     $todayClasses = ClassRoutine::where('teacher_id', $teacher->unique_id)
    //                          ->where('day_of_week', strtolower(now()->englishDayOfWeek))
    //                          ->orderBy('start_time')
    //                          ->with(['class_levels', 'subject'])
    //                          ->get();

    //     // Get students count
    //     $studentsCount = User::where('role', 'student')
    //                        ->whereIn('class_id', $classes->pluck('id'))
    //                        ->count();
    //     // Upcoming holidays
    //     $upcomingHolidays = Holiday::where('date', '>=', now())
    //                              ->orderBy('date')
    //                              ->take(3)
    //                              ->get();

    //     // Recent notices (teacher notices)
    //     $recentNotices = Notices::whereJsonContains('audience', 'teachers')
    //                          ->orderBy('created_at', 'desc')
    //                          ->take(5)
    //                          ->get();

    //     return view('dashboard.teacher.teacher-dash', compact(
    //         'teacher',
    //         'classes',
    //         'todayClasses',
    //         'studentsCount',
    //         'upcomingHolidays',
    //         'recentNotices'
    //     ));
    // }

    public function dashboard()
    {
        $teacher = Auth::user();

        // Get classes taught by this teacher
        $classes = ClassRoutine::where('teacher_id', $teacher->unique_id)
            ->distinct('class_level_id')
            ->with('class_levels')
            ->get()
            ->pluck('class_levels')
            ->unique();

        // Get today's classes
        $todayClasses = ClassRoutine::where('teacher_id', $teacher->unique_id)
            ->where('day_of_week', strtolower(now()->englishDayOfWeek))
            ->orderBy('start_time')
            ->with(['class_levels', 'subject'])
            ->get();

        // Get students count
        $classLevelIds = $classes->pluck('id');
        $studentsCount = Student::whereIn('class', $classLevelIds)->count();

        // Upcoming holidays
        $upcomingHolidays = Holiday::where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        // Recent notices for teachers
        $recentNotices = Notices::whereJsonContains('audience', 'teachers')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // dd($classes, $todayClasses, $studentsCount, $upcomingHolidays, $recentNotices);
        return view('dashboard.teacher.teacher-dash', compact(
            'teacher',
            'classes',
            'todayClasses',
            'studentsCount',
            'upcomingHolidays',
            'recentNotices'
        ));
    }

    // Shedule Refference Start:

    // public function mySchedule(Request $request)
    // {
    //     $teacherId = Teacher::where('teacher_id', auth()->user()->unique_id)->first()->id; // Assuming teacher is logged in
    //     // dd($teacherId);
    //     // Get all schedules for this teacher

    //     // $schedules = ClassRoutine::with(['branch', 'classLevel', 'subject'])
    //     //     ->where('teacher_id', $teacherId)
    //     //     ->orderBy('day_of_week')
    //     //     ->orderBy('start_time')
    //     //     ->get();

    //     $schedules = ClassRoutine::with(['branch', 'classLevel', 'subject'])
    //         ->where('teacher_id', $teacherId)
    //         ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
    //         ->orderBy('start_time')
    //         ->get();



    //     // $schedules = DB::table('class_routines')
    //     //     ->join('branches', 'class_routines.branch_id', '=', 'branches.id')
    //     //     // ->join('class_levels', 'class_routines.class_level_id', '=', 'class_levels.id')
    //     //     // ->join('subject', 'class_routines.subject_id', '=', 'subject.id')
    //     //     ->where('class_routines.teacher_id', $teacherId)
    //     //     // ->orderBy('class_routines.day_of_week')
    //     //     // ->orderBy('class_routines.start_time')
    //     //     ->select(
    //     //         'class_routines.*',
    //     //         'branches.branch_name',
    //     //         // 'class_levels.name as class_level_name',
    //     //         // 'subject.sub_name as subject_name'
    //     //     )
    //     //     ->get();

    //     // dd($schedules, $request->all(), $teacherId);
    //     // Group by view type
    //     $viewType = $request->get('view', 'weekly'); // daily, weekly, monthly

    //     $filteredSchedules = $this->filterSchedules($schedules, $viewType);

    //     dd($filteredSchedules, $viewType);

    //     return view('dashboard.teacher.schedule', [
    //         'schedules' => $filteredSchedules,
    //         'branches' => Branch::all(),
    //         'viewType' => $viewType
    //     ]);
    // }

    // public function mySchedule(Request $request)
    // {
    //     $teacherId = Teacher::where('teacher_id', auth()->user()->unique_id)->first()->id;

    //     $schedules = ClassRoutine::with(['branch', 'classLevel', 'subject'])
    //         ->where('teacher_id', $teacherId)
    //         ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
    //         ->orderBy('start_time')
    //         ->get();

    //     // Get all unique branch-class combinations
    //     $classGroups = $schedules->unique(function ($item) {
    //         return $item->branch_id . '-' . $item->class_level_id;
    //     });

    //     // Get student counts in a single query
    //     $studentCounts = Student::selectRaw('branch_id, class, COUNT(*) as count')
    //         ->whereIn('branch_id', $classGroups->pluck('branch_id'))
    //         ->whereIn('class', $classGroups->pluck('class'))
    //         ->groupBy('branch_id', 'class')
    //         ->get()
    //         ->keyBy(function ($item) {
    //             return $item->branch_id . '-' . $item->class_level_id;
    //         });

    //     // Assign student counts to schedules
    //     $schedules->each(function ($schedule) use ($studentCounts) {
    //         $key = $schedule->branch_id . '-' . $schedule->class_level_id;
    //         $schedule->student_count = $studentCounts[$key]->count ?? 0;
    //     });

    //     $viewType = $request->get('view', 'weekly');
    //     $filteredSchedules = $this->filterSchedules($schedules, $viewType);

    //     return view('dashboard.teacher.schedule', [
    //         'schedules' => $filteredSchedules,
    //         'branches' => Branch::all(),
    //         'viewType' => $viewType
    //     ]);
    // }

    // Shedule Refference End:

    public function mySchedule(Request $request)
    {
        $teacherId = Teacher::where('teacher_id', auth()->user()->unique_id)->first()->teacher_id;
        // dd($teacherId);
        $schedules = ClassRoutine::with(['branch', 'classLevel', 'subject'])
            ->where('teacher_id', $teacherId)
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        // Load student counts for each class
        $schedules->each(function ($schedule) {
            $schedule->student_count = Student::where('branch_id', $schedule->branch_id)
                ->where('class', $schedule->class_level_id)
                ->count();
        });




        $viewType = $request->get('view', 'weekly');
        $filteredSchedules = $this->filterSchedules($schedules, $viewType);

        // dd( $schedules,$filteredSchedules, $viewType);

        return view('dashboard.teacher.schedule', [
            'schedules' => $filteredSchedules,
            'branches' => Branch::all(),
            'viewType' => $viewType
        ]);
    }



    private function filterSchedules($schedules, $viewType)
    {
        $today = now()->format('l'); // Current day name (Monday, Tuesday, etc.)
        $currentWeek = now()->weekOfYear;
        $currentMonth = now()->month;

        return $schedules->filter(function ($schedule) use ($viewType, $today, $currentWeek, $currentMonth) {
            if ($viewType === 'daily') {
                return $schedule->day_of_week === $today;
            } elseif ($viewType === 'weekly') {
                return true; // Show all for weekly view
            } elseif ($viewType === 'monthly') {
                // Assuming you have a way to determine month from day_of_week
                // This is simplified - you might need a more robust solution
                return true;
            }
            return false;
        });
    }

    public function studentbyclass($b_id, $c_id)
    {
        // dd($b_id, $c_id);
        $classLevel = ClassLevels::findOrFail($c_id);
        $students = Student::where('class', $c_id)->get();
        $branch = Branch::findOrFail($b_id);


        // return view('students.by-class', compact('students', 'classLevel'));

        // $students = User::where('class_id', $id)
        //     ->where('role', 'student')
        //     ->get();
        // dd($students, $classLevel);
        return view('dashboard.teacher.studentbyclass', compact('students', 'classLevel', 'branch'));
    }

    public function allnotice()
    {
        $notices = Notices::whereJsonContains('audience', 'teachers')
            ->orderBy('created_at', 'desc')
            ->get();
        // $teacherNotices = Notices::whereJsonContains('audience', 'teachers')->get();
        // dd($teacherNotices);
        // dd($notices);
        return view('dashboard.teacher.allnotice', compact('notices'));
    }
    public function allnoticegeneral()
    {
        $notices = Notices::whereJsonContains('audience', 'general')
            ->orderBy('created_at', 'desc')
            ->get();
        // $teacherNotices = Notices::whereJsonContains('audience', 'teachers')->get();
        // dd($teacherNotices);
        // dd($notices);
        return view('dashboard.teacher.allnotice', compact('notices'));
    }

    public function noticeview($id)
    {
        $notice = Notices::findOrFail($id);
        // dd($notice);
        return view('dashboard.teacher.noticeview', compact('notice'));
    }

    public function objectionstore(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,stu_id',
            'class_level_id' => 'required|exists:class_levels,id',
            'branch_id' => 'required|exists:branches,id',
            'teacher_id' => 'required|exists:teacher,teacher_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $objection = Objection::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Objection created successfully',
            'data' => $objection
        ]);
    }

    // Feedback Section Start

    public function feedbackIndex()
    {
        $feedbacks = Feedback::where('role_type', 'teacher')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        $branches = Branch::all();
        // dd($feedbacks, $branches);
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
            'role_type' => 'teacher',
            'user_id' => auth()->id(),
            'branch_id' => auth()->user()->branch_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'branch_id' => $validated['branch_id'] ?? null,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Your ' . $validated['type'] . ' has been submitted!');
    }

    // public function holidays(Request $request)
    // {
    //     $query = Holiday::with('branch')
    //         ->orderBy('date', 'asc');

    //     // Apply date range filter
    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         $query->whereBetween('date', [
    //             $request->start_date,
    //             $request->end_date
    //         ]);
    //     }

    //     // Apply branch filter
    //     if ($request->filled('branch_id')) {
    //         $query->where('branch_id', $request->branch_id);
    //     }

    //     // Apply recurring filter
    //     if ($request->filled('is_recurring')) {
    //         $query->where('is_recurring', $request->is_recurring);
    //     }

    //     $holidays = $query->paginate(15);
    //     $branches = Branch::all(); // For filter dropdown

    //     return view('dashboard.holiday', compact('holidays', 'branches'));
    // }

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


    //materials

    public function materialsindex()
    {
        $materials = Material::where('teacher_id', auth()->id())
            ->with('class')
            ->latest()
            ->paginate(10);

        // dd($materials);

        return view('dashboard.teacher.materials.index', compact('materials'));
    }

    public function materialscreate()
    {
        $classes = ClassLevels::all();
        return view('dashboard.teacher.materials.add', compact('classes'));
    }

    public function materialsstore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required',
            'type' => 'required|in:document,video,image,text',
            'description' => 'nullable|string',
            'file' => 'required_if:type,document,video,image|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4,mov,avi|max:20480',
            'content' => 'required_if:type,text'
        ]);

        $material = new Material();
        $material->teacher_id = auth()->id();
        $material->class_id = $request->class_id;
        $material->title = $request->title;
        $material->description = $request->description;
        $material->type = $request->type;

        if ($request->type === 'text') {
            $material->content = $request->content;
        } else {
            $path = $request->file('file')->store('public/materials');
            $material->file_path = Storage::url($path);
        }

        $material->save();

        return response()->json([
            'message' => 'Material uploaded successfully.',
            'redirect' => route('materials.index')
        ]);
    }


    public function materialsedit($id)
    {
        $material = Material::findOrFail($id); // Adjust model name as needed

        // Ensure teacher can only edit their own materials
        if ((string) $material->teacher_id !== auth()->id()) {
            dd((string) $material->teacher_id, auth()->id(), 'hi');
            abort(403, 'Unauthorized access');
        }

        $classes = ClassLevels::all(); // Adjust model name as needed

        return view('dashboard.teacher.materials.add', compact('material', 'classes'));
    }

    /**
     * Update the specified material
     */
    // public function materialsupdate(Request $request, $id)
    // {
    //     $material = Material::findOrFail($id); // Adjust model name as needed

    //     // Ensure teacher can only update their own materials
    //     if ((string) $material->teacher_id !== auth()->id()) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'class_id' => 'required',
    //         'type' => 'required|in:document,video,image,text',
    //         'description' => 'nullable|string',
    //         'file' => 'nullable|file|max:50000', // Optional for updates
    //         'content' => 'required_if:type,text|string',
    //     ]);

    //     try {
    //         $material->title = $request->title;
    //         $material->class_id = $request->class_id;
    //         $material->type = $request->type;
    //         $material->description = $request->description;

    //         if ($request->type === 'text') {
    //             $material->content = $request->content;
    //             // Clear file data if switching to text type
    //             $material->file_path = null;
    //             // $material->file_name = null;
    //         } else {
    //             // Handle file upload if new file is provided
    //             if ($request->hasFile('file')) {
    //                 // Delete old file if exists
    //                 if ($material->file_path && \Storage::disk('public')->exists($material->file_path)) {
    //                     \Storage::disk('public')->delete($material->file_path);
    //                 }

    //                 $file = $request->file('file');
    //                 $fileName = time() . '_' . $file->getClientOriginalName();
    //                 $filePath = $file->storeAs('materials', $fileName, 'public');
    //                 $material->file_path = $filePath;
    //                 // $material->file_name = $fileName;
    //             }
    //             // Clear content if switching from text type
    //             if ($material->wasChanged('type') && $material->getOriginal('type') === 'text') {
    //                 $material->content = null;
    //             }
    //         }

    //         $material->save();

    //         if ($request->expectsJson()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Material updated successfully!',
    //                 'redirect' => route('materials.index')
    //             ]);
    //         }

    //         return redirect()->route('materials.index')->with('success', 'Material updated successfully!');
    //     } catch (\Exception $e) {
    //         if ($request->expectsJson()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to update material: ' . $e->getMessage()
    //             ], 500);
    //         }

    //         return back()->withInput()->withErrors(['error' => 'Failed to update material: ' . $e->getMessage()]);
    //     }
    // }

    public function materialsupdate(Request $request, $id)
    {
        $material = Material::findOrFail($id); // Adjust model name as needed

        // Ensure teacher can only update their own materials
        if ((string) $material->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Prepare validation rules based on type
        $rules = [
            'title' => 'required|string|max:255',
            'class_id' => 'required',
            'type' => 'required|in:document,video,image,text',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:50000', // Optional for updates
        ];

        // Only validate content if type is text
        if ($request->type === 'text') {
            $rules['content'] = 'required|string';
        }

        $request->validate($rules);

        try {
            $material->title = $request->title;
            $material->class_id = $request->class_id;
            $material->type = $request->type;
            $material->description = $request->description;

            if ($request->type === 'text') {
                $material->content = $request->content;
                // Clear file data if switching to text type
                $material->file_path = null;
                // $material->file_name = null;
            } else {
                // Handle file upload if new file is provided
                if ($request->hasFile('file')) {
                    // Delete old file if exists
                    if ($material->file_path && \Storage::disk('public')->exists($material->file_path)) {
                        \Storage::disk('public')->delete($material->file_path);
                    }

                    $file = $request->file('file');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('materials', $fileName, 'public');
                    $material->file_path = $filePath;
                    // $material->file_name = $fileName;
                }
                // Clear content if switching from text type
                if ($material->wasChanged('type') && $material->getOriginal('type') === 'text') {
                    $material->content = null;
                }
            }

            $material->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Material updated successfully!',
                    'redirect' => route('materials.index')
                ]);
            }

            return redirect()->route('materials.index')->with('success', 'Material updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update material: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to update material: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified material
     */
    public function materialsdestroy($id)
    {
        // dd($id);
        try {
            $material = Material::findOrFail($id); // Adjust model name as needed

            // Ensure teacher can only delete their own materials
            if ((string) $material->teacher_id !== auth()->id()) {
                abort(403, 'Unauthorized access');
            }

            // Delete associated file if exists
            if ($material->file_path && \Storage::disk('public')->exists($material->file_path)) {
                \Storage::disk('public')->delete($material->file_path);
            }

            $material->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Material deleted successfully!'
                ]);
            }

            return redirect()->route('materials.index')->with('success', 'Material deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete material: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to delete material: ' . $e->getMessage()]);
        }
    }

    public function materialshow($id)
    {
        $material = Material::findOrFail($id); // Adjust model name as needed
        $teacher = Teacher::where('teacher_id', $material->teacher_id)->first();
        // dd($material, $teacher);
        // Ensure teacher can only view their own materials
        if ((string) $material->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('dashboard.teacher.materials.show', compact('material','teacher'));
    }
}
