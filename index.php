<?php

session_start();
// セッションの値を初期化
$_SESSION = array();

// セッションを破棄
session_destroy();

?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  <!-- BootstrapのCSS読み込み -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body>

<div id="wrapper">

<div id="body1">
<div id="header">
  <p><a href="index.php"><img src="images/logo/698942.png"></a></p>
</div>

<div id="main">
  <div id="left">
    <div id="left1">
      <p class="p">店舗側はこちら</p>
      <a href="s_login.php" id="margin" class="border_slide_btn">ログイン</a>
      <a href="s_reg_in.php" class="border_slide_btn">新規登録</a>
    </div>
  </div>
  <div id="right">
  　 <div id="right1">
      <p class="p">購入者側はこちら</p>
      <a href="b_login.php" id="margin1" class="border_slide_btn">ログイン</a>
      <a href="b_reg_in.php" class="border_slide_btn">新規登録</a>
    </div>
  </div>
</div></div>



<div id="end">
  <p>HEW 7team</p>
</div>

  </div>
</body>

</html>