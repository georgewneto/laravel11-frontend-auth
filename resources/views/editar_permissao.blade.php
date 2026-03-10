@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Permissões</h3>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Editar permissão</p>
                        </div>

                        <div class="card-body">
                            <form action="/permissoes/editar/{{$permissao['id']}}" method="POST">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{$permissao['id']}}">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="name" placeholder="Nome" name="name" value="{{ $permissao['name'] }}">
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
