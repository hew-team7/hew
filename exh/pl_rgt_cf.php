<?php
session_start();

if (!isset($_SESSION['jan'])) {
    header('Location:./pl_rgt_in.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品登録確認</title>
</head>
<body>
    <h2>商品登録確認</h2>
    <form action="pl_rgt_cl.php" method="post" enctype="multipart/form-data">

        <h3>商品画像登録</h3>
        <p><img src="<?php if(isset($_SESSION['new_name'])){if(file_exists($_SESSION['new_name'])){ echo $_SESSION['new_name']; }}else{ echo './images/product/no.png'; } ?>" width="300"></p>
        
        <h3>商品名</h3>
        <p><?php echo $_SESSION['pl_name'] ?></p>

        <h3>メーカー名</h3>
        <p><?php echo $_SESSION['mk_name'] ?></p>

        <h3>JANコード/バーコード</h3>
        <p><?php echo $_SESSION['jan'] ?></p>

        <h3>バーコードの分類</h3>
        <p><?php echo $_SESSION['class'] == 0 ? 'ユニークなコード' : '既成のコード' ?></p>

        <h3>通常販売価格</h3>
        <p><?php echo $_SESSION['price'] != '' ? $_SESSION['price'].' 円' : '設定なし' ?></p>
        
        
        <br><br>
        <a href="./pl_rgt_in.php">変更する</a>
        <button>登録する</button>
    </form>
</body>
</html>
