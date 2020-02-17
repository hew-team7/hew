<?php
require_once "config.php";
require_once "function.php";
session_start();
$name   = $_SESSION['goodsName'] ;
$detail = $_SESSION['goodsDetail'];
$price  = $_SESSION['goodsPrice'];
$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB); //DB接続開始
mysqli_set_charset($cn, 'utf8');
$id=idget()+1;
$sql = "
INSERT INTO shop_product (id,shop_id,name,detail,list_price,hash_tag) 
VALUES ('$id','1','$name','$detail','$price','111');
";
$img_name = $_SESSION['img_name'];
rename("image/b_header/$img_name", "image/shop_id/$img_name");
echo $sql;
mysqli_query($cn, $sql);
mysqli_close($cn);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>JavaScriptの書き方1: 外部定義</title>
<link rel="stylesheet" type="text/css" href="css.css">
<link rel="stylesheet" href="slick/slick.css" />
<link rel="stylesheet" href="slick/slick-theme.css" />
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
</head>
<body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="slick/slick.min.js"></script>
<script src="mysample.js"></script>
</body>
</html>