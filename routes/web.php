<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
// Auth::routes(['verify' => true]);
Route::get('/modal', function(){
    return view('components.create-event-modal');
});

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
    Route::get('calendar', [CalendarController::class,'load'])->name('calendar');
});

Route::middleware(['role:admin|secretary'])->group(function() {
    Route::post('/create-invitation',[ InvitationController::class,'store'])->name('invitation.store');
    Route::get('/invitation', [ InvitationController::class,'create'])->name('invitation');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/evaluations', [CalendarController::class, 'getAllEvents']);
    Route::post('/evaluation', [CalendarController::class, 'create']);
});