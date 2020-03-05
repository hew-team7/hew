<?php
$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

session_start();

$yid = $_SESSION['user_id'];
var_dump($yid);
//
//  ランキング
$sql = "SELECT buyer_login.id,buyer_login.user_id,point,rank FROM point INNER JOIN buyer_list ON point.user_id = buyer_list.id INNER JOIN buyer_login ON point.user_id = buyer_login.id GROUP BY user_id;";
$result = mysqli_query($cn, $sql);
while ($rows = mysqli_fetch_assoc($result)) {
  $spoints[] = $rows;
}
if (isset($spoints)) {
  foreach ($spoints as $id => $data) {
    $srow[$id] = $data["point"];
  }
  array_multisort($srow, SORT_DESC, $spoints);
}

// 特定の月のランキング
if (isset($_POST['search'])) {
  if (!($_POST['when'] == '')) {
    $when = $_POST['when'];
    $when = '%' . $when . '%';
    $sql = "SELECT buyer_login.id,buyer_login.user_id,SUM(get_point) AS get_point,point,rank FROM point INNER JOIN buyer_list ON point.user_id = buyer_list.id INNER JOIN buyer_login ON point.user_id = buyer_login.id WHERE date LIKE '$when' GROUP BY user_id;";
    $result = mysqli_query($cn, $sql);
    $spoints = array();
    while ($rows = mysqli_fetch_assoc($result)) {
      $spoints[] = $rows;
    }
    if (isset($spoints)) {
      foreach ($spoints as $data) {
        $rank[] = $data["get_point"];
      }
      if(is_array($rank)){
        array_multisort($rank, SORT_DESC, $spoints);
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <!-- Required meta tags always come first -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>ランキング | HELOSS</title>

  <!-- Font Awesome -->
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="Material%20Design%20Bootstrap%20Template_files/bootstrap.css" rel="stylesheet">

  <!-- Material Design Bootstrap -->
  <link href="Material%20Design%20Bootstrap%20Template_files/mdb.css" rel="stylesheet">



  <style>
    body {
      background-color: #f5f5f5;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }

    .dark-skin .navbar {
      background-color: #fb7d22;
    }

    .dark-skin .side-nav .logo-wrapper {

      background-size: auto;
      background-size: cover;
    }

    .side-nav .logo-wrapper,
    .side-nav .logo-wrapper a {
      height: 0px;
    }

    .dark-gradient,
    .dark-skin .side-nav {

      background: linear-gradient(135deg, #fb7d22 0, #fb7d22 100%);

    }

    .dark-skin .side-nav .sn-avatar-wrapper img {
      border: none;
      box-shadow: 2px 3px 3px rgba(0, 0, 0, 0.3);
    }

    .side-nav .sn-avatar-wrapper img {
      max-width: 65px;
      margin-left: -10px;
      margin-top: 8px;
    }

    .dark-skin .side-nav .collapsible li a:hover {
      background-color:
        #f0a773;
      transition: all .3s linear;
    }

    .dark-skin .side-nav .collapsible li a:hover {
      background-color:
        #c66017;
      transition: all .3s linear;
    }

    .side-nav .collapsible>li {
      padding-right: 1rem;
      padding-left: 1rem;
      margin-top: 10px;
    }

    .title{
      color:#f0a773;
      border-bottom: 1px solid #f0a773;
      padding-bottom: 10px;
      margin: 0 auto 30px auto;
    }

    table{
      margin-top: 30px;
      text-align: center;
    }

    th{
      color: #f0a773;
    }

    .me{
      background-color: #f0a773;
      color: #fff;
    }
  </style>

</head>

<body class="fixed-sn dark-skin" style="">

  <!--Double Navigation-->
  <header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed custom-scrollbar ps-container ps-theme-default" style="transform: translateX(-100%);" data-ps-id="96864e62-e306-5383-47b2-9d30422757ea">



      <!-- Side navigation links -->
      <li>
        <ul class="collapsible collapsible-accordion">
          <li><a href="./map.php" class="collapsible-header waves-effect"><i class="fa fa-map"></i> マップ</a>

          </li>

          <li><a href="./ranking.php" class="collapsible-header waves-effect"><i class="fa fa-crown"></i> ランキング</a>

          </li>

          <li><a href="./b_pl.php" class="collapsible-header waves-effect"><i class="fa fa-user"></i> ステータス</a>

          </li>

          <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cog"></i> 設定<i class="fa fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="./b_pl_stg.php" class="waves-effect">プロフィール編集</a>
                </li>
                <li><a href="./log_out.php" class="waves-effect">ログアウト</a>
                </li>
              </ul>
            </div>
          </li>

          <li><a href="./b_question.php" class="collapsible-header waves-effect"><i class="fa fa-question"></i> お問い合わせ</a>
        </ul>
      </li>
      <!--/. Side navigation links -->

      <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
      </div>
      <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
      </div>
    </ul>
    <!--/. Sidebar navigation -->

    <!--Navbar-->
    <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

      <!-- SideNav slide-out button -->
      <div class="float-xs-left">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
      </div>

      <!-- Breadcrumb-->
      <div class="breadcrumb-dn">
        <p>HELOSS</p>
      </div>


      <ul class="nav navbar-nav float-xs-right">

        <li class="nav-item ">
          <a href="./b_news.php" class="nav-link waves-effect waves-light"><i class="fa fa-bell"></i> <span class="hidden-sm-down">お知らせ</span></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <span class="hidden-sm-down">プロフィール</span> </a>
          <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <a class="dropdown-item waves-effect waves-light" href="./s_pl.php">プロフィール確認</a>
            <a class="dropdown-item waves-effect waves-light" href="./s_pl_stg.php">プロフィール編集</a>
          </div>
        </li>
      </ul>

    </nav>
    <!--/.Navbar-->

  </header>
  <!--/Double Navigation-->

  <!--Main layout-->
  <main class="">
    <div class="container-fluid text-xs-center" style="height: 800px;">
      <div class="row">
        <div class="col-md-12">
        <h4 class="title">ポイントランキング</h4>
              <form action="./ranking.php" method="POST" class="navbar-form">
                <div class="row a">
                  <div class="col-md-4 offset-md-2" style="margin-top:25px;">
                    <h6>特定の月のランキングを見る<small>(例:2020-02)</small></h6>
                  </div>
                  <div class="col-md-2">
                      <input type="text" name="when" class="form-control" autocomplete="off">
                  </div>
                  <div class="col-md-2">
                    <button type="submit" name="search" class="btn btn-warning waves-effect waves-light">検索</button>
                  </div>
                </div>
              </form>
              <?php if(isset($when)): ?>
                <p>調べた年月：<?php echo $_POST['when']; ?></p>
              <?php endif ?>
              <h5>
                <?php if ((isset($_POST['add1'])) && !($_POST['add1'] == "")) : ?>
                  検索条件：
                  <?php echo $_POST['add1']; ?>
                <?php endif ?>
                <?php if ((isset($_POST['add2'])) && !($_POST['add2'] == "")) : ?>
                  <?php echo $_POST['add2']; ?>
                <?php endif ?>
              </h5>
              <div class="card" style="padding: 0 10px;">
                <table class="table">
                  <thead class="thead-warning">
                    <th style="text-align: center;">順位</th>
                    <th style="text-align: center;">ID</th>
                    <?php if (isset($when)) : ?>
                      <th style="text-align: center;">獲得P</th>
                    <?php endif ?>
                    <th style="text-align: center;">累計P</th>
                    <th style="text-align: center;">ランク</th>
                  </thead>
                  <tbody>
                    <?php $p = 0; ?>
                    <?php $rank = 0; ?>
                    <?php $cnt = 0; ?>
                    <?php foreach ($spoints as $spoint) : ?>
                      <?php if($spoint['user_id'] == $yid): ?>
                        <?php $check = 1; ?>
                      <?php else: ?>
                        <?php $check = 0; ?>
                      <?php endif ?>
                      <tr class="<?php if($check == 1){ echo 'me'; }?>">
                        <?php if (isset($when)) : ?>
                          <?php if (!($p == $spoint['get_point'])) : // 同順位じゃない
                          ?>
                            <?php $rank++; ?>
                            <?php if (!($cnt == 0)) : //一つ前までが同順位の場合 
                            ?>
                              <?php $rank += $cnt; ?>
                              <?php $cnt = 0; ?>
                            <?php endif ?>
                            <td><?php echo $rank; ?></td>
                            <?php $p = $spoint['get_point']; ?>
                          <?php else : // 前と同じポイントの場合 
                          ?>
                            <td><?php echo $rank; ?></td>
                            <?php $cnt++; ?>
                            <?php $p = $spoint['get_point']; ?>
                          <?php endif ?>
                        <?php else : ?>
                          <?php if (!($p == $spoint['point'])) : // 同順位じゃない
                          ?>
                            <?php $rank++; ?>
                            <?php if (!($cnt == 0)) : //一つ前までが同順位の場合 
                            ?>
                              <?php $rank += $cnt; ?>
                              <?php $cnt = 0; ?>
                            <?php endif ?>
                            <td><?php echo $rank; ?></td>
                            <?php $p = $spoint['point']; ?>
                          <?php else : // 前と同じポイントの場合 
                          ?>
                            <td><?php echo $rank; ?></td>
                            <?php $cnt++; ?>
                            <?php $p = $spoint['point']; ?>
                          <?php endif ?>
                        <?php endif ?>
                        <td><?php echo $spoint['user_id']; ?></td>
                        <?php if (isset($when)) : ?>
                          <td><?php echo $spoint['get_point']; ?></td>
                        <?php endif ?>
                        <td><?php echo $spoint['point']; ?></td>
                        <td><?php echo $spoint['rank']; ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!--/Main layout-->

  <!--Footer-->
  <footer class="page-footer center-on-small-only">

    <!--Footer Links-->
    <div class="container">
      <p class="container-fluid center-block text-center"><img src="./images/logo/698942.png"></p>
    </div>

    <!--/.Footer Links-->


    <!--Copyright-->
    <div class="footer-copyright">
      <div class="container-fluid">
        © 2020 Copyright: HELOSS Entertainment.

      </div>
    </div>
    <!--/.Copyright-->

  </footer>
  <!--/.Footer-->

  <!-- SCRIPTS -->

  <!-- JQuery -->
  <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/jquery-3.js"></script>

  <!-- Tooltips -->
  <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/tether.js"></script>

  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/bootstrap.js"></script>

  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="Material%20Design%20Bootstrap%20Template_files/mdb.js"></script>

  <script>
    $(".button-collapse").sideNav();

    var el = document.querySelector('.custom-scrollbar');

    Ps.initialize(el);
  </script>




  <div class="hiddendiv common"></div>
  <div class="drag-target" style="touch-action: pan-y; user-select: none; left: 0px;"></div>
</body>

</html>