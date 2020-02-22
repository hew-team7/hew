
<?php

require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT id,name,address1,address2 
FROM shop_list;";

$result = mysqli_query($cn,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($cn);
 
mb_language("Japanese");//文字コードの設定
mb_internal_encoding("UTF-8");
 
$apikey = "dj00aiZpPUpiQlVZd3ZoaGc5MiZzPWNvbnN1bWVyc2VjcmV0Jng9NGU-";

//住所1を入れて緯度経度を求める。
$address = $row['address1'] . $row['address2'];
$address = urlencode($address);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address ;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents ->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon1 = $geo[0];
$lat1 = $geo[1];
$name = $row['name'];



/* 
//住所3を入れて緯度経度を求める。
$address3 = "";
$address = urlencode($address3);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address ;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents ->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon3 = $geo[0];
$lat3 = $geo[1];
*/

/* 
//住所4を入れて緯度経度を求める。
$address4 = "";
$address = urlencode($address4);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address ;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents ->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon4 = $geo[0];
$lat4 = $geo[1];
 */ 
 
 
?><DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
　<script src="js/leaflet.sprite.js"></script>
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
            var popup1 = L.popup().setContent('<a href="">あ</a>');
            //var popup3 = L.popup().setContent("<?php //echo $address3?>");
            //var popup4 = L.popup().setContent("<?php //echo $address4?>");
          //マーカーにポップアップを紐付けする。同時にbindTooltipでツールチップも追加
            L.marker(mpoint, { draggable: true, icon: L.spriteIcon('red')}).bindTooltip("現在地").addTo(map);
            L.marker([<?php echo $lat1?>, <?php echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php echo $name;?>").addTo(map);
            //L.marker([<?php //echo $lat3?>, <?php //echo $lon3?>]).bindPopup(popup3).bindTooltip("").addTo(map);
            //L.marker([<?php //echo $lat4?>, <?php //echo $lon4?>]).bindPopup(popup4).bindTooltip("").addTo(map);
            mapcontainer.style.width = '800px';
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
</head>
<body onload="init()">
  <div id="mapcontainer" style="margin: auto;height: 500px;"></div>
</body>
</html>