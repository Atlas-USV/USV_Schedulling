<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('Home.home');
})->name('home');
// Auth::routes(['verify' => true]);
Route::get('/features', function () {
    return view('Home.features'); // Căutăm în resources/views/Home/features.blade.php
})->name('features');

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