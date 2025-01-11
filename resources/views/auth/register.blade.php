<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Registre-se - API Laravel</title>
    <meta name="description" content="Painel Administrativo">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="card shadow-lg o-hidden border-0 my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/dogs/image2.jpeg&quot;);"></div>
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="text-dark mb-1">API Laravel</h1>
                            <h4 class="text-dark mb-4">Registre-se! Crie sua conta</h4>
                        </div>
                        <form class="user" method="POST" action="{{ route('auth.register') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Primeiro nome" name="first_name">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Último nome" name="last_name">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Seu e-mail" name="email">
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Sua senha" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repita sua senha" name="password_confirmation">
                                </div>
                            </div>
                            @if($errors)
                                <?php
                                $erros = $errors->all();
                                if (count($erros) > 0) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    @foreach($erros as $erro)
                                        {{$erro}}<br>
                                    @endforeach
                                </div>
                                <?php
                                }
                                ?>
                            @endif
                            <div>
                            </div>

                            <button class="btn btn-primary d-block btn-user w-100" type="submit">Criar minha conta</button>
                            <!--hr>
                            <a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button">
                                <i class="fab fa-google"></i>&nbsp; Register with Google </a>
                            <a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button">
                                <i class="fab fa-facebook-f"></i>&nbsp; Register with Facebook </a-->
                            <hr>
                        </form>
                        <div class="text-center">
                            <a class="small" href="{{url('/forgot-password')}}">Esqueceu sua senha?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{url('/login')}}">Já tem sua conta? Faça o login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/script.min.js"></script>
</body>
</html>
