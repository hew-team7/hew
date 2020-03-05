<?php
require_once './config.php';
session_start();

if(isset($_SESSION['jan'])){//2重登録対策

	$maker_id = 0;

	if($_SESSION['class'] == 1){//ユニークかどうか(既成ならtrue)
		if ($_SESSION['digit'] == 13) {//桁数(13桁ならtrue)
			if ($_SESSION['jan'] >= 4900000000000 && $_SESSION['jan'] < 5000000000000 || $_SESSION['jan'] >= 4500000000000 && $_SESSION['jan'] < 4560000000000) {//4900000-4999999 or 4500000-4559999
				$maker_id = substr($_SESSION['jan'], 0 , 7);
			}
			elseif ($_SESSION['jan'] >= 4560000000000 && $_SESSION['jan'] < 4600000000000) {//456000000-459999999
				$maker_id = substr($_SESSION['jan'], 0 , 9);
			}
			else{//その他の国
				$maker_id = substr($_SESSION['jan'], 0 , 3);
			}
			
		}
		elseif ($_SESSION['digit'] == 8){//8桁
			$maker_id = substr($_SESSION['jan'], 0 , 6);
		}
		else{//ユニークである
			$_SESSION['class'] = 0; 
			$maker_id = substr($_SESSION['jan'], 0 , 7);
		}

	}
	else{//ユニークである
		$maker_id = substr($_SESSION['jan'], 0 , 7);
	}
	
	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql="INSERT INTO shop_product(shop_product_id,shop_id,product_id,maker_id,product_name,maker_name,code_class,price) VALUES ('".$_SESSION['shop_product_id']."','".$_SESSION['shop_number']."',".$_SESSION['jan'].",'".$maker_id."','".$_SESSION['pl_name']."','".$_SESSION['mk_name']."','".$_SESSION['class']."','".$_SESSION['price']."')";
	
	mysqli_query($cn,$sql); 
	mysqli_close($cn);

	unset($_SESSION['shop_product_id']);
	unset($_SESSION['jan']);
	unset($_SESSION['pl_name']);
	unset($_SESSION['mk_name']);
	unset($_SESSION['class']);
	unset($_SESSION['price']);
	unset($_SESSION['digit']);
	unset($_SESSION['new_name']);
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
    <h2>商品登録完了</h2>
    <p>商品登録完了しました</p>
    <p><a href="./pl_rgt_in.php">続けて登録</a></p>
    <p><a href="./pl_exh_list.php">登録商品一覧へ</a></p>
    <p><a href="./s_rgt_in.php">トップページに戻る</a></p>    
</body>
</html>
