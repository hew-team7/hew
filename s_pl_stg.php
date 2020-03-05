<?php
require_once "config.php";
session_start();

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

		header('Location:s_pl.php');

	}

}

$row = get_spl(DB_HOST,DB_USER,DB_PASS,DB,$_SESSION['shop_id']);


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
if($row == null){
    $row['s_name'] = '';
    $row['introduction'] = '';
}

?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>プロフィール編集 | HELOSS</title>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">


    
    <style>
        body {
            background-color: #f5f5f5;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .dark-skin .navbar {
            background-color: #fb7d22;
        }
        .dark-skin .side-nav .logo-wrapper {
            
                background-size: auto;
            background-size: cover;
        }
        .side-nav .logo-wrapper, .side-nav .logo-wrapper a {
            height: 0px;
        }
        .dark-gradient, .dark-skin .side-nav {
    
            background: linear-gradient(135deg,#fb7d22 0,#fb7d22 100%);
                
         }
         .dark-skin .side-nav .sn-avatar-wrapper img {
            border: none;
            box-shadow: 2px 3px 3px rgba(0,0,0,0.3); 
        }

        .side-nav .sn-avatar-wrapper img {
            max-width: 65px;
            margin-left: -10px;
            margin-top: 8px;
        }
        .dark-skin .side-nav .collapsible li a:hover {
            background-color: 
            #f0a773;
            transition: all .3s linear;
        }
        .dark-skin .side-nav .collapsible li a:hover {
            background-color: 
            #c66017;
            transition: all .3s linear;
        }
        
        .side-nav .collapsible > li {
            padding-right: 1rem;
            padding-left: 1rem;
            margin-top: 10px;
        }

    </style>

</head>

<body class="fixed-sn dark-skin" style="">

    <!--Double Navigation-->
    <header>

        <!-- Sidebar navigation -->
        <ul id="slide-out" class="side-nav fixed custom-scrollbar ps-container ps-theme-default" style="transform: translateX(-100%);" data-ps-id="96864e62-e306-5383-47b2-9d30422757ea">

            

            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion">
                    <li><a href="./map.php" class="collapsible-header waves-effect"><i class="fa fa-map"></i> マップ</a>
                        
                    </li>
                    
                    <li><a href="./ranking.php" class="collapsible-header waves-effect"><i class="fa fa-crown"></i> ランキング</a>
                        
                    </li>
                  
                    <li><a href="./b_pl.php" class="collapsible-header waves-effect"><i class="fa fa-user"></i> ステータス</a>
                        
                    </li>
                    
                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cog"></i> 設定<i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="./b_pl_stg.php" class="waves-effect">プロフィール編集</a>
                                </li>
                                <li><a href="./log_out.php" class="waves-effect">ログアウト</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="./b_question.php" class="collapsible-header waves-effect"><i class="fa fa-question"></i> お問い合わせ</a>
                </ul>
            </li>
            <!--/. Side navigation links -->

        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></ul>
        <!--/. Sidebar navigation -->

        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

            <!-- SideNav slide-out button -->
            <div class="float-xs-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
            </div>

            <!-- Breadcrumb-->
            <div class="breadcrumb-dn">
                <p>HELOSS</p>
            </div>


            <ul class="nav navbar-nav float-xs-right">

                <li class="nav-item ">
                    <a href="./b_news.php" class="nav-link waves-effect waves-light"><i class="fa fa-bell"></i> <span class="hidden-sm-down">お知らせ</span></a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <span class="hidden-sm-down">プロフィール</span> </a>
                    <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <a class="dropdown-item waves-effect waves-light" href="./s_pl.php">プロフィール確認</a>
                        <a class="dropdown-item waves-effect waves-light" href="./s_pl_stg.php">プロフィール編集</a>
                    </div>
                </li>
            </ul>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double Navigation-->

    <!--Main layout-->
    <main class="">
        <div id="m" class="container-fluid text-xs-center" style="height: 800px;margin: 0 20%;">
            <form action="b_pl_stg.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <h4 style="margin-top:50px;">プロフィール編集</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <input type="text" id="form1" name="s_name" value="<?= $row['s_name']; ?>">
                        <label for="form1" class="">店舗名(20文字まで)</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <textarea name="intro" rows="10" cols="25" id="form2"  value="<?php echo $row['introduction'] ?>"></textarea>
                        <label for="form2" class="">ショップ紹介(500文字まで)</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5>アイコンを変更</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="file" name="sicon">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h5>ヘッダー画像を変更</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="file" name="sheader">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-amber waves-effect waves-light">保存する</button>
                    <a class="btn btn-elegant waves-effect waves-light" href="./s_pl.php">キャンセル</a>
                </div>
            </div>

        </form>



            
        </div>
    </main>
    <!--/Main layout-->

    <!--Footer-->
    <footer class="page-footer center-on-small-only">

        <!--Footer Links-->
        <div class="container">
        <p class="container-fluid center-block text-center"><img src="./images/logo/698942.png"></p> 
        </div>   
        
        <!--/.Footer Links-->


        <!--Copyright-->
        <div class="footer-copyright">
            <div class="container-fluid">
                © 2020 Copyright: HELOSS Entertainment.

            </div>
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->

    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/jquery-3.js"></script>

    <!-- Tooltips -->
    <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/tether.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/bootstrap.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/mdb.js"></script>

    <script>
        $(".button-collapse").sideNav();

        var el = document.querySelector('.custom-scrollbar');

        Ps.initialize(el);
    </script>
    




<div class="hiddendiv common"></div><div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div></body></html>
