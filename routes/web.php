<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isPremiumUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Stripe\Subscription;

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

Route::get('/', function () {
    return redirect('/login');
});



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/register/seeker', [UserController::class, 'createSeeker'])->name('create.seeker');
Route::post('/register/seeker', [UserController::class, 'storeSeeker'])->name('store.seeker');

Route::get('/register/employer', [UserController::class, 'createEmployer'])->name('create.employer');
Route::post('/register/employer', [UserController::class, 'storeEmployer'])->name('store.employer');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('login.post');
route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
Route::get('/verify', [DashboardController::class, 'verify'])->name('verification.notice');

Route::get('/resend/verification/email', [DashboardController::class, 'resend'])->name('resend.email');

Route::get('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
Route::get('/pay/weekly', [SubscriptionController::class, 'initiatePayment'])->name('pay.weekly');
Route::get('/pay/monthly', [SubscriptionController::class, 'initiatePayment'])->name('pay.monthly');
Route::get('/pay/yearly', [SubscriptionController::class, 'initiatePayment'])->name('pay.yearly');
Route::get('/payment/success', [SubscriptionController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [SubscriptionController::class, 'paymentCancel'])->name('payment.cancel');

Route::get('job/create', [PostJobController::class, 'create'])->name('job.create')->middleware(isPremiumUser::class);
Route::post('job/store', [PostJobController::class, 'store'])->name('job.store')->middleware(isPremiumUser::class);
Route::get('job/{id}/edit', [PostJobController::class, 'edit'])->name('job.edit')->middleware(isPremiumUser::class);
Route::put('job/{id}/update', [PostJobController::class, 'update'])->name('job.update')->middleware(isPremiumUser::class);