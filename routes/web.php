<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AdminController;

// --- Public Routes ---
Route::get('/', [RecipeController::class, 'index'])->name('home');
Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('recipe.show');

Route::get('/ajax-search', [RecipeController::class, 'getSuggestions'])->name('ajax.search');

// --- Guest Routes---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 1. Chức năng cho Người dùng thường (User)
    
    // Đăng bài
    Route::get('/create-recipe', [RecipeController::class, 'create'])->name('recipe.create');
    Route::post('/create-recipe', [RecipeController::class, 'store'])->name('recipe.store');
    
    // Bình luận
    Route::post('/recipe/{id}/review', [RecipeController::class, 'storeReview'])->name('review.store');
    
    // Xóa bài 
    Route::delete('/recipe/{id}', [RecipeController::class, 'destroy'])->name('recipe.destroy');

    // Sửa bài 
    Route::get('/recipe/{id}/edit', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::put('/recipe/{id}', [RecipeController::class, 'update'])->name('recipe.update');


    // 2. Chức năng riêng cho Admin
    
    Route::middleware('admin')->prefix('admin')->group(function () {
        
        // Trang chủ quản trị
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Duyệt bài
        Route::post('/recipe/{id}/approve', [AdminController::class, 'approveRecipe'])->name('admin.recipe.approve');

        // Xóa bài (Admin xóa bất kỳ bài nào)
       
        Route::delete('/recipe/{id}', [AdminController::class, 'deleteRecipe'])->name('admin.recipe.delete');

        // Xóa bình luận
        Route::delete('/comment/{id}', [AdminController::class, 'deleteComment'])->name('admin.comment.delete');

        // Xóa người dùng
        Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

        // Admin sửa bài viết (Logic quản trị)
        Route::get('/recipe/{id}/edit', [AdminController::class, 'edit'])->name('admin.recipe.edit');
     
        Route::put('/recipe/{id}', [AdminController::class, 'update'])->name('admin.recipe.update');
    });
    

});