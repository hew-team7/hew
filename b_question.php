	<?php
	require_once "config.php";

	$_SESSION['user_id'] = 'hiraken0817';

	if (isset($_POST['content'])) {
		if ($_POST['content'] != '') {
			question_db(HOST, DB_USER, DB_PASS, DB_NAME, $_SESSION['user_id'], $_POST['type'], $_POST['content']);
			header('Location:./b_question_cl.php');
		}
	}

	function question_db($host, $db_user, $db_pass, $db_name, $user_id, $type, $content)
	{
		$cn = mysqli_connect($host, $db_user, $db_pass, $db_name);
		mysqli_set_charset($cn, 'utf8');
		$sql = "INSERT INTO buyer_question(user_id,type,msg) VALUES ('" . $user_id . "','" . $type . "','" . $content . "')";
		mysqli_query($cn, $sql);
	}


	?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>お問い合せ　｜　購入者</title>
	</head>

	<body>




	</body>

	</html>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<!-- Required meta tags always come first -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>お問い合せ　｜　購入者</title>

		<!-- Font Awesome -->
		<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
		<!-- Bootstrap core CSS -->
		<link href="Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

		<!-- Material Design Bootstrap -->
		<link href="Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">



		<style>
			body {
				background-color: #f5f5f5;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}

			.dark-skin .navbar {
				background-color: #fb7d22;
			}

			.dark-skin .side-nav .logo-wrapper {

				background-size: auto;
				background-size: cover;
			}

			.side-nav .logo-wrapper,
			.side-nav .logo-wrapper a {
				height: 0px;
			}

			.dark-gradient,
			.dark-skin .side-nav {

				background: linear-gradient(135deg, #fb7d22 0, #fb7d22 100%);

			}

			.dark-skin .side-nav .sn-avatar-wrapper img {
				border: none;
				box-shadow: 2px 3px 3px rgba(0, 0, 0, 0.3);
			}

			.side-nav .sn-avatar-wrapper img {
				max-width: 65px;
				margin-left: -10px;
				margin-top: 8px;
			}

			.dark-skin .side-nav .collapsible li a:hover {
				background-color:
					#f0a773;
				transition: all .3s linear;
			}

			.dark-skin .side-nav .collapsible li a:hover {
				background-color:
					#c66017;
				transition: all .3s linear;
			}

			.side-nav .collapsible>li {
				padding-right: 1rem;
				padding-left: 1rem;
				margin-top: 10px;
			}
		</style>

	</head>

	<body class="fixed-sn dark-skin" style="">

		<!--Double Navigation-->
		<header>

			<!-- Sidebar navigation -->
			<ul id="slide-out" class="side-nav fixed custom-scrollbar ps-container ps-theme-default" style="transform: translateX(-100%);" data-ps-id="96864e62-e306-5383-47b2-9d30422757ea">



				<!-- Side navigation links -->
				<li>
					<ul class="collapsible collapsible-accordion">
						<li><a href="./map.php" class="collapsible-header waves-effect"><i class="fa fa-map"></i> マップ</a>

						</li>

						<li><a href="./ranking.php" class="collapsible-header waves-effect"><i class="fa fa-crown"></i> ランキング</a>

						</li>

						<li><a href="./b_pl.php" class="collapsible-header waves-effect"><i class="fa fa-user"></i> ステータス</a>

						</li>

						<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cog"></i> 設定<i class="fa fa-angle-down rotate-icon"></i></a>
							<div class="collapsible-body">
								<ul>
									<li><a href="./b_pl_stg.php" class="waves-effect">プロフィール編集</a>
									</li>
									<li><a href="./log_out.php" class="waves-effect">ログアウト</a>
									</li>
								</ul>
							</div>
						</li>

						<li><a href="./b_question.php" class="collapsible-header waves-effect"><i class="fa fa-question"></i> お問い合わせ</a>
					</ul>
				</li>
				<!--/. Side navigation links -->

				<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
					<div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
				</div>
				<div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
					<div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
				</div>
			</ul>
			<!--/. Sidebar navigation -->

			<!--Navbar-->
			<nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

				<!-- SideNav slide-out button -->
				<div class="float-xs-left">
					<a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
				</div>

				<!-- Breadcrumb-->
				<div class="breadcrumb-dn">
					<p>HELOSS</p>
				</div>


				<ul class="nav navbar-nav float-xs-right">

					<li class="nav-item ">
						<a href="./b_news.php" class="nav-link waves-effect waves-light"><i class="fa fa-bell"></i> <span class="hidden-sm-down">お知らせ</span></a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <span class="hidden-sm-down">プロフィール</span> </a>
						<div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
							<a class="dropdown-item waves-effect waves-light" href="./b_pl.php">プロフィール確認</a>
							<a class="dropdown-item waves-effect waves-light" href="./b_pl_stg.php">プロフィール編集</a>
						</div>
					</li>
				</ul>

			</nav>
			<!--/.Navbar-->

		</header>
		<!--/Double Navigation-->

		<!--Main layout-->
		<main class="">
			<div class="container-fluid text-xs-center" style="height: 800px;">
				<h2>お問い合せ</h2>
				<h3>お問い合わせ内容</h3>
				<form action="./b_question.php" method="post">
					<table class="table">
						<tr>
							<div class="row" style="padding-top:50px">
								<div class="col-lg-4 offset-lg-4">
									<div class="form-group has-warning mx-auto">
										<select name="type" class="form-control">
											<option value="0">商品に不備がある</option>
											<option value="1">サイトの不具合について</option>
											<option value="2">登録情報について</option>
											<option value="3">商品代金の支払い・クーポンについて</option>
										</select></div>
								</div>
							</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="row" style="padding-top:50px">
									<div class="col-lg-8 offset-lg-2">
										<div id="form-group">
											<textarea rows="5" name="content" class="form-control" style="height:200px"></textarea>
										</div>
									</div>
								</div>
							</td>
						</tr>

					</table>
					<button class="btn btn-orange waves-effect waves-light">送信</button>
				</form>
			</div>
		</main>
		<!--/Main layout-->

		<!--Footer-->
		<footer class="page-footer center-on-small-only">

			<!--Footer Links-->
			<div class="container">
				<p class="container-fluid center-block text-center"><img src="./images/logo/698942.png"></p>
			</div>

			<!--/.Footer Links-->


			<!--Copyright-->
			<div class="footer-copyright">
				<div class="container-fluid">
					© 2020 Copyright: HELOSS Entertainment.

				</div>
			</div>
			<!--/.Copyright-->

		</footer>
		<!--/.Footer-->

		<!-- SCRIPTS -->

		<!-- JQuery -->
		<script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/jquery-3.js"></script>

		<!-- Tooltips -->
		<script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/tether.js"></script>

		<!-- Bootstrap core JavaScript -->
		<script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/bootstrap.js"></script>

		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/mdb.js"></script>

		<script>
			$(".button-collapse").sideNav();

			var el = document.querySelector('.custom-scrollbar');

			Ps.initialize(el);
		</script>




		<div class="hiddendiv common"></div>
		<div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div>
	</body>

	</html>