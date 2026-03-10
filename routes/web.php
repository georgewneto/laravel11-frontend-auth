<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\AuthenticateWithToken;
use Illuminate\Support\Facades\Route;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('auth.forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

Route::get('/produtos', [ProdutosController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('produtos');
Route::get('/profile', [ProfileController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->middleware(AuthenticateWithToken::class)->name('profile.update');

Route::get('/usuarios', [UsuarioController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('usuarios.index');
Route::get('/usuarios/novo', [UsuarioController::class, 'create'])->middleware(AuthenticateWithToken::class)->name('usuarios.create');
Route::post('/usuarios/novo', [UsuarioController::class, 'store'])->middleware(AuthenticateWithToken::class)->name('usuarios.store');
Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'edit'])->middleware(AuthenticateWithToken::class)->name('usuarios.edit');
Route::post('/usuarios/editar/{id}', [UsuarioController::class, 'update'])->middleware(AuthenticateWithToken::class)->name('usuarios.update');
Route::get('/usuarios/excluir/{id}', [UsuarioController::class, 'delete'])->middleware(AuthenticateWithToken::class)->name('usuarios.delete');

Route::get('/permissoes', [PermissionController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('permissoes.index');
Route::get('/permissoes/novo', [PermissionController::class, 'create'])->middleware(AuthenticateWithToken::class)->name('permissoes.create');
Route::post('/permissoes/novo', [PermissionController::class, 'store'])->middleware(AuthenticateWithToken::class)->name('permissoes.store');
Route::get('/permissoes/editar/{id}', [PermissionController::class, 'edit'])->middleware(AuthenticateWithToken::class)->name('permissoes.edit');
Route::post('/permissoes/editar/{id}', [PermissionController::class, 'update'])->middleware(AuthenticateWithToken::class)->name('permissoes.update');
Route::get('/permissoes/excluir/{id}', [PermissionController::class, 'delete'])->middleware(AuthenticateWithToken::class)->name('permissoes.delete');

Route::get('/funcoes', [RoleController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('funcoes.index');
Route::get('/funcoes/novo', [RoleController::class, 'create'])->middleware(AuthenticateWithToken::class)->name('funcoes.create');
Route::post('/funcoes/novo', [RoleController::class, 'store'])->middleware(AuthenticateWithToken::class)->name('funcoes.store');
Route::get('/funcoes/editar/{id}', [RoleController::class, 'edit'])->middleware(AuthenticateWithToken::class)->name('funcoes.edit');
Route::post('/funcoes/editar/{id}', [RoleController::class, 'update'])->middleware(AuthenticateWithToken::class)->name('funcoes.update');
Route::get('/funcoes/excluir/{id}', [RoleController::class, 'delete'])->middleware(AuthenticateWithToken::class)->name('funcoes.delete');
Route::get('/funcoes/permissions/{id}', [RoleController::class, 'editPermissions'])->middleware(AuthenticateWithToken::class)->name('funcoes.editPermissions');
Route::post('/funcoes/permissions/{id}', [RoleController::class, 'updatePermissions'])->middleware(AuthenticateWithToken::class)->name('funcoes.updatePermissions');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(AuthenticateWithToken::class)->name('dashboard');



Route::get('/', function () {
    return view('auth.login');
})->name('welcome');
