<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->title; ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="/theme/assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<link href="/vendors/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

	<!-- Core JS files -->
	<script type="text/javascript" src="/theme/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/core/libraries/bootstrap.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="/theme/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="/theme/assets/js/plugins/forms/styling/switchery.min.js"></script>

	<script type="text/javascript" src="/theme/assets/js/core/app.js"></script>
	<!-- /theme JS files -->

	<script type="text/javascript" src="/js/jquery/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/jquery/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="/js/layout-common.js"></script>
	<link href="/css/layout-common.css" rel="stylesheet" type="text/css">
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="/"><img src="/theme/assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="/theme/assets/images/placeholder.jpg" alt="">
						<span>Админ</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="/site/logout"><i class="icon-switch2"></i> Выйти</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page header -->
	<div class="page-header">
		<div class="breadcrumb-line breadcrumb-line-wide">
			<?
            $this->widget('application.components.BreadCrumb', array(
              'crumbs' => $this->breadcrumbs,
            )); ?>
		</div>

		<div class="page-header-content">
			<div class="page-title">
				<h4><span class="text-semibold"><?= $this->title; ?></span></h4>
			</div>
		</div>
	</div>
	<!-- /page header -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-default">
				<div class="sidebar-content">

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-title h6">
							<span>Меню</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>

						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
								<li><a href="/admin/trainings"><i class="fa fa-life-ring"></i> <span>Тренинги</span></a></li>
								<li><a href="/admin/coaches"><i class="fa fa-male"></i> <span>Тренеры</span></a></li>
								<li><a href="/admin/clients"><i class="fa fa-users"></i> <span>Клиенты</span></a></li>
								

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<?php echo $content; ?>

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->

</body>
</html>
