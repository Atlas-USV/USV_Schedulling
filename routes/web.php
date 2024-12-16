<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminEvaluationController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\UserController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/tasks', [DashboardController::class, 'storeTask'])->name('tasks.store');
    Route::delete('/tasks/{id}', [DashboardController::class, 'deleteTask'])->name('tasks.delete');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/tasks/{id}/edit', [DashboardController::class, 'editTask'])->name('tasks.edit');
    Route::get('/exams', [DashboardController::class, 'showExams'])->name('exams.index');



});

Route::middleware(['auth', 'role:admin|secretary'])->group(function () {
    Route::get('/evaluations/pending', [AdminEvaluationController::class, 'index'])->name('evaluations.pending');
    Route::post('/evaluations/{evaluation}/accept', [AdminEvaluationController::class, 'accept'])->name('evaluations.accept');
    Route::delete('/evaluations/{id}', [AdminEvaluationController::class, 'delete'])->name('evaluations.delete');
    Route::post('/evaluations/{id}/decline', [AdminEvaluationController::class, 'decline'])->name('evaluations.decline');
    Route::post('/evaluations/update', [AdminEvaluationController::class, 'update'])->name('evaluations.update');


});



Route::middleware(['auth'])->group(function () {
    Route::get('/evaluations', [CalendarController::class, 'getAllEvents']);
    Route::post('/evaluation', [CalendarController::class, 'create']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::post('/inbox/{id}/read', [InboxController::class, 'markAsRead'])->name('inbox.read');
});

Route::middleware(['auth', 'role:admin|secretary'])->group(function () {
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/groups/by-faculty/{faculty_id}', [UserController::class, 'getGroupsByFaculty'])->name('groups.by-faculty');

});