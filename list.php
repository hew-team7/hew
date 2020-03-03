<?php
$shop_id = $_GET['shop_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT ssp.id,price_cut,ssp.detail,sell_quantity,expiration_date,close_date,sp.product_name,ssp.sell_price,file_name,sl.name AS shop_name  
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_id AND close_date > now() AND sell_quantity > 0;";
$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = mysqli_fetch_assoc($result)){
  $table_array[] = $row;
}
$cnt = count($table_array);

$sql = "SELECT s_name,introduction   
FROM shop_plofile 
WHERE shop_id = $shop_id;";
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
    <title><?php echo $table_array[0]["shop_name"]?>の商品</title>
    <link href="https://fonts.googleapis.com/css?family=Sawarabi+Mincho" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  
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
        $('.fixed-sn main').css('margin-top', headerHeight+5 + 'px');
     });
    </script>
    <script>
    $(function () {
        var ua = navigator.userAgent;
        if ((ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0) && ua.indexOf('Mobile') > 0) {
            // スマートフォン用処理
            $('#main .product').css('width', '120px');
            $('#main .product img').css('width', '110px');
        } else {
            // PC用処理
            $('#main .product').css('width', '180px');
            $('#main .product img').css('width', '170px');
        }
    })

    </script>
    <style>
        body {
            background-color: #fff;
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
    <main id="main" style="margin:2%;;background-color: #fff;border-radius:2%;">
    　<?php if($cnt!=0){ ?>
        <h1 style="font-size:1.8em;">商品</h1>
        <div class="row">

            <?php for($i=0;$i<$cnt;$i++){ ?>
                <a href="goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>">
                <div class="col-lg-4 col-md-6">


                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight z-depth-1">
                        <img src="./img/<?php echo $table_array[$i]["file_name"]; ?>" class="img-fluid">
                        <a>
                            <div class="mask waves-effect waves-light"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Category & Title-->
                        <h4 class="card-title"><strong><a href="goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>"><?php echo $table_array[$i]["product_name"] ?></a></strong></h4>

                        <!--Description-->
                        <p class="card-text"><?php echo $table_array[$i]["detail"]; ?></p>

                        <!--Card footer-->
                        <div class="card-footer">
                            <span class="left" style="padding-left:120px;">￥<?php echo $table_array[$i]['sell_price'] ?> <span class="discount">￥<?php echo $table_array[$i]['price_cut'] ?></span></span>
                        </div>

                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
                </div></a>
            <?php } ?>     
            
        </div>
      <?php }else{ ?>
        <p style="text-align: center;">掲載されている商品ありません。</p>
      <?php } ?>
      <?php if($row != null){?>
        <h1 style="font-size:1.8em;">店舗情報</h1>
        <p style="text-align: center;">店舗名　：　<?php echo $row["s_name"] ?><br>店舗説明　：　<?php echo $row["introduction"] ?></p>
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