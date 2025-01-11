<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthenticateWithToken;
use Illuminate\Support\Facades\Route;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

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

Route::get('/dashboard', function () {
    function timestampParaDataHora($timestamp, $formato = 'd/m/Y H:i:s') {
        // Cria um objeto DateTime a partir do timestamp (em segundos)
        $data = new DateTime();
        $data->setTimestamp($timestamp);

        // Formata a data e hora de acordo com o formato especificado
        return $data->format($formato);
    }

    $tokenService = new TokenService();
    $token = Session::get('token');

    $userName = null;
    $userId = 0;
    $userPermissions = null;
    $userRoles = null;
    $exp = 0;
    if ($token) {
        $decoded = $tokenService->decodeToken($token);
        if ($decoded) {
            // Acessar dados do token
            $userId = $decoded->sub ?? null;
            $userName = $decoded->name ?? null;
            $userRoles = $decoded->roles ?? null;
            $userPermissions = $decoded->permissions ?? null;
            $exp = timestampParaDataHora($decoded->exp) ?? null;
        }
    }

    return view('dashboard')
        ->with('exp', $exp)
        ->with('userId', $userId)
        ->with('userName', $userName)
        ->with('userRoles', $userRoles)
        ->with('userPermissions', $userPermissions);
})->middleware(AuthenticateWithToken::class)->name('dashboard');


Route::get('/', function () {
    return view('auth.login');
})->name('welcome');
