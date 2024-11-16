<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
});
// Auth::routes(['verify' => true]);


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

Route::get('side', function () {
    return view('side');
})->middleware(['auth']);

// $this->middleware('auth'); // Only authenticated users can access this controller
// $this->middleware('role:admin|secretary')->only('store'); // Only admin and secretary can access store method

Route::middleware(['role:admin|secretary'])->group(function() {
    Route::post('/create-invitation',[ InvitationController::class,'store'])->name('invitation.store');
    Route::get('/invitation', [ InvitationController::class,'create'])->name('invitation');
});