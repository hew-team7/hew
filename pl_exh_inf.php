<?php

require_once "config.php";
session_start();
$pr = get_pr($_GET['id']);

function get_pr($id){

  $cn = mysqli_connect('localhost','root','','hew_07');
    mysqli_set_charset($cn,'utf8');
  $sql = "SELECT * from shop_product WHERE shop_product_id = ".$id;
  $result = mysqli_query($cn, $sql);
  $row = mysqli_fetch_assoc($result);
  mysqli_close($cn);
  return $row;
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pr['product_name'] ?>の商品情報</title>
</head>
<body>
    <h2>商品情報</h2>

    <p><img src="<?php if(file_exists('./images/product/'.$pr['file_name'])){ echo './images/product/'.$pr['file_name']; }else{ echo './images/product/no.png'; } ?>" width="200"></p>
    <p>商品：<a href="./pl_exh_in.php?id='<?php echo $pr['shop_product_id'] ?>'"><?php echo $pr['product_name'] ?></a></p>
    <p>メーカー：<?php echo $pr['maker_name'] ?></p>
    <p>設定価格：<?php echo $pr['price'] ?>円</p>
    <p>バーコード：<?php echo $pr['product_id'] ?></p>

    <p><a href="./">戻る</a>
    <p><a href="./pl_exh_in.php">出品する</a>
</body>
</html>
