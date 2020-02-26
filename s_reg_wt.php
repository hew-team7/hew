<?php
session_start();

// セッションの値を初期化
$_SESSION = array();
 
// セッションを破棄
session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>会員登録画面 - 確認</title>
  <link rel="stylesheet" type="text/css" href="./css/">
  <meta http-equiv="refresh" content="5; url=./top-page.php">
</head>

<body>
  <div id="header-top">
    <h1>会員登録完了</h1>

    <div id="navi">
      <ul>
        <li>会員情報入力</li>
        <li class="arrow y"></li>
        <li>入力情報確認</li>
        <li class="arrow y"></li>
        <li class="now">登録完了</li>
      </ul>
    </div>
  </div>

  <div id="space"></div>
  <!--レイアウト調整用 -->

  <p class="border"></p>

  <div id="wrapper2">
    <div class="success">
      <h2 class="pad">会員登録完了</h2>

      <p class="padi">会員登録が完了しました。</p>
      <p>５秒後にTOPページへ遷移します。</p>

      <p>自動的に変わらない場合、下のリンク先をクリックしてください。</p>
      <a href="./top-page.php" class="button d">TOPページへ戻る</a>
    </div>
  </div>

</body>

</html>