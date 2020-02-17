<?php

const HOST = 'localhost';
const DB_NAME = 'hew_07';
const DB_USER = 'root';
const DB_PASS = '';
session_start();
$_SESSION['shop_id'] = 'heiwado';

$hfilename = './images/plofile/s_header/'.$_SESSION['shop_id'];
$ifilename = './images/plofile/s_icon/'.$_SESSION['shop_id'];
 
// ヘッダーファイルが存在するかチェックする
if (file_exists($hfilename.'.jpg')) {
 	$hfilename = $hfilename.'.jpg';
} 
elseif (file_exists($hfilename.'.png')) {
	$hfilename = $hfilename.'.png';
}
elseif (file_exists($hfilename.'.gif')){
 	$hfilename = $hfilename.'.gif';
}
else{
	$hfilename = 'none';
}

// アイコンファイルが存在するかチェックする
if (file_exists($ifilename.'.jpg')) {
 	$ifilename = $ifilename.'.jpg';
} 
elseif (file_exists($ifilename.'.png')) {
	$ifilename = $ifilename.'.png';
}
elseif (file_exists($ifilename.'.gif')){
 	$ifilename = $ifilename.'.gif';
}
else{
	$ifilename = 'none';
}

function get_spl($host,$db_user,$db_pass,$db_name,$shop_id){
	
	$cn = mysqli_connect($host,$db_user,$db_pass,$db_name);
	mysqli_set_charset($cn,'utf8');	
	$sql= "SELECT * FROM shop_plofile WHERE shop_id = '".$shop_id."';";//変える必要あり
	$sql = "SELECT a.postal_code,a.address1,a.address2,a.tel,a.mail,b.s_name,b.introduction FROM shop_list a INNER JOIN shop_plofile b ON a.id = b.shop_id WHERE b.shop_id = '".$_SESSION['shop_id']."'";
	$result = mysqli_query($cn, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

$row = get_spl(HOST,DB_USER,DB_PASS,DB_NAME,$_SESSION['shop_id']);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ショップ情報確認</title>
</head>
<body>
	<h2>ショップ情報確認</h2>

	<p><img src="<?php if($hfilename != 'none') echo $hfilename ?>"></p>

	<p><img src="<?php if($ifilename != 'none') echo $ifilename ?>"></p>
	<p><?php echo $row['s_name'] ?></p>

	<h3>ショップ紹介</h3>
	<p><?php echo $row['introduction'] ?></p>

	<h3>店舗住所</h3>
	<p><?php echo $row['postal_code'] ?><br>
		<?php echo $row['address1'].$row['address2'] ?></p>

	<h3>連絡先</h3>
	<h4>電話番号</h4>
	<p><?php echo $row['tel'] ?></p>
	<h4>メールアドレス</h4>
	<p><?php echo $row['mail'] ?></p>

	
	<p><a href="./s_pl_cl.php">登録する</a></p>
	<p><a href="./s_pl_in.php">戻る</a></p>
</body>
</html>