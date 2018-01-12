<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Вход</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="/theme/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="/theme/assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="/theme/assets/js/core/app.js"></script>
	<script type="text/javascript" src="/theme/assets/js/pages/login.js"></script>
	<!-- /theme JS files -->

</head>

<body class="bg-slate-800">

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Advanced login -->
				<form method="POST">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
							<h5 class="content-group-lg">Войдите в ваш аккаунт <small class="display-block">Введите логин и пароль</small></h5>
						</div>

						<? if ($message): ?>
							<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> <?= $message; ?></span>
						<? endif; ?>
						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="Логин" name="login">
							<div class="form-control-feedback">
								<i class="icon-user text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Пароль" name="password">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn bg-blue btn-block">Войти <i class="icon-circle-right2 position-right"></i></button>
						</div>
					</div>
				</form>
				<!-- /advanced login -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->

</body>
</html>