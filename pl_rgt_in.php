<?php
require_once "config.php";
session_start();

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
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>商品登録 | HELOSS</title>

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
            background-color: #52dda9;
        }
        .dark-skin .side-nav .logo-wrapper {
            
                background-size: auto;
            background-size: cover;
        }
        .side-nav .logo-wrapper, .side-nav .logo-wrapper a {
            height: 0px;
        }
        .dark-gradient, .dark-skin .side-nav {
    
            background: linear-gradient(135deg,#52dda9 0,#52dda9 100%);
                
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
            background-color: #91eeba;
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
                    <li><a href="./pl_rgt_in.php" class="collapsible-header waves-effect"><i class="fa fa-pencil-alt"></i> 商品登録</a>
                        
                    </li>
                    
                    <li><a href="./pl_exh_list.php" class="collapsible-header waves-effect"><i class="fa fa-camera"></i> 出品する</a>
                        
                    </li>
                  
                    <li><a href="./pl_exh_now.php" class="collapsible-header waves-effect"><i class="fa fa-fish"></i> 出品している商品</a>
                        
                    </li>
                    
                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cog"></i> 設定<i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="./s_pl_stg.php" class="waves-effect">プロフィール編集</a>
                                </li>
                                <li><a href="./log_out.php" class="waves-effect">ログアウト</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="./s_question.php" class="collapsible-header waves-effect"><i class="fa fa-question"></i> お問い合わせ</a>
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
                    <a href="./s_news.php" class="nav-link waves-effect waves-light"><i class="fa fa-bell"></i> <span class="hidden-sm-down">お知らせ</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <span class="hidden-sm-down">プロフィール</span> </a>
                    <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <a class="dropdown-item waves-effect waves-light" href="./b_pl.php">プロフィール確認</a>
                        <a class="dropdown-item waves-effect waves-light" href="./b_pl_stg.php">プロフィール編集</a>
                    </div>
                </li>
            </ul>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double Navigation-->

    <!--Main layout-->
    <main class="">
        <div class="container-fluid text-xs-center" style="height: 800px;">
            <form action="pl_rgt_in.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <h4>商品登録</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h5>商品画像</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="file" name="pl_img">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <input type="text" id="form1"  name="pl_name" value="<?php if(isset($_SESSION['pl_name'])) echo $_SESSION['pl_name'] ?>"><?php if($msg1 != '') echo $msg1 ?>
                        <label for="form1" class="">商品名</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <input type="text" id="form1"  name="mk_name" value="<?php if(isset($_SESSION['mk_name'])) echo $_SESSION['mk_name'] ?>"><?php if($msg2 != '') echo $msg2 ?>
                        <label for="form1" class="">メーカー名</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5>JANコード/バーコード</h5> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="radio-inline">
                        <input type="radio" name="digit" value="13" checked="checked" id='13'>
                        <label for="13">13桁</label>
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="digit" value="8" id='8'>
                        <label for="8">8桁</label>
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="digit" value="0" id='0'>
                        <label for="0">その他</label>
                    </div>
                    
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h5>バーコードの分類</h5> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="radio-inline">
                        <input type="radio" name="class" value="0" checked="checked" id='uni'>
                        <label for="uni">ユニーク</label>
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="class" value="1" checked="checked" id='ki'>
                        <label for="ki">既成</label>
                    </div>                   
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <input type="text" id="form2"  name="jan" value="<?php if(isset($_SESSION['jan'])) echo $_SESSION['jan'] ?>"><?php if($msg3 != '') echo $msg3 ?>
                        <label for="form2" class="">バーコード</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="md-form">
                        <input type="text" name="price" value="<?php if(isset($_SESSION['price'])) echo $_SESSION['price'] ?>">
                        <label class="">通常販売課価格</label>
                    </div>

                </div>
            </div>

            
            <br>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-cyan waves-effect waves-light">保存する</button>
                    <a class="btn btn-elegant waves-effect waves-light" href="./b_pl.php">キャンセル</a>
                </div>
            </div>
            
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