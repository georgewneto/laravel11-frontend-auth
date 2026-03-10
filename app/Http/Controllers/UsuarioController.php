<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use DateTime;
use Illuminate\Http\Request;

use App\Services\TokenService;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $tokenService = new TokenService();
        $token = Session::get('token');
        $tokenService->getRolesAndPermissions($token, 'usuarios');
    }

    public function index(Request $request)
    {
        $response = $this->authService->getUsers();
        return view('usuarios')
            ->with('usuarios', $response['data']);
    }

    public function edit(int $id)
    {
        $response = $this->authService->getUser($id);
        $roles = $this->authService->getRoles();
        return view('editar_usuario')
            ->with('usuario', $response['data'])
            ->with('roles', $roles);
    }

    public function update(Request $request)
    {
        $cpf = $request->input('cpf');
        $cpf = preg_replace('/\D/', '', $cpf); // Remove non-numeric characters
        $telefone = $request->input('telefone');
        $telefone = preg_replace('/\D/', '', $telefone); // Remove non-numeric characters
        $request->merge([
            'cpf' => $cpf,
            'telefone' => $telefone,
        ]);
        $data = $request->all();
        $response = $this->authService->updateUser($data);

        if ($response['status'] !== 'success') {
            return redirect()->back()->withErrors($response['errors']);
        }
        $roles = $request->input('roles');

        //Pegar as permissões do usuário
        $response = $this->authService->getUser($request->input('id'));
        //$rolesAtuais = $response['data']['roles'] ?? [];

        $rolesBd = $this->authService->getRoles();

        //Comparar com as novas permissoes
        foreach ($rolesBd as $f) {
            // adicionar as novas
            if (in_array($f['id'], $roles)) {
                $this->authService->addRoleToUser($request->input('id'), $f['name']);
            }
            // remover as que não existem mais
            if (!in_array($f['id'], $roles)) {
                $this->authService->removeRoleFromUser($request->input('id'), $f['name']);
            }
        }

        if ($response['status'] === 'success') {
            return redirect()->route('usuarios.index')->with('success', 'Usuario atualizado com sucesso.');
        }
        return redirect()->back()->withErrors($response['errors']);
    }

    public function create()
    {
        $roles = $this->authService->getRoles();
        return view('novo_usuario')
            ->with('roles', $roles);
    }

    public function store(Request $request)
    {
        $cpf = $request->input('cpf');
        $cpf = preg_replace('/\D/', '', $cpf); // Remove non-numeric characters
        $telefone = $request->input('telefone');
        $telefone = preg_replace('/\D/', '', $telefone); // Remove non-numeric characters
        $request->merge([
            'cpf' => $cpf,
            'telefone' => $telefone,
        ]);
        $data = $request->all();
        $response = $this->authService->createUser($data);

        // fazer um novo post pra atualizar cpf e telefone e permissões / pegar o id do usuário criado
        $request->merge([
            'id' => $id = $response['user']['id'] ?? 0,
        ]);
        $data = $request->all();
        $this->authService->updateUser($data);

        $roles = $request->input('roles');

        //Pegar as permissões do usuário
        $response = $this->authService->getUser($request->input('id'));
        //$rolesAtuais = $response['data']['roles'] ?? [];

        $rolesBd = $this->authService->getRoles();

        //Comparar com as novas permissoes
        foreach ($rolesBd as $f) {
            // adicionar as novas
            if (in_array($f['id'], $roles)) {
                $this->authService->addRoleToUser($request->input('id'), $f['name']);
            }
            // remover as que não existem mais
            if (!in_array($f['id'], $roles)) {
                $this->authService->removeRoleFromUser($request->input('id'), $f['name']);
            }
        }

        if (isset($response['status'])) {
            if ($response['status'] === 'error') {
                return redirect()->back()->withErrors($response['errors']);
            }
            return redirect()->route('usuarios.index')->with('error', 'Usuario criado com sucesso.');
        }
        return redirect()->route('usuarios.index')->with('error', 'Usuario criado com sucesso.');
    }

    public function delete(int $id)
    {
        $response = $this->authService->deleteUser($id);
        if ($response['status'] === 'success') {
            return redirect()->route('usuarios.index')->with('success', 'Usuario excluído com sucesso.');
        }
        return redirect()->back()->withErrors($response['errors']);

    }

}
