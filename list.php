
<?php
$shop_id = $_GET['shop_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT ssp.id,price_cut,quantity,expiration_date,sp.name AS product_name,sp.list_price,hash_tag,sl.name AS shop_name  
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.shop_id = $shop_id;";
$result = mysqli_query($cn,$sql);
$table_array = array();  // テーブル情報を格納する変数
while($row = $result->fetch_assoc() ){
  $table_array[] = $row;
}
mysqli_close($cn);
var_dump($table_array);
$cnt = count($table_array);
var_dump($cnt);

  
?><DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $table_array[0]["shop_name"]?>の商品</title>
  <link rel="stylesheet" type="text/css" href="css/list.css">
  <script></script>
</head>
<body>
<div id="main">
      <h1><?php echo $table_array[0]["shop_name"]?>の商品</h1>
      <div class="PRODUCTS">
        <div class="Product1">
            <div class="product">
              <a href="goods_list.php?product_id=<?php echo $table_array[0]["id"]; ?>">
                <p><img src="./img/product_<?php echo $table_array[0]["id"]; ?>.jpg"></p>
                <p><?php echo $table_array[0]["product_name"] ?></p>
                <p>￥<?php echo $table_array[0]['list_price'] ?>　<span style="color: red">cut ￥<?php echo $table_array[0]["price_cut"]; ?></p>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
</body>
</html>