<?php

require_once 'config.php';

$cn0 = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn0,'utf8');
$sql0 = "SELECT DISTINCT sl.id 
FROM shop_list sl INNER JOIN shop_sell_product ssp ON sl.id = ssp.shop_id 
WHERE close_date >= now() AND NOT buy_quantity = sell_quantity;";

$result = mysqli_query($cn0,$sql0);
$table_array0 = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array0[] = $row;
}
mysqli_close($cn0);
$cnt0 = count($table_array0);
$ids = "";
$tmp = $table_array0;
for($i=0;$i<$cnt0;$i++){
  $ids .= $table_array0[$i]["id"];
  if(next($tmp)){
    $ids .= ",";
  }
  
}

$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT id,name,address1,address2 
FROM shop_list 
WHERE id IN($ids);";

$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array[] = $row;
}
mysqli_close($cn);
$cnt = count($table_array);

$cn1 = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn1,'utf8');
$sql1 = "SELECT id,name,address1,address2 
FROM shop_list 
WHERE id NOT IN($ids);";

$result1 = mysqli_query($cn1,$sql1);
$table_array1 = array();  // テーブル情報を格納する変数
while($row = $result1->fetch_assoc() ){
  $table_array1[] = $row;
}
mysqli_close($cn1);
$cnt1 = count($table_array1);

 
mb_language("Japanese");//文字コードの設定
mb_internal_encoding("UTF-8");
 
$apikey = "dj00aiZpPTJoc1NXdUlmVFdJaSZzPWNvbnN1bWVyc2VjcmV0Jng9ZDk-";

for ($i=0; $i<$cnt; $i++){
  //住所1を入れて緯度経度を求める。
$address[$i] = $table_array[$i]['address1'] . $table_array[$i]['address2'];
$address[$i] = urlencode($address[$i]);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address[$i] ;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents ->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon[$i] = $geo[0];
$lat[$i] = $geo[1];

}

  for ($i=0; $i<$cnt1; $i++){
    //住所1を入れて緯度経度を求める。
  $address1[$i] = $table_array1[$i]['address1'] . $table_array1[$i]['address2'];
  $address1[$i] = urlencode($address1[$i]);
  $url1 = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address1[$i] ;
  $contents = file_get_contents($url1);
  $contents = json_decode($contents);
  @$Coordinates = $contents ->Feature[0]->Geometry->Coordinates;
  $geo = explode(",", $Coordinates);
  $lon1[$i] = $geo[0];
  @$lat1[$i] = $geo[1];
  
  }


 
 
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MAP | HELOSS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="css/map.css">
    <link href="https://fonts.googleapis.com/css?family=Sawarabi+Mincho" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
    <script src="js/leaflet.sprite.js"></script>


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
    <script>

        function init() {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
            // success callback
            function(position) {
                var map = L.map('mapcontainer').setView([34.699875 , 135.493032], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: "<a href='https://www.openstreetmap.org/copyright' target='_blank'>地理院タイル</a>"
                }).addTo(map);
                //ポップアップオブジェクトを作成
                    //var popup1 = L.popup().setContent('<a href="">あ</a>');
                //マーカーにポップアップを紐付けする。同時にbindTooltipでツールチップも追加
                    L.marker([34.699875 , 135.493032], { draggable: true, icon: L.spriteIcon('red')}).bindTooltip("現在地").addTo(map);
                    //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
                    <?php for($i=0; $i<$cnt; $i++){?>
                    var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array[$i]['name'];?><br><?php echo $table_array[$i]['address1'].$table_array[$i]['address2'];?><br><a href="list.php?shop_id=<?php echo $table_array[$i]['id'];?>">商品はこちら</a>');
                    L.marker([<?php echo $lat[$i];?>, <?php echo $lon[$i];?>],{ icon: L.spriteIcon('blue')}).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array[$i]['name'];?>").addTo(map);
                    <?php } ?>

                    //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
                    <?php for($i=0; $i<$cnt1; $i++){?>
                    var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array1[$i]['name'];?><br><?php echo $table_array1[$i]['address1'].$table_array1[$i]['address2'];?>');
                    L.marker([<?php echo $lat1[$i];?>, <?php echo $lon1[$i];?>],{ icon: L.spriteIcon('green')}).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array1[$i]['name'];?>").addTo(map);
                    <?php } ?>
                
            },
            // error callback
            function(position) {
                　var map = L.map('mapcontainer').setView([34.699875 , 135.493032], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: "<a href='https://www.openstreetmap.org/copyright' target='_blank'>地理院タイル</a>"
                    }).addTo(map);
                    //ポップアップオブジェクトを作成
                        //var popup1 = L.popup().setContent('<a href="">あ</a>');
                    //マーカーにポップアップを紐付けする。同時にbindTooltipでツールチップも追加
                        L.marker([34.699875 , 135.493032], { draggable: true, icon: L.spriteIcon('red')}).bindTooltip("現在地").addTo(map);
                        //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
                        <?php for($i=0; $i<$cnt; $i++){?>
                        var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array[$i]['name'];?><br><?php echo $table_array[$i]['address1'].$table_array[$i]['address2'];?><br><a href="list.php?shop_id=<?php echo $table_array[$i]['id'];?>">商品はこちら</a>');
                        L.marker([<?php echo $lat[$i];?>, <?php echo $lon[$i];?>],{ icon: L.spriteIcon('blue')}).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array[$i]['name'];?>").addTo(map);
                        <?php } ?>

                        //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
                        <?php for($i=0; $i<$cnt1; $i++){?>
                        var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array1[$i]['name'];?><br><?php echo $table_array1[$i]['address1'].$table_array1[$i]['address2'];?>');
                        L.marker([<?php echo $lat1[$i];?>, <?php echo $lon1[$i];?>],{ icon: L.spriteIcon('green')}).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array1[$i]['name'];?>").addTo(map);
                        <?php } ?>
            }
            )
        }  

        
        }

</script>

</head>

<body class="fixed-sn dark-skin" style=""  onload="init()">

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
        <div class="container-fluid text-xs-center" style="height: 600px;">
           <div id="mapcontainer" style="width: 100%;z-index:1;height: 600px;"></div>
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