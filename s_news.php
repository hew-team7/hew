<?php
session_start();

//$sid = $_SESSION['sid'];

$cn = mysqli_connect('localhost','root','','hew');
mysqli_set_charset($cn,'utf8');

// 仮ID
$sid = '32000004';
$sql = "SELECT * FROM shop_list WHERE id = '$sid';";
$result = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($result);
$address = $srow['address1'];

// 都道府県の確認
$address = $srow['address1'];
if(!(mb_strpos($address,'都') == false)){
  $cnt = 2;
}else if(!(mb_strpos($address,'道') == false)){
  $cnt = 2;
}else if(!(mb_strpos($address,'府') == false)){
  $cnt = 2;
}else{
  $cnt = mb_strpos($address,'県');
}

$address = mb_substr($address,0,$cnt+1);

// 多店舗からの通知があるかどうか
$sql = "SELECT * FROM news WHERE send_to = '$address';";
$result = mysqli_query($cn, $sql);
$nlists = array();
while ($rows = mysqli_fetch_assoc($result)) {
  $nlists[] = $rows;
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
  <table>
    <tr>
      <th>主題</th>
      <th>掲示日</th>
      <th>詳細</th>
    </tr>
    <?php foreach($nlists as $nlist): ?>
    <tr>
      <td><?php echo $nlist['title']; ?></td>
      <td><?php echo $nlist['paste_date']; ?></td>
      <td><a href="./s_new_det.php?id=<?php echo $nlist['id']; ?>">詳細</a></td>
    </tr>
    <?php endforeach ?>
  </table>

</body>
</html>