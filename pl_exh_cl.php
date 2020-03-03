<?php
require_once './config.php';
session_start();

if(isset($_SESSION['reason'])){//2重登録対策
	
	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql="INSERT INTO shop_sell_product(shop_id, product_id, detail, reason, sell_price, price_cut, sales_comission, sell_quantity, expiration_date,  close_date,discount,sell_point) VALUES ('".$_SESSION['shop_id']."','".$_GET['id']."','".$_SESSION['detail']."','".$_SESSION['a_reason']."',".$_SESSION['price'].",".$_SESSION['dis_price'].",".$_SESSION['sale_com'].",".$_SESSION['quantity'].",'".$_SESSION['ex_date']."','".$_SESSION['pub_date']."',".$_SESSION['discount'].",".$_SESSION['point'].")";
	
	
	mysqli_query($cn,$sql); 
	mysqli_close($cn);

	
	unset($_SESSION['detail']);
	unset($_SESSION['reason']);
	unset($_SESSION['a_reason']);
	unset($_SESSION['price']);
	unset($_SESSION['dis_price']);
	unset($_SESSION['sale_com']);
	unset($_SESSION['quantity']);
	unset($_SESSION['ex_date']);
	unset($_SESSION['pub_date']);
	unset($_SESSION['discount']);
	unset($_SESSION['a_discount']);
	unset($_SESSION['point']);

}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>出品完了</title>
</head>
<body>
    <h2>出品完了</h2>
    <p>出品完了しました</p>
    <p><a href="./pl_exh_list.php">登録商品一覧へ</a></p>
    <p><a href="./s_top.php">トップページに戻る</a></p>    
</body>
</html>
