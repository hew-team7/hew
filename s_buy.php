<?php
session_start();

//$sid = $_SESSION['sid'];

$sid = '32000004';
$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

$pid = $_GET['pid'];

// 商品詳細
$sql = "SELECT * FROM shop_sell_product a 
INNER JOIN shop_list b ON a.shop_id = b.id INNER JOIN shop_product c ON a.product_id = c.id WHERE a.product_id = '$pid';";
$result = mysqli_query($cn, $sql);
$prow = mysqli_fetch_assoc($result);

$sname = $prow['name'];
$quan = $prow['sell_quantity'];
$price = $prow['sell_quantity'] * $prow['price_cut'];

// 店舗詳細
$sql = "SELECT * FROM shop_list WHERE id = '$sid'";
$result = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($result);
$bname = $srow['name'];

// 購入する
if (isset($_POST['suc'])) {
  // 購入数の変更
  $sql = "UPDATE shop_sell_product SET buy_quantity = '$quan' WHERE product_id = '$pid';";
  $result = mysqli_query($cn, $sql);

  // 管理側へ通知
  $sql3 = "SELECT MAX(id) AS id FROM news;";
  $result = mysqli_query($cn, $sql3);
  $row = mysqli_fetch_assoc($result);
  $nid = $row['id'] + 1;
  $title = $bname . "が" . $sname . "の商品を購入しました";
  $detail = $bname . "が" . $sname . "の商品を購入しました。/商品名：" . $prow['product_name'] . "/数量：" . $prow['sell_quantity'] . "個/金額：￥" . number_format($price) . "円";
  $sql = "INSERT INTO news(id,title,detail,news_type,send_to,from_to,sell_id) VALUES($nid,'$title','$detail',6,0,'$sid','$pid');";
  $result = mysqli_query($cn, $sql);

  header("location: ./s_buy_suc.php");
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

    th {
      text-align: center;
    }

    .g {
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
      <h2 style="margin: 30px 0;" class="g">購入内容確認</h2>
      <div class="card">
        <table class="table">
          <tr>
            <th class="o">商品名</th>
            <td><?php echo $prow['product_name']; ?></td>
          </tr>
          <tr>
            <td class="o">数量</th>
            <td><?php echo $prow['sell_quantity']; ?>個</td>
          </tr>
          <tr>
            <td class="o">金額</th>
            <td>￥<?php echo number_format($price); ?>円</td>
          </tr>
          <tr>
            <td class="o">購入店</th>
            <td><?php echo $prow['name']; ?></td>
          </tr>
        </table>
      </div>

      <h5 style="margin: 60px 0 30px 0;">本当に購入しますか？</h5>

      <div class="row">
        <form action="./s_buy.php?pid=<?php echo $pid; ?>" method="post">
          <a href="./s_news.php" class="btn btn-success waves-effect waves-light">購入をやめる</a>
          <button name="suc" class="btn btn-success waves-effect waves-light" style="margin-left: 50px;">購入する</button>
        </form>
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