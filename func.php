<?php

/** 購入者に関するSQL */

//*** メールアドレス一覧を呼び出す関数 */
function buyer_mail_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT buyer_list.mail from buyer_list INNER JOIN buyer_login ON buyer_list.id = buyer_login.id;";
  $result = mysqli_query($cn, $sql);
  $marrays = array();
  while ($mrows = mysqli_fetch_assoc($result)) {
    $marrays[] = $mrows;
  }
  mysqli_close($cn);
  return var_dump($marrays);
}

//*** ユーザーIDを一覧を呼び出す関数 */
function buyer_id_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT buyer_login.user_id from buyer_login INNER JOIN buyer_list ON buyer_login.id = buyer_list.id;";
  $result = mysqli_query($cn, $sql);
  $rarrays = array();
  while ($rrows = mysqli_fetch_assoc($result)) {
    $rarrays[] = $rrows;
  }
  mysqli_close($cn);
  return $rarrays;
}



/** 店側に関するSQL */
function shop_mail_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT shop_list.mail from shop_list INNER JOIN shop_login ON shop_list.id = shop_login.id;";
  $result = mysqli_query($cn, $sql);
  $sarrays = array();
  while ($srows = mysqli_fetch_assoc($result)) {
    $sarrays[] = $srows;
  }
  mysqli_close($cn);
  return var_dump($sarrays);
}

//*** ユーザーIDを一覧を呼び出す関数 */
function shop_id_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT shop_login.shop_id from shop_login INNER JOIN shop_list ON shop_login.id = shop_list.id;";
  $result = mysqli_query($cn, $sql);
  $siarrays = array();
  while ($sirows = mysqli_fetch_assoc($result)) {
    $siarrays[] = $sirows;
  }
  mysqli_close($cn);
  return $siarrays;
}

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
		$x = floor(($w1 - $h1) / 2);	//開始位置調整
		$w1 = $h1;	//横長画像は幅を高さに合わせる
	} else {
		$y = floor(($h1 - $w1) / 2);	//開始位置調整
		$h1 = $w1;	//縦長画像は高さを幅に合わせる
	}
}
function idget()
{
    $cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB); //DB接続開始
    mysqli_set_charset($cn, 'utf8');
    $sql = "
    SELECT MAX(id) FROM shop_product;
    ";
	$result = mysqli_query($cn, $sql);
    if($result){
		$row=mysqli_fetch_assoc($result);
	}
	else{
		$row['MAX(id)']=1;
	}
    mysqli_close($cn);
    return $row['MAX(id)'];
}

?>