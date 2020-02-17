<?php


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品情報確認</title>
<link rel="stylesheet" type="text/css" href="css.css">
<link rel="stylesheet" href="slick/slick.css" />
<link rel="stylesheet" href="slick/slick-theme.css" />
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
</head>
<body>

<h1>商品情報確認</h1>
<p>商品名：<?php   echo $_SESSION['goodsName'] ?></p>
<p>商品詳細：<?php echo $_SESSION['goodsDetail'] ?></p>
<p>価格：<?php     echo $_SESSION['goodsPrice'] ?></p>
<a href="syuppin3.php">next</a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="slick/slick.min.js"></script>
<script src="mysample.js"></script>
</body>
</html>