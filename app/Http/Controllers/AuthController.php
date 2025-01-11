<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $response = $this->authService->login($credentials);
        } catch (\Exception $e) {
            $erro = $e->getMessage();
            print($erro);
            if (strpos($erro, 'Credenciais inv\u00e1lidas') !== false)
            {
                return back()->withErrors(['message' => $response['message'] ?? 'E-mail ou senha incorretos!']);
            }
        }

        if (isset($response['token'])) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['message' => $response['message'] ?? 'Erro ao realizar login.']);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        if ($data['password'] == null)
        {
            return back()->withErrors(['message' => $response['message'] ?? 'Senha não informada!']);
        }
        if ($data['first_name'] == null && $data['last_name'] == null)
        {
            return back()->withErrors(['message' => $response['message'] ?? 'O nome precisa ser informado!']);
        }
        if ($data['email'] == null)
        {
            return back()->withErrors(['message' => $response['message'] ?? 'O email precisa ser informado!']);
        }

        if ($data['password'] != $data['password_confirmation'])
        {
            return back()->withErrors(['message' => $response['message'] ?? 'Senhas não conferem! Usuário não registrado.']);
        }
        try {
            $response = $this->authService->register($data);
        } catch (\Exception $e) {
            $erro = $e->getMessage();
            if (strpos($erro, 'The email has already been taken') !== false)
            {
                return back()->withErrors(['message' => $response['message'] ?? 'Email já cadastrado!']);
            }
        }
        if (isset($response['token'])) {
            Session::put('token', $response['token']);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['message' => $response['message'] ?? 'Erro ao tentar registrar novo usuário.']);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->only('email');
        try {
            $response = $this->authService->forgotPassword($data);
        } catch (\Exception $e) {
            $erro = $e->getMessage();
            //var_dump($erro);
            if (strpos($erro, 'Email inexistente') !== false)
            {
                return back()->withErrors(['message' => $response['message'] ?? 'Email não cadastrado']);
            }
            return back()->withErrors(['message' => $response['message'] ?? 'Erro ao tentar enviar o email, tente novamente em alguns instantes']);
        }

        return back()->with('message', $response['message'] ?? 'Email enviado com sucesso!');
    }
}
