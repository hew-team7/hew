<?php

session_start();

$mail = $_SESSION['mail'];
$id = $_SESSION['id'];
$pass = $_SESSION['pass'];
$lpass = '';
for($p = 0 ; $p < strlen($pass) ; $p++){
  $lpass .= '*';
}
$pass = password_hash($pass, PASSWORD_BCRYPT);

$name = $_SESSION['name'];
$kname = $_SESSION['kname'];

$tel = $_SESSION['tel'];
$fcode = $_SESSION['fcode'];
$lcode = $_SESSION['lcode'];
$paddr = $_SESSION['paddr'];
$addr = $_SESSION['addr'];
$detail = $_SESSION['detail'];

if (isset($_SESSION['bname'])) {
  $bname = $_SESSION['bname'];
} else {
  $bname = '未登録';
}
if (isset($_SESSION['branch'])) {
  $branch = $_SESSION['branch'];
} else {
  $branch = '未登録';
}
if (isset($_SESSION['bnumber'])) {
  $bnumber = $_SESSION['bnumber'];
} else {
  $bnumber = '未登録';
}

$month = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C');

//*** 入力した内容で登録するを押された場合 */
if (isset($_POST['ok'])) {
  $code = strval($fcode) . strval($lcode);
  $cn = mysqli_connect('localhost', 'root', '', 'hew');
  mysqli_set_charset($cn, 'utf8');
  $sql1 = "SELECT id FROM shop_login ORDER BY id ASC;";
  $rsl = mysqli_query($cn, $sql1);
  $kid = "";
  $dmonth = "";
  while ($row = mysqli_fetch_assoc($rsl)){
    $kid = $row['id'];
  }
  if(!($kid == "")){
    $dmonth = substr($kid, 0, 1); //** データベース上の最近の月情報 */
  }

  $nmonth = date('n') - 1; //** 現在の月取得 */
  $nmonth = $month[$nmonth]; //** 月情報 */

  $nyear = date('y'); //** 現在の年取得 */

  
  $mid = substr($kid, 3);
  $mid = ltrim($mid, '0'); //** 5桁なので前に0がある場合、一度無くす */
  if(!($dmonth == $nmonth) || $kid == ''){ //** その月の新規会員がいない場合 */
    $mid = '00001'; //** 00001にする */
  }else{
    $mid++; //** これまでの会員に＋１ */
    $mid = sprintf('%05d', $mid); //** 5桁に合わせる */
  }

  $nid = strval($nmonth) . strval($nyear) . strval($mid);

  $sql3 = "INSERT INTO shop_list(id, name, postal_code, address1, address2, tel ,mail, detail, registration_date) VALUES('$nid', '$name', '$code', '$paddr', '$addr', '$tel', '$mail', '$detail', '".date('Y-m-d H:i:s')."');";
  mysqli_query($cn,$sql3);
  $sql2 = "INSERT INTO shop_login(id, shop_id, pass) VALUES('$nid', '$id', '$pass');";
  mysqli_query($cn, $sql2);
  mysqli_close($cn);

  header("location:./s_reg_wt.php");
  exit;
}

//*** 入力した内容を修正するを押された場合 */
if (isset($_POST['ng'])) {
    header("location:./s_reg_in.php");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>会員登録画面 - 確認</title>
  <link rel="stylesheet" type="text/css" href="./css/"">
</head>

<body>
  <div id="header-top">
    <h1>会員情報確認</h1>

    <div id="navi">
      <ul>
        <li>会員情報入力</li>
        <li class="arrow y"></li>
        <li class="now">入力情報確認</li>
        <li class="arrow y"></li>
        <li>登録完了</li>
      </ul>
    </div>
  </div>

  <div id="space"></div>
  <!--レイアウト調整用 -->

  <p class="border"></p>

  <div id="wrapper3">
    <form action="" method="POST">
      <div class="form">

        <h2 class="pad">会員入力情報確認</h2>

        <div class="imp">
          <h2><img src="./images/saru2.png" width="26px" height="26px">
            <p>メールアドレス/ユーザーID/パスワード</p>
          </h2>
          <table>
            <tr>
              <td class="title">メールアドレス</td>
              <td><?php echo $mail; ?></td>
            </tr>
            <tr>
              <td class="title">ユーザーID</td>
              <td><?php echo $id; ?></td>
            </tr>
            <tr>
              <td class="title">パスワード</td>
              <td><?php echo $lpass; ?></td>
            </tr>
          </table>
        </div>

        <div class="name">
          <h2>店舗の基本情報</h2>
          <table>
            <tr>
              <td class="title">店舗名</td>
              <td class="title"><span class="title"></span><?php echo $name; ?></td>
            </tr>
            <tr>
              <td class="title">店舗名(フリガナ)</td>
              <td class="title"><span class="title"></span><?php echo $kname; ?></td>
            </tr>
          </table>
        </div>

        <div class="address">
          <h2>店舗の住所</h2>
          <table>
            <tr>
              <td class="title">電話番号</td>
              <td><?php echo $tel; ?></td>
            </tr>
            <tr>
              <td class="title">郵便番号</td>
              <td><?php echo $fcode; ?> - <?php echo $lcode; ?></td>
            </tr>
            <tr>
              <td class="title">都道府県,市町村</td>
              <td><?php echo $paddr; ?></td>
            </tr>
            <tr>
              <td class="title">番地・号・マンション</td>
              <td><?php echo $addr; ?></td>
            </tr>
          </table>
        </div>

        <div class="address">
          <h2>お振込先の情報</h2>
          <table>
            <tr>
              <td class="title">銀行名</td>
              <td><?php echo $bname; ?></td>
            </tr>
            <tr>
              <td class="title">支店名/支店コード</td>
              <td><?php echo $branch; ?></td>
            </tr>
            <tr>
              <td class="title">口座番号</td>
              <td><?php echo $bnumber; ?></td>
            </tr>
          </table>
        </div>

        <div class="submit">
          <input type="submit" value="入力した内容で登録する" name="ok" class="obutton c">
          <input type="submit" value="入力した内容を修正する" name="ng" class="nbutton c">
        </div>
      </div>
    </form>

  </div>

</body>
</html>