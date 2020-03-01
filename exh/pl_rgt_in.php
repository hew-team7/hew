<?php
require_once "config.php";
session_start();
$_SESSION['shop_id']='biyonse';

//エラーチェック

$msg1 = '';
$msg2 = '';
$msg3 = '';

if (isset($_POST['pl_name'])){
    
    $_SESSION['pl_name'] = $_POST['pl_name'];
    $_SESSION['mk_name'] = $_POST['mk_name'];
    $_SESSION['jan'] = $_POST['jan'];
    $_SESSION['digit'] = $_POST['digit'];
    $_SESSION['class'] = $_POST['class'];
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['shop_product_id'] = $_SESSION['shop_id'].'_'.$_SESSION['jan'];

    if($_SESSION['pl_name'] == ''){
        $msg1 = '入力必須項目です';
    }
    else{
        $msg1 = '';
    }

    if($_SESSION['mk_name'] == ''){
        $msg2 = '入力必須項目です';
    }
    else{
        $msg2 = '';
    }

    if($_SESSION['jan'] != ''){
        if (strlen($_SESSION['jan']) == $_SESSION['digit']) {
            if (is_numeric($_SESSION['jan'])) {
                $msg3 = '';
               
            }
            else{
                $msg3 = '数字を入力してください';
            }
            
        }
        else{
            $msg3 = $_SESSION['digit'].'桁の数字を入力してください';
        }
    }
    else{
        $msg3 = '入力必須項目です';
    }

    if ($msg1 == '' && $msg2 == '' && $msg3 == '') {
        //商品画像保存
        if(isset($_FILES['pl_img'])){

            $filename = './images/product/'.$_SESSION['shop_product_id'];

            if($_FILES['pl_img']['size'] != 0){//画像の有無

                if (file_exists($filename.'.jpg')) {
                    $filename = $filename.'.jpg';
                    unlink($filename);
                } 
                elseif (file_exists($filename.'.png')) {
                    $filename = $filename.'.png';
                    unlink($filename);
                }
                elseif (file_exists($filename.'.gif')){
                    $filename = $filename.'.gif';
                    unlink($filename);
                }

                $upload_file = $_FILES['pl_img'];
                $extension = pathinfo($upload_file['name']);//拡張子を抽出
                $new_name = $filename.'.'.$extension['extension'];
                createThumb($upload_file['tmp_name'],$new_name,300);
                $_SESSION['new_name'] = $new_name;

            }

        }
        header('Location:pl_rgt_cf.php');
    }

}

//画像トリミング保存(正方形)
function createThumb($filename1, $filename2, $resize)//createThumb（アップロードするファイルのパス , アップロード後のパス , アップロード後の縦横のサイズ);
{

    
    list($w1, $h1, $type) = getimagesize($filename1);
    switch ($type) {
        case 1://GIF
            $image1 = imagecreatefromgif($filename1);
            break;
        case 2://JPEG
            $image1 = imagecreatefromjpeg($filename1);
            break;
        case 3://PNG
            $image1 = imagecreatefrompng($filename1);
            break;
        default:
            return false;
    }
    $x = 0;
    $y = 0;

    //画像ロード
    fitCover50($resize, $w1, $h1, $w2, $h2, $x, $y);
    
    $image2 = ImageCreateTrueColor($w2, $h2);
    
    //縮小しながらコピー
    imagecopyresampled($image2, $image1, 0, 0, $x, $y, $w2, $h2, $w1, $h1);
    
    //変換した画像をファイルに保存
    switch ($type) {
        case 1://GIF
            imagegif($image2, $filename2);
            break;
        case 2://JPEG
            imagejpeg($image2, $filename2, 85);
            break;
        case 3://PNG
            imagepng($image2, $filename2);
            break;
    }
    //メモリ解放
    ImageDestroy($image1);
    ImageDestroy($image2);
}

//矩形範囲でトリミング（真ん中を切り取る）
function fitCover50($resize, &$w1, &$h1, &$w2, &$h2, &$x, &$y)
{
    $w2 = $resize; //出力先は問答無用で矩形範囲のサイズ
    $h2 = $resize; //
    if ($w1 > $h1) {
        $x = floor(($w1 - $h1) / 2);    //開始位置調整
        $w1 = $h1;  //横長画像は幅を高さに合わせる
    } else {
        $y = floor(($h1 - $w1) / 2);    //開始位置調整
        $h1 = $w1;  //縦長画像は高さを幅に合わせる
    }
}

    
?>


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
    <form action="pl_rgt_in.php" method="post" enctype="multipart/form-data">

        <h3>商品画像登録</h3>
        <p><input type="file" name="pl_img"></p>
        
        <h3>商品名</h3>
        <p><input type="text" name="pl_name" value="<?php if(isset($_SESSION['pl_name'])) echo $_SESSION['pl_name'] ?>"><?php if($msg1 != '') echo $msg1 ?></p>

        <h3>メーカー名</h3>
        <p><input type="text" name="mk_name" value="<?php if(isset($_SESSION['mk_name'])) echo $_SESSION['mk_name'] ?>"><?php if($msg2 != '') echo $msg2 ?></p>

        <h3>JANコード/バーコード</h3>
        <p><input type="radio" name="digit" value="13" checked="checked">13桁
        <input type="radio" name="digit" value="8">8桁
        <input type="radio" name="digit" value="0">その他</p>
        <p><input type="text" name="jan" value="<?php if(isset($_SESSION['jan'])) echo $_SESSION['jan'] ?>"><?php if($msg3 != '') echo $msg3 ?></p>

        <h3>バーコードの分類</h3>
        <input type="radio" name="class" value="0" checked="checked">ユニーク
        <input type="radio" name="class" value="1">既成

        <h3>通常販売価格</h3>
        <input type="text" name="price" value="<?php if(isset($_SESSION['price'])) echo $_SESSION['price'] ?>"> 円
        
        <br><br>
        <a href="./s_top.php">キャンセル</a>
        <button>確認する</button>
    </form>
</body>
</html>
