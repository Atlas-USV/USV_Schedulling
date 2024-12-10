<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('Home.home');
})->name('home');
Route::get('/features', function () {
    return view('Home.features'); 
})->name('features');

Route::get('/users', function () {
    return view('Users.users'); 
})->name('users');

Route::middleware(['guest'])->group(function () {
    Route::get('/register/{invitation_id}', [AuthController::class, 'showRegisterForm'])
        ->middleware('signed')
        ->name('register.view');

    Route::post('/register/{invitation_id}', [AuthController::class, 'register'])
        ->middleware('signed')
        ->name('register');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    
});

Route::middleware(['auth'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['role:admin|secretary'])->group(function() {
    Route::post('/create-invitation',[ InvitationController::class,'store'])->name('invitation.store');
    Route::get('/invitation', [ InvitationController::class,'create'])->name('invitation');
}); 
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () {
        return view('Dashboard.dashboard');
    })->name('dashboard');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});