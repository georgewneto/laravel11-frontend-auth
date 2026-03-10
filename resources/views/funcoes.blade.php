@extends('layout')

@section('conteudo')
        <h3 class="text-dark mb-4">Funções</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Lista de funções na API</p>
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
                        <!--div class="text-md-end dataTables_filter" id="dataTable_filter">
                            <label class="form-label">
                                <input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search">
                            </label>
                        </div-->
                    </div>
                </div>

                <a class="btn btn-warning btn-sm" href="{{ route('funcoes.create') }}">Novo</a>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($funcoes as $funcao) { ?>
                        <tr>
                            <td>{{ $funcao['name'] }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('funcoes.edit', ['id' => $funcao['id']]) }}">Editar</a>
                                <a class="btn btn-danger btn-sm" href="{{ route('funcoes.delete', ['id' => $funcao['id']]) }}">Excluir</a>
                                <a class="btn btn-info btn-sm" href="{{ route('funcoes.editPermissions', ['id' => $funcao['id']]) }}">Permissões</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                    </table>
                    <a class="btn btn-warning btn-sm" href="{{ route('funcoes.create') }}" style="margin-top: 10px;">Novo</a>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando de 1 a 10 do total de {{ sizeof($funcoes) }} registros</p>
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
