<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\likeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Models\Connections;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
    
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ConnectionController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/notifications', [ProfileController::class, 'notification'])->name('my.notification');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/Profile', [ProfileController::class, 'addSkills'])->name('profile.addSkills');

    Route::post('/connections/send', [ConnectionController::class, 'sendRequest'])->name('connections.send');
    Route::post('/connections/accept', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::post('/connections/reject', [ConnectionController::class, 'rejectRequest'])->name('connections.reject');

  
    Route::get('profile/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('profile/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('profile/{projects}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/posts/{commentId}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    Route::resource('profile/certifications', CertificationController::class);
    Route::resource('posts/posts', PostController::class);
    
    Route::post('/posts/{post}/like', [likeController::class, 'toggleLike'])->name('posts.like');
    Route::get('/posts/{post}/check-like', [likeController::class, 'checkLike'])->name('posts.checkLike');
    
    
    
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
    
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');
    
    Route::resource('posts/Job_offers', JobController::class);
    
    
});


require __DIR__.'/auth.php';
