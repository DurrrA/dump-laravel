<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LoginController::class, 'indexlogin'])->name('homepage');
Route::get('/register', [LoginController::class, 'indexregister']);
Route::get('/dashboard', function () {
    return view('users.dashboard'); // Updated view path
})->middleware('auth'); // Apply auth middleware to /dashboard route
Route::get('/admin/test', [adminController::class, 'showUpgradeForm'])->name('admin.showUpgradeForm');
Route::get('/profile', [UserController::class, 'profileUser'])->name('profile');

Route::post('/login', [LoginController::class, 'login'])->name('loginForm');
Route::post('/register', [LoginController::class, 'register'])->name('registerForm');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/admin/test', [adminController::class, 'upgradeUserToExpert'])->name('admin.upgradeUserToExpert');


Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('admin/users/{user}/verify', [UserController::class, 'verify'])->name('admin.users.verify');
});

