<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品登録</title>
</head>
<body>
    <h2>商品登録</h2>
    <form action="pl_rg_in.php" method="post" enctype="multipart/form-data">

        <h3>商品画像登録</h3>
        <p><input type="file" name="pl_img_01"></p>
        <p><input type="file" name="pl_img_02"></p>
        
        <h3>商品名</h3>
        <p><input type="text" name="pl_name"></p>

        <h3>メーカー名</h3>
        <p><input type="text" name="mk_name"></p>

        <h3>JANコード/バーコード</h3>
        <p><input type="text" name="jan"></p>

        <h3>バーコードの分類</h3>
        <input type="radio" name="class" value="0" checked="checked">ユニーク
        <input type="radio" name="class" value="1">既成

        <h3>通常販売価格</h3>
        <input type="text" name="price"> 円
        
        <br><br>
        <a href="./s_top.php">キャンセル</a>
        <button>確認する</button>
    </form>
</body>
</html>
