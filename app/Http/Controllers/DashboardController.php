<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'dashboard');
    }

    public function index(Request $request)
    {
        return view('dashboard');
    }
}
