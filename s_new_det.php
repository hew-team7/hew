<?php
session_start();

//$sid = $_SESSION['sid'];

$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

$id = $_GET['id'];
$sql = "SELECT a.id,name,title,tel,address1,address2,postal_code,mail,a.paste_date,a.detail,sell_id,b.id AS sid
FROM news a 
INNER JOIN shop_list b ON a.from_to = b.id WHERE news_type = 5 AND a.id = '$id';";
$result = mysqli_query($cn, $sql);
$nrow = mysqli_fetch_assoc($result);
$detail = explode("/", $nrow['detail']);
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
      <td class="text-primary">店舗名</td>
      <td><?php echo $nrow['name']; ?></td>
    </tr>
    <tr>
      <td class="text-primary">主題</td>
      <td><?php echo $nrow['title']; ?></td>
    </tr>
    <tr>
      <td class="text-primary">内容</td>
      <td>
        <?php foreach ($detail as $details) : ?>
          <p class="f"><?php echo $details; ?></p>
        <?php endforeach ?>
      </td>
    </tr>
    <tr>
      <td class="text-primary">郵便番号・住所</td>
      <td>〒<?php echo $nrow['postal_code']; ?>　<?php echo $nrow['address1'] . $nrow['address2']; ?></td>
    </tr>
    <tr>
      <td class="text-primary">メールアドレス</td>
      <td><?php echo $nrow['mail']; ?></td>
    </tr>
    <tr>
      <td class="text-primary">通知日</td>
      <td><?php echo $nrow['paste_date']; ?></td>
    </tr>
    <tr>
      <td><a href="./">店舗詳細に行く</a></td>
      <td><a href="./s_buy.php?pid=<?php echo $nrow['sell_id']; ?>">購入する</a></td>
    </tr>
  </table>

</body>

</html>