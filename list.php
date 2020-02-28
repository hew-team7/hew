
<?php
$shop_id = $_GET['shop_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT ssp.id,price_cut,quantity,expiration_date,close_date,sp.name AS product_name,sp.list_price,hash_tag,sl.name AS shop_name  
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_id AND close_date > now() AND quantity > 0;";
$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array[] = $row;
}
mysqli_close($cn);
$cnt = count($table_array);


  
?><DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $table_array[0]["shop_name"]?>の商品</title>
  <link rel="stylesheet" type="text/css" href="css/list.css">
  <link href="https://fonts.googleapis.com/css?family=Sawarabi+Mincho" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/map.js"></script>
</head>
<body>
<div id="header">
    <p><a href="index.php"><img src=""></a></p>
  </div>
  <div class="drawer drawer--rght">
    <div class="zdo_drawer_menu right">
      <div class="zdo_drawer_bg"></div>
          <button type="button" class="zdo_drawer_button">
          <span class="zdo_drawer_bar zdo_drawer_bar1"></span>
          <span class="zdo_drawer_bar zdo_drawer_bar2"></span>
          <span class="zdo_drawer_bar zdo_drawer_bar3"></span>
          <span class="zdo_drawer_menu_text zdo_drawer_text">MENU</span>
          <span class="zdo_drawer_close zdo_drawer_text">CLOSE</span>
        </button>
      <nav class="zdo_drawer_nav_wrapper">
        <ul class="zdo_drawer_nav">
          <a href=""><li>マイページ</li></a>
          <a href=""><li>お気に入り</li></a>
          <a href=""><li id="last">履歴</li></a>
        </ul>
      </nav>
    </div>
    </div>

    <script>
      $(function () {
        $('.zdo_drawer_button').click(function () {
          $(this).toggleClass('active');
          $('.zdo_drawer_bg').fadeToggle();
          $('nav').toggleClass('open');
        })
        $('.zdo_drawer_bg').click(function () {
          $(this).fadeOut();
          $('.zdo_drawer_button').removeClass('active');
          $('nav').removeClass('open');
          });
        })
    </script>
<div id="main">
　<?php if($cnt!=0){ ?>
    <h1>商品</h1>
      <div class="PRODUCTS">
        <div class="Product1">
        　<?php for($i=0;$i<$cnt;$i++){ ?>
            <div class="product">
              <a href="goods_list.php?product_id=<?php echo $table_array[$i]["id"]; ?>">
                <p><img src="./img/product_<?php echo $table_array[$i]["id"]; ?>.jpg"></p>
                <p><?php echo $table_array[$i]["product_name"] ?></p>
                <p>￥<?php echo $table_array[$i]['list_price'] ?>　<span style="color: red">→ ￥<?php echo $table_array[$i]["price_cut"]; ?></p>
              </a>
            </div>
          <?php } ?>  
        </div>
      </div>
  <?php }else{ ?>
       <p id="p1">掲載されている商品ありません。</p>
  <?php } ?>
</div>
<div id="end">
  <p>HEW 7team</p>
</div>
</body>
</html>