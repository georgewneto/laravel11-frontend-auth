@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Usuários</h3>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Editar usuário</p>
                        </div>
                <?php
                function colocarMascaraTelefone($telefone) {
                    return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
                }
                function colocarMascaraCpf($cpf) {
                    // Mostra apenas os 6 números centrais, troca os outros por asteriscos
                    $cpf = preg_replace('/\D/', '', $cpf); // Remove não dígitos
                    if(strlen($cpf) !== 11) return $cpf; // Retorna como está se não tiver 11 dígitos
                    return Str::substr($cpf, 0, 3) .'.'. substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-'.substr($cpf, 9, 2);
                }
                ?>
                        <div class="card-body">
                            <form action="/usuarios/editar/{{$usuario['id']}}" method="POST">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{$usuario['id']}}">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="name" placeholder="Nome" name="name" value="{{ $usuario['name'] }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">
                                                <strong>Email</strong>
                                            </label>
                                            <input class="form-control" type="email" id="email" placeholder="E-mail" name="email" value="{{$usuario['email']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>CPF</strong>
                                            </label>
                                            <input class="form-control" type="text" id="cpf" placeholder="CPF" name="cpf" value="{{colocarMascaraCpf($usuario['cpf'])}}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="telefone">
                                                <strong>Telefone</strong>
                                            </label>
                                            <input class="form-control" type="telefone" id="telefone" placeholder="Telefone" name="telefone" value="{{colocarMascaraTelefone($usuario['telefone'])}}">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $rolesArray = [];
                                foreach ($usuario['roles'] as $role) {
                                    $rolesArray[] = $role['id'];
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="roles">
                                                <strong>Função</strong>
                                            </label>
                                            <select class="form-select" id="roles" name="roles[]" multiple>

                                                @foreach($roles as $role)
                                                    {{ $permissionName = ""; }}
                                                    @foreach ($role['permissions'] as $permission)
                                                        {{$permissionName = $permission['name']."; ".$permissionName; }}
                                                    @endforeach
                                                    <option value="{{$role['id']}}" {{ in_array($role['id'], $rolesArray) ? 'selected' : '' }}>{{$role['name']}} ({{$permissionName}})</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
