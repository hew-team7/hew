<?php

require_once 'config.php';
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
mysqli_set_charset($cn,'utf8');
$sql = "SELECT sp.detail,price_cut,quantity,expiration_date,ssp.shop_id,sl.name AS shop_name,sp.name AS p_name 
FROM shop_sell_product ssp 
INNER JOIN shop_product sp ON sp.id = ssp.product_id 
INNER JOIN shop_list sl ON sl.id = ssp.shop_id 
WHERE ssp.id = 1;";

echo $sql;
$result = mysqli_query($cn,$sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($cn);


?><!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/goods_list.css">
</head>

<body>

  <div id="wrapper">

    <div id="header">
      <p><a href="index.php"><img src=""></a></p>
    </div>
    <div id="header1">
    <?php
      if (isset($_SESSION['user_id'])) { ?>
        <p id="right"><a href="mypage.php">マイページ</a></p>
      <?php } else { ?>
        <p id="right"><a href="login.php">ログイン</a></p>
      <?php }
      //session_destroy();
      ?>
    </div>


    

    <div id="main">
      <div id="left">
        <p><img src="img/"></p>
        <p id="money">￥<?php echo $row['price_cut']; ?></p>
      </div>
      <div id="right">
        <table>
          <tr>
            <th style="width: 400px" align="left">出品者：<a href="search.php?id=<?php echo $row['shop_id']; ?>"><?php echo $row['shop_name']; ?></a></th>
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
      </form>


      <div id="come">
        <input type="image" src="img/はーと.png" name="heart" width="50" class="ico">
        <input type="image" src="img/60009001106.jpg" name="report" width="50" class="ico none">



        <form action="" method="post">
          <textarea cols="100" rows="8" name="comment"></textarea>
          <input type="submit" name="submit1" value="コメントをする" id="submit1">
        </form>
      </div>

      <h2>出品者の他商品</h2>
      <div class="Product">
        <?php if (empty($member_products)) : ?>
          <p style="margin-bottom: 50px">他に出品されている商品は存在しません</p>
        <?php else : ?>
          <?php foreach ($member_products as $member_product) { ?>
            <div class="product">
              <a href="product.php?id=<?php echo $member_product['id']; ?>">
                <p><img src="img/product_<?php echo $member_product['id']; ?>_1.jpg"></p>
                <p><?php echo $member_product['name']; ?></p>
                <p>￥<?php echo $member_product['price']; ?></p>
              </a>
            </div>
          <?php
          }
          mysqli_close($cn); ?>
          <div id="detail"><a href="search.php?id=<?php echo $row['member_id'] ?>">>>詳細</a></div>
        <?php endif ?>
      </div>

    </div>

    <div id="end">
      <p>××××××××××××××××××××××××××××</p>
    </div>

  </div>
</body>

</html>