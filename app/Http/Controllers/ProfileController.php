<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use DateTime;
use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(Request $request)
    {
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'profile');
        $email = null;
        $telefone = null;
        $cpf = null;

        $response = null;
        try {
            $response = $this->authService->me();
            $email = $response['email'];
            $telefone = $response['telefone'];
            $cpf = $response['cpf'];
            $id = $response['id'];
        } catch (\Exception $e) {
            $erro = $e->getMessage();
            return view('profile')
                ->with('error', $erro)
                ->with('email', $email)
                ->with('telefone', $telefone)
                ->with('cpf', $cpf)
                ->with('id', $id);

        }

        return view('profile')
            ->with('email', $email)
            ->with('telefone', $telefone)
            ->with('cpf', $cpf)
            ->with('id', $id);
    }

    public function update(Request $request)
    {
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'profile');

        $request->validate([
            'email' => 'required|email',
            'telefone' => 'required|string',
            'cpf' => 'required|string',
        ]);

        $cpf = $request->input('cpf');
        $cpf = preg_replace('/\D/', '', $cpf); // Remove non-numeric characters
        $telefone = $request->input('telefone');
        $telefone = preg_replace('/\D/', '', $telefone); // Remove non-numeric characters
        $request->merge([
            'cpf' => $cpf,
            'telefone' => $telefone,
        ]);

        $data = $request->all();
        try {
            $response = $this->authService->updateProfile($data);
            return redirect()->route('profile')->with('success', 'Dados atualizados com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Falha ao tentar atualizar o perfil do usuário: ' . $e->getMessage());
        }
    }

}
