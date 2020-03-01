<?php

require_once "config.php";
session_start();
$pr_info = get_pr_inf($_SESSION['shop_id']);

function get_pr_inf($shop_id){

  $cn = mysqli_connect('localhost','root','','hew_07');
    mysqli_set_charset($cn,'utf8');
  $sql = "SELECT * from shop_product WHERE shop_id = '".$shop_id."' ORDER BY create_at DESC;";
  $result = mysqli_query($cn, $sql);
  $arrays = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $arrays[] = $rows;
  }
  mysqli_close($cn);
  return $arrays;
    
}

function get_pr_serch($word){

  $cn = mysqli_connect('localhost','root','','hew_07');
    mysqli_set_charset($cn,'utf8');
  $sql = "SELECT * from shop_product WHERE product_name LIKE '%".$word."%';";
  $result = mysqli_query($cn, $sql);
  $arrays = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $arrays[] = $rows;
  }
  mysqli_close($cn);
  return $arrays;
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録商品一覧</title>
</head>
<body>
    <h2>登録商品一覧</h2>
<?php 
    foreach ($pr_info as $rows) {
?>
    <p><img src="<?php if(file_exists('./images/product/'.$rows['file_name'])){ echo './images/product/'.$rows['file_name']; }else{ echo './images/product/no.png'; } ?>" width="200"></p>
    <p>商品：<a href="./pl_exh_in.php?id='<?php echo $rows['shop_product_id'] ?>'"><?php echo $rows['product_name'] ?></a></p>
    <p>メーカー：<?php echo $rows['maker_name'] ?></p>
    <p>設定価格：<?php echo $rows['price'] ?>円</p>
    <p>バーコード：<?php echo $rows['product_id'] ?></p>
<?php
    } 
?>
    <p><img src=""></p>
    <p></p>
</body>
</html>
