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

$fn = $_SESSION['fn'];
$ln = $_SESSION['ln'];
$kfn = $_SESSION['kfn'];
$kln = $_SESSION['kln'];

$code = $_SESSION['code'];
$paddr = $_SESSION['paddr'];
$addr = $_SESSION['addr'];

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
  $cn = mysqli_connect('localhost', 'root', '', 'hew');
  mysqli_set_charset($cn, 'utf8');
  $sql1 = "SELECT id FROM buyer_login ORDER BY id ASC;";
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

  $sql3 = "INSERT INTO buyer_list(id, mail, f_name, l_name, postal_code, address1, address2, registration_date) VALUES('$nid', '$mail', '$fn', '$ln', '$code', '$paddr', '$addr', '".date('Y-m-d H:i:s')."');";
  mysqli_query($cn,$sql3);
  $sql2 = "INSERT INTO buyer_login(id, user_id, pass) VALUES('$nid', '$id', '$pass');";
  mysqli_query($cn, $sql2);
  mysqli_close($cn);

  header("location:./b_reg_wt.php");
  exit;
}

//*** 入力した内容を修正するを押された場合 */
if (isset($_POST['ng'])) {
    header("location:./b_reg_in.php");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>会員登録画面</title>
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

  <div id="wrapper3">
    <form action="" method="POST">
      <div class="form">

        <h2 class="pad">会員入力情報確認</h2>

        <div class="imp">
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
          <h2>お客様の基本情報</h2>
          <table>
            <tr>
              <td class="title">氏名</td>
              <td class="title"><span class="title">姓)</span><?php echo $fn; ?></td>
              <td class="title"><span class="title span">名)</span><?php echo $ln; ?></td>
            </tr>
            <tr>
              <td class="title">氏名(フリガナ)</td>
              <td class="title"><span class="title">姓)</span><?php echo $kfn; ?></td>
              <td class="title"><span class="title span">名)</span><?php echo $kln; ?></td>
            </tr>
          </table>
        </div>

        <div class="address">
          <h2>お届け先の住所</h2>
          <table>
            <tr>
              <td class="title">郵便番号</td>
              <td><?php echo $code; ?></td>
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