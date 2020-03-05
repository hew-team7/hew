<?php
session_start();

//$sid = $_SESSION['sid'];

$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

// 仮ID
$sid = '32000004';
$sql = "SELECT * FROM shop_list WHERE id = '$sid';";
$result = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($result);
$address = $srow['address1'];

// 都道府県の確認
$address = $srow['address1'];
if (!(mb_strpos($address, '都') == false)) {
  $cnt = 2;
} else if (!(mb_strpos($address, '道') == false)) {
  $cnt = 2;
} else if (!(mb_strpos($address, '府') == false)) {
  $cnt = 2;
} else {
  $cnt = mb_strpos($address, '県');
}

$address = mb_substr($address, 0, $cnt + 1);

// 多店舗からの通知があるかどうか
$sql = "SELECT * FROM news WHERE send_to = '$address';";
$result = mysqli_query($cn, $sql);
$nlists = array();
while ($rows = mysqli_fetch_assoc($result)) {
  $nlists[] = $rows;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <!-- Required meta tags always come first -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>通知一覧 | HELOSS</title>

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
      background-color: #52dda9;
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

      background: linear-gradient(135deg, #52dda9 0, #52dda9 100%);

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
      background-color: #91eeba;
      transition: all .3s linear;
    }

    .side-nav .collapsible>li {
      padding-right: 1rem;
      padding-left: 1rem;
      margin-top: 10px;
    }

    .u {
      margin-bottom: 30px;
    }

    th{
      text-align: center;
    }

    .g{
      color: #52dda9;
      border-bottom: solid 1px #52dda9;
      padding-bottom: 20px;
    }

    .o{
      color: #52dda9;
      font-weight: bolder;
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
          <li><a href="./pl_rgt_in.php" class="collapsible-header waves-effect"><i class="fa fa-pencil-alt"></i> 商品登録</a>

          </li>

          <li><a href="./pl_exh_list.php" class="collapsible-header waves-effect"><i class="fa fa-camera"></i> 出品する</a>

          </li>

          <li><a href="./s_top.php" class="collapsible-header waves-effect"><i class="fa fa-fish"></i> 出品している商品</a>

          </li>

          <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cog"></i> 設定<i class="fa fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="./s_pl_stg.php" class="waves-effect">プロフィール編集</a>
                </li>
                <li><a href="./log_out.php" class="waves-effect">ログアウト</a>
                </li>
              </ul>
            </div>
          </li>

          <li><a href="./s_question.php" class="collapsible-header waves-effect"><i class="fa fa-question"></i> お問い合わせ</a>
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
          <a href="./s_news.php" class="nav-link waves-effect waves-light"><i class="fa fa-bell"></i> <span class="hidden-sm-down">お知らせ</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <span class="hidden-sm-down">プロフィール</span> </a>
          <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <a class="dropdown-item waves-effect waves-light" href="./s_pl.php">プロフィール確認</a>
            <a class="dropdown-item waves-effect waves-light" href="./s_pl_stg.php">プロフィール編集</a>
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
      <h2 style="margin: 30px 0;" class="g">通知一覧</h2>
      <div class="card">
      <table class="table">
        <thead>
          <th>主題</th>
          <th>掲示日</th>
          <th>詳細</th>
        </thead>
        <?php foreach ($nlists as $nlist) : ?>
          <tbody>
            <tr>
              <td style="padding-top: 25px;"><?php echo $nlist['title']; ?></td>
              <td style="padding-top: 25px;"><?php echo $nlist['paste_date']; ?></td>
              <td><a href="./s_new_det.php?id=<?php echo $nlist['id']; ?>" class="btn btn-success waves-effect waves-light">詳細</a></td>
            </tr>
          </tbody>
        <?php endforeach ?>
      </table>
      </div>
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