<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notices;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Parents;
use App\Models\Contact;
use App\Models\GalleryImage;
use App\Models\Branch;
use App\Models\Consult;
use App\Models\Job;
use App\Models\Application;
use App\Models\Attendance;
use App\Models\ClassLevels;
use App\Models\ClassPeriod;
use App\Models\ClassRoutine;
use App\Models\Feedback;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\Objection;
use App\Models\TeacherAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    // public function view()
    // {
    //     $student = User::where('role', 'student')->count();
    //     $teacher = User::where('role', 'teacher')->count();

    //     // dd($student,$teacher);
    //     return view('dashboard.admin.admin-dash', compact('student', 'teacher'));
    // }

    public function view()
    {
        $admin = Auth::user();

        // Get total counts
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = Teacher::count();
        $classesCount = ClassLevels::count();
        $activeRoutinesCount = ClassRoutine::count();

        // Get recent notices (all types)
        $recentNotices = Notices::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming holidays
        $upcomingHolidays = Holiday::where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        // Get latest registrations
        // $latestStudents = User::where('role', 'student')
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        // $latestTeachers = Teacher::orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        $latestStudents = User::where('role', 'student')
            ->with('class_level')

            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestTeachers = Teacher::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin.admin-dash', compact(
            'admin',
            'studentsCount',
            'teachersCount',
            'classesCount',
            'activeRoutinesCount',
            'recentNotices',
            'upcomingHolidays',
            'latestStudents',
            'latestTeachers'
        ));
    }



    public function noticeAddForm()
    {
        return view('dashboard.admin.add-notice');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'shortdescription' => 'required|string',
            'audience' => 'required|array|min:1', // At least one checkbox must be selected
            'attachment' => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

        $notice = new Notices();
        $notice->title = $request->title;
        $notice->shortdescription = $request->shortdescription;
        $notice->description = $request->description;
        $notice->audience = $request->audience; // Store selected audiences as JSON

        if ($request->hasFile('attachment')) {
            $fileName = time() . '.' . $request->attachment->extension();
            $request->attachment->move(public_path('uploads'), $fileName);
            $notice->attachment = 'uploads/' . $fileName;
        }
        $notice->save();

        return back()->with('success', 'Notice published successfully!');
    }

    public function noticeShow()
    {
        $notices = Notices::all();
        return view('dashboard.admin.view-notices', compact('notices'));
    }

    public function noticeedit($id)
    {
        $notice = Notices::findOrFail($id);
        return view('dashboard.admin.add-notice', compact('notice'));
    }

    public function updateNotice(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'shortdescription' => 'required|string',
            'audience' => 'required|array|min:1',
            'attachment' => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

        $notice = Notices::findOrFail($id);
        $notice->title = $request->title;
        $notice->shortdescription = $request->shortdescription;
        $notice->description = $request->description;
        // $notice->audience = json_encode($request->audience);
        $notice->audience = $request->audience; // Store as an array directly

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($notice->attachment && file_exists(public_path($notice->attachment))) {
                unlink(public_path($notice->attachment));
            }
            $fileName = time() . '.' . $request->attachment->extension();
            $request->attachment->move(public_path('uploads'), $fileName);
            $notice->attachment = 'uploads/' . $fileName;
        }

        $notice->save();

        return redirect()->route('admin.noticeshow')->with('success', 'Notice updated successfully!');
    }
    public function noticedestroy($id)
    {
        $notice = Notices::findOrFail($id);
        $notice->delete();

        return response()->json(['success' => 'Notice deleted successfully']);
    }






    public function showRegisterForm()
    {
        $branches = Branch::all(); // Fixed typo from "brances"
        $classLevels = ClassLevels::all(); // Fixed typo from "ClassLevels" to "ClassLevel" if that's your model name
        return view('dashboard.admin.add-member', compact('branches', 'classLevels'));
    }

    public function getsubjects()
    {
        $subject = Subject::all();
        return response()->json($subject);
    }



    public function searchStudents(Request $request)
    {
        $query = Student::with(['class_level', 'branch']);

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->class_level_id) {
            $query->where('class', $request->class_level_id);
        }

        $students = $query->get();

        return response()->json($students);
    }




    private function generateUniqueId()
    {
        do {
            $uniqueId = mt_rand(1000000000, 9999999999); // Generate 10-digit number
        } while (User::where('unique_id', $uniqueId)->exists()); // Ensure it's unique

        return $uniqueId;
    }


    public function memberregister(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,parent,teacher',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);

        $uniqueId = $this->generateUniqueId();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
        }

        // dd($imagePath);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'unique_id' => $uniqueId,
        ]);


        if ($request->role === 'student') {
            $validatedStudent = $request->validate([
                'class_level_id' => 'required|exists:class_levels,id',
                'school_name' => 'required|string|max:255',
                'ph_no' => 'nullable|string|max:20',
                'address' => 'required|string|max:255',
                'medium' => 'required|in:english,bengali',
                'branch_id' => 'required|exists:branches,id',
            ]);

            // dd($request->all());

            Student::create([
                'stu_id' => $uniqueId,
                'name' => $request->name,
                'image' => $imagePath,
                'class' => $request->class_level_id,
                'school_name' => $request->school_name,
                'ph_no' => $request->ph_no ?? null,
                'email' => $request->email ?? null,
                'address' => $request->address,
                'medium' => $request->medium,
                'branch_id' => $request->branch_id,
                'status' => '1',
            ]);
        } elseif ($request->role === 'teacher') {
            $validatedTeacher = $request->validate([
                'subject_id' => 'required|exists:subject,id',
                'ph_no' => 'nullable|string|max:20',
                'address' => 'required|string|max:255',
            ]);

            Teacher::create([
                'teacher_id' => $uniqueId,
                'name' => $request->name,
                'image' => $imagePath,
                'subject' => $request->subject_id,
                'ph_no' => $request->ph_no ?? null,
                'email' => $request->email ?? null,
                'address' => $request->address,
            ]);
        } elseif ($request->role === 'parent') {
            // $validatedParent = $request->validate([
            //     'ph_no' => 'nullable|string|max:20',
            //     'address' => 'required|string|max:255',
            //     // 'child_id' => 'required|exists:student,stu_id',
            //     'child_id' => 'required|array',
            //     'child_id.*' => 'exists:students,stu_id'
            // ]);
            $validatedParent = $request->validate([
                'ph_no' => 'nullable|string|max:20',
                'address' => 'required|string|max:255',
                'child_id' => 'sometimes|array', // Changed from 'required' to 'sometimes'
                'child_id.*' => 'exists:student,stu_id'
            ]);
            // $validated['child_id'] = implode(',', $request->child_id);

            // Parents::create([
            //     'parent_id' => $uniqueId,
            //     'name' => $request->name,
            //     'image' => $imagePath,
            //     'ph_no' => $request->ph_no ?? null,
            //     'email' => $request->email ?? null,
            //     'address' => $request->address,
            //     // 'stu_id' => $request->child_id,
            //     'stu_id' => implode(',', $request->child_id),
            // ]);
            $childIds = $request->child_id ? implode(',', $request->child_id) : null;

            Parents::create([
                'parent_id' => $uniqueId,
                'name' => $request->name,
                'image' => $imagePath,
                'ph_no' => $request->ph_no ?? null,
                'email' => $request->email ?? null,
                'address' => $request->address,
                'stu_id' => $childIds, // This can now be null
            ]);
        }

        return redirect()->back()->with('success', ucfirst($request->role) . ' registered successfully.');
    }

    public function showMembers($role)
    {
        $roleModels = [
            'student' => [
                'model' => Student::class,
                'fields' => [
                    'student.id',
                    'student.stu_id as Student Id',
                    'student.name as Name',
                    'student.image as Image',
                    'class_levels.name as Class',
                    'student.school_name as School Name',
                    'student.ph_no as Phone',
                    'student.address as Address',
                    'student.medium as Medium'
                ],
                'join' => [
                    'table' => 'class_levels',
                    'first' => 'student.class',
                    'operator' => '=',
                    'second' => 'class_levels.id',
                    'type' => 'leftJoin' // Explicit join type
                ]
            ],
            'teacher' => [
                'model' => Teacher::class,
                'fields' => [
                    'teacher.id',
                    'teacher.teacher_id as Teacher Id',
                    'teacher.name as Name',
                    'teacher.image as Image',
                    'subject.sub_name as Subject',
                    'teacher.email as Email',
                    'teacher.ph_no as Phone',
                    'teacher.address as Address'
                ],
                'join' => [
                    'table' => 'subject',
                    'first' => 'teacher.subject',
                    'operator' => '=',
                    'second' => 'subject.id',
                    'type' => 'leftJoin'
                ]
            ],
            'parent' => [
                'model' => Parents::class,
                'fields' => [
                    'id',
                    'parent_id as Parent Id',
                    'name as Name',
                    'image as Image',
                    'stu_id as Child Id',
                    'email as Email',
                    'ph_no as Phone',
                    'address as Address'
                ]
            ],
        ];

        if (!isset($roleModels[$role])) {
            return view('dashboard.admin.view-members', ['members' => collect(), 'role' => $role]);
        }

        $model = $roleModels[$role]['model'];
        $fields = $roleModels[$role]['fields'];
        $query = $model::select($fields);

        if (isset($roleModels[$role]['join'])) {
            $join = $roleModels[$role]['join'];

            // Use consistent join syntax
            $query->{$join['type'] ?? 'leftJoin'}(
                $join['table'],
                $join['first'],
                $join['operator'] ?? '=',
                $join['second']
            );
        }

        $members = $query->get();

        return view('dashboard.admin.view-members', compact('members', 'role'));
    }

    public function memberedit($unick_id)
    {
        $role = User::where('unique_id', $unick_id)->first()->role;
        if (!$role) {
            abort(404, 'User role not found');
        }
        if ($role == 'student') {
            $join_q = 'stu_id';
        } elseif ($role == 'parent') {
            $join_q = 'parent_id';
        } elseif ($role == 'teacher') {
            $join_q = 'teacher_id';
        }

        // Join with the respective table
        $member = User::join($role, 'users.unique_id', '=', "$role.$join_q")
            ->select('users.*', "$role.*")
            ->where('users.unique_id', $unick_id)
            ->first();

        if (!$member) {
            abort(404, 'Member not found');
        }
        $subjects = Subject::all();
        $classLevels = ClassLevels::all();
        $branches = Branch::all();

        if ($member->image) {
            $member->image_url = Storage::url($member->image);
        }

        // dd($member, $role, $subjects, $classLevels, $branches);
        // return view('dashboard.admin.edit-member', compact('member'));
        return view('dashboard.admin.add-member', compact('member', 'role', 'subjects', 'classLevels', 'branches'));
    }
    public function memberUpdate(Request $request, $id)
    {
        // Common validation for all roles
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:student,parent,teacher',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ph_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Update the user record
        User::where('unique_id', $id)->update($userData);

        // Role-specific updates
        switch ($request->role) {
            case 'student':
                $request->validate([
                    'class_level_id' => 'required|exists:class_levels,id',
                    'school_name' => 'required|string|max:255',
                    'medium' => 'required|in:english,bengali',
                    'branch_id' => 'required|exists:branches,id',
                ]);

                $studentData = [
                    'name' => $request->name,
                    'class' => $request->class_level_id,
                    'school_name' => $request->school_name,
                    'ph_no' => $request->ph_no,
                    'email' => $request->email,
                    'address' => $request->address,
                    'medium' => $request->medium,
                    'branch_id' => $request->branch_id,
                ];

                $this->handleImageUpdate($request, Student::class, 'stu_id', $id, $studentData);

                Student::where('stu_id', $id)->update($studentData);
                return redirect()->route('admin.members', ['student'])->with('success', 'Student updated successfully');

            case 'teacher':
                $request->validate([
                    'subject_id' => 'required|exists:subject,id',
                ]);

                $teacherData = [
                    'name' => $request->name,
                    'subject' => $request->subject_id,
                    'ph_no' => $request->ph_no,
                    'email' => $request->email,
                    'address' => $request->address,
                ];

                $this->handleImageUpdate($request, Teacher::class, 'teacher_id', $id, $teacherData);

                Teacher::where('teacher_id', $id)->update($teacherData);
                return redirect()->route('admin.members', ['teacher'])->with('success', 'Teacher updated successfully');

            case 'parent':
                $request->validate([
                    'child_id' => 'required|exists:student,stu_id',
                ]);

                $parentData = [
                    'name' => $request->name,
                    'ph_no' => $request->ph_no,
                    'email' => $request->email,
                    'address' => $request->address,
                    'stu_id' => $request->child_id,
                ];

                $this->handleImageUpdate($request, Parents::class, 'parent_id', $id, $parentData);

                Parents::where('parent_id', $id)->update($parentData);
                return redirect()->route('admin.members', ['parent'])->with('success', 'Parent updated successfully');
        }

        return back()->with('error', 'Invalid role specified');
    }

    /**
     * Handle image update logic
     */
    protected function handleImageUpdate($request, $model, $idColumn, $id, &$data)
    {
        $currentImage = $model::where($idColumn, $id)->value('image');

        // If remove_image checkbox is checked
        if ($request->has('remove_image')) {
            // Delete the current image if exists
            if ($currentImage) {
                Storage::delete($currentImage);
            }
            $data['image'] = null;
        }
        // If new image is uploaded
        elseif ($request->hasFile('image')) {
            // Delete the current image if exists
            if ($currentImage) {
                Storage::delete($currentImage);
            }
            // Store the new image
            $data['image'] = $request->file('image')->store('profile_images', 'public');
        }
        // Keep the existing image if no changes
        else {
            $data['image'] = $currentImage;
        }
    }


    public function deleteMember($id)
    {
        DB::beginTransaction();

        try {
            // Find the user and their role
            $user = User::where('unique_id', $id)->firstOrFail();
            $role = $user->role;

            // Delete associated image if exists
            $this->deleteMemberImage($role, $id);

            // Delete role-specific record first
            switch ($role) {
                case 'student':
                    Student::where('stu_id', $id)->delete();
                    break;
                case 'teacher':
                    Teacher::where('teacher_id', $id)->delete();
                    break;
                case 'parent':
                    Parents::where('parent_id', $id)->delete();
                    break;
            }

            // Finally delete the user
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst($role) . ' deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete member's associated image file
     */
    protected function deleteMemberImage($role, $memberId)
    {
        $imagePath = null;

        switch ($role) {
            case 'student':
                $imagePath = Student::where('stu_id', $memberId)->value('image');
                break;
            case 'teacher':
                $imagePath = Teacher::where('teacher_id', $memberId)->value('image');
                break;
            case 'parent':
                $imagePath = Parents::where('parent_id', $memberId)->value('image');
                break;
        }

        if ($imagePath && Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }

    public function contactView()
    {
        $contacts = Contact::latest()->get(); // Fetch all contacts (latest first)
        return view('dashboard.admin.view-contacts', compact('contacts'));
    }
    public function consultView()
    {
        $consults = Consult::latest()->get(); // Fetch all contacts (latest first)
        return view('dashboard.admin.view-consult', compact('consults'));
    }


    // Gallery Functions Start

    public function admingallery()
    {
        $images = GalleryImage::all();
        // dd($images);
        return view('dashboard.admin.image-upload', compact('images'));
    }

    public function uploadImage(Request $request)
    {
        // dd($request);
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }
    public function deleteImage($id)
    {
        $image = GalleryImage::findOrFail($id);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function toggleFeatured(Request $request, $id)
    {
        $image = GalleryImage::findOrFail($id);

        if ($image->is_featured) {
            $image->is_featured = false; // Unfeature
        } else {
            if (GalleryImage::where('is_featured', true)->count() >= 4) {
                return response()->json(['error' => 'Only 4 images can be featured at a time.'], 400);
            }
            $image->is_featured = true; // Feature
        }

        $image->save();

        return response()->json(['success' => true, 'is_featured' => $image->is_featured]);
    }


    // Branches Management

    public function branches()
    {

        $branches = Branch::all();
        return view('dashboard.admin.branches-show', compact('branches'));
    }
    public function createBranches()
    {
        return view('dashboard.admin.branches-create');
    }


    // Store new branch
    public function storeBranches(Request $request)
    {

        // dd($request);
        $validated = $request->validate([
            'branch_name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'working_hours' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('branches', 'public');
            }
        }

        // Create Branch
        Branch::create([
            'branch_name' => $validated['branch_name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'working_hours' => $validated['working_hours'],
            'contact' => $validated['contact'],
            'email' => $validated['email'],
            'images' => $imagePaths,
        ]);

        return redirect()->route('admin.branches')->with('success', 'Branch created successfully!');
    }

    public function branchEdit($id)
    {
        $branch_details = Branch::where('id', $id)->first();
        // dd($branch_details);
        return view('dashboard.admin.branches-create', compact('branch_details'));
    }

    public function branchUpdate(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        // Validate request
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'working_hours' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Update branch details
        $branch->update([
            'branch_name' => $request->branch_name,
            'location' => $request->location,
            'description' => $request->description,
            'working_hours' => $request->working_hours,
            'contact' => $request->contact,
            'email' => $request->email,
        ]);

        // Handle image upload
        if ($request->hasFile('images')) {
            // Decode stored images properly
            $oldImages = is_string($branch->images) ? json_decode($branch->images, true) : $branch->images;


            // Ensure $oldImages is an array before deleting
            if (!empty($oldImages) && is_array($oldImages)) {
                foreach ($oldImages as $oldImage) {
                    if (is_string($oldImage)) {
                        Storage::delete('public/' . $oldImage);
                    }
                }
            }

            // Upload new images
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('branches', 'public'); // Store in storage/app/public/branches
                $imagePaths[] = $path;
            }

            // Save new image paths as JSON
            $branch->update(['images' => json_encode($imagePaths)]);
        }

        return redirect()->route('admin.branches')->with('success', 'Branch updated successfully');
    }


    public function branchDelete($id)
    {
        // dd($id);
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return redirect()->route('admin.branches')->with('success', 'Branch deleted successfully!');
    }

    // JOB MANAGEMENT

    // View all jobs
    public function jobs()
    {
        $jobs = Job::latest()->get();
        return view('dashboard.admin.jobs-view', compact('jobs'));
    }


    // Show job creation form
    public function createJob()
    {
        return view('dashboard.admin.job-create');
    }

    // Store new job
    public function storeJob(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'type' => 'required|in:Full-Time,Part-Time,Remote',
            'degree' => 'nullable|string|max:100',
            'description' => 'required|string',
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs')->with('success', 'Job created successfully!');
    }


    // Show job edit form
    public function jobEdit($id)
    {
        $job = Job::findOrFail($id);
        return view('dashboard.admin.job-edit', compact('job'));
    }

    // Update job details
    public function jobUpdate(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'type' => 'required|in:Full-Time,Part-Time,Remote',
            'degree' => 'nullable|string|max:100',
            'description' => 'required|string',
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs')->with('success', 'Job updated successfully!');
    }

    // Delete job
    public function jobDelete($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully!');
    }


    // Subject Management

    public function addsubject()
    {
        return view('dashboard.admin.subject-create', ['subject' => null]);
    }
    public function subjects()
    {
        $subjects = Subject::all();
        return view('dashboard.admin.subject-view', compact('subjects'));
    }

    public function storeSubject(Request $request)
    {
        // dd($request);
        $request->validate([
            'sub_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        Subject::create($request->all());

        return redirect()->route('admin.subjects')->with('success', 'Subject created successfully!');
    }
    public function subjectUpdate($id)
    {
        // dd($id);
        $subject = Subject::findOrFail($id);
        return view('dashboard.admin.subject-create', compact('subject'));
    }
    public function subjectEdit(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'sub_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $subject->update($request->all());

        return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully!');
    }
    public function subjectDelete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects')->with('success', 'Subject deleted successfully!');
    }

    // Application View
    public function ViewApplication()
    {
        $applications = Application::with('job')->latest()->get();
        return view('dashboard.admin.application-view', compact('applications'));
    }
    public function deleteApplication($id)
    {
        // dd($id);
        $application = Application::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        // Delete resume file from storage
        if ($application->resume) {
            Storage::disk('public')->delete($application->resume);
        }

        // Delete application record
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully']);
    }


    // Routine Management


    public function createRoutine()
    {
        $branches = Branch::all();
        $classLevels = ClassLevels::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('dashboard.admin.add-routine', compact('branches', 'classLevels', 'subjects', 'teachers'));
    }

    public function storeRoutine(Request $request)
    {


        // Validate the request data
        // $validated = $request->validate([
        //     'branch_id' => 'required',
        //     'class_level_id' => 'required',
        //     'routine' => 'required|array',
        //     'routine.*' => 'required|array',
        //     'routine.*.*' => 'required|array',
        //     'routine.*.*.start_time' => 'required|date_format:H:i',
        //     'routine.*.*.end_time' => 'required|date_format:H:i|after:routine.*.*.start_time',
        //     'routine.*.*.subject_id' => 'required',
        //     'routine.*.*.teacher_id' => 'required',
        // ]);

        // try {
        // Begin database transaction
        // dd($request);
        // DB::beginTransaction();

        // First delete existing routine for this branch and class level
        ClassRoutine::where('branch_id', $request->branch_id)
            ->where('class_level_id', $request->class_level_id)
            ->delete();

        // Process each day's periods
        foreach ($request->routine as $day => $periods) {
            foreach ($periods as $periodData) {
                ClassRoutine::create([
                    'branch_id' => $request->branch_id,
                    'class_level_id' => $request->class_level_id,
                    'day_of_week' => $day,
                    'start_time' => $periodData['start_time'],
                    'end_time' => $periodData['end_time'],
                    'subject_id' => $periodData['subject_id'],
                    'teacher_id' => $periodData['teacher_id'],
                    // 'created_by' => auth()->id(), // if you have user tracking
                ]);
            }
        }

        // Commit transaction
        DB::commit();

        return redirect()->route('admin.routine.create')
            ->with('success', 'Weekly routine created successfully');
        // } catch (\Exception $e) {
        //     // Rollback transaction on error
        //     DB::rollBack();

        //     return back()->withInput()
        //         ->with('error', 'Error creating routine: ' . $e->getMessage());
        // }
    }


    public function routineList()
    {
        $routines = ClassRoutine::select(
            'branches.id as branch_id',
            'branches.branch_name',
            'class_levels.id as class_level_id',
            'class_levels.name as class_name'
        )
            ->join('branches', 'branches.id', '=', 'class_routines.branch_id')
            ->join('class_levels', 'class_levels.id', '=', 'class_routines.class_level_id')
            ->groupBy('branches.id', 'branches.branch_name', 'class_levels.id', 'class_levels.name')
            ->get()
            ->groupBy('branch_name');
        // dd($routines);
        return view('dashboard.admin.routinelist', compact('routines'));
    }

    public function viewRoutine($branchId, $classLevelId)
    {
        $routine = ClassRoutine::with(['branch', 'classLevel', 'subject', 'teacher'])
            ->where('branch_id', $branchId)
            ->where('class_level_id', $classLevelId)
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        $branch = $routine->first()->branch ?? null;
        $classLevel = $routine->first()->classLevel ?? null;
        // dd($routine);
        return view('dashboard.admin.routineview', compact('routine', 'branch', 'classLevel'));
    }

    public function downloadRoutine($branchId, $classLevelId, $type)
    {
        $routine = ClassRoutine::with(['branch', 'classLevel', 'subject', 'teacher'])
            ->where('branch_id', $branchId)
            ->where('class_level_id', $classLevelId)
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        $branch = $routine->first()->branch;
        $classLevel = $routine->first()->classLevel;

        if ($type === 'pdf') {
            $pdf = PDF::loadView('dashboard.admin.routinepdf', compact('routine', 'branch', 'classLevel'));
            return $pdf->download("{$branch->branch_name}-{$classLevel->name}-routine.pdf");
        }

        if ($type === 'image') {
            $html = view('dashboard.admin.routineimage', compact('routine', 'branch', 'classLevel'))->render();

            // Create a new image with specified dimensions
            $img = Image::canvas(800, 600, '#ffffff');

            // For actual HTML to image conversion, you would need additional packages
            // This is a simplified version that won't work directly
            return response()->make(
                $img->encode('jpg'),
                200,
                [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'attachment; filename="' . $branch->branch_name . '-' . $classLevel->name . '-routine.jpg"'
                ]
            );
        }

        return back();
    }

    public function routineEdit($id)
    {
        // dd($id);
        $routine = ClassRoutine::findOrFail($id);
        $branches = Branch::all();
        $classLevels = ClassLevels::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('dashboard.admin.routine-edit', compact('routine', 'branches', 'classLevels', 'subjects', 'teachers'));
    }

    public function routineUpdate(Request $request, $id)
    {
        // dd($request);

        // $validated = $request->validate([
        //     'branch_id' => 'required',
        //     'class_level_id' => 'required',
        //     'day_of_week' => 'required|string',
        //     'start_time' => 'required|date_format:H:i',
        //     'end_time' => 'required|date_format:H:i|after:start_time',
        //     'subject_id' => 'required',
        //     'teacher_id' => 'required',
        // ]);
        // dd($validated);

        $routine = ClassRoutine::findOrFail($id);
        $routine->update($request->all());

        // return redirect()->back()->with('success', 'Routine updated successfully');


        return redirect()->route('admin.routine.view', ['b_id' => $request->branch_id, 'c_id' => $request->class_level_id])
            ->with('success', 'Routine updated successfully');
    }
    public function routineDelete($id)
    {
        $routine = ClassRoutine::findOrFail($id);
        $routine->delete();

        // return redirect()->route('admin.routine.index')
        return redirect()->route('admin.routine.view', ['b_id' => $routine->branch_id, 'c_id' => $routine->class_level_id])
            ->with('success', 'Routine deleted successfully');
    }


    // Feedback Management

    public function feedbackIndex()
    {
        $filter = request('filter', 'all');

        $feedbacks = Feedback::with(['user', 'branch'])
            ->when($filter != 'all', function ($query) use ($filter) {
                return $query->where('status', $filter);
            })
            ->latest()
            ->paginate(15);

        return view('dashboard.admin.feedbacks', compact('feedbacks'));
    }

    public function updateFeedback(Request $request, $id)
    {
        // dd($request,$id);
        $feedback = Feedback::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $feedback->update($validated);

        return back()->with('success', 'Feedback updated successfully!');
    }






    //Attendance Management

    public function todayclass()
    {
        $today = strtolower(now()->format('l')); // e.g. 'monday'

        // Get branches that have classes today with eager loading
        $branches = Branch::with(['todayClasses' => function ($query) use ($today) {
            $query->with(['classLevel', 'subject', 'teacher'])
                ->where('day_of_week', $today)
                ->orderBy('start_time');
        }])->whereHas('todayClasses', function ($query) use ($today) {
            $query->where('day_of_week', $today);
        })->get();


        foreach ($branches as $branch) {
            foreach ($branch->todayClasses as $index => $class) {
                $class->is_complete = Attendance::where('class_routine_id', $class->id)
                    ->whereDate('date', now()->toDateString())
                    ->exists();
            }
        }
        // dd($branches->class->id);
        return view('dashboard.admin.todayclasses', compact('branches'));
    }

    // public function classStudents($b_id, $c_id, $r_id)
    // {
    //     // dd($b_id, $c_id,$r_id);
    //     $classLevel = ClassLevels::findOrFail($c_id);
    //     $students = Student::where('class', $c_id)->get();
    //     $branch = Branch::findOrFail($b_id);
    //     $teacherid = ClassRoutine::where('id', $r_id)->first()->teacher_id;
    //     $teacher = Teacher::where('teacher_id', $teacherid)->first();
    //     // dd($teacher);
    //     return view('dashboard.admin.student-attendence', compact('students', 'classLevel', 'branch', 'r_id', 'teacher'));
    // }

    public function classStudents($b_id, $c_id, $r_id)
    {
        $classLevel = ClassLevels::findOrFail($c_id);
        $students = Student::where('class', $c_id)->get();
        $branch = Branch::findOrFail($b_id);

        // Get class routine and teacher
        $classRoutine = ClassRoutine::where('id', $r_id)->first();
        $teacher = Teacher::where('teacher_id', $classRoutine->teacher_id)->first();

        // Get today's date
        $today = \Carbon\Carbon::today()->toDateString();

        // Get existing teacher attendance
        $teacherAttendance = TeacherAttendance::where([
            'teacher_id' => $teacher->teacher_id,
            'class_routine_id' => $r_id,
            'date' => $today
        ])->first();

        // Get existing student attendance
        $studentAttendanceRecords = Attendance::where([
            'class_routine_id' => $r_id,
            'date' => $today
        ])->get()->keyBy('student_id');

        return view('dashboard.admin.student-attendence', compact(
            'students',
            'classLevel',
            'branch',
            'r_id',
            'teacher',
            'teacherAttendance',
            'studentAttendanceRecords'
        ));
    }

    // public function storeAttendance(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'class_routine_id' => 'required|exists:class_routines,id',
    //         'date' => 'required|date',
    //         'attendance' => 'required|array',
    //     ]);

    //     try {
    //         DB::beginTransaction();
    //         // dd($request->attendance);
    //         foreach ($request->attendance as $studentId => $data) {
    //             Attendance::updateOrCreate(
    //                 [
    //                     'student_id' => $studentId,
    //                     'class_routine_id' => $request->class_routine_id,
    //                     'date' => $request->date,
    //                 ],
    //                 [
    //                     'status' => $data['status'] ?? 0, // Default to absent if not checked
    //                     'remarks' => $data['remarks'] ?? null,
    //                 ]
    //             );
    //         }

    //         DB::commit();

    //         return redirect()->back()->with('success', 'Attendance saved successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Error saving attendance: ' . $e->getMessage());
    //     }
    // }

    // public function storeAttendance(Request $request)
    // {
    //     $request->validate([
    //         'class_routine_id' => 'required|exists:class_routines,id',
    //         'date' => 'required|date',
    //         'attendance' => 'required|array',
    //         'attendance.*.status' => 'sometimes|boolean',
    //         'attendance.*.remarks' => 'nullable|string|max:255',
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         foreach ($request->attendance as $studentId => $data) {
    //             Attendance::updateOrCreate(
    //                 [
    //                     'student_id' => $studentId,
    //                     'class_routine_id' => $request->class_routine_id,
    //                     'date' => $request->date,
    //                 ],
    //                 [
    //                     // 'status' => isset($data['status']) ? 1 : 0,
    //                     'status' => isset($data['status']) && $data['status'] ? 1 : 0,
    //                     'remarks' => $data['remarks'] ?? null,
    //                 ]
    //             );
    //         }

    //         DB::commit();

    //         return redirect()->route('admin.todayclass')->with('success', 'Attendance saved successfully!');

    //         // return redirect()->back()->with('success', 'Attendance saved successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()
    //             ->withInput()
    //             ->with('error', 'Error saving attendance: ' . $e->getMessage());
    //     }
    // }

    public function storeAttendance(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'class_routine_id' => 'required|exists:class_routines,id',
            'date' => 'required|date',
            'teacher_attendance.status' => 'sometimes|boolean',
            'teacher_attendance.remarks' => 'nullable|string|max:255',
            'attendance' => 'required|array',
            'attendance.*.status' => 'sometimes|boolean',
            'attendance.*.remarks' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Get the teacher_id from the class routine
            $classRoutine = ClassRoutine::findOrFail($request->class_routine_id);
            $teacherId = $classRoutine->teacher_id;

            // Save teacher attendance
            if (isset($request->teacher_attendance)) {
                TeacherAttendance::updateOrCreate(
                    [
                        'teacher_id' => $teacherId,
                        'class_routine_id' => $request->class_routine_id,
                        'date' => $request->date,
                    ],
                    [
                        'status' => $request->teacher_attendance['status'] ?? 0,
                        'remarks' => $request->teacher_attendance['remarks'] ?? null,
                    ]
                );
            }

            // Save student attendance
            foreach ($request->attendance as $studentId => $data) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'class_routine_id' => $request->class_routine_id,
                        'date' => $request->date,
                    ],
                    [
                        'status' => isset($data['status']) && $data['status'] ? 1 : 0,
                        'remarks' => $data['remarks'] ?? null,
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.todayclass')->with('success', 'Attendance saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error saving attendance: ' . $e->getMessage());
        }
    }

    public function calendarView()
    {
        $attendanceDays = Attendance::select('date')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN 1 END) as present')
            ->groupBy('date')
            ->get();
        return view('dashboard.admin.attendance-calendar', compact('attendanceDays'));
    }

    public function getDateClasses(Request $request)
    {
        $date = $request->input('date');
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->englishDayOfWeek;

        // Get all classes scheduled for this day of week
        $classes = ClassRoutine::with(['branch', 'classLevel'])
            ->where('day_of_week', $dayOfWeek)
            ->get()
            ->groupBy('branch_id');

        return view('dashboard.admin.attendance-dateclasses', compact('classes', 'date'));
    }
    public function getClassAttendance(Request $request)
    {
        $classRoutineId = $request->input('class_routine_id');
        $date = $request->input('date');

        $class = ClassRoutine::with(['branch', 'classLevel', 'subject', 'teacher'])->find($classRoutineId);

        $students = Student::where('branch_id', $class->branch_id)
            ->where('class', $class->class_level_id)
            ->get();

        // Get attendance records for these students on this date for this class
        $attendanceRecords = Attendance::where('class_routine_id', $classRoutineId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('dashboard.admin.attendance-classattendance', compact('class', 'students', 'attendanceRecords', 'date'));
    }


    // Holidays Management
    public function holidayindex()
    {
        // $holidays = Holiday::with('branch')->latest()->paginate(10);
        $holidays = Holiday::with('branch')->paginate(10);
        return view('dashboard.admin.holidays.index', compact('holidays'));
    }

    public function holidaycreate()
    {
        $branches = Branch::all();
        return view('dashboard.admin.holidays.create', compact('branches'));
    }

    public function holidaystore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'is_recurring' => 'boolean',
            'branch_id' => 'nullable|exists:branches,id'
        ]);

        Holiday::create($request->all());

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday created successfully.');
    }

    public function holidayshow(Holiday $holiday)
    {
        return view('dashboard.admin.holidays.show', compact('holiday'));
    }

    public function holidayedit(Holiday $holiday)
    {
        $branches = Branch::all();
        return view('dashboard.admin.holidays.edit', compact('holiday', 'branches'));
    }

    public function holidayupdate(Request $request, Holiday $holiday)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'is_recurring' => 'boolean',
            'branch_id' => 'nullable|exists:branches,id'
        ]);

        $holiday->update($request->all());

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday updated successfully.');
    }

    public function holidaydestroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('holidays.index')
            ->with('success', 'Holiday deleted successfully.');
    }

    //Leave Management

    public function leaveindex()
    {
        // $applications = LeaveApplication::with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
        $applications = DB::table('leave_applications')
            ->join('users', 'leave_applications.user_id', '=', 'users.unique_id')
            ->select('leave_applications.*', 'users.name as user_name', 'users.email as user_email') // include any user fields you need
            ->orderBy('leave_applications.created_at', 'desc')
            ->paginate(10);

        // dd($applications);
        return view('dashboard.admin.leave.leaveindex', compact('applications'));
    }

    public function leaveupdate(Request $request, LeaveApplication $leaveApplication)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_comment' => 'nullable|string|max:500',
        ]);

        $leaveApplication->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
        ]);

        return redirect()->back()->with('success', 'Leave application updated!');
    }


    // Objections Management

    public function objections(Request $request)
    {
        $query = Objection::with(['student', 'teacher', 'classLevel', 'branch'])
            ->orderBy('created_at', 'desc');

        // Add search filters
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('stu_id', 'like', "%$search%");
            })
                ->orWhereHas('branch', function ($q) use ($search) {
                    $q->where('branch_name', 'like', "%$search%");
                })
                ->orWhereHas('classLevel', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        $objections = $query->get();
        $classes = ClassLevels::all();
        $branches = Branch::all();
        $teachers = Teacher::all();
        $students = Student::all();

        return view('dashboard.admin.objections', compact('objections', 'classes', 'branches', 'teachers', 'students'));
    }

    public function storeObjection(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,stu_id',
            'class_level_id' => 'required|exists:class_levels,id',
            'branch_id' => 'required|exists:branches,id',
            // 'teacher_id' => 'required|exists:teachers,teacher_id',
            'teacher_id' => 'nullable|exists:teachers,teacher_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if (!isset($validated['teacher_id']) || empty($validated['teacher_id'])) {
            // If teacher_id is not provided, set it to null
            $validated['approved'] = 1; // Automatically approve if no teacher is assigned
            $validated['teacher_id'] = null; // Set teacher_id to null
        }

        // dd($validated);
        Objection::create($validated);


        return redirect()->route('admin.objections')->with('success', 'Objection added successfully!');
    }

    public function approveObjection($id)
    {
        // dd($id);
        // $objection = Objection::findOrFail($id);
        $approved = Objection::where('student_id', $id)
            ->update([
                'approved' => 1
            ]);

        return redirect()->route('admin.objections')->with('success', 'Objection approved successfully!');
    }

    public function searchStudents1(Request $request)
    {
        $search = $request->search;

        $students = Student::with(['branch', 'classLevel'])
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('stu_id', 'like', "%$search%")
                    ->orWhereHas('branch', function ($q) use ($search) {
                        $q->where('branch_name', 'like', "%$search%");
                    })
                    ->orWhereHas('classLevel', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            })
            ->paginate(10);

        $results = $students->map(function ($student) {
            return [
                'id' => $student->stu_id,
                'text' => $student->name,
                'name' => $student->name,
                'stu_id' => $student->stu_id,
                'branch' => $student->branch->branch_name ?? 'N/A',
                'class' => $student->classLevel->name ?? 'N/A'
            ];
        });

        return response()->json([
            'results' => $results,
            'total_count' => $students->total()
        ]);
    }

    // In your AdminController.php
    public function getStudentDetails(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,stu_id'
        ]);

        $student = Student::with(['branch', 'classLevel'])
            ->where('stu_id', $request->student_id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'class_level_id' => $student->class_level_id,
                'branch_id' => $student->branch_id,
                'student_name' => $student->name,
                'branch_name' => $student->branch->branch_name ?? 'N/A',
                'class_name' => $student->classLevel->name ?? 'N/A'
            ]
        ]);
    }

    public function getStudentsByBranchClass(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'class_level_id' => 'required|exists:class_levels,id'
        ]);

        $students = Student::where('branch_id', $request->branch_id)
            ->where('class', $request->class_level_id)
            ->get(['stu_id', 'name', 'image']);

        // Map students to include full image URLs
        $students = $students->map(function ($student) {
            return [
                'stu_id' => $student->stu_id,
                'name' => $student->name,
                'image_url' => $student->image ? asset('storage/' . $student->image) : asset('images/default-student.png')
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }
}
