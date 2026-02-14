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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('website.home');
// })->name('home');


// Route::get('/gallery', function () {
//     return view('website.gallery');
// })->name('gallery');
// Route::get('/branches', function () {
//     return view('website.branches');
// })->name('branches');
// Route::get('/contact-us', function () {
//     return view('website.contactus');
// })->name('contactus');
// Route::get('/about-us', function () {
//     return view('website.aboutus');
// })->name('aboutus');



// Route::get('/dash', function () {
//     return view('dashboard.dash');
// });


Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');
Route::get('/branches', [WebsiteController::class, 'branches'])->name('branches');
Route::get('/contact-us', [WebsiteController::class, 'contactus'])->name('contactus');
Route::get('/about-us', [WebsiteController::class, 'aboutus'])->name('aboutus');
Route::get('/notification/{id}', [WebsiteController::class, 'shownotice'])->name('notification.details');
Route::post('/contact-submit', [WebsiteController::class, 'contactSubmit'])->name('contact.submit');

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['redirect_if_authenticated'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
});




// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'view'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/teacher/dashboard',[TeacherController::class, 'view'])->name('teacher.dashboard')->middleware('role:teacher');
    Route::get('/student/dashboard', [StudentController::class, 'view'])->name('student.dashboard')->middleware('role:student');
    Route::get('/parent/dashboard', [ParentController::class, 'view'])->name('parent.dashboard')->middleware('role:parent');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes

        // For New Notice Register and Show

    Route::get('/admin/notice-add-form', [AdminController::class, 'noticeAddForm'])->name('admin.noticeaddform')->middleware('role:admin');
    Route::post('/notice/store', [AdminController::class, 'store'])->name('notice.store')->middleware('role:admin');
    Route::get('/admin/notice-show', [AdminController::class, 'noticeShow'])->name('admin.noticeshow')->middleware('role:admin');
    Route::get('/admin/notices/edit/{id}', [AdminController::class, 'noticeedit'])->name('notices.edit')->middleware('role:admin');
    Route::put('/admin/notice/update/{id}', [AdminController::class, 'updateNotice'])->name('notice.update')->middleware('role:admin');
    Route::delete('/admin/notices/delete/{id}', [AdminController::class, 'noticedestroy'])->name('notices.destroy')->middleware('role:admin');

        // For New member Register and Show

    Route::get('/add-member', [AdminController::class, 'showRegisterForm'])->name('registerform')->middleware('role:admin');
    Route::get('/get-subjects', [AdminController::class, 'getSubjects'])->name('getSubjects')->middleware('role:admin');
    Route::post('/member-register', [AdminController::class, 'memberregister'])->name('memberregister')->middleware('role:admin');
    Route::get('/admin/members/{role}', [AdminController::class, 'showMembers'])->name('admin.students')->middleware('role:admin');
    Route::put('/admin/member/update/{id}', [AdminController::class, 'memberUpdate'])->name('memberUpdate')->middleware('role:admin');
    Route::get('/admin/members/edit/{unick_id}', [AdminController::class, 'memberedit'])->name('member.edit')->middleware('role:admin');
    Route::delete('/admin/members/{id}', [AdminController::class, 'deleteMember'])->name('member.delete');


        //contact view

    Route::get('/admin/contacts-view', [AdminController::class, 'contactView'])->name('admin.contacts.view');

        //Image Upload ,Delete ,featured

    Route::get('/admin/gallery', [AdminController::class, 'admingallery'])->name('admin.gallery');
    Route::post('/admin/gallery/upload', [AdminController::class, 'store'])->name('admin.gallery.upload');
    Route::delete('/admin/gallery/delete/{id}', [AdminController::class, 'destroy'])->name('admin.gallery.delete');
    Route::post('/admin/gallery/feature/{id}', [AdminController::class, 'toggleFeatured'])->name('admin.gallery.feature');
});






