<?php
require_once "function.php";
    $error[0] = "";
    $error[1] = "";
    $error[2] = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    session_start();
    if($_POST['goodsName'] != null){
        $_SESSION['goodsName'] = $_POST['goodsName'];
    }
    else{
        $error[0]="商品名を入力してください";
    }
    
    if($_POST['goodsDetail'] != null){
        $_SESSION['goodsDetail'] = $_POST['goodsDetail'];
    }
    else{
        $error[1]="商品詳細を入力してください";
    }
    
    if($_POST['goodsPrice'] != null){
        $_SESSION['goodsPrice'] = $_POST['goodsPrice'];
    }
    else{
        $error[2]="価格を入力してください";
    }
    if(isset($_FILES['bheader'])){
        if($_FILES['bheader']['size'] != 0){//画像の有無
            // if (file_exists($hfilename.'.jpg')) {
            //     $hfilename = $hfilename.'.jpg';
            //     unlink($hfilename);
            // } 
            // elseif (file_exists($hfilename.'.png')) {
            //     $hfilename = $hfilename.'.png';
            //     unlink($hfilename);
            // }
            // elseif (file_exists($hfilename.'.gif')){
            //     $hfilename = $hfilename.'.gif';
            //     unlink($hfilename);
            // }
            $upload_file = $_FILES['bheader'];
            $extension = pathinfo($upload_file['name']);//拡張子を抽出
            $new_name = $_SESSION['goodsName'].'.'.$extension['extension'];
            $_SESSION['img_name'] = $new_name;
            createThumb($upload_file['tmp_name'],'./image/b_header/'.$new_name,500);
        }
    }
    if(empty($error[0]) && empty($error[1]) && empty($error[2])){
        // header("Location : syuppin2.php");
        require_once "syuppin2.php";
        exit;
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>出品画面</title>
    <link rel="stylesheet" href="css/syuppin.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h2>商品情報を入力してください</h2>
        <h3 class="goodsName">商品名:<input type="text" name="goodsName" value=<?php 
        if(isset($_SESSION["goodsName"])){
            echo $_SESSION["goodsName"];
        }
        else{
            echo "";
        }
        ?>>
        <?php
        if($error[0]!=null){
            echo $error[0];
        }
        ?>
        </h3>
        <h3 class="goodsImage">商品画像</h3><input type="file" name="bheader"><label class="custom-file-label" for="customFile" data-browse="参照"></label>
        <h3 class="goodsDetail">商品詳細:<br><textarea name="goodsDetail" rows="5" cols="40" value=<?php 
        if(isset($_SESSION["goodsDetail"])){
            echo $_SESSION["goodsDetail"];
        }
        else{
            echo "";
        }
        ?>></textarea>
        <?php
        if($error[1]!=null){
            echo $error[1];
        }
        ?>
        </h3>
        <h3 class="goodsPrice">価格:<input type="number" name="goodsPrice" value=<?php 
        if(isset($_SESSION["goodsPrice"])){
            echo $_SESSION["goodsPrice"];
        }
        else{
            echo "";
        }
        ?>>円　
        <?php
        if($error[2]!=null){
            echo $error[2];
        }
        ?>
        </h3>
        <p class="confirmation">
        <input type="submit" value="確認画面へ" class="btn-stitch">
        <input type="reset" value="全てリセット"class="btn-stitch">
        </p>
    </form>
</body>
</html>