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

    private function timestampParaDataHora($timestamp, $formato = 'd/m/Y H:i:s') {
        // Cria um objeto DateTime a partir do timestamp (em segundos)
        $data = new DateTime();
        $data->setTimestamp($timestamp);

        // Formata a data e hora de acordo com o formato especificado
        return $data->format($formato);
    }

    public function index(Request $request)
    {
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
            }
            $servico = 'produtos';
            $autorizado = false;
            foreach ($userRoles as $role) {
                if ($role == 'admin' || in_array($servico, $userRoles)) {
                    $autorizado = true;
                    break;
                }
            }
            foreach ($userPermissions as $permission) {
                if ($permission == 'admin' || in_array($servico, $userPermissions)) {
                    $autorizado = true;
                    break;
                }
            }
        }
        if (!$autorizado) {
            return redirect()->route('dashboard');
        }
        $email = null;

        $response = null;
        try {
            $response = $this->authService->me();
            $email = $response['email'];
        } catch (\Exception $e) {
            $erro = $e->getMessage();
            return view('profile')->withErrors(['message' => $erro])
                ->with('userId', $userId)
                ->with('userName', $userName)
                ->with('userEmail', $email);
        }

        return view('profile')
            ->with('userId', $userId)
            ->with('userName', $userName)
            ->with('userEmail', $email);

    }

}
