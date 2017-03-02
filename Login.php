<?php

require_once'Core/init.php';

$user = new User;

if($user->isLoggedIn())
{
	Redirect::to('index.php');
}
// else
// {
// 	require_once'Includes/googleAuth/gpConfig.php';
// 	$authUrl = $gClient->createAuthUrl();
// }

?>

<!Doctype html>

<html>
	<head>
		<title>
			Login
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="keywords" content="blog, technology, code, program, alorithms"/>
		<meta name="description" content="We emphaisze on solving problems">
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

		<style>
			body
			{
				position: absolute;
				height: 100%;
				width: 100%;
				background-color: #eee;
			}
			#login-form
			{
				position:relative;
			  	top:50%;
			    left:50%;
				-ms-transform: translateX(-50%) translateY(-50%);
				-webkit-transform: translate(-50%,-50%);
				transform: translate(-50%,-50%);
			}
			#remember-me-container
			{
				margin-left: 7px;
				margin-top: 15px;
				margin-bottom: 10px;
			}
			.error
			{
				display: none;
			}
		</style>

	</head>
	<body>
	
		<div id="login-form">
			<h5 class="center-align condensed light">Sign in to BlogSparta</h5>
			<div class="row">
				<div class="col s4 offset-s4">
					<ul class="collection center-align z-depth-1 error">
						<li class="collection-item red-text"></li>
					</ul>
					<div class="card">
						<div class="card-content">
							<div class="row">
								<form class="col s12" action="" method="post">
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">email</i>
											<input type="text" name="email" id="email" />
											<label for="email">Email</label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">lock</i>
											<input type="password" name="password" id="password" />
											<label for="password">Password</label>
										</div>
										<div class="col s6 offset-s3" id="remember-me-container">
											<input type="checkbox" id="remember_me" name="remember_me">
											<label for="remember_me"> Remember Me</label>
										</div>
										<div class="input-field col s12">
											<input type="hidden" name="_token" id="_token" value="<?php echo Token::generate(); ?>">
										</div>
										<input type="submit" class="btn waves-effect waves-light col s4 offset-s4" value="login" id="submit">
										<div class="center-align">
											<a class="red-text" href="forgot_password.php">Forgot password?</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="center-align">Or</div>
					<div class="row">
						<a href="<?php echo $authUrl ?>" class="waves-effect waves-light btn red col s8 offset-s2">Sign in with google</a>
					</div>
					<div class="section">
						<ul class="collection center-align z-depth-1">
							<li class="collection-item">New to BlogSparta? <a href="register.php">Create an account</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<script src="Includes/js/jquery.min.js"></script>
		<script type="text/javascript" src="Includes/js/materialize.min.js"></script>
		<script type="text/javascript">
			// $('#submit').off('click');
			$(document).ready(function(){
				$('body').on('click', '#submit', function(e){
					e.preventDefault();
					var email = $('#email').val();
					var password = $('#password').val();
					var remember_me = $('#remember_me').val();
					var _token = $('#_token').val();
					
					$.ajax({
						type : "POST",
						url : "login_backend.php",
						data : {email: email, password: password, remember_me: remember_me, _token: _token},
						cache: false,
						success: function(response)
						{
							var response = JSON.parse(response);
							$('#_token').val(response._token);
							if(response.status==0)
							{
								$(window.location).attr('href', 'index.php');
							}
							else
							{
								$('#password').val('');
								Materialize.toast(response.message, 4000, 'red');
								$('.error li').text(response.message);
								$('.error').show();
							}
						}
					});

				});

			});
		</script>
	</body>
</html>
