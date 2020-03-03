<?php
session_start();

//$sid = $_SESSION['sid'];

$sid = '32000004';
$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

$pid = $_GET['pid'];

// 商品詳細
$sql = "SELECT * FROM shop_sell_product a 
INNER JOIN shop_list b ON a.shop_id = b.id INNER JOIN shop_product c ON a.product_id = c.id WHERE a.product_id = '$pid';";
$result = mysqli_query($cn, $sql);
$prow = mysqli_fetch_assoc($result);

$sname = $prow['name'];
$quan = $prow['sell_quantity'];
$price = $prow['sell_quantity'] * $prow['price_cut'];

// 店舗詳細
$sql = "SELECT * FROM shop_list WHERE id = '$sid'";
$result = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($result);
$bname = $srow['name'];

// 購入する
if(isset($_POST['suc'])){
  // 購入数の変更
  $sql = "UPDATE shop_sell_product SET buy_quantity = '$quan' WHERE product_id = '$pid';";
  $result = mysqli_query($cn, $sql);

  // 管理側へ通知
  $sql3 = "SELECT MAX(id) AS id FROM news;";
  $result = mysqli_query($cn, $sql3);
  $row = mysqli_fetch_assoc($result);
  $nid = $row['id'] + 1;
  $title = $bname."が".$sname."の商品を購入しました";
  $detail = $bname."が".$sname."の商品を購入しました。/商品名：".$prow['product_name']."/数量：".$prow['sell_quantity']."個/金額：￥".number_format($price)."円";
  $sql = "INSERT INTO news(id,title,detail,news_type,send_to,from_to,sell_id) VALUES($nid,'$title','$detail',5,0,'$sid','$pid');";
  $result = mysqli_query($cn, $sql);
  var_dump($sql);
  //header("location: ./s_buy_suc.php");
}


?>

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
      <th>商品名</th>
      <td><?php echo $prow['product_name']; ?></td>
    </tr>
    <tr>
      <th>数量</th>
      <td><?php echo $prow['sell_quantity']; ?>個</td>
    </tr>
    <tr>
      <th>金額</th>
      <td>￥<?php echo number_format($price); ?>円</td>
    </tr>
    <tr>
      <th>購入店</th>
      <td><?php echo $prow['name']; ?></td>
    </tr>
    <tr>
      <td colspan="2">本当に購入しますか？</td>
    </tr>
    <tr>
      <form action="./s_buy.php?pid=<?php echo $pid; ?>" method="post">
      <td><a href="./s_news.php">購入をやめる</a></td>
      <td><button name="suc">購入する</button></td>
      </form>
    </tr>
  </table>

</body>

</html>