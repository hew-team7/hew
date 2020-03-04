<?php

require_once('func.php');
require_once('error.php');

$codes = [];

session_start();

if (isset($_POST['check'])) {
  //** メアド、ID、パスワードに関するエラーチェック */
  $mail = $_POST['mail'];
  $id = $_POST['id'];
  $pass = $_POST['pass'];
  //** メアド */
  if ($mail == "") { //** 空白チェック */
    $codes[] = '101';
  } else if (!(filter_var($mail, FILTER_VALIDATE_EMAIL))) { //** 正しいメアドかどうか */
    $codes[] = '102';
  }

  //** ユーザーID */
  if ($id == '') {
    $codes[] = '201'; //*** 空欄の場合、エラーを出す */
  } else {
    $ilists = shop_id_list();
    foreach ($ilists as $ilist) {
      if ($id == $ilist['shop_id']) {
        $codes[] = '202'; //*** これまでに登録されたログインIDと被っている場合、エラーを出す */
      }
    }
  }

  //** パスワード */
  if ($pass == "") { //** 空白かどうか */
    $codes[] = '301';
  } elseif (strlen($pass) < 8) { //** 8文字以上かどうか */
    $codes[] = '302';
  } elseif (!(preg_match("/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i", $pass))) { //** 正しく設定されているか(英数字) */
    $codes[] = '303';
  }


  //** 氏名に関するエラーチェック */
  $name = $_POST['name'];
  $kname = $_POST['kname'];
  //** 氏名(漢字) */
  if ($name == "") { //** 空白かどうか */
    $codes[] = '401';
  }

  //** 氏名(カタカナ) */
  if ($kname == "") { //** 空白かどうか */
    $codes[] = '501';
  }


  //** 住所に関するエラーチェック */
  $tel = $_POST['tel'];
  $code = $_POST['zip21'];
  $paddr = $_POST['addr21'];
  $addr = $_POST['addr'];
  $detail = $_POST['detail'];
  //** 電話番号 */
  if ($tel == "") {
    $codes[] = '901';
  }

  //** 郵便番号 */
  if ($code == "") { //** 空白かどうか */
    $codes[] = '601';
  }

  //** 都道府県,市町村 */
  if ($paddr == "") { //** 空白かどうか */
    $codes[] = '701';
  }

  //** 住所 */
  if ($addr == "") { //** 空白かどうか */
    $codes[] = '801';
  }

  //** 住所 */
  if ($detail == "") { //** 空白かどうか */
    $codes[] = '502';
  }



  //** エラーが一つもない場合セッションに値を入れる */
  if (empty($codes)) {


    $_SESSION['mail'] = $mail;
    $_SESSION['id'] = $id;
    $_SESSION['pass'] = $pass;

    $_SESSION['name'] = $name;
    $_SESSION['kname'] = $kname;

    $_SESSION['tel'] = $tel;
    $_SESSION['code'] = $code;
    $_SESSION['paddr'] = $paddr;
    $_SESSION['addr'] = $addr;
    $_SESSION['detail'] = $detail;

    //** 銀行口座 */
    if (!($_POST['bname'] == "")) {
      $_SESSION['bname'] = $_POST['bname'];
    }
    if (!($_POST['branch'] == "")) {
      $_SESSION['branch'] = $_POST['branch'];
    }
    if (!($_POST['bnumber'] == "")) {
      $_SESSION['bnumber'] = $_POST['bnumber'];
    }

    header('location:s_reg_cf.php');
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<!DOCTYPE html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>店舗登録</title>
  <link href="css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
  <link rel="stylesheet" href="./css/kanri.css">

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- Chartist JS -->
  <script src="js/plugins/chartist.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>

<body>
  <div id="header2">
    <img src="./images/logo/698942.png">
  </div>

  <div id="wrapper">
    <!-- End Navbar -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 i">
            <div class="card">
              <div class="card-header card-header-success">
                <h4 class="card-title" style="text-align: center;">店舗登録</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <form action="s_reg_in.php" method="POST">
                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">メールアドレス/ユーザーID/パスワード</label>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="bmd-label-floating">メールアドレス<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="mail" autocomplete="off" value="<?php echo isset($_SESSION['mail']) ? $_SESSION['mail'] : (isset($_POST['mail']) ? $_POST['mail'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '101') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '102') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '103') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">店舗ID<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="id" autocomplete="off" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_POST['id']) ? $_POST['id'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '201') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '202') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">パスワード <span class="red2">※8文字以上の英数字</span><span class="red">必須</span></label>
                        <input type="text" class="form-control" name="pass" autocomplete="off" value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass'] : (isset($_POST['pass']) ? $_POST['pass'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '301') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '302') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '303') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">店舗の基本情報</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">店舗名<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="name" autocomplete="off" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : (isset($_POST['name']) ? $_POST['name'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '401') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">店舗名(フリガナ) <span class="red2">※8文字以上の英数字</span><span class="red">必須</span></label>
                        <input type="text" class="form-control" name="kname" autocomplete="off" value="<?php echo isset($_SESSION['kname']) ? $_SESSION['kname'] : (isset($_POST['kname']) ? $_POST['kname'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '501') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="bmd-label-floating">店舗説明<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="detail" autocomplete="off" value="<?php echo isset($_SESSION['detail']) ? $_SESSION['detail'] : (isset($_POST['detail']) ? $_POST['detail'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '502') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">店舗の住所</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">電話番号<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="tel"　autocomplete="off" value="<?php echo isset($_SESSION['tel']) ? $_SESSION['tel'] : (isset($_POST['tel']) ? $_POST['tel'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '901') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="bmd-label-floating">郵便番号(ハイフン有)<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="zip21" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr21','addr21');" maxlength="3" autocomplete="off" value="<?php echo isset($_SESSION['code']) ? $_SESSION['code'] : (isset($_POST['zip21']) ? $_POST['zip21'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '601') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label class="bmd-label-floating">都道府県,市町村<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="addr21" autocomplete="off" value="<?php echo isset($_SESSION['paddr']) ? $_SESSION['paddr'] : (isset($_POST['addr21']) ? $_POST['addr21'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '701') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">番地/号/マンション名<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="addr" size="36" autocomplete="off" value="<?php echo isset($_SESSION['addr']) ? $_SESSION['addr'] : (isset($_POST['addr']) ? $_POST['addr'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '801') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">収入のお振込先の情報</label>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">銀行名</span></label>
                        <input type="text" class="form-control" name="bname" autocomplete="off" value="<?php echo isset($_SESSION['bcode']) ? $_SESSION['bcode'] : (isset($_POST['bcode']) ? $_POST['bcode'] : ''); ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">支店名/支店コード</label>
                        <input type="text" class="form-control" name="branch" value="<?php echo isset($_SESSION['branch']) ? $_SESSION['branch'] : (isset($_POST['branch']) ? $_POST['branch'] : ''); ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">口座番号</label>
                        <input type="text" class="form-control" name="bnumber" value="<?php echo isset($_SESSION['bnumber']) ? $_SESSION['bnumber'] : (isset($_POST['bnumber']) ? $_POST['bnumber'] : ''); ?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 offset-lg-5">
                      <input type="submit" value="確認" class="btn btn-success waves-effect waves-light" style="margin: 30px 0;" name="check">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>