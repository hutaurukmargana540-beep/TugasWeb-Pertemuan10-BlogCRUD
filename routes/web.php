<?php

// ====================================================================
// routes/web.php  —  TR 10: Blog CRUD
// REQ 1: Route::resource('posts') + named routes (posts.index, dst.)
// ====================================================================

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

// Route tambahan (bonus soft delete) HARUS didefinisikan SEBELUM resource,
// kalau tidak "posts/trash" akan dianggap sebagai posts/{post}.
Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
    ->withTrashed()->name('posts.restore');
Route::delete('posts/{post}/force', [PostController::class, 'forceDelete'])
    ->withTrashed()->name('posts.force-delete');

// 7 route CRUD sekaligus: index, create, store, show, edit, update, destroy
Route::resource('posts', PostController::class);
