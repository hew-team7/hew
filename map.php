
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






 
 
?><DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <link rel="stylesheet" type="text/css" href="css/map.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/map.js"></script>
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
            //var popup1 = L.popup().setContent('<a href="">あ</a>');
          //マーカーにポップアップを紐付けする。同時にbindTooltipでツールチップも追加
            L.marker(mpoint, { draggable: true, icon: L.spriteIcon('red')}).bindTooltip("現在地").addTo(map);
            //L.marker([<?php //echo $lat1?>, <?php //echo $lon1?>]).bindPopup(popup1).bindTooltip("<?php //echo $name;?>").addTo(map);
            <?php for($i=0; $i<$cnt; $i++){?>
              var popup<?php echo $i;?> = L.popup().setContent('<?php echo $table_array[$i]['name'];?><br><?php echo $table_array[$i]['address1'].$table_array[$i]['address2'];?><br><a href="list.php?shop_id=<?php echo $table_array[$i]['id'];?>">商品はこちら</a>');
              L.marker([<?php echo $lat[$i];?>, <?php echo $lon[$i];?>]).bindPopup(popup<?php echo $i; ?>).bindTooltip("<?php echo $table_array[$i]['name'];?>").addTo(map);
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
</head>
<body onload="init()">
  <div id="header">
    <p><a href="index.php"><img src=""></a></p>
  </div>
  <div id="navi">
    <ul>
      <a href=""><li>マイページ</li></a>
      <a href=""><li>お気に入り</li></a>
      <a href=""><li id="last">履歴</li></a>
    </ul>
  </div>
  <div id="mapcontainer" style="width: 85%;"></div>
  <div id="end">
    <p>HEW 7team</p>
  </div>
</body>
</html>