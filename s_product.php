<?php
$shop_id = 32000002;
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT ssp.id,price_cut,sell_quantity,expiration_date,close_date,sp.product_name,sp.price,sl.name AS shop_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_id AND close_date >= now() AND sell_quantity > 0;";
$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array[] = $row;
}
mysqli_close($cn);
$cnt = count($table_array);

$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT ssp.id,price_cut,sell_quantity,expiration_date,close_date,sp.product_name,sp.price,sl.name AS shop_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_id;";
$result = mysqli_query($cn,$sql);
$table_array1 = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array1[] = $row;
}
mysqli_close($cn);
$cnt1 = count($table_array1);


  
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>自店舗の商品</title>
    <link href="https://fonts.googleapis.com/css?family=Sawarabi+Mincho" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="css/list.css">
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
                                <li><a href="#" class="waves-effect" style="color: gray;">　商品を登録する</a>
                                </li>
                                <li><a href="#" class="waves-effect" style="color: gray;">　商品を掲載する</a>
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
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

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
    <main id="main" style="margin:30px;margin-top:90px;widht:80%;background-color: #fff;border-radius:2%;">
        　<?php if($cnt!=0){ ?>
            <h1>掲載中の商品</h1>
            <div class="PRODUCTS">
                <div class="Product1">
                　<?php for($i=0;$i<$cnt;$i++){ ?>
                    <div class="product">
                    <a href="goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>">
                        <p><img src="./img/product_<?php echo $table_array[$i]["id"]; ?>.jpg"></p>
                        <p><?php echo $table_array[$i]["product_name"] ?></p>
                        <p>￥<?php echo $table_array[$i]['price'] ?>　<span style="color: red">→ ￥<?php echo $table_array[$i]["price_cut"]; ?></p>
                    </a>
                    </div>
                <?php } ?>  
                </div>
            </div>
        <?php }else{ ?>
            <p id="p1">掲載されている商品ありません。</p>
        <?php } ?>

        <?php if($cnt1!=0){ ?>
            <h1>登録中の商品</h1>
            <div class="PRODUCTS">
                <div class="Product1">
                　<?php for($i=0;$i<$cnt1;$i++){ ?>
                    <div class="product">
                    <a href="goods_list.php?product_id=<?php echo $table_array1[$i]["id"]; ?>">
                        <p><img src="./img/product_<?php echo $table_array1[$i]["id"]; ?>.jpg"></p>
                        <p><?php echo $table_array1[$i]["product_name"] ?></p>
                        <p>￥<?php echo $table_array1[$i]['price'] ?>　<span style="color: red">→ ￥<?php echo $table_array1[$i]["price_cut"]; ?></p>
                    </a>
                    </div>
                <?php } ?>  
                </div>
            </div>
        <?php }else{ ?>
            <p id="p1">登録されている商品ありません。</p>
        <?php } ?>


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