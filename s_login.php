<?php

require_once('error.php');
require_once 'config.php';

$codes = [];

session_start();

if(isset($_POST['log'])){
  $yid = $_POST['yid'];
  $pass = $_POST['pass'];

  $dpass = "";
  $cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT shop_id,pass FROM shop_login WHERE shop_id = '$yid';";
  $result = mysqli_query($cn, $sql);
  $row = mysqli_fetch_assoc($result);
  $spass = $row['pass'];
  $sid = $row['shop_id'];

  if($yid == ""){
    $codes[] = '201';
  }elseif(!($sid == $yid)){
    $codes[] = '203';
  }

  if($pass == ""){
    $codes[] = '301';
  }

  if(empty($codes)){
    if(password_verify($pass, $spass)){
      $sql = "SELECT * FROM shop_list INNER JOIN shop_login ON shop_list.id = shop_login.id;";
      $result2 = mysqli_query($cn, $sql);
      $row2 = mysqli_fetch_assoc($result2);
      $_SESSION['sid'] = $yid;
      $_SESSION['name'] = $rows2['name'];
      $_SESSION['code'] = $rows2['postal_code'];
      $_SESSION['addr'] = $rows2['address1'] . $rows2['address2'];
      header("location:./s_top.php");
      exit;
    }else{
      $codes[] = '304';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ログイン画面</title>
  <link rel="stylesheet" type="text/css" href="./css/">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
  <div id="header-top">
    <h1>ログイン</h1>
  </div>

  <div id="space"></div>
  <!--レイアウト調整用 -->

  <p class="border"></p>

  <div id="wrapper">
    <form action="s_login.php" method="POST">
      <div class="login">
        <div class="id">
          <p>店ID</p>
          <input type="text" name="yid" autocomplete="off" class="id2" size="40" value="<?php echo isset($_POST['yid']) ? $_POST['yid']: '' ; ?>">
          <?php foreach ($codes as $code): ?>
                <?php if($code == '201'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '203'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?>
        </div>
        <p>
      </div>
      <div class="pass">
        <p>パスワード</p>
        <input type="password" name="pass" class="pass2" size="40" value="<?php echo isset($_POST['pass']) ? $_POST['pass']: '' ; ?>">
        <?php foreach ($codes as $code): ?>
                <?php if($code == '301'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php elseif($code == '304'): ?>
                  <p class="red2"><?php echo ERROR[$code]; ?></p>
                <?php endif ?>
              <?php endforeach ?>
      </div>

      <input type="submit" value="ログイン" class="button red log" name="log">
    </form>
  </div>
</body>
</html>