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
      $sql = "SELECT shop_id,shop_login.id AS id,name,postal_code,address1,address2 FROM shop_list INNER JOIN shop_login ON shop_list.id = shop_login.id WHERE shop_id = '$yid';";
      $result2 = mysqli_query($cn, $sql);
      $row2 = mysqli_fetch_assoc($result2);
      $_SESSION['shop_id'] = $row2['shop_id'];
      $_SESSION['shop_number'] = $row2['id'];
      $_SESSION['name'] = $row2['name'];
      $_SESSION['code'] = $row2['postal_code'];
      $_SESSION['addr'] = $row2['address1'] . $rows2['address2'];
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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>ログイン</title>
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
          <div class="col-md-5 i">
            <div class="card">
              <div class="card-header card-header-success">
                <h4 class="card-title" style="text-align: center;">ログイン</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body" style="margin: 0 auto;">
                <form action="" method="POST">
                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">ユーザーID</label>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control q" name="yid" autocomplete="off" class="id2" size="50" value="<?php echo isset($_POST['yid']) ? $_POST['yid'] : ''; ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '201') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '203') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>
                  <label class="z" style="margin: 50px 0 10px 0; font-size: 1.2em;">パスワード</label>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="password" class="form-control q" name="pass" class="pass2" size="40" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '301') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '304') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-1 offset-lg-4">
                      <input type="submit" value="ログイン" class="btn btn-success waves-effect waves-light" style="margin: 30px 0;" name="log">
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

</html>