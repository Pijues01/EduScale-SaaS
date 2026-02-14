<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\WebsiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Website Public Routes
Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');
Route::get('/branches', [WebsiteController::class, 'branches'])->name('branches');
Route::get('/contact-us', [WebsiteController::class, 'contactus'])->name('contactus');
Route::get('/about-us', [WebsiteController::class, 'aboutus'])->name('aboutus');
Route::get('/notification/{id}', [WebsiteController::class, 'shownotice'])->name('notification.details');
Route::post('/contact-submit', [WebsiteController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/consult-submit', [WebsiteController::class, 'consultSubmit'])->name('consult.submit');
Route::get('/career', [WebsiteController::class, 'career'])->name('career');
Route::post('/job-apply', [WebsiteController::class, 'jobApply'])->name('job.apply');

// Authentication Routes
Route::middleware(['redirect_if_authenticated'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
});
Route::post('/login', [AuthController::class, 'login']);

// Dashboard Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profileshow'])->name('profile');
    Route::put('/profile', [AuthController::class, 'profileupdate'])->name('profile.update');
    Route::post('/profile/avatar', [AuthController::class, 'profileupdateAvatar'])->name('profile.avatar');

    // Admin Dashboard & Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'view'])->name('admin.dashboard');

        // Notice Management
        Route::get('/notice-add-form', [AdminController::class, 'noticeAddForm'])->name('admin.noticeaddform');
        Route::post('/notice/store', [AdminController::class, 'store'])->name('notice.store');
        Route::get('/notice-show', [AdminController::class, 'noticeShow'])->name('admin.noticeshow');
        Route::get('/notices/edit/{id}', [AdminController::class, 'noticeedit'])->name('notices.edit');
        Route::put('/notice/update/{id}', [AdminController::class, 'updateNotice'])->name('notice.update');
        Route::delete('/notices/delete/{id}', [AdminController::class, 'noticedestroy'])->name('notices.destroy');

        // Member Management (Students, Teachers, Parents)
        Route::get('/add-member', [AdminController::class, 'showRegisterForm'])->name('registerform');
        Route::get('/get-subjects', [AdminController::class, 'getSubjects'])->name('getSubjects');

        Route::get('/search-students', [AdminController::class, 'searchStudents'])->name('searchStudents');

        Route::post('/member-register', [AdminController::class, 'memberregister'])->name('memberregister');
        Route::get('/members/{role}', [AdminController::class, 'showMembers'])->name('admin.members');
        Route::put('/member/update/{id}', [AdminController::class, 'memberUpdate'])->name('memberUpdate');
        Route::get('/members/edit/{unick_id}', [AdminController::class, 'memberedit'])->name('member.edit');
        Route::delete('/members/{id}', [AdminController::class, 'deleteMember'])->name('member.delete');

        // Contact View
        Route::get('/contacts-view', [AdminController::class, 'contactView'])->name('admin.contacts.view');
        Route::get('/consults-view', [AdminController::class, 'consultView'])->name('admin.consults.view');

        // Gallery Management
        Route::get('/gallery', [AdminController::class, 'admingallery'])->name('admin.gallery');
        Route::post('/gallery/upload', [AdminController::class, 'uploadImage'])->name('admin.gallery.upload');
        Route::delete('/gallery/delete/{id}', [AdminController::class, 'deleteImage'])->name('admin.gallery.delete');
        Route::post('/gallery/feature/{id}', [AdminController::class, 'toggleFeatured'])->name('admin.gallery.feature');

        // Branches management
        Route::get('/branches', [AdminController::class, 'branches'])->name('admin.branches');
        Route::get('/branch/create', [AdminController::class, 'createBranches'])->name('admin.branches.create');
        Route::post('/branch/store', [AdminController::class, 'storeBranches'])->name('admin.branches.store');
        Route::get('/branch/edit/{id}', [AdminController::class, 'branchEdit'])->name('admin.branches.edit');
        Route::put('/admin/branches/update/{id}', [AdminController::class, 'branchUpdate'])->name('admin.branches.update');
        Route::delete('branch/delete/{id}', [AdminController::class, 'branchDelete'])->name('admin.branches.delete');

        //Job Management
        Route::get('/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
        Route::get('/job/create', [AdminController::class, 'createJob'])->name('admin.jobs.create');
        Route::post('/job/store', [AdminController::class, 'storeJob'])->name('admin.jobs.store');
        Route::get('/job/edit/{id}', [AdminController::class, 'jobEdit'])->name('admin.jobs.edit');
        Route::put('/job/update/{id}', [AdminController::class, 'jobUpdate'])->name('admin.jobs.update');
        Route::delete('/job/delete/{id}', [AdminController::class, 'jobDelete'])->name('admin.jobs.delete');

        // Subject Management
        Route::get('/add-subject', [AdminController::class, 'addsubject'])->name('admin.addsubject');
        Route::post('/subject/store', [AdminController::class, 'storeSubject'])->name('admin.subject.store');
        Route::get('/subjects', [AdminController::class, 'subjects'])->name('admin.subjects');
        Route::get('/subject/update/{id}', [AdminController::class, 'subjectUpdate'])->name('admin.subject.update');
        Route::put('/subject/edit/{id}', [AdminController::class, 'subjectEdit'])->name('admin.subject.edit');
        Route::delete('/subject/delete/{id}', [AdminController::class, 'subjectDelete'])->name('admin.subject.delete');


        // Applications
        Route::get('/application', [AdminController::class, 'ViewApplication'])->name('admin.viewapplication');
        Route::delete('/application/delete/{id}', [AdminController::class, 'deleteApplication'])->name('admin.application.delete');

        // Routine Management
        Route::get('/routine', [AdminController::class, 'routineList'])->name('admin.routine');
        Route::get('/routine/create', [AdminController::class, 'createRoutine'])->name('admin.routine.create');
        Route::post('/routine/store', [AdminController::class, 'storeRoutine'])->name('admin.routine.store');


        Route::get('/routine', [AdminController::class, 'routineList'])->name('admin.routine');
        Route::get('/routine/view/{b_id}/{c_id}', [AdminController::class, 'viewRoutine'])->name('admin.routine.view');
        Route::get('/download/{branch}/{classLevel}/{type}', [AdminController::class, 'downloadRoutine'])->name('admin.routine.download');
        Route::get('/routine/edit/{id}', [AdminController::class, 'routineEdit'])->name('admin.routine.edit');
        Route::put('/routine/update/{id}', [AdminController::class, 'routineUpdate'])->name('admin.routine.update');
        Route::delete('/routine/delete/{id}', [AdminController::class, 'routineDelete'])->name('admin.routine.delete');
        // get.teachers.by.subject
        Route::get('/get-teachers-by-subject', [AdminController::class, 'getTeachersBySubject'])->name('admin.get.teachers.by.subject');

        //Feedback Routes
        Route::get('/admin/feedbacks', [AdminController::class, 'feedbackIndex'])->name('admin.feedbacks');
        Route::put('/feedbacks/{id}', [AdminController::class, 'updateFeedback'])->name('admin.feedbacks.update');

        //Attendance Routes
        Route::get('/today-class', [AdminController::class, 'todayclass'])->name('admin.todayclass');
        Route::get('/class/students/{branch_id}/{class_level_id}/{routine_id}', [AdminController::class, 'classStudents'])->name('class.students');
        Route::post('/attendance/store', [AdminController::class, 'storeAttendance'])->name('attendance.store');

        Route::get('/attendance/calendar', [AdminController::class, 'calendarView'])->name('attendance.calendar');
        Route::get('/attendance/date-classes', [AdminController::class, 'getDateClasses'])->name('attendance.date-classes');
        Route::get('/attendance/class-attendance', [AdminController::class, 'getClassAttendance'])->name('attendance.class-attendance');

        //Holidays Route
        Route::get('holidays', [AdminController::class, 'holidayindex'])->name('holidays.index');
        Route::get('holidays/create', [AdminController::class, 'holidaycreate'])->name('holidays.create');
        Route::post('holidays', [AdminController::class, 'holidaystore'])->name('holidays.store');
        Route::get('holidays/{holiday}', [AdminController::class, 'holidayshow'])->name('holidays.show');
        Route::get('holidays/{holiday}/edit', [AdminController::class, 'holidayedit'])->name('holidays.edit');
        Route::put('holidays/{holiday}', [AdminController::class, 'holidayupdate'])->name('holidays.update');
        Route::delete('holidays/{holiday}', [AdminController::class, 'holidaydestroy'])->name('holidays.destroy');

        //Leave Application
        Route::get('/admin/leave-applications', [AdminController::class, 'leaveindex'])->name('admin.leave.index');
        Route::put('/admin/leave-applications/{leaveApplication}', [AdminController::class, 'leaveupdate'])->name('admin.leave.update');

        //Objection Manegment
        Route::get('/objections', [AdminController::class, 'objections'])->name('admin.objections');
        Route::post('/objections', [AdminController::class, 'storeObjection'])->name('admin.objections.store');
        Route::post('/objections/{id}/approve', [AdminController::class, 'approveObjection'])->name('admin.objections.approve');
        Route::get('/admin/search-students', [AdminController::class, 'searchStudents1'])->name('admin.searchStudents');
        Route::get('/admin/get-student-details', [AdminController::class, 'getStudentDetails'])->name('admin.getStudentDetails');
        Route::get('/admin/get-students-by-branch-class', [AdminController::class, 'getStudentsByBranchClass'])->name('admin.getStudentsByBranchClass');
    });

    // Teacher Dashboard
    // Route::middleware(['role:teacher'])->get('/teacher/dashboard', [TeacherController::class, 'view'])->name('teacher.dashboard');
    // Teacher Routes Group
    Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

        // Schedule (add this new route)
        Route::get('/schedule', [TeacherController::class, 'mySchedule'])->name('teacher.schedule');
        Route::get('/student-byclass/{b_id}/{c_id}', [TeacherController::class, 'studentbyclass'])->name('students.byClass');

        //Notice Routes
        Route::get('/notice-show', [TeacherController::class, 'allnotice'])->name('teacher.noticeshow');
        Route::get('/notice-view/{id}', [TeacherController::class, 'noticeview'])->name('teacher.noticeview');
        Route::get('/notice-show-general', [TeacherController::class, 'allnoticegeneral'])->name('teacher.noticeshow.general');

        //Student Objection Routes
        Route::post('/objections', [TeacherController::class, 'objectionstore'])->name('teacher.objections.store');

        //Feedback Routes
        Route::get('/teacher/feedback', [TeacherController::class, 'feedbackIndex'])->name('teacher.feedback');
        Route::post('/teacher/feedback', [TeacherController::class, 'storeFeedback'])->name('teacher.feedback.store');
        //Holiday Shedule
        Route::get('/holidays', [TeacherController::class, 'holidays'])->name('teacher.holidays.index');

        //Leave Application
        Route::get('/teacher/leave', [TeacherController::class, 'leavecreate'])->name('teacher.leave.create');
        Route::post('/teacher/leave', [TeacherController::class, 'leavestore'])->name('teacher.leave.store');
        // Add other teacher routes here...




        Route::get('/materials', [TeacherController::class, 'materialsindex'])->name('materials.index');
        Route::get('/materials/create', [TeacherController::class, 'materialscreate'])->name('materials.create');
        Route::post('/materials', [TeacherController::class, 'materialsstore'])->name('materials.store');
        Route::get('/materials/{material}/edit', [TeacherController::class, 'materialsedit'])->name('materials.edit');
        Route::put('/materials/{material}', [TeacherController::class, 'materialsupdate'])->name('materials.update');
        Route::get('/materials/show/{material}', [TeacherController::class, 'materialshow'])->name('materials.show');
        Route::delete('/materials/{material}', [TeacherController::class, 'materialsdestroy'])->name('materials.destroy');


    });







    // Student Dashboard
    // Route::middleware(['role:student'])->get('/student/dashboard', [StudentController::class, 'view'])->name('student.dashboard');
    Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {

        Route::get('/dashboard', [StudentController::class, 'view'])->name('student.dashboard');
        Route::get('/attendance', [StudentController::class, 'studentCalendarView'])
            ->name('student.attendance.calendar');
        Route::get('/attendance/date', [StudentController::class, 'getStudentDateAttendance'])
            ->name('student.attendance.date');

        //Notice Routes
        Route::get('/notice-show', [StudentController::class, 'studentnotice'])->name('student.noticeshow');
        Route::get('/notice-view/{id}', [StudentController::class, 'noticeview'])->name('student.noticeview');
        Route::get('/notice-show-general', [StudentController::class, 'allnoticegeneral'])->name('student.noticeshow.general');

        //Feedback Routes
        Route::get('/feedback', [StudentController::class, 'feedbackIndex'])->name('student.feedback');
        Route::post('/feedback', [StudentController::class, 'storeFeedback'])->name('student.feedback.store');
        //Class Shedule
        Route::get('/class-schedule', [StudentController::class, 'classschedule'])->name('student.classschedule');
        //Holiday Shedule
        Route::get('/holidays', [StudentController::class, 'holidays'])->name('student.holidays.index');

        //Leave Application
        Route::get('/student/leave', [StudentController::class, 'leavecreate'])->name('student.leave.create');
        Route::post('/student/leave', [StudentController::class, 'leavestore'])->name('student.leave.store');

        Route::get('/materials', [StudentController::class, 'materialsindex'])->name('student.materials.index');
        Route::get('/materials/show/{material}', [StudentController::class, 'materialshow'])->name('student.materials.show');
    });

    // Parent Dashboard
    // Route::middleware(['role:parent'])->get('/parent/dashboard', [ParentController::class, 'view'])->name('parent.dashboard');
    Route::middleware(['auth', 'role:parent'])->prefix('parent')->group(function () {
        Route::get('/dashboard', [ParentController::class, 'view'])->name('parent.dashboard');
        Route::get('/children', [ParentController::class, 'parentChildrenList'])->name('parent.children');
        // Route::get('/attendance/{studentId}', [ParentController::class, 'parentChildCalendar'])->name('parent.attendance.calendar');
        // Route::get('/attendance/{studentId}/date', [ParentController::class, 'parentDateAttendance'])->name('parent.attendance.date');

        //Notice Routes
        Route::get('/parent-notices', [ParentController::class, 'parentnotice'])->name('parent.notices');
        Route::get('/notice-view/{id}', [ParentController::class, 'noticeview'])->name('parent.noticeview');
        Route::get('/general-notice', [ParentController::class, 'generalnotice'])->name('parent.notices.general');

        //Feedback Routes
        Route::get('/feedback', [ParentController::class, 'feedbackIndex'])->name('parent.feedback');
        Route::post('/feedback', [ParentController::class, 'storeFeedback'])->name('parent.feedback.store');

        //Holiday Shedule
        Route::get('/holidays', [ParentController::class, 'holidays'])->name('parent.holidays.index');

        //Objection Routes
        Route::get('/objections', [ParentController::class, 'parentObjections'])->name('parent.objections');

        //Class Shedule
        Route::get('/class-schedule/{id}', [ParentController::class, 'classschedule'])->name('parent.classschedule');

        //Attendance Routes
        // Route::get('/attendance/{id}', [ParentController::class, 'studentCalendarView'])->name('parent.attendance.calendar');
        // Route::get('/attendance/date', [ParentController::class, 'getStudentDateAttendance'])->name('parent.attendance.date');
        Route::get('/attendance/{id}', [ParentController::class, 'studentCalendarView'])->name('parent.attendance.calendar');
        Route::get('/attendance/{id}/date', [ParentController::class, 'getStudentDateAttendance'])->name('parent.attendance.date');
    });
});
