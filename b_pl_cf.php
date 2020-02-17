<?php

const HOST = 'localhost';
const DB_NAME = 'hew_07';
const DB_USER = 'root';
const DB_PASS = '';
session_start();
$_SESSION['user_id'] = 'biyonse1111';

$hfilename = './images/plofile/b_header/'.$_SESSION['user_id'];
$ifilename = './images/plofile/b_icon/'.$_SESSION['user_id'];

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

function get_bpl($host,$db_user,$db_pass,$db_name,$user_id){
	
	$cn = mysqli_connect($host,$db_user,$db_pass,$db_name);
	mysqli_set_charset($cn,'utf8');	
	$sql= "SELECT * FROM buyer_plofile WHERE user_id = '".$user_id."';";//変える必要あり
	$result = mysqli_query($cn, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

$row = get_bpl(HOST,DB_USER,DB_PASS,DB_NAME,$_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロフィール確認</title>
</head>
<body>
	<h2>プロフィール確認</h2>

	<p><img src="<?php if($hfilename != 'none') echo $hfilename ?>""></p>

	<p><img src="<?php if($ifilename != 'none') echo $ifilename ?>"></p>
	<p><?php echo $row['n_name'] ?></p>

	<h3>自己紹介</h3>
	<p><?php echo $row['introduction'] ?></p>
	<p><a href="./b_pl_in.php">戻る</a></p>
	<p><a href="./b_pl_cl.php">登録する</a></p>
	
</body>
</html>