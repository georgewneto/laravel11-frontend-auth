<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use DateTime;
use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'funcoes');
    }

    public function index(Request $request)
    {
        $response = $this->authService->getRoles();
        return view('funcoes')
            ->with('funcoes', $response);
    }

    public function edit(int $id)
    {
        $response = $this->authService->getRole($id);
        return view('editar_funcao')
            ->with('funcao', $response);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $response = $this->authService->updateRole($data);
        if ($response['message'] === 'Role updated successfully.') {
            return redirect()->route('funcoes.index')->with('success', 'Função atualizada com sucesso.');
        }
        return redirect()->back()->withErrors($response['errors']);
    }

    public function create()
    {
        return view('nova_funcao');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $response = $this->authService->createRole($data);

        try {
            if ($response['message'] == 'Role created successfully.') {
                return redirect()->route('funcoes.index')->with('success', 'Função criada com sucesso.');
            }
            return redirect()->route('funcoes.index')->with('success', 'Falha ao criar função.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        $response = $this->authService->deleteRole($id);
        try {
            if ($response['message'] == 'Role deleted successfully.') {
                return redirect()->route('funcoes.index')->with('success', 'Função removida com sucesso.');
            }
            return redirect()->route('funcoes.index')->with('success', 'Falha ao criar função.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editPermissions(int $id)
    {
        $response = $this->authService->getRole($id);
        if (isset($response['message']) && $response['message'] === 'Role not found.') {
            return redirect()->route('funcoes.index')->withErrors(['error' => 'Função não encontrada.']);
        }
        $permissions = $this->authService->getPermissions();
        if (isset($permissions['message']) && $permissions['message'] === 'Permissions not found.') {
            return redirect()->route('funcoes.index')->withErrors(['error' => 'Permissões não encontradas.']);
        }

        $role = $response ?? null;
        if (!$role) {
            return redirect()->route('funcoes.index')->withErrors(['error' => 'Função não encontrada.']);
        }
        return view('editar_funcao_permissoes')
            ->with('funcao', $response)
            ->with('permissoes', $permissions);
    }

    public function updatePermissions(Request $request, int $id)
    {
        $data = $request->all();
        $permissoes = [];
        foreach ($data['permissions'] as $p) {
                $response = $this->authService->getPermission($p);
                $permissoes[] = $response['name'];
        }
        if (isset($response['message']) && $response['message'] === 'Role not found.') {
            return redirect()->route('funcoes.index')->withErrors(['error' => 'Função não encontrada.']);
        }

        $response = null;
        $permissoes_existentes = $this->authService->getPermissions();
        foreach ($permissoes_existentes as $p) {
            $data = [
                'role' => $request->role,
                'permission' => $p['name']
            ];
            $response = $this->authService->removePermissionFromRole($data);
        }
        foreach ($permissoes as $p) {
            $data = [
               'role' => $request->role,
               'permission' => $p
            ];
            $response = $this->authService->permissionAssignToRole($data);
        }

        if (isset($response['message']) && $response['message'] === 'Permission assigned to user successfully.') {
            return redirect()->route('funcoes.index')->with('success', 'Permissões atualizadas com sucesso.');
        }
        try {
            return redirect()->back()->withErrors($response['errors']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
