@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Funções</h3>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Editar permissões de uma função</p>
                        </div>

                        <div class="card-body">
                            <form action="/funcoes/permissions/{{$funcao['id']}}" method="POST">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{$funcao['id']}}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="role">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="role" placeholder="Nome" readonly name="role" value="{{ $funcao['name'] }}">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $permissionsArray = [];
                                foreach ($funcao['permissions'] as $p) {
                                    $permissionsArray[] = $p['id'];
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="permissions">
                                                <strong>Permissões</strong>
                                            </label>
                                            <select class="form-select" id="permissions" name="permissions[]" multiple>
                                                @foreach($permissoes as $permission)
                                                    <option value="{{$permission['id']}}" {{ in_array($permission['id'], $permissionsArray) ? 'selected' : '' }}>{{$permission['name']}}</option>
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
