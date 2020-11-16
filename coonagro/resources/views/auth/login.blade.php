<!DOCTYPE html>
<html>

<head>
    <link rel="sortcut icon" href="/img/logo-login.png" type="image/png" style="border-radius:50px" />
    <title>Coonagro - Cooperativa Naciona Agroindustrial</title>
    <meta charset="utf-8" name="viewport" content="{{ csrf_token() }} width=device-width, initial-scale=1.0" >

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="/img/logo-login.png" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div style="margin-top:30px" class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>

                        <input type="text"
                               class="form-control"
                               placeholder="Usuário"
                               name="usuario"
                               required
                        >
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>

                        <input id="password"
                               type="password"
                               placeholder="Senha"
                               class="form-control"
                               name="senha"
                               required
                               autocomplete="current-password"
                        >
                    </div>

                    <div class="input-group mb-3 justify-content-center" style="margin-top: 15px;">
                        <div class="row" style="margin-left: 0; margin-right: 0; width: 100%">
                            <div class="opcao col-sm-4 col-6 text-center">
                                <input type="radio" id="adm" name="tipo_usuario" value="adn">
                                <label for="adm"><img src="./img/manager.svg" alt="">Administrativo</label>
                            </div>
                            <div class="opcao col-sm-4 col-6 text-center">
                                <input type="radio" id="cli" name="tipo_usuario" value="cli" checked>
                                <label for="cli"><img src="./img/employees.svg" alt="">Cliente</label>
                            </div>
                            <div class="opcao col-sm-4 col-6 text-center">
                                <input type="radio" id="transp" name="tipo_usuario" value="transp">
                                <label for="transp"><img src="./img/truck.svg" alt="">Transportadora</label>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-center mb-3 login_container">
                        <button type="submit" name="button" class="btn login_btn"><b>ENTRAR</b></button>
                    </div> <br>

{{--                    <div style="border-radius: 7px; padding: 10px; background: #2E2E2E">--}}
{{--                        <h6 style="color: white">--}}
{{--                            <b>IMPORTANTE</b>: A retirada dos produtos mediante envio antecipado deste formuláio preenchido.--}}
{{--                        </h6>--}}
{{--                        <h6 style="color: white">--}}
{{--                            Prazo máximo de carregamento é de 48 horas após o caminhão entrar no pátio de espera da Coonagro.--}}
{{--                        </h6>--}}
{{--                    </div>--}}
                </form>
            </div>
        </div>

        @if(session('error'))
            <div style="position: absolute" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-circle"></i> {{session('error')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    // setTimeout(function(){
    //     let msg = document.getElementById("msg");
    //     msg.parentNode.removeChild(msg);
    // }, 2000);
</script>
</html>
