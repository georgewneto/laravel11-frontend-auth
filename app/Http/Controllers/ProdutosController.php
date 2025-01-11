<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use DateTime;
use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class ProdutosController extends Controller
{
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
                $exp = $this->timestampParaDataHora($decoded->exp) ?? null;
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

        return view('produtos')
            ->with('exp', $exp)
            ->with('userId', $userId)
            ->with('userName', $userName)
            ->with('userRoles', $userRoles)
            ->with('userPermissions', $userPermissions);
    }
}
