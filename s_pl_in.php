<?php

const HOST = 'localhost';
const DB_NAME = 'hew_07';
const DB_USER = 'root';
const DB_PASS = '';
session_start();
$_SESSION['shop_id'] = 'heiwado';
$hfilename = './images/plofile/s_header/'.$_SESSION['shop_id'];
$ifilename = './images/plofile/s_icon/'.$_SESSION['shop_id'];

if (isset($_POST['s_name']) || isset($_POST['intro'])) {
	
	if($_POST['s_name'] != ''){
		set_spl(HOST,DB_USER,DB_PASS,DB_NAME,$_POST['s_name'],$_POST['intro'],$_SESSION['shop_id']);
	
//アイコン画像保存
		if(isset($_FILES['sicon'])){
			if($_FILES['sicon']['size'] != 0){//画像の有無

				if (file_exists($ifilename.'.jpg')) {
					$ifilename = $ifilename.'.jpg';
					unlink($ifilename);
				} 
				elseif (file_exists($ifilename.'.png')) {
					$ifilename = $ifilename.'.png';
					unlink($ifilename);
				}
				elseif (file_exists($ifilename.'.gif')){
					$ifilename = $ifilename.'.gif';
					unlink($ifilename);
				}

				$upload_file = $_FILES['sicon'];
				$extension = pathinfo($upload_file['name']);//拡張子を抽出
				$new_name = $_SESSION['shop_id'].'.'.$extension['extension'];
				createThumb($upload_file['tmp_name'],'./images/plofile/s_icon/'.$new_name,200);

			}

		}

		//ヘッダー画像保存
		if(isset($_FILES['sheader'])){
			if($_FILES['sheader']['size'] != 0){//画像の有無

				if (file_exists($hfilename.'.jpg')) {
					$hfilename = $hfilename.'.jpg';
					unlink($hfilename);
				} 
				elseif (file_exists($hfilename.'.png')) {
					$hfilename = $hfilename.'.png';
					unlink($hfilename);
				}
				elseif (file_exists($hfilename.'.gif')){
					$hfilename = $hfilename.'.gif';
					unlink($hfilename);
				}

				$upload_file = $_FILES['sheader'];
				$extension = pathinfo($upload_file['name']);//拡張子を抽出
				$new_name = $_SESSION['shop_id'].'.'.$extension['extension'];
				createThumb($upload_file['tmp_name'],'./images/plofile/s_header/'.$new_name,500);

			}

		}

		header('Location:s_pl_cf.php');

	}

}

$row = get_spl(HOST,DB_USER,DB_PASS,DB_NAME,$_SESSION['shop_id']);


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
		$x = floor(($w1 - $h1) / 2);	//開始位置調整
		$w1 = $h1;	//横長画像は幅を高さに合わせる
	} else {
		$y = floor(($h1 - $w1) / 2);	//開始位置調整
		$h1 = $w1;	//縦長画像は高さを幅に合わせる
	}
}

function set_spl($host,$db_user,$db_pass,$db_name,$name,$intro,$shop_id){
	
	$cn = mysqli_connect($host,$db_user,$db_pass,$db_name);
	mysqli_set_charset($cn,'utf8');	
	$sql="UPDATE shop_plofile SET introduction = '".$intro."' , s_name = '".$name."' WHERE shop_id = '".$shop_id."'";
	
	mysqli_query($cn,$sql); 
}

function get_spl($host,$db_user,$db_pass,$db_name,$shop_id){
	
	$cn = mysqli_connect($host,$db_user,$db_pass,$db_name);
	mysqli_set_charset($cn,'utf8');	
	$sql= "SELECT * FROM shop_plofile WHERE shop_id = '".$shop_id."';";//変える必要あり
	$result = mysqli_query($cn, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>店舗プロフィール編集</title>
</head>
<body>
	<h2>店舗プロフィール編集</h2>
	<form action="s_pl_in.php" method="post" enctype="multipart/form-data">

		<h3>アイコンを変更</h3>
		<p><input type="file" name="sicon"></p>
		
		<h3>店舗名(20文字まで)</h3>
		<p><input type="text" name="s_name" value="<?php echo $row['s_name'] ?>">
<?php 
		if (isset($_POST['s_name'])) {
			
			if($_POST['s_name'] == ''){ ?>
				<br>必須項目です
<?php 		}
		} ?>
		</p>

	
		<h3>ショップ紹介(500文字まで)</h3>
		<textarea name="intro" rows="10" cols="25"><?php echo $row['introduction'] ?></textarea>

		<h3>ヘッダー画像を変更</h3>
		<p><input type="file" name="sheader"></p>

		<button>確認する</button>
	</form>
</body>
</html>