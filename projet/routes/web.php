<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Routes
Route::middleware(['auth'])->group(function() {

    // Route pour le tableau de bord standard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Gestion du profil perso
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route pour afficher et mettre à jour les utilisateurs (Admin)
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');


    // Routes pour les projets
    Route::resource('projects', ProjectController::class);
    // Index des projets
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    // Création de projets
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    // Edition des projets
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Routes pour les tâches
    Route::resource('tasks', TaskController::class);
    // Index pour les tâches
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    // Création de tâches
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // Gestion des tâches liées aux projets
    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');

    //Modifications des tâches
    Route::patch('/tasks/{task}/close', [TaskController::class, 'close'])->name('tasks.close');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}/update', [TaskController::class, 'update'])->name('tasks.update');

    //Infos sur les taches
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.add');
    
    // Route pour supprimer une notification
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.delete');


});





require __DIR__.'/auth.php';
