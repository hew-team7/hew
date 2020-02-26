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
  if($mail == ""){ //** 空白チェック */
    $codes[] = '101';
  }else if(!(filter_var($mail, FILTER_VALIDATE_EMAIL))){ //** 正しいメアドかどうか */
    $codes[] = '102';
  }

  //** ユーザーID */
  if ($id == '') {
    $codes[] = '201'; //*** 空欄の場合、エラーを出す */
  }else{
    $ilists = shop_id_list();
    foreach($ilists as $ilist){
      if($id == $ilist['shop_id']){
        $codes[] = '202'; //*** これまでに登録されたログインIDと被っている場合、エラーを出す */
      }
    }
  }

  //** パスワード */
  if($pass == ""){ //** 空白かどうか */
    $codes[] = '301';
  }elseif(strlen($pass) < 8){ //** 8文字以上かどうか */
    $codes[] = '302';
  }elseif(!(preg_match("/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i",$pass))){ //** 正しく設定されているか(英数字) */
    $codes[] = '303';
  }


  //** 氏名に関するエラーチェック */
  $name = $_POST['name'];
  $kname = $_POST['kname'];
  //** 氏名(漢字) */
  if($name == ""){ //** 空白かどうか */
    $codes[] = '401';
  }

  //** 氏名(カタカナ) */
  if($kname == ""){ //** 空白かどうか */
    $codes[] = '501';
  }


  //** 住所に関するエラーチェック */
  $tel = $_POST['tel'];
  $fcode = $_POST['zip21'];
  $lcode = $_POST['zip22'];
  $paddr = $_POST['addr21'];
  $addr = $_POST['addr'];
  $detail = $_POST['detail'];
  //** 電話番号 */
  if($tel == ""){
    $codes[] = '901';
  }

  //** 郵便番号 */
  if($fcode == "" || $lcode == ""){ //** 空白かどうか */
    $codes[] = '601';
  }

  //** 都道府県,市町村 */
  if($paddr == ""){ //** 空白かどうか */
    $codes[] = '701';
  }

  //** 住所 */
  if($addr == ""){ //** 空白かどうか */
    $codes[] = '801';
  }

  //** 住所 */
  if($detail == ""){ //** 空白かどうか */
    $codes[] = '502';
  }
  


  //** エラーが一つもない場合セッションに値を入れる */
  if(empty($codes)){


    $_SESSION['mail'] = $mail;
    $_SESSION['id'] = $id;
    $_SESSION['pass'] = $pass;

    $_SESSION['name'] = $name;
    $_SESSION['kname'] = $kname;

    $_SESSION['tel'] = $tel;
    $_SESSION['fcode'] = $fcode;
    $_SESSION['lcode'] = $lcode;
    $_SESSION['paddr'] = $paddr;
    $_SESSION['addr'] = $addr;
    $_SESSION['detail'] = $detail;

    //** 銀行口座 */
    if(!($_POST['bname'] == "")){
      $_SESSION['bname'] = $_POST['bname'];
    }
    if(!($_POST['branch'] == "")){
      $_SESSION['branch'] = $_POST['branch'];
    }
    if(!($_POST['bnumber'] == "")){
      $_SESSION['bnumber'] = $_POST['bnumber'];
    }

    header('location:s_reg_cf.php');
  }

}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>会員登録画面</title>
  <link rel="stylesheet" type="text/css" href="./css/">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
  <div id="header-top">
    <h1>会員登録</h1>

    <div id="navi">
      <ul>
        <li class="now">会員情報入力</li>
        <li class="arrow y"></li>
        <li>入力情報確認</li>
        <li class="arrow y"></li>
        <li>登録完了</li>
      </ul>
    </div>
  </div>

  <div id="space"></div>
  <!--レイアウト調整用 -->

  <p class="border"></p>

  <div id="wrapper">
    <form action="s_reg_in.php" method="POST">
      <div class="form">

        <h2 class="pad">会員情報入力</h2>

        <div class="imp">
          <h2>メールアドレス/ユーザーID/パスワード</h2>
          <table>
            <tr>
              <td class="title">メールアドレス<span class="red">必須</span></td>
              <td><input type="text" name="mail" size="50" autocomplete="off" value="<?php echo isset($_SESSION['mail']) ? $_SESSION['mail']:( isset($_POST['mail']) ? $_POST['mail'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '101'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '102'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '103'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
            <tr>
              <td class="title">店舗ID<span class="red">必須</span></td>
              <td><input type="text" name="id" size="40" autocomplete="off" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id']:( isset($_POST['id']) ? $_POST['id'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '201'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '202'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
            <tr>
              <td class="title">パスワード <span class="red2">※8文字以上の英数字</span><span class="red">必須</span></td>
              <td><input type="text" name="pass" size="40" autocomplete="off" value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass']:( isset($_POST['pass']) ? $_POST['pass'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '301'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '302'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '303'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
          </table>
        </div>

        <div class="name">
          <h2>店舗の基本情報</h2>
          <table>
            <tr>
              <td class="title">店舗名<span class="red">必須</span></span></td>
              <td><span class="title"></span><input type="text" name="name" autocomplete="off" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name']:( isset($_POST['name']) ? $_POST['name'] : '' ); ?>"></td>
              <?php foreach ($codes as $code): ?>
            <tr>
              <?php if($code == '401'): ?>
              <td></td>
              <td>
                <p class="red2 attention"><?php echo ERROR[$code]; ?></p>
              </td>
                <?php endif ?>
            </tr>
            <?php endforeach ?>
            <tr>
              <td class="title">店舗名(フリガナ)<span class="red">必須</span></td>
              <td><span class="title"></span><input type="text" name="kname" autocomplete="off" value="<?php echo isset($_SESSION['kname']) ? $_SESSION['kname']:( isset($_POST['kname']) ? $_POST['kname'] : '' ); ?>"></td>
            </tr>
            <?php foreach ($codes as $code): ?>
            <tr>
              <?php if($code == '501'): ?>
              <td></td>
              <td>
                <p class="red2 attention"><?php echo ERROR[$code]; ?></p>
              </td>
                <?php endif ?>
            </tr>
            <?php endforeach ?>
            <tr>
              <td class="title">店舗説明<span class="red">必須</span></td>
              <td><span class="title"></span><input type="text" name="detail" autocomplete="off" value="<?php echo isset($_SESSION['detail']) ? $_SESSION['detail']:( isset($_POST['detail']) ? $_POST['detail'] : '' ); ?>"></td>
            </tr>
            <?php foreach ($codes as $code): ?>
            <tr>
              <?php if($code == '502'): ?>
              <td></td>
              <td>
                <p class="red2 attention"><?php echo ERROR[$code]; ?></p>
              </td>
                <?php endif ?>
            </tr>
            <?php endforeach ?>
          </table>
        </div>

        <div class="address">
          <h2>店舗の住所</h2>
          <table>
            <tr>
              <td class="title">電話番号<span class="red">必須</span></td>
              <td><input type="text" name="tel" size="30" autocomplete="off" value="<?php echo isset($_SESSION['tel']) ? $_SESSION['tel']:( isset($_POST['tel']) ? $_POST['tel'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '601'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
            <tr>
              <td class="title">郵便番号<span class="red">必須</span></td>
              <td><input type="text" name="zip21" size="4" maxlength="3" autocomplete="off" value="<?php echo isset($_SESSION['fcode']) ? $_SESSION['fcode']:( isset($_POST['zip21']) ? $_POST['zip21'] : '' ); ?>">
               － <input type="text" name="zip22" size="5" maxlength="4" autocomplete="off" onKeyUp="AjaxZip3.zip2addr('zip21','zip22','addr21','addr21');" value="<?php echo isset($_SESSION['lcode']) ? $_SESSION['lcode']:( isset($_POST['zip22']) ? $_POST['zip22'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '601'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
            <tr>
              <td class="title">都道府県,市町村<span class="red">必須</span></td>
              <td><input type="text" name="addr21" size="30" autocomplete="off" value="<?php echo isset($_SESSION['paddr']) ? $_SESSION['paddr']:( isset($_POST['addr21']) ? $_POST['addr21'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '701'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
            <tr>
              <td class="title">番地・号<span class="red">必須</span></td>
              <td><input type="text" name="addr" size="40" autocomplete="off" value="<?php echo isset($_SESSION['addr']) ? $_SESSION['addr']:( isset($_POST['addr']) ? $_POST['addr'] : '' ); ?>">
              <?php foreach ($codes as $code): ?>
                <?php if($code == '801'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?></td>
            </tr>
          </table>
        </div>

        <div class="bank">
          <h2>収入のお振込先の情報</h2>
          <table>
            <tr>
              <td class="title">銀行名<span class="red">必須</span></td>
              <td><input type="text" name="bname" autocomplete="off" size="30" value="<?php echo isset($_SESSION['bcode']) ? $_SESSION['bcode']:( isset($_POST['bcode']) ? $_POST['bcode'] : '' ); ?>"></td>
            </tr>
            <tr>
              <td class="title">支店名/支店コード<span class="red">必須</span></td>
              <td><input type="text" autocomplete="off" name="branch" value="<?php echo isset($_SESSION['branch']) ? $_SESSION['branch']:( isset($_POST['branch']) ? $_POST['branch'] : '' ); ?>"></td>
            </tr>
            <tr>
              <td class="title">口座番号<span class="red">必須</span></td>
              <td><input type="text" autocomplete="off" name="bnumber" value="<?php echo isset($_SESSION['bnumber']) ? $_SESSION['bnumber']:( isset($_POST['bnumber']) ? $_POST['bnumber'] : '' ); ?>"></td>
            </tr>
          </table>
        </div>

        <input type="submit" value="確認" class="button" name="check">

      </div>
    </form>
  </div>
</body>

