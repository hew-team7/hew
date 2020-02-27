<?php
$product_id = $_GET['product_id'];
require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT sp.detail,price_cut,quantity,expiration_date,ssp.shop_id,sl.name AS shop_name,sp.name AS p_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.id = $product_id;";

$result = mysqli_query($cn,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($cn);


?><!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php echo $row['p_name'];?></title>
  <link rel="stylesheet" type="text/css" href="css/goods_list.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/map.js"></script>
  <link rel="stylesheet" type="text/css" href="css/goods_list.css">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body>

  <div id="wrapper">

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

    

    <div id="main">
      <div id="left">
        <p><img src="img/"></p>
        <p id="money">￥<?php echo $row['price_cut']; ?></p>
      </div>
      <div id="right">
        <table>
          <tr>
            <th style="width: 400px" align="left">出品者： <?php echo $row['shop_name']; ?></th>
          </tr>
          <tr>
            <th align="left">商品名：<?php echo $row['p_name']; ?></th>
          </tr>
          <tr>
            <th align="left" valign="top">説明：<?php echo $row['detail']; ?></th>
          </tr>
          <tr>
            <th align="left">数量：<?php echo $row['quantity']; ?></th>
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


      
      

    </div>

    <div id="end">
      <p>HEW 7team</p>
    </div>

  </div>
</body>

</html>