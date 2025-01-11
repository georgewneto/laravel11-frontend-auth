@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Perfil</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    <img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/image2.jpeg" width="160" height="160">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-sm" type="button" onclick="alert('Not implemented yet!')">Change Photo</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Dados do Usuário</p>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <input type="hidden" id="userid" name="userid" value="{{$userId}}}">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="name" placeholder="Nome" name="name" value="{{$userName}}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">
                                                <strong>Email</strong>
                                            </label>
                                            <input class="form-control" type="email" id="email" placeholder="E-mail" name="email" value="{{$userEmail}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm disabled" type="submit" onclick="alert('Not implemented yet')">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
