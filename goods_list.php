<?php
$product_id = $_GET['product_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT maker_name,price_cut,sell_quantity,expiration_date,ssp.shop_id,sl.name AS shop_name,sp.product_name AS p_name,file_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.id = $product_id;";


$result = mysqli_query($cn,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($cn);


?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $row['p_name'];?></title>
    <link rel="stylesheet" type="text/css" href="css/goods_list.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/goods_list.css">
  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="test/Material%20Design%20Bootstrap%20Template_files/font-awesome.css">

    <!-- Bootstrap core CSS -->
    <link href="test/Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="test/Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">


    <script>
      $(function(){
        var headerHeight = $('#nav').outerHeight();// ナビの高さを取得 
        var windowHeight = $(window).height();// 表示画面の高さを取得
        var H = windowHeight-headerHeight-30; 
        $('#main').css('min-height', H + 'px');
        $('.fixed-sn main').css('margin-top', headerHeight+20 + 'px');
      });

    </script>
    <style>
        body {
            background: url("./images/index.jpg")no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>

</head>

<body class="fixed-sn dark-skin" style="">

    <!--Double Navigation-->
    <header>

        <!-- Sidebar navigation -->
        <ul id="slide-out" class="side-nav fixed custom-scrollbar ps-container ps-theme-default" style="transform: translateX(-100%);" data-ps-id="96864e62-e306-5383-47b2-9d30422757ea">

            <!-- Logo -->
            <li>
                <div class="logo-wrapper waves-light sn-avatar-wrapper waves-effect waves-light">
                    <a href="#">
                        <img src="./images/" class="rounded-circle">
                    </a>
                </div>
            </li>
            <!--/. Logo -->


            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion" style="color: gray;">
                    <li><a class="collapsible-header waves-effect arrow-r" style="color: gray;">・ マイページ</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#" class="waves-effect" style="color: gray;">　お気に入り</a>
                                </li>
                                <li><a href="#" class="waves-effect" style="color: gray;">　購入履歴</a>
                                </li>
                                <li><a href="#" class="waves-effect" style="color: gray;">　登録内容の変更</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a class="collapsible-header waves-effect arrow-r" style="color: gray;">・ 問い合わせ</a></li>
                </ul>
            </li>
            <!--/. Side navigation links -->

        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></ul>
        <!--/. Sidebar navigation -->

        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav" id="nav">

            <!-- SideNav slide-out button -->
            <div class="float-xs-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><img src="./images/icon_23.png" style="width: 5%;"></a>
            </div>

            <!-- Breadcrumb-->
            <div class="breadcrumb-dn">
                <p>HELOSS</p>
            </div>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double Navigation-->

    <!--Main layout-->
    <main id="main" style="margin:30px;widht:80%;background-color: #fff;border-radius:2%;">
      <div id="left">
        <p><img src="img/<?php echo $row['file_name']; ?>"></p>
        <p id="money">￥<?php echo $row['price_cut']; ?></p>
      </div>
      <div id="right">
        <table>
          <tr>
            <th style="width: 400px" align="left">店舗： <?php echo $row['shop_name']; ?></th>
          </tr>
          <tr>
            <th align="left">商品名：<?php echo $row['p_name']; ?></th>
          </tr>
          <tr>
            <th align="left" valign="top">メーカー：<?php echo $row['maker_name']; ?></th>
          </tr>
          <tr>
            <th align="left">数量：<?php echo $row['sell_quantity']; ?></th>
          </tr>
          <tr>
            <th align="left">期限：<?php echo $row['expiration_date']; ?></th>
          </tr>
          
        </table>
      </div>

      <form action="" method="post">
        <input class="buy" type="submit" name="submit" id="submit" value="購入する">
        <input type="image" src="images/はーと.png" name="heart" class="ico">
        <input type="image" src="images/60009001106.jpg" name="report"  class="ico" id="ico_n">
      </form>


    </main>
    <!--/Main layout-->

    <!--Footer-->
    <footer class="page-footer" style="height: 30px;">

        <!--Copyright-->
        <div class="footer-copyright">
            <div class="container-fluid" style="padding-top: 8px;">HEW 7team</div>
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->








    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script type="text/javascript" src="test/Material%20Design%20Bootstrap%20Template_files/jquery-3.js"></script>

    <!-- Tooltips -->
    <script type="text/javascript" src="tets/Material%20Design%20Bootstrap%20Template_files/tether.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="test/Material%20Design%20Bootstrap%20Template_files/bootstrap.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="test/Material%20Design%20Bootstrap%20Template_files/mdb.js"></script>

    <script>
        $(".button-collapse").sideNav();

        var el = document.querySelector('.custom-scrollbar');

        Ps.initialize(el);
    </script>




<div class="hiddendiv common"></div><div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div></body></html>