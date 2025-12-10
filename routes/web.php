<?php

use Inertia\Inertia;
use App\Mail\SendEmailReject;
use App\Mail\SendEmailRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\Public\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('Index', [

//     ]);
// })->name('/');

Route::get('/', [\App\Http\Controllers\Public\PublicController::class, 'index'])->name('/');

Route::get('/email', function () {
    return view('Emails.Registration', [
        'data' => [
            'name' => "randi",
            'id' => "123",
              'password' => "randi",
              'email' => "randisun1995@gmail.com"
        ]
        // Add any data you want to pass to the view here
    ]);
});
//prefix "admin"
Route::prefix('admin')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

        //route management
        Route::get('/profile', [App\Http\Controllers\Admin\ManagementController::class, 'index'])->name('profile.index');
        Route::put('/profile/password', [App\Http\Controllers\Admin\ManagementController::class, 'updatePassword'])->name('profile.password.update');
        Route::get('/registration/', [\App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('admin.registration.index')->middleware('role:administrator,peserta');

        //route registration
          Route::get('/registration/email', [\App\Http\Controllers\Admin\RegistrationController::class, 'sendEmail'])->name('admin.registration.sendEmail')->middleware('role:administrator,peserta');
        Route::post('/registration/store', [\App\Http\Controllers\Admin\RegistrationController::class, 'store'])->name('admin.registration.store')->middleware('role:administrator,peserta');
        Route::put('/registration/{id}/update', [\App\Http\Controllers\Admin\RegistrationController::class, 'update'])->name('admin.registration.update')->middleware('role:administrator,peserta');
        Route::get('/registration/{id}/email-approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'Sendemailapprove'])->name('admin.registration.email.approve')->middleware('role:administrator,peserta');
        Route::get('/registration/{id}/approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'approve'])->name('admin.registration.approve')->middleware('role:administrator,peserta');
        Route::get('/registration/{id}/confirm', [\App\Http\Controllers\Admin\RegistrationController::class, 'confirm'])->name('admin.registration.confirm')->middleware('role:administrator,peserta');
        Route::get('/registration/{id}/reject', [\App\Http\Controllers\Admin\RegistrationController::class, 'reject'])->name('admin.registration.reject')->middleware('role:administrator,peserta');
        Route::get('/registration/export', [\App\Http\Controllers\Admin\RegistrationController::class, 'export'])->name('registrations.export')->middleware('role:administrator,peserta');
        // Route::get('/registration/{id}/email', [\App\Http\Controllers\Admin\RegistrationController::class, 'sendEmail'])->name('admin.registration.sendEmail')->middleware('role:administrator,peserta');
        Route::resource('/registration', \App\Http\Controllers\Admin\RegistrationController::class, ['as' => 'admin']);



        //route posts
        Route::get('/admin/posts/', [\App\Http\Controllers\Admin\PostController::class, 'list'])->name('admin.posts.list')->middleware('role:administrator');
        Route::post('/posts/{id}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.posts.update')->middleware('role:administrator');
        Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class, ['as' => 'admin'])->middleware('role:administrator');
        Route::get('/posts/{id}/approve', [\App\Http\Controllers\Admin\PostController::class, 'approve'])->name('admin.posts.approve')->middleware('role:administrator');
        Route::get('/posts/{id}/reject', [\App\Http\Controllers\Admin\PostController::class, 'reject'])->name('admin.posts.reject')->middleware('role:administrator');
        Route::put('/posts/{post}/activate', [\App\Http\Controllers\Admin\PostController::class, 'activate'])->name('admin.posts.activate')->middleware('role:administrator');
        Route::put('/posts/{post}/deactivate', [\App\Http\Controllers\Admin\PostController::class, 'deactivate'])->name('admin.posts.deactivate')->middleware('role:administrator');

        //route events
        Route::get('/events-ref', [\App\Http\Controllers\Admin\EventController::class, 'Indexref'])->name('admin.events.Indexref')->middleware('role:administrator,ketua_wakil_subseksi');

        Route::post('/events-ref/', [\App\Http\Controllers\Admin\EventController::class, 'Storeref'])->name('admin.events.Storeref')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::put('/events-ref/{id}', [\App\Http\Controllers\Admin\EventController::class, 'Updateref'])->name('admin.events.Updateref')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::delete('/events-ref/{id}/delete', [\App\Http\Controllers\Admin\EventController::class, 'Deleteref'])->name('admin.events.Deleteref')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::post('/events/{id}/activate', [\App\Http\Controllers\Admin\EventController::class, 'activate'])->name('admin.events.activate')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::post('/events/{id}/close', [\App\Http\Controllers\Admin\EventController::class, 'close'])->name('admin.events.close')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::post('/events/{id}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('admin.events.update')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::get('/events/{id}/enroll', [\App\Http\Controllers\Admin\EventController::class, 'enroll'])->name('admin.events.enroll')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::post('/events/{id}/enroll', [\App\Http\Controllers\Admin\EventController::class, 'Storeenroll'])->name('admin.events.Storeenroll')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::get('/events/{id}/unenroll', [\App\Http\Controllers\Admin\EventController::class, 'unenroll'])->name('admin.events.unenroll')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::post('/events/{id}/unenroll', [\App\Http\Controllers\Admin\EventController::class, 'storeunenroll'])->name('admin.events.storeunenroll')->middleware('role:administrator,ketua_wakil_subseksi');
        Route::resource('/events', \App\Http\Controllers\Admin\EventController::class, ['as' => 'admin']);

        //route setting
        Route::resource('/setting', \App\Http\Controllers\Admin\AuthAdminController::class, ['as' => 'admin'])->middleware('role:administrator,ketua_wakil_subseksi,peserta');

        //route users
        Route::post('/users/{id}', [\App\Http\Controllers\Admin\DataMembersController::class, 'update'])->name('admin.users.update')->middleware('role:administrator,ketua_wakil_subseksi,peserta');
        Route::get('/members/report/export', [\App\Http\Controllers\Admin\DataMembersController::class, 'exportReport'])->name('admin.member.export')->middleware('role:administrator,ketua_wakil_subseksi,peserta');
        Route::get('/members/report', [\App\Http\Controllers\Admin\DataMembersController::class, 'indexReport'])->name('admin.member.report')->middleware('role:administrator,ketua_wakil_subseksi,peserta');
         Route::get('/members/export', [\App\Http\Controllers\Admin\DataMembersController::class, 'export'])->name('members.export')->middleware('role:administrator,peserta');
        Route::resource('/members', \App\Http\Controllers\Admin\DataMembersController::class, ['as' => 'admin'])->middleware('role:administrator,ketua_wakil_subseksi,peserta');

    });
});



Route::get('/user/login', function () {

    //cek session users
    if(auth()->guard('member')->check()) {
        return redirect()->route('user.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('User/Auth/Login');
});

//login users
Route::post('/user/login', \App\Http\Controllers\User\LoginController::class)->name('user.login');



Route::prefix('user')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['member']], function () {
        //route dashboard
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
        Route::post('/dashboard/verify', [App\Http\Controllers\User\DashboardController::class, 'verifyData'])->name('user.dashboard.verifyData');

        //route profile
        Route::get('/profile', [\App\Http\Controllers\User\DataProfileController::class, 'showProfileOnly'])->name('user.profile');
        Route::get('/profile/data-utama', [\App\Http\Controllers\User\DataProfileController::class, 'indexIndiv'])->name('user.profile.data-utama');
        Route::post('/profile/image', [\App\Http\Controllers\User\DataProfileController::class, 'updateImage'])->name('user.profile.data-utama.image');
        Route::get('/profile/edit', [\App\Http\Controllers\User\DataProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/edit', [\App\Http\Controllers\User\DataProfileController::class, 'update'])->name('user.profile.update');
        Route::put('/data-profile/{id}/update-password', [\App\Http\Controllers\User\DataProfileController::class, 'updatePassword'])->name('data-profile.update-password');

        //route posts
        Route::get('/posts/list', [\App\Http\Controllers\User\PostsController::class, 'index'])->name('user.posts.index');
        Route::get('/posts/list/{post:slug}', [\App\Http\Controllers\User\PostsController::class, 'show'])->name('user.posts.show');

        //route events
        Route::resource('/events', \App\Http\Controllers\User\EventController::class, ['as' => 'user']);
        Route::get('/events/{event:slug}', [\App\Http\Controllers\User\EventController::class, 'show'])->name('user.events.join');

        //route setting
        Route::get('/setting', [App\Http\Controllers\User\LoginController::class, 'setting'])->name('user.setting');
        Route::put('/setting/update', [App\Http\Controllers\User\LoginController::class, 'resetPassword'])->name('user.setting.update');
    });
});


//other public routes
Route::get('/warta', [\App\Http\Controllers\Public\PostsController::class, 'index'])->name('posts.index');
Route::get('/warta/{post:slug}', [\App\Http\Controllers\Public\PostsController::class, 'show'])->name('posts.show');

Route::get('/kegiatan', [\App\Http\Controllers\Public\EventsController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{id}', [\App\Http\Controllers\Public\EventsController::class, 'show'])->name('events.show');


Route::get('/forget-password', [\App\Http\Controllers\Public\PublicController::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password/email', [\App\Http\Controllers\Public\PublicController::class, 'emailforgetPassword'])->name('forget.password.email'); 

Route::get('/user/reset-password/{id}', [PublicController::class, 'IndexforgetPassword'])->name('forget.reset.index'); 
Route::put('/user/reset-password/{id}/reset', [PublicController::class, 'ResetPassword'])->name('forget.reset.post');






