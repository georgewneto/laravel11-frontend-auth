@extends('layout')

@section('conteudo')
        <h3 class="text-dark mb-4">Usuários</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Lista de usuários na API</p>
            </div>
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors)
                    <?php
                    $erros = $errors->all();
                    if (count($erros) > 0) {
                    ?>
                        <br />
                        <div class="alert alert-danger" role="alert">
                            @foreach($erros as $erro)
                                {{$erro}}<br />
                            @endforeach
                        </div>
                    <?php
                    }
                    ?>
                    @endif
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <!--div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <label class="form-label">Mostrar&nbsp; <select class="d-inline-block form-select form-select-sm">
                                    <option value="10" selected="">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>&nbsp; </label>
                        </div-->
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter">
                            <label class="form-label">
                                <input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search">
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                function colocarMascaraTelefone($telefone) {
                    return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
                }
                function colocarMascaraCpfComLgpd($cpf) {
                    // Mostra apenas os 6 números centrais, troca os outros por asteriscos
                    $cpf = preg_replace('/\D/', '', $cpf); // Remove não dígitos
                    if(strlen($cpf) !== 11) return $cpf; // Retorna como está se não tiver 11 dígitos
                    return '***.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-**';
                }
                ?>
                <a class="btn btn-warning btn-sm" href="{{ route('usuarios.create') }}">Novo</a>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Funções</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Permissões</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td>
                                <!--img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar5.jpeg"-->{{ $usuario['name'] }}
                            </td>
                            <td><?php foreach ($usuario['roles'] as $role) { echo $role['name']."; "; }  ?></td>
                            <td>{{ $usuario['email'] }}</td>
                            <td>{{ colocarMascaraCpfComLgpd($usuario['cpf']) }}</td>
                            <td>{{ colocarMascaraTelefone($usuario['telefone']) }}</td>
                            <td><?php foreach ($usuario['roles'] as $role) { foreach ($role['permissions'] as $permission) { echo $permission['name']."; "; }; }  ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('usuarios.edit', ['id' => $usuario['id']]) }}">Editar</a>
                                <a class="btn btn-danger btn-sm" href="{{ route('usuarios.delete', ['id' => $usuario['id']]) }}">Excluir</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Funções</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Permissões</th>
                        </tr>
                        </tfoot>
                    </table>
                    <a class="btn btn-warning btn-sm" href="{{ route('usuarios.create') }}" style="margin-top: 10px;">Novo</a>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando de 1 a 10 do total de {{ sizeof($usuarios) }} registros</p>
                    </div>
                    <div class="col-md-6">
                        <!--nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" aria-label="Previous" href="#">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" aria-label="Next" href="#">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </nav-->
                    </div>

                </div>
            </div>
        </div>
@stop
