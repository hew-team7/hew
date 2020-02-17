<?php

// if(isset($_FILES['bheader'])){
// 	if($_FILES['bheader']['size'] != 0){//画像の有無

// 		if (file_exists($hfilename.'.jpg')) {
// 			$hfilename = $hfilename.'.jpg';
// 			unlink($hfilename);
// 		} 
// 		elseif (file_exists($hfilename.'.png')) {
// 			$hfilename = $hfilename.'.png';
// 			unlink($hfilename);
// 		}
// 		elseif (file_exists($hfilename.'.gif')){
// 			$hfilename = $hfilename.'.gif';
// 			unlink($hfilename);
// 		}

// 		$upload_file = $_FILES['bheader'];
// 		$extension = pathinfo($upload_file['name']);//拡張子を抽出
// 		$new_name = $_SESSION['user_id'].'.'.$extension['extension'];
// 		createThumb($upload_file['tmp_name'],'./images/plofile/b_header/'.$new_name,500);

// 	}

// }


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

?>