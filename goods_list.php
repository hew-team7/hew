<?php
$product_id = $_GET['product_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT maker_name,price_cut,sell_quantity,buy_quantity,expiration_date,ssp.shop_id,sl.name AS shop_name,sp.product_name AS p_name,file_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.id = $product_id;";


$result = mysqli_query($cn,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($cn);
$quantity = $row['sell_quantity'] - $row['buy_quantity'];


?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $row['p_name'];?> | HELOSS</title>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>


    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">


    <script>
      $(function () {
          var ua = navigator.userAgent;
          if ((ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0) && ua.indexOf('Mobile') > 0) {
              // スマートフォン用処理
              $('#table').css('margin-left','20%');
          } 
      })
    </script>
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
        .side-nav .logo-wrapper, .side-nav .logo-wrapper a {
            height: 0px;
        }
        .dark-gradient, .dark-skin .side-nav {
    
            background: linear-gradient(135deg,#fb7d22 0,#fb7d22 100%);
                
         }
         .dark-skin .side-nav .sn-avatar-wrapper img {
            border: none;
            box-shadow: 2px 3px 3px rgba(0,0,0,0.3); 
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
        
        .side-nav .collapsible > li {
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

        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></ul>
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
        <div class="container-fluid text-xs-center" style="min-heght:800px;">
        <div class="row">
          <div class="col-lg-6" style="margin-top:7%;">
            <p style="text-align:center;"><img src="images/product/<?php echo $row['file_name']; ?>" width="50%;"></p>
            <p id="money" style="text-align:center;font-size:2em;border-bottom:solid 1px #000;margin:0 20%;">￥<?php echo $row['price_cut']; ?></p>
          </div>
          <div class="col-lg-6" style="margin-top:10%;" id="table">
            <table class="table" style=";">
                <tr>
                  <th class="text-center" style="width: 400px;border:none;" align="left">店舗　　　：　　 <?php echo $row['shop_name']; ?></th>
                </tr>
                <tr>
                  <th class="text-center" style="width: 400px;border:none;" align="left">商品名　　：　　<?php echo $row['p_name']; ?></th>
                </tr>
                <tr>
                  <th class="text-center" style="width: 400px;border:none;" align="left" valign="top">メーカー　：　　<?php echo $row['maker_name']; ?></th>
                </tr>
                <tr>
                  <th class="text-center" style="width: 400px;border:none;" align="left">数量　　　：　　<?php echo $quantity; ?></th>
                </tr>
                <tr>
                  <th class="text-center" style="width: 400px;border:none;" align="left">期限　　　：　　<?php echo $row['expiration_date']; ?></th>
                </tr>
            </table>
          </div>
        </div>
      </div>
    
      <form action="" method="post" style="text-align:center;margin-top:50px;">
        <input class="btn btn-warnig btn-rounded waves-effect waves-light" type="submit" name="submit" id="submit" value="購入する" style="background:orange;">
        <input type="image" src="images/はーと.png" name="heart" class="ico" style="height: 60px;margin:0 20px;">
        <input type="image" src="images/60009001106.jpg" name="report"  style="height: 60px;margin:0 20px;">
      </form>
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




<div class="hiddendiv common"></div><div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div></body></html>