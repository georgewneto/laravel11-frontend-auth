<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Esqueceu sua senha - API Laravel</title>
    <meta name="description" content="Painel Administrativo">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-12 col-xl-10">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-password-image" style="background-image: url(&quot;assets/img/dogs/image1.jpeg&quot;);"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h4 class="text-dark mb-2">Esqueceu sua senha?</h4>
                                    <p class="mb-4">Insira seu email abaixo e enviaremos mais instruções sobre como recuperar seu senha!</p>
                                </div>
                                <form class="user" action="/forgot-password" method="POST">
                                    <?=@csrf_field()?>
                                    <div class="mb-3">
                                        <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Informe seu email" name="email">
                                    </div>
                                    <button class="btn btn-primary d-block btn-user w-100" type="submit">Solicitar nova senha</button>
                                </form>
                                <br />
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
                                @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="text-center">
                                    <hr>
                                    <a class="small" href="{{url('/register')}}">Criar um usuário!</a>
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
    </div>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/script.min.js"></script>
</body>
</html>
