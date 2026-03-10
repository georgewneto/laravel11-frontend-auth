@extends('layout')

@section('conteudo')
    <h3 class="text-dark mb-4">Usuários</h3>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Novo usuário</p>
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
                            <form action="/usuarios/novo" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">
                                                <strong>Nome</strong>
                                            </label>
                                            <input class="form-control" type="text" id="name" placeholder="Nome" name="name">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">
                                                <strong>Email</strong>
                                            </label>
                                            <input class="form-control" type="email" id="email" placeholder="E-mail" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="cpf">
                                                <strong>CPF</strong>
                                            </label>
                                            <input class="form-control" type="text" id="cpf" placeholder="000.000.000-00" name="cpf" maxlength="14" oninput="mascararCPF(this)">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="telefone">
                                                <strong>Telefone</strong>
                                            </label>
                                            <input class="form-control" type="text" id="telefone" placeholder="(00) 00000-0000" name="telefone" maxlength="15" oninput="mascararTelefone(this)">
                                        </div>
                                    </div>
                                </div>

                                <script>
                                function mascararCPF(input) {
                                    // Remove tudo que não é dígito
                                    let cpf = input.value.replace(/\D/g, '');

                                    // Limita a 11 dígitos
                                    cpf = cpf.substring(0, 11);

                                    // Aplica a máscara
                                    if (cpf.length > 9) {
                                        cpf = cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
                                    } else if (cpf.length > 6) {
                                        cpf = cpf.replace(/^(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                                    } else if (cpf.length > 3) {
                                        cpf = cpf.replace(/^(\d{3})(\d{1,3})/, '$1.$2');
                                    }

                                    input.value = cpf;
                                }

                                function mascararTelefone(input) {
                                    // Remove tudo que não é dígito
                                    let telefone = input.value.replace(/\D/g, '');

                                    // Limita a 11 dígitos
                                    telefone = telefone.substring(0, 11);

                                    // Aplica a máscara
                                    if (telefone.length > 10) {
                                        telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
                                    } else if (telefone.length > 6) {
                                        telefone = telefone.replace(/^(\d{2})(\d{4,5})(\d{0,4})$/, '($1) $2-$3');
                                    } else if (telefone.length > 2) {
                                        telefone = telefone.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
                                    } else if (telefone.length > 0) {
                                        telefone = telefone.replace(/^(\d{0,2})/, '($1');
                                    }

                                    input.value = telefone;
                                }

                                // Certifique-se de que o formulário envia apenas os dígitos sem formatação
                                document.querySelector('form').addEventListener('submit', function(event) {
                                    const cpfInput = document.getElementById('cpf');
                                    const telefoneInput = document.getElementById('telefone');

                                    // Mantém apenas os dígitos nos campos ocultos que serão enviados
                                    const cpfDigitos = cpfInput.value.replace(/\D/g, '');
                                    const telefoneDigitos = telefoneInput.value.replace(/\D/g, '');

                                    // Atualiza os valores antes do envio
                                    cpfInput.value = cpfDigitos;
                                    telefoneInput.value = telefoneDigitos;
                                });
                                </script>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="password">
                                                <strong>Senha</strong>
                                            </label>
                                            <input class="form-control" type="password" id="password"
                                                   placeholder="Informe uma senha" name="password" required
                                                   oninput="validatePassword()">
                                            <small id="passwordHelp" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="password_confirmation">
                                                <strong>Confirmar Senha</strong>
                                            </label>
                                            <input class="form-control" type="password"
                                                   id="password_confirmation" placeholder="Digite novamente sua senha"
                                                   name="password_confirmation" required
                                                   oninput="comparePasswords()">
                                            <small id="confirmPasswordHelp" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                function validatePassword() {
                                    const password = document.getElementById('password').value;
                                    const passwordHelp = document.getElementById('passwordHelp');

                                    if (password.length === 0) {
                                        passwordHelp.textContent = 'A senha não pode estar vazia';
                                        return false;
                                    } else if (password.length < 6) {
                                        passwordHelp.textContent = 'A senha deve ter pelo menos 6 caracteres';
                                        return false;
                                    } else if (/^[0-9]+$/.test(password) || /^[a-zA-Z]+$/.test(password)) {
                                        passwordHelp.textContent = 'A senha é muito simples. Use letras e números';
                                        return false;
                                    } else {
                                        passwordHelp.textContent = '';
                                        comparePasswords();
                                        return true;
                                    }
                                }

                                function comparePasswords() {
                                    const password = document.getElementById('password').value;
                                    const confirmPassword = document.getElementById('password_confirmation').value;
                                    const confirmPasswordHelp = document.getElementById('confirmPasswordHelp');

                                    if (confirmPassword.length === 0) {
                                        confirmPasswordHelp.textContent = 'Por favor, confirme sua senha';
                                        return false;
                                    } else if (password !== confirmPassword) {
                                        confirmPasswordHelp.textContent = 'As senhas não coincidem';
                                        return false;
                                    } else {
                                        confirmPasswordHelp.textContent = '';
                                        return true;
                                    }
                                }

                                document.querySelector('form').addEventListener('submit', function(event) {
                                    if (!validatePassword() || !comparePasswords()) {
                                        event.preventDefault();
                                    }
                                });
                                </script>
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
                                                    <option value="{{$role['id']}}" >{{$role['name']}} ({{$permissionName}})</option>

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
