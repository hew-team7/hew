<?php
session_start();
$shop_id = $_SESSION['shop_id'];
$shop_number = $_SESSION['shop_number'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql1 = "SELECT shop_id 
FROM shop_login 
WHERE shop_id = '$shop_id';";
$result1 = mysqli_query($cn,$sql1);
$row1 = mysqli_fetch_assoc($result1);
$sid = $row1["shop_id"];

$sql = "SELECT ssp.id,price_cut,sell_price,ssp.detail,sell_quantity,buy_quantity,expiration_date,close_date,file_name,sp.product_name AS product_name,sp.price,sl.name AS shop_name  
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_number AND close_date > now() AND sell_quantity > buy_quantity;";
$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = mysqli_fetch_assoc($result) ){
$table_array[] = $row;
}
$cnt = count($table_array);

$sql = "SELECT * FROM shop_product WHERE shop_id = '$shop_number';";
$result1 = mysqli_query($cn,$sql);
$table_array1 = array();  // テーブル情報を格納する変数
while($row1 = mysqli_fetch_assoc($result1) ){
$table_array1[] = $row1;
}
$cnt1 = count($table_array1);

mysqli_close($cn);


  
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>店舗　TOPページ | HELOSS</title>
    <link href="https://fonts.googleapis.com/css?family=Sawarabi+Mincho" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
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
        .overlay img, .overlay video {
            margin: auto;
        }

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
        .side-nav .logo-wrapper, .side-nav .logo-wrapper a {
            height: 0px;
        }
        .dark-gradient, .dark-skin .side-nav {
    
            background: linear-gradient(135deg,#52dda9 0,#52dda9 100%);
                
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
            background-color: #91eeba;
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
        <div class="container-fluid text-xs-center" style="min-height: 500px;">
                <?php if($cnt!=0){ ?>
                <h1 style="font-size:1.5em;margin-top:30px;text-align:left;margin-left:20px;margin-bottom:30px;">掲載されている商品</h1>
                <div class="row">

                    <?php for($i=0;$i<$cnt;$i++){ ?>
                        <a href="goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>">
                        <div class="col-lg-4 col-md-6">

                        <!--Card-->
                        <div class="card">

                            <!--Card image-->
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="./images/product/<?php echo $table_array[$i]["file_name"]; ?>" class="img-fluid">
                                <a>
                                    <div class="mask waves-effect waves-light"></div>
                                </a>
                            </div>
                            <!--/.Card image-->

                            <!--Card content-->
                            <div class="card-block text-xs-center">
                                <!--Category & Title-->
                                <h4 class="card-title"><strong><a href="s_goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>"><?php echo $table_array[$i]["product_name"] ?></a></strong></h4>

                                <!--Description--><?php if($table_array[$i]["detail"] != null){ ?>
                                <p class="card-text"><?php echo $table_array[$i]["detail"]; ?></p>
                                <?php } ?>
                                <!--Card footer-->
                                <div class="card-footer">
                                    <span class="left"  style="margin-left:30%;">￥<?php echo $table_array[$i]['price_cut'] ?> <span class="discount">￥<?php echo $table_array[$i]['sell_price'] ?></span></span>
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

            <?php if($cnt1!=0){ ?>
                <h1 style="font-size:1.5em;margin-top:30px;text-align:left;margin-left:20px;margin-bottom:30px;">登録されている商品</h1>
                <div class="row">

                    <?php for($i=0;$i<$cnt1;$i++){ ?>
                        <div class="col-lg-4 col-md-6">

                        <!--Card-->
                        <div class="card">

                            <!--Card image-->
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="./images/product/<?php echo $table_array1[$i]["file_name"]; ?>" class="img-fluid">
                                    <div class="mask waves-effect waves-light"></div>
                            </div>
                            <!--/.Card image-->

                            <!--Card content-->
                            <div class="card-block text-xs-center">
                                <!--Category & Title-->
                                <h4 class="card-title text-xs"><strong><?php echo $table_array1[$i]["product_name"] ?></strong></h4>

                                <!--Card footer-->
                                <div class="card-footer">
                                    <span class="center"  style=""><span style="font-size:0.5em;">maker : </span><?php echo $table_array1[$i]['maker_name'] ?></span><br>
                                    <span class="center"  style=""><span style="font-size:0.5em;">価格 : </span>￥<?php echo number_format($table_array1[$i]['price']); ?></span>
                                </div>

                            </div>
                            <!--/.Card content-->

                        </div>
                        <!--/.Card-->
                        </div>
                    <?php } ?>     
                    
                </div>
            <?php }else{ ?>
                <p style="text-align: center;">登録されている商品ありません。</p>
            <?php } ?>
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




<div class="hiddendiv common"></div><div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div></body></html>