@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Perfil</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    <img class="rounded-circle mb-3 mt-4" src="assets/img/people/image2.png" width="160" height="160">
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
                            <form action="/profile/update" method="POST">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{$id}}">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="name" placeholder="Nome" name="name" value="<?php $user = session('user');echo $user['name']?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">
                                                <strong>Email</strong>
                                            </label>
                                            <input class="form-control" type="email" id="email" placeholder="E-mail" name="email" value="{{$email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>CPF</strong>
                                            </label>
                                            <input class="form-control" type="text" id="cpf" placeholder="CPF" name="cpf" value="{{colocarMascaraCpf($cpf)}}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="telefone">
                                                <strong>Telefone</strong>
                                            </label>
                                            <input class="form-control" type="telefone" id="telefone" placeholder="Telefone" name="telefone" value="{{colocarMascaraTelefone($telefone)}}">
                                        </div>
                                    </div>

                                    @if($errors)
                                            <?php
                                            $erros = $errors->all();
                                        if (count($erros) > 0) {
                                            ?>
                                        <br />
                                        <div class="alert alert-danger" role="alert">
                                            @foreach($erros as $erro)
                                                {{$erro}}<br>
                                            @endforeach
                                        </div>
                                            <?php
                                        }
                                            ?>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
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
