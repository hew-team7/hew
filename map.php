<?php

require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT id,name,address1,address2 FROM shop_list;";

$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array[] = $row;
}
mysqli_close($cn);
$cnt = count($table_array);

 
mb_language("Japanese");//文字コードの設定
mb_internal_encoding("UTF-8");
 
$apikey = "dj00aiZpPUpiQlVZd3ZoaGc5MiZzPWNvbnN1bWVyc2VjcmV0Jng9NGU-";

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






 
 
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>map</title>
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
    <link rel="stylesheet" href="test/Material%20Design%20Bootstrap%20Template_files/font-awesome.css">

    <!-- Bootstrap core CSS -->
    <link href="test/Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="test/Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">

    <script>

      function init() {

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            // success callback
            function(position) {
              var map = L.map('mapcontainer', { zoomControl: false });
              var mpoint = [position.coords.latitude, position.coords.longitude];
              map.setView(mpoint, 15);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: "<a href='https://www.openstreetmap.org/copyright' target='_blank'>地理院タイル</a>"
              }).addTo(map);
              //ポップアップオブジェクトを作成
                  //var popup1 = L.popup().setContent('<a href="">あ</a>');
              //マーカーにポップアップを紐付けする。同時にbindTooltipでツールチップも追加
                  L.marker(mpoint, { draggable: true, icon: L.spriteIcon('red')}).bindTooltip("現在地").addTo(map);
                  //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
                  <?php for($i=0; $i<$cnt; $i++){?>
                  var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array[$i]['name'];?><br><?php echo $table_array[$i]['address1'].$table_array[$i]['address2'];?><br><a href="list.php?shop_id=<?php echo $table_array[$i]['id'];?>">商品はこちら</a>');
                  L.marker([<?php echo $lat[$i];?>, <?php echo $lon[$i];?>],{ icon: L.spriteIcon('red')}).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array[$i]['name'];?>").addTo(map);
                  <?php } ?>
                
            },
            // error callback
            function(position) {
            　 var mapcontainer = document.getElementById('mapcontainer');
            　 var textNode = document.createTextNode('位置情報の取得に失敗しました。');
            　 mapcontainer.appendChild(textNode);
            }
          )
        }  

        
      }

    </script>
    <script>
      $(function(){
        var headerHeight = $('#nav').outerHeight();// ナビの高さを取得 
        var windowHeight = $(window).height();// 表示画面の高さを取得
        var H = windowHeight-headerHeight-30;
        $('#mapcontainer').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定  
        $('#main').css('height', H + 'px');
        $('.fixed-sn main').css('margin-top', headerHeight + 'px');
        console.log(headerHeight);
        console.log(H);
        console.log(windowHeight);
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

<body class="fixed-sn dark-skin" onload="init()">

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
            <div class="breadcrumb-dn" style="position: relative;left:-90px;">
                <p>Material Design for Bootstrap</p>
            </div>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double Navigation-->

    <!--Main layout-->
    <main id="main">
    <div id="mapcontainer" style="width: 100%;"></div>
    </main>
    <!--/Main layout-->

    <!--Footer-->
    <footer class="page-footer" style="height: 30px;" id="foo">

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