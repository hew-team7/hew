<?php
require_once "config.php";
session_start();


$pr = get_pr($_GET['id']);

//エラーチェック

$msg1 = '';
$msg2 = '';
$msg3 = '';
$msg4 = '';

if (isset($_POST['reason'])) {

    $_SESSION['reason'] = $_POST['reason'];
    $_SESSION['quantity'] = $_POST['quantity'];
    $_SESSION['detail'] = $_POST['detail'];
    $_SESSION['ex_date'] = $_POST['ex_date'];
    $_SESSION['pub_date'] = $_POST['pub_date'];
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['discount'] = $_POST['discount'];


    if ($_SESSION['quantity'] <= 0) {
        $msg1 = '1個以上選択してください';
    } else {
        $msg1 = '';
    }

    if ($_SESSION['pub_date'] != '') {
        $pub = str_replace('-', '', $_SESSION['pub_date']);
        $ex = str_replace('-', '', $_SESSION['ex_date']);
        if (date("Ymd") > $pub) {
            $msg2 = '不正な年月日です';
        } elseif ($pub > $ex) {
            $msg2 = '掲載期間が消費期限後です';
        } else {
            $msg2 = '';
        }
    } else {
        $msg2 = '入力必須項目です';
    }


    if ($_SESSION['ex_date'] == '') {
        if (date("Ymd") > $pub) {
            $msg3 = '不正な年月日です';
        } else {
            $msg3 = '入力必須項目です';
        }
    } else {
        $msg3 = '';
    }

    if ($_SESSION['price'] == '') {
        $msg4 = '入力必須項目です';
    } else {
        $msg4 = '';
    }

    if ($msg1 == '' && $msg2 == '' && $msg3 == '' && $msg4 == '') {

        header('Location:pl_exh_cf.php?id=' . $pr['shop_product_id']);
    }
}

function get_pr($id)
{

    $cn = mysqli_connect('localhost', 'root', '', 'hew');
    mysqli_set_charset($cn, 'utf8');
    $sql = "SELECT * from shop_product WHERE shop_product_id = '" . $id . "'";
    $result = mysqli_query($cn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($cn);
    return $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $pr['product_name'] ?>の出品 | HELOSS</title>

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

        .side-nav .logo-wrapper,
        .side-nav .logo-wrapper a {
            height: 0px;
        }

        .dark-gradient,
        .dark-skin .side-nav {

            background: linear-gradient(135deg, #52dda9 0, #52dda9 100%);

        }

        .dark-skin .side-nav .sn-avatar-wrapper img {
            border: none;
            box-shadow: 2px 3px 3px rgba(0, 0, 0, 0.3);
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

        .side-nav .collapsible>li {
            padding-right: 1rem;
            padding-left: 1rem;
            margin-top: 10px;
        }

        .u {
            margin-bottom: 30px;
        }

        .g {
            color: #52dda9;
            border-bottom: solid 1px #52dda9;
            padding-bottom: 20px;
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

                    <li><a href="./s_top.php" class="collapsible-header waves-effect"><i class="fa fa-fish"></i> 出品している商品</a>

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

            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </ul>
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
        <div class="container-fluid text-xs-center" style="height: 1400px;">
            <h2 class="g">商品出品</h2>
            <form action="pl_exh_in.php?id=<?php echo $pr['shop_product_id'] ?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <p><img src="<?php if (file_exists('./images/product/' . $pr['file_name'])) {
                                            echo './images/product/' . $pr['file_name'];
                                        } else {
                                            echo './images/product/no.png';
                                        } ?>" width="200"></p>
                    </div>
                </div>
                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>商品名</h4>
                    </div>
                    <div class="col-md-4">
                        <p><?php echo $pr['product_name'] ?></p>
                    </div>
                </div>
                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>メーカー</h4>
                    </div>
                    <div class="col-md-4">
                        <p><?php echo $pr['maker_name'] ?></p>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4 class="select1a">出品理由</h4>
                    </div>
                    <div class="col-md-4">
                        <select id="select1a" class="form-control" name="reason" value='<?php if (isset($_SESSION['reason'])) {
                                                                                            echo $_SESSION['reason'];
                                                                                        } ?>'>
                            <option value="0">消費/賞味期限間近</option>
                            <option value="1">期間限定セール</option>
                            <option value="2">在庫一掃セール</option>
                            <option value="3">お客様感謝セール</option>
                            <option value="4">訳ありセール</option>
                        </select>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4 class="bmd-label-floating">詳細</h4>
                    </div>
                    <div class="col-md-4">
                        <textarea name="detail" style="height: 100px;"><?php if (isset($_SESSION['detail'])) {
                                                                            echo $_SESSION['detail'];
                                                                        } ?></textarea>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>数量</h4>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantity" value="<?php if (isset($_SESSION['quantity'])) {
                                                                        echo $_SESSION['quantity'];
                                                                    } else {
                                                                        echo '1';
                                                                    } ?>">
                    </div>
                    <div class="col-md-1">
                        <p>個 <?php echo $msg1 ?></p>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>賞味期限</h4>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="ex_date" value="<?php if (isset($_SESSION['ex_date'])) {
                                                                        echo $_SESSION['ex_date'];
                                                                    } ?>"> <?php echo $msg3 ?>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>商品掲載期間</h4>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="pub_date" value="<?php if (isset($_SESSION['pub_date'])) {
                                                                        echo $_SESSION['pub_date'];
                                                                    } ?>"> <?php echo $msg2 ?>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4>販売価格</h4>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="price" value="<?php echo $pr['price'] ?>">
                    </div>
                    <div class="col-md-1">
                        円 <?php echo $msg4 ?>
                    </div>
                </div>

                <div class="row u">
                    <div class="col-md-4 offset-md-2">
                        <h4 class="select1aa">割引率</h4>
                    </div>
                    <div class="col-md-4">
                        <select id="select1aa" class="form-control" name="discount">
                            <option value="0">5%</option>
                            <option value="1">10%</option>
                            <option value="2">15%</option>
                            <option value="3">20%</option>
                            <option value="4">30%</option>
                            <option value="5">40%</option>
                            <option value="6">50%</option>
                            <option value="7">60%</option>
                            <option value="8">70%</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <a href="./pl_exh_list.php" class="btn btn-success waves-effect waves-light" style="margin-right: 60px;">キャンセル</a>
                    <button class="btn btn-success waves-effect waves-light">確認する</button>
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




    <div class="hiddendiv common"></div>
    <div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div>
</body>

</html>