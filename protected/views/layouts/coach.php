<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="/favicon.ico">

	<title>Кабинет тренера</title>

	<link href="/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/vendors/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

	<link href="/vendors/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
	<link href="/css/layout-common.css" rel="stylesheet">
	<link href="/css/cabinet.css" rel="stylesheet">

	<link href="/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">

	<!-- Core JS files -->
	<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="/vendors/bootstrap/js/popper.min.js"></script>
	<script type="text/javascript" src="/vendors/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/pickers/daterangepicker.js"></script>
	<!-- /core JS files -->

	<script type="text/javascript" src="/js/layout-common.js"></script>
	</head>

	<body>

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="#">Тренер</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">

			</ul>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="/coach/profile/edit">Профиль</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/site/logout">Выход</a>
				</li>
			</ul>

		</div>
	</nav>

	<div class="container">
		<?= $content; ?>
	</div>

	<script type="text/javascript" src="/js/coach.js"></script>
	</body>
</html>