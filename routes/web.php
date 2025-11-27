<?php

use App\Mail\SendEmailRegistration;
use App\Mail\SendEmailReject;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
            'id' => "123"
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
        Route::resource('/management', App\Http\Controllers\Admin\ManagementController::class, ['as' => 'admin']);
        Route::get('/managementfilter', [\App\Http\Controllers\Admin\ManagementController::class, 'filter'])->name('admin.menegemnet.filter');
        Route::post('/management/store', [\App\Http\Controllers\Admin\ManagementController::class, 'store'])->name('admin.menegemnet.store');
        Route::post('/management/update', [\App\Http\Controllers\Admin\ManagementController::class, 'update'])->name('admin.menegemnet.update');
        Route::post('/management/update/status', [\App\Http\Controllers\Admin\ManagementController::class, 'status'])->name('admin.menegemnet.status');
        Route::get('/registration/', [\App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('admin.registration.index');

        //route registration
        Route::post('/registration/store', [\App\Http\Controllers\Admin\RegistrationController::class, 'store'])->name('admin.registration.store');
        Route::put('/registration/{id}/update', [\App\Http\Controllers\Admin\RegistrationController::class, 'update'])->name('admin.registration.update');
        Route::get('/registration/{id}/email-approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'Sendemailapprove'])->name('admin.registration.email.approve');
        Route::get('/registration/{id}/approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'approve'])->name('admin.registration.approve');
        Route::get('/registration/{id}/confirm', [\App\Http\Controllers\Admin\RegistrationController::class, 'confirm'])->name('admin.registration.confirm');
        Route::get('/registration/{id}/reject', [\App\Http\Controllers\Admin\RegistrationController::class, 'reject'])->name('admin.registration.reject');
        Route::get('/registration/{id}/email', [\App\Http\Controllers\Admin\RegistrationController::class, 'sendEmail'])->name('admin.registration.sendEmail');
        Route::resource('/registration', \App\Http\Controllers\Admin\RegistrationController::class, ['as' => 'admin']);

        //route posts
        Route::get('/admin/posts/', [\App\Http\Controllers\Admin\PostController::class, 'list'])->name('admin.posts.list');
        Route::post('/posts/{id}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.posts.update');
        Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class, ['as' => 'admin']);
        Route::get('/posts/{id}/approve', [\App\Http\Controllers\Admin\PostController::class, 'approve'])->name('admin.posts.approve');
        Route::get('/posts/{id}/reject', [\App\Http\Controllers\Admin\PostController::class, 'reject'])->name('admin.posts.reject');

        //route events
         Route::get('/events-ref', [\App\Http\Controllers\Admin\EventController::class, 'Indexref'])->name('admin.events.Indexref');
        Route::post('/events-ref/', [\App\Http\Controllers\Admin\EventController::class, 'Storeref'])->name('admin.events.Storeref');
        Route::put('/events-ref/{id}', [\App\Http\Controllers\Admin\EventController::class, 'Updateref'])->name('admin.events.Updateref');
        Route::delete('/events-ref/{id}/delete', [\App\Http\Controllers\Admin\EventController::class, 'Deleteref'])->name('admin.events.Deleteref');
        Route::post('/events/{id}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('admin.events.update');
        Route::get('/events/{id}/enroll', [\App\Http\Controllers\Admin\EventController::class, 'enroll'])->name('admin.events.enroll');
        Route::post('/events/{id}/enroll', [\App\Http\Controllers\Admin\EventController::class, 'Storeenroll'])->name('admin.events.Storeenroll');
        Route::resource('/events', \App\Http\Controllers\Admin\EventController::class, ['as' => 'admin']);

        //route setting
        Route::resource('/setting', \App\Http\Controllers\Admin\AuthAdminController::class, ['as' => 'admin']);

        //route users
        Route::post('/users/{id}', [\App\Http\Controllers\Admin\DataMembersController::class, 'update'])->name('admin.users.update');
        Route::get('/members/report/export', [\App\Http\Controllers\Admin\DataMembersController::class, 'exportReport'])->name('admin.member.export');
        Route::get('/members/report', [\App\Http\Controllers\Admin\DataMembersController::class, 'indexReport'])->name('admin.member.report');
        Route::resource('/members', \App\Http\Controllers\Admin\DataMembersController::class, ['as' => 'admin']);

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


//prefix "admin"
Route::prefix('user')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['member']], function () {
        //route dashboard
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
        Route::post('/dashboard/verify', [App\Http\Controllers\User\DashboardController::class, 'verifyData'])->name('user.dashboard.verifyData');

        //route profile
        Route::get('/profile', [\App\Http\Controllers\User\DataProfileController::class, 'index'])->name('user.profile');
        Route::get('/profile/data-utama', [\App\Http\Controllers\User\DataProfileController::class, 'indexIndiv'])->name('user.profile.data-utama');
        Route::post('/profile/image', [\App\Http\Controllers\User\DataProfileController::class, 'updateImage'])->name('user.profile.data-utama.image');
        Route::get('/profile/edit', [\App\Http\Controllers\User\DataProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/edit', [\App\Http\Controllers\User\DataProfileController::class, 'update'])->name('user.profile.update');

        //route posts
        Route::get('/posts/list', [\App\Http\Controllers\User\PostsController::class, 'list'])->name('user.posts.list');
        Route::get('/posts/list/{post:slug}', [\App\Http\Controllers\User\PostsController::class, 'showlist'])->name('user.posts.showlist');
        Route::post('/posts/{id}', [\App\Http\Controllers\User\PostsController::class, 'update'])->name('user.posts.update');
        Route::resource('/posts', \App\Http\Controllers\User\PostsController::class, ['as' => 'user']);

        //route events
        Route::resource('/events', \App\Http\Controllers\User\EventController::class, ['as' => 'user']);
        Route::get('/events/{event:slug}', [\App\Http\Controllers\User\EventController::class, 'show'])->name('user.events.join');

        //route setting
        Route::get('/setting', [App\Http\Controllers\User\LoginController::class, 'setting'])->name('user.setting');
        Route::put('/setting/update', [App\Http\Controllers\User\LoginController::class, 'resetPassword'])->name('user.setting.update');

    });
});


//public
//route registration
Route::get('/registration', [\App\Http\Controllers\Public\RegistrationController::class, 'create'])->name('registration');
Route::get('/registration/berhasil', [\App\Http\Controllers\Public\RegistrationController::class, 'berhasil'])->name('registration.berhasil');
Route::post('/registration/store', [\App\Http\Controllers\Public\RegistrationController::class, 'store'])->name('registration.store');
Route::get('/registration/success', [\App\Http\Controllers\Public\RegistrationController::class, 'index'])->name('registration.success');
Route::get('/registration/confirm/{id}/edit', [\App\Http\Controllers\Public\RegistrationController::class, 'edit'])->name('registration.confirm.edit');
Route::post('/registration/confirm/{id}', [\App\Http\Controllers\Public\RegistrationController::class, 'update'])->name('registration.confirm.update');
Route::get('/registration/success', [\App\Http\Controllers\Public\RegistrationController::class, 'index'])->name('registration.success');

//other public routes
Route::get('/warta', [\App\Http\Controllers\Public\PostsController::class, 'index'])->name('posts.index');
Route::get('/warta/{post:slug}', [\App\Http\Controllers\Public\PostsController::class, 'show'])->name('posts.show');

Route::get('/kegiatan', [\App\Http\Controllers\Public\EventsController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{id}', [\App\Http\Controllers\Public\EventsController::class, 'show'])->name('events.show');

Route::get('/about', [\App\Http\Controllers\Public\PublicController::class, 'about'])->name('about');
Route::get('/ketua-umum', [\App\Http\Controllers\Public\PublicController::class, 'ketuaUmum'])->name('ketuaUmum');
Route::get('/peraturan-organisasi', [\App\Http\Controllers\Public\PublicController::class, 'peraturanOrganisasi'])->name('peraturanOrganisasi');
Route::get('/sejarah', [\App\Http\Controllers\Public\PublicController::class, 'sejarah'])->name('sejarah');
Route::get('/struktur-organisasi', [\App\Http\Controllers\Public\PublicController::class, 'strukturOrganisasi'])->name('strukturOrganisasi');
Route::get('/visi-misi', [\App\Http\Controllers\Public\PublicController::class, 'visiMisi'])->name('visiMisi');
Route::get('/kontak-kami', [\App\Http\Controllers\Public\PublicController::class, 'kontak'])->name('kontak');

Route::get('/faq', [\App\Http\Controllers\Public\PublicController::class, 'faq'])->name('faq');

Route::get('/forget-password', [\App\Http\Controllers\Public\PublicController::class, 'forgetPassword'])->name('forget.password');
Route::get('/forget-password/email', [\App\Http\Controllers\Public\PublicController::class, 'emailforgetPassword'])->name('forget.password.email');
Route::get('/user/forget-password/{id}', [\App\Http\Controllers\Public\PublicController::class, 'IndexforgetPassword'])->name('forget.password.index');
Route::put('/user/forget-password/{id}/reset', [\App\Http\Controllers\Public\PublicController::class, 'ResetPassword'])->name('forget.password.reset');


//maintenance route
Route::get('/maintenance', [\App\Http\Controllers\Public\PublicController::class, 'maintenance'])->name('maintenance');
