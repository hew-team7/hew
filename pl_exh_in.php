<?php
require_once "config.php";
session_start();


$pr = get_pr($_GET['id']);

//エラーチェック

$msg1 = '';
$msg2 = '';
$msg3 = '';
$msg4 = '';

if (isset($_POST['reason'])){
    
    $_SESSION['reason'] = $_POST['reason'];
    $_SESSION['quantity'] = $_POST['quantity'];
    $_SESSION['detail'] = $_POST['detail'];
    $_SESSION['ex_date'] = $_POST['ex_date'];
    $_SESSION['pub_date'] = $_POST['pub_date'];
    $_SESSION['price'] = $_POST['price'];
     $_SESSION['discount'] = $_POST['discount'];


    if($_SESSION['quantity'] <= 0){
        $msg1 = '1個以上選択してください';
    }
    else{
        $msg1 = '';
    }

    if($_SESSION['pub_date'] != ''){
        $pub = str_replace('-', '', $_SESSION['pub_date']);
        $ex = str_replace('-', '', $_SESSION['ex_date']);        
        if(date("Ymd") > $pub){
            $msg2 = '不正な年月日です';
        }
        elseif ($pub > $ex) {
            $msg2 = '掲載期間が消費期限後です';
        }
        else{
            $msg2 = '';
        }
    }
    else{
        $msg2 = '入力必須項目です';
    }
    

    if($_SESSION['ex_date'] == ''){
        if(date("Ymd") > $pub){
            $msg3 = '不正な年月日です';
        }
        else{
            $msg3 = '入力必須項目です';
        }
    }
    else{
        $msg3 = '';
    }

    if($_SESSION['price'] == ''){
        $msg4 = '入力必須項目です';
    }
    else{
        $msg4 = '';
    }

    if ($msg1 == '' && $msg2 == '' && $msg3 == '' && $msg4 == '') {
        
        header('Location:pl_exh_cf.php?id='.$pr['shop_product_id']);
    }

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
    <form action="pl_exh_in.php?id=<?php echo $pr['shop_product_id'] ?>" method="post">

        
        <p><img src="<?php if(file_exists('./images/product/'.$pr['file_name'])){ echo './images/product/'.$pr['file_name']; }else{ echo './images/product/no.png'; } ?>" width="200"></p>
        <h3>商品名</h3>
        <p><?php echo $pr['product_name'] ?></p>
        <h3>メーカー</h3>
        <p><?php echo $pr['maker_name'] ?></p>

        <h3>出品理由</h3>
        <p><select name="reason" value='<?php if(isset($_SESSION['reason'])){ echo $_SESSION['reason']; }?>'>
            <option value="0">消費/賞味期限間近</option>
            <option value="1">期間限定セール</option>
            <option value="2">在庫一掃セール</option>
            <option value="3">お客様感謝セール</option>
            <option value="4">訳ありセール</option>
        </select></p>

        <h3>詳細</h3>
        <textarea name="detail"><?php if(isset($_SESSION['detail'])){ echo $_SESSION['detail']; }?></textarea>

        <h3>数量</h3>
        <p><input type="number" name="quantity" value="<?php if (isset($_SESSION['quantity'])) { echo $_SESSION['quantity']; } else{ echo '1'; }?>"> 個 <?php echo $msg1 ?></p>

         <h3>消費期限/賞味期限</h3>
        <p><input type="date" name="ex_date" value="<?php if(isset($_SESSION['ex_date'])){ echo $_SESSION['ex_date']; }?>"> <?php echo $msg3 ?></p>

        <h3>商品掲載期間</h3>
        <p><input type="date" name="pub_date" value="<?php if(isset($_SESSION['pub_date'])){ echo $_SESSION['pub_date']; }?>"> <?php echo $msg2 ?></p>

        <h3>販売価格</h3>
        <p><input type="text" name="price" value="<?php echo $pr['price'] ?>"> 円 <?php echo $msg4 ?></p>

        <h3>割引率</h3>
        <p><select name="discount">
            <option value="0">5%</option>
            <option value="1">10%</option>
            <option value="2">15%</option>
            <option value="3">20%</option>
            <option value="4">30%</option>
            <option value="5">40%</option>
            <option value="6">50%</option>
            <option value="7">60%</option>
            <option value="8">70%</option>
        </select></p>

        <br><br>
        <a href="./pl_exh_list.php?">キャンセル</a>
        <button>確認する</button>
        <p><a href="./pl_stg_in.php">商品名、画像の変更</a></p>
    </form>
</body>
</html>
