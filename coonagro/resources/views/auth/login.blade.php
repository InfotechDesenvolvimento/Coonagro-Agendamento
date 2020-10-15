<!DOCTYPE html>
<html>

<head>
	<link rel="sortcut icon" href="/img/logo-login.png" type="image/png" style="border-radius:50px" />
	<title>Coonagro - Cooperativa Naciona Agroindustrial</title>
	<meta charset="utf-8" name="viewport" content="{{ csrf_token() }} width=device-width, initial-scale=1.0" >
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/loginAdm.css">
	<link rel="stylesheet" href="/css/style.css">
</head>

<body style="background-image: url(/img/fundo_coonagro.jpeg); background-size: cover">
	@if(isset($error))
		<div id="msg" style="position: absolute" class="alert alert-danger alert-dismissible fade show" role="alert">
	  <strong><i class="fas fa-exclamation-circle"></i> {{$error}}</strong>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
	@endif

	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card" style="margin-top:140px">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="/img/logo-login.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method="POST" action="{{ url('/login') }}">
            @csrf
						<div style="margin-top:30px"class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>

              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Usuário" name="user" required>

						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
              <input id="password" type="password"  placeholder="Senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          	</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="remember" class="custom-control-input" id="customControlInline"  {{ old('remember') ? 'checked' : '' }}>
							</div>
						</div>
            <div class="d-flex justify-content-center mt-3 login_container">
    					<button type="submit" name="button" class="btn login_btn"><b>ENTRAR</b></button>
    				</div> <br>
            <div style="border-radius: 7px; padding: 10px; background: #2E2E2E">
              <h6 style="color: white"> <b>IMPORTANTE</b>: A retirada dos produtos mediante envio antecipado deste formuláio preenchido.</h6>
              <h6 style="color: white"> Prazo máximo de carregamento é de 48 horas após o caminhão entrar no pátio de espera da Coonagro. </h6>
            </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

<script>
	setTimeout(function(){
		var msg = document.getElementById("msg");
		msg.parentNode.removeChild(msg);
	}, 2000);
</script>
</html>
