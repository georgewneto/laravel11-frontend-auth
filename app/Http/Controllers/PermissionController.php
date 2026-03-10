<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use DateTime;
use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'permissoes');
    }

    public function index(Request $request)
    {
        $response = $this->authService->getPermissions();
        return view('permissoes')
            ->with('permissoes', $response);
    }

    public function edit(int $id)
    {
        $response = $this->authService->getPermission($id);
        return view('editar_permissao')
            ->with('permissao', $response);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $response = $this->authService->updatePermission($data);
        if ($response['message'] === 'Permission updated successfully.') {
            return redirect()->route('permissoes.index')->with('success', 'Permissão atualizada com sucesso.');
        }
        return redirect()->back()->withErrors($response['errors']);
    }

    public function create()
    {
        return view('nova_permissao');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $response = $this->authService->createPermission($data);

        try {
            if ($response['message'] == 'Permission created successfully.') {
                return redirect()->route('permissoes.index')->with('success', 'Permissão criada com sucesso.');
            }
            return redirect()->route('permissoes.index')->with('success', 'Falha ao criar permissão.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        $response = $this->authService->deletePermission($id);
        try {
            if ($response['message'] == 'Permission deleted successfully.') {
                return redirect()->route('permissoes.index')->with('success', 'Permissão removida com sucesso.');
            }
            return redirect()->route('permissoes.index')->with('success', 'Falha ao criar permissão.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
