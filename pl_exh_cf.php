<?php
require_once "config.php";
session_start();

$pr = get_pr($_GET['id']);
$reason = [
    '消費/賞味期限間近',
    '期間限定セール',
    '在庫一掃セール',
    'お客様感謝セール',
    '訳ありセール',
];

$_SESSION['a_reason'] = $reason[$_SESSION['reason']];

$discount = [
    5,
    10,
    15,
    20,
    25,
    30,
    40,
    50,
    60,
    70,
];

$_SESSION['a_discount'] = $discount[$_SESSION['discount']];

$_SESSION['dis_price'] = floor($_SESSION['price']-$_SESSION['price']*0.01*$discount[$_SESSION['discount']]);

if ($_SESSION['price'] <= 400) {
    $_SESSION['sale_com'] = 20;
    $_SESSION['point'] = 2;
}
else{
    $_SESSION['sale_com'] =  ($_SESSION['price'] - $_SESSION['dis_price'])*0.10;
    $_SESSION['point'] = floor($_SESSION['sale_com']/2);
}

function get_pr($id){

  $cn = mysqli_connect('localhost','root','','hew');
    mysqli_set_charset($cn,'utf8');
  $sql = "SELECT * from shop_product WHERE shop_product_id = '".$id."'";
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
    <title><?php echo $pr['product_name'] ?>の出品</title>
</head>
<body>
    <h2>商品出品</h2>
    
    <p><img src="<?php if(file_exists('./images/product/'.$pr['file_name'])){ echo './images/product/'.$pr['file_name']; }else{ echo './images/product/no.png'; } ?>" width="200"></p>
    <h3>商品名</h3>
    <p><?php echo $pr['product_name'] ?></p>
    <h3>メーカー</h3>
    <p><?php echo $pr['maker_name'] ?></p>

    <h3>出品理由</h3>
    <p><?php echo $_SESSION['a_reason'] ?></p>

    <h3>詳細</h3>
    <p><?php echo $_SESSION['detail']; ?></p>

    <h3>数量</h3>
    <p><?php echo $_SESSION['quantity']; ?> 個</p>

     <h3>消費期限/賞味期限</h3>
    <p><?php echo $_SESSION['ex_date'] ?></p>

    <h3>商品掲載期限</h3>
    <p><?php echo $_SESSION['pub_date'] ?></p>

    <h3>販売価格</h3>
    <p><?php echo $_SESSION['price'] ?> 円</p>

    <h3>割引率</h3>
    <p><?php echo $_SESSION['a_discount'] ?> %</p>

    <h3>割引後価格</h3>
    <p><?php echo $_SESSION['dis_price']; ?> 円</p>

    <h3>販売手数料</h3>
    <p><?php echo $_SESSION['sale_com'] ?> 円</p>

    <h3>購入者付与ポイント</h3>
    <p><?php echo $_SESSION['point'] ?> ポイント</p>

    <br><br>
    <p><a href="./pl_exh_in.php?id=<?php echo $pr['shop_product_id'] ?>">変更する</a>
    <a href="./pl_exh_cl.php?id=<?php echo $pr['shop_product_id'] ?>">出品する</a></p>

</body>
</html>
