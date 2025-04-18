<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - AdminLaravel</title>
    <meta name="description" content="Painel Administrativo">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
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
                            <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/dogs/image3.jpeg&quot;);"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4">API Laravel</h4>
                                </div>
                                <form class="user" action="/login" method="POST">
                                    <?=@csrf_field()?>
                                    <div class="mb-3">
                                        <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Informe seu email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Sua senha" name="password">
                                    </div>
                                    <!--div class="mb-3">
                                        <div class="custom-checkbox small">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="formCheck-1">
                                                <label class="form-check-label" for="formCheck-1">Remember Me</label>
                                            </div>
                                        </div>
                                    </div-->
                                    <button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>

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
                                    <hr>
                                    <!--a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button">
                                        <i class="fab fa-google"></i>&nbsp; Login with Google </a>
                                    <a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button">
                                        <i class="fab fa-facebook-f"></i>&nbsp; Login with Facebook </a>
                                    <hr-->
                                </form>
                                <div class="text-center">
                                    <a class="small" href="{{url('/forgot-password')}}">Esqueceu a senha?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{url('/register')}}">Criar um usuário</a>
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
