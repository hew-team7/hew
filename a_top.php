<?php
$cn = mysqli_connect('localhost', 'root', '', 'hew_07');
mysqli_set_charset($cn, 'utf8');

/** 会員数 */
$sql = "SELECT COUNT(*) AS bcnt FROM buyer_list WHERE delete_date IS NULL;";
$bresult = mysqli_query($cn, $sql);
$brow = mysqli_fetch_assoc($bresult);

for ($i = 0; $i < 7; $i++) {
  $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $i, date('Y')));
  $sql = "SELECT COUNT(*) AS klist FROM buyer_list WHERE registration_date LIKE '%$date%';";
  $tresult = mysqli_query($cn, $sql);
  $trow = mysqli_fetch_assoc($tresult);
  $date = date('n/j', mktime(0, 0, 0, date('n'), date('j') - $i, date('Y')));
  $trow[] = $date;
  $klists[] = $trow;
  if($i == 0){
    $today = $trow['klist'];
  }
  if($i == 1){
    $yesterday = $trow['klist'];
    if($today == 0){
      $brate = 0;
    }
    $brate = $today / $yesterday * 100;
  }
}
$klists = array_reverse($klists);


/** 店舗数 */
$sql = "SELECT COUNT(*) AS scnt FROM shop_list WHERE delete_time IS NULL;";
$sresult = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($sresult);

for ($i = 0; $i < 7; $i++) {
  $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $i, date('Y')));
  $sql = "SELECT COUNT(*) AS slist FROM shop_list WHERE registration_date LIKE '%$date%';";
  $tresult = mysqli_query($cn, $sql);
  $drow = mysqli_fetch_assoc($tresult);
  $date = date('n/j', mktime(0, 0, 0, date('n'), date('j') - $i, date('Y')));
  $drow[] = $date;
  $slists[] = $drow;
}
$slists = array_reverse($slists);


/** 商品数 */
$now = date('Y-m-d H:i:s');
$sql = "SELECT COUNT(*) AS pcnt FROM shop_sell_product WHERE close_date >= '$now';";
$presult = mysqli_query($cn, $sql);
$prow = mysqli_fetch_assoc($presult);


for ($i = 0; $i < 7; $i++) {
  $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $i, date('Y')));
  $sql = "SELECT COUNT(*) AS plist FROM shop_sell_product WHERE paste_date LIKE '%$date%';";
  $tresult = mysqli_query($cn, $sql);
  $arow = mysqli_fetch_assoc($tresult);
  $date = date('n/j', mktime(0, 0, 0, date('n'), date('j') - $i, date('Y')));
  $arow[] = $date;
  $plists[] = $arow;
}
$plists = array_reverse($plists);


/** 売れ残り商品数 */
$sql = "SELECT COUNT(*) AS rcnt FROM shop_sell_product WHERE NOT sell_quantity = buy_quantity AND close_date <= '$now';";
$rresult = mysqli_query($cn, $sql);
$rrow = mysqli_fetch_assoc($rresult);

for ($i = 0; $i < 7; $i++) {
  $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $i, date('Y')));
  $sql = "SELECT COUNT(*) AS llist FROM shop_sell_product WHERE paste_date LIKE '%$date%' AND close_date <= '$now';";
  $tresult = mysqli_query($cn, $sql);
  $crow = mysqli_fetch_assoc($tresult);
  $date = date('y/n/j', mktime(0, 0, 0, date('n'), date('j') - $i, date('Y')));
  $crow[] = $date;
  $llists[] = $crow;
}
$llists = array_reverse($llists);

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>管理者 | トップページ</title>
  <link href="css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- Chartist JS -->
  <script src="js/plugins/chartist.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="images/sidebar-1.jpg">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
      <div class="logo">
        <a href="" class="simple-text logo-normal">
          Creative Tim
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./a_top.php">
              <i class="material-icons">dashboard</i>
              <p>TOP</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">person</i>
              <p>購入者一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">fastfood</i>
              <p>商品一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">emoji_food_beverage</i>
              <p>売れ残り商品一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./s_list.php">
              <i class="material-icons">store_mall_directory</i>
              <p>店舗一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./tables.html">
              <i class="material-icons">content_paste</i>
              <p>ランキング</p>
            </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">管理者TOP</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Mike John responded to your email</a>
                  <a class="dropdown-item" href="#">You have 5 new tasks</a>
                  <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                  <a class="dropdown-item" href="#">Another Notification</a>
                  <a class="dropdown-item" href="#">Another One</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">person</i>
                  </div>
                  <p class="card-category">登録者数</p>
                  <h3 class="card-title"><?php echo $brow['bcnt']; ?>
                    <small>人</small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <?php if($brate >= 100): ?>
                      <span class="text-success"><i class="fa fa-long-arrow-up"></i> <?php echo $brate; ?>%　</span>
                       増加しています(昨日:<?php echo $yesterday;?>人)
                    <?php elseif($brate < 100): ?>
                      <span class="text-danger"><i class="material-icons">assessment</i><i class="fa fa-long-arrow-down"></i> <?php echo $brate; ?> </span>          
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">店舗数</p>
                  <h3 class="card-title"><?php echo $srow['scnt']; ?>
                    <small>店舗</small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">assessment</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">fastfood</i>
                  </div>
                  <p class="card-category">商品数</p>
                  <h3 class="card-title"><?php echo $prow['pcnt']; ?>
                    <small>点</small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">assessment</i> Tracked from Github
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <p class="card-category">売れ残り商品数</p>
                  <h3 class="card-title"><?php echo $rrow['rcnt']; ?>
                    <small>点</small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">assessment</i> Just Updated
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-success aa">
                <div class="ct-chart ct-perfect-fourth"></div>
                <?php
                echo "<script type='text/javascript'>";
                echo "var chart = new Chartist.Line('.ct-perfect-fourth', {";
                echo "labels: [";
                foreach ($klists as $klist) {
                  echo "'$klist[0]',";
                }
                echo "],";
                echo "series: [";
                echo "[";
                foreach ($klists as $klist) {
                  echo "$klist[klist],";
                }
                echo "]";
                echo "]";
                echo "}, {";
                echo "low: 0,";
                echo "showPoint: false,";
                echo "fullWidth: true,";
                echo "height: 180,";
                echo "tension: 0";
                echo "});";

                echo "chart.on('draw', function(data) {";
                echo "if (data.type === 'line' || data.type === 'area') {";
                echo "data.element.animate({";
                echo "d: {";
                echo "begin: 2000 * data.index,";
                echo "dur: 2000,";
                echo "from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),";
                echo "to: data.path.clone().stringify(),";
                echo "easing: Chartist.Svg.Easing.easeOutQuint";
                echo "}";
                echo "});";
                echo "}";
                echo "});";
                echo "</script>";
                ?>
              </div>
              <div class="card-body">
                <h4 class="card-title">会員数推移(日単位) ※直近1週間</h4>
                <p class="card-category">
                  <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> updated 4 minutes ago
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-warning aa">
                <div class="ct-chart ct-perfect-fifth"></div>
                <?php
                echo "<script type='text/javascript'>";
                echo "var chart = new Chartist.Line('.ct-perfect-fifth', {";
                echo "labels: [";
                foreach ($slists as $slist) {
                  echo "'$slist[0]',";
                }
                echo "],";
                echo "series: [";
                echo "[";
                foreach ($slists as $slist) {
                  echo "$slist[slist],";
                }
                echo "]";
                echo "]";
                echo "}, {";
                echo "low: 0,";
                echo "showPoint: false,";
                echo "fullWidth: true,";
                echo "height: 180,";
                echo "tension: 0";
                echo "});";

                echo "chart.on('draw', function(data) {";
                echo "if (data.type === 'line' || data.type === 'area') {";
                echo "data.element.animate({";
                echo "d: {";
                echo "begin: 2000 * data.index,";
                echo "dur: 2000,";
                echo "from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),";
                echo "to: data.path.clone().stringify(),";
                echo "easing: Chartist.Svg.Easing.easeOutQuint";
                echo "}";
                echo "});";
                echo "}";
                echo "});";
                echo "</script>";
                ?>
              </div>
              <div class="card-body">
                <h4 class="card-title">店舗数推移(日単位) ※直近1週間</h4>
                <p class="card-category">Last Campaign Performance</p>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> campaign sent 2 days ago
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-danger">
                <div class="ct-chart ct-perfect-six"></div>
                <?php
                echo "<script type='text/javascript'>";
                echo "var chart = new Chartist.Line('.ct-perfect-six', {";
                echo "labels: [";
                foreach ($plists as $plist) {
                  echo "'$plist[0]',";
                }
                echo "],";
                echo "series: [";
                echo "[";
                foreach ($plists as $plist) {
                  echo "$plist[plist],";
                }
                echo "]";
                echo "]";
                echo "}, {";
                echo "low: 0,";
                echo "showPoint: false,";
                echo "fullWidth: true,";
                echo "height: 180,";
                echo "tension: 0";
                echo "});";

                echo "chart.on('draw', function(data) {";
                echo "if (data.type === 'line' || data.type === 'area') {";
                echo "data.element.animate({";
                echo "d: {";
                echo "begin: 2000 * data.index,";
                echo "dur: 2000,";
                echo "from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),";
                echo "to: data.path.clone().stringify(),";
                echo "easing: Chartist.Svg.Easing.easeOutQuint";
                echo "}";
                echo "});";
                echo "}";
                echo "});";
                echo "</script>";
                ?>
              </div>
              <div class="card-body">
                <h4 class="card-title">商品数推移(日単位) ※直近1週間</h4>
                <p class="card-category">Last Campaign Performance</p>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> campaign sent 2 days ago
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                  <div class="nav-tabs-wrapper">
                    <span class="nav-tabs-title">Tasks:</span>
                    <ul class="nav nav-tabs" data-tabs="tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#profile" data-toggle="tab">
                          <i class="material-icons">alarm</i> 通知
                          <div class="ripple-container"></div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="profile">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" checked>
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                              </label>
                            </div>
                          </td>
                          <td>Sign contract for "What are conference organizers afraid of?"</td>
                          <td class="td-actions text-right">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                            <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                              <i class="material-icons">close</i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Employees Stats</h4>
                  <p class="card-category">New employees on 15th September, 2016</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>RANKING</th>
                      <th>USER_ID</th>
                      <th>POINT</th>
                      <th>RANK</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Dakota Rice</td>
                        <td>$36,738</td>
                        <td>Niger</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid">
            <nav class="float-left">
              <ul>
                <li>
                  <a href="https://www.creative-tim.com">
                    Creative Tim
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright float-right">
              &copy;
              <script>
                document.write(new Date().getFullYear())
              </script>, made with <i class="material-icons">favorite</i> by
              <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
            </div>
            <!-- your footer here -->
          </div>
        </footer>
      </div>
    </div>

    <!--   Core JS Files   -->
    <script src="js/core/jquery.min.js" type="text/javascript"></script>
    <script src="js/core/popper.min.js" type="text/javascript"></script>
    <script src="js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>

    <!-- Plugin for the momentJs  -->
    <script src="js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
    <!--  Notifications Plugin    -->
    <script src="js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <script>
      $(document).ready(function() {
        $().ready(function() {
          $sidebar = $('.sidebar');

          $sidebar_img_container = $sidebar.find('.sidebar-background');

          $full_page = $('.full-page');

          $sidebar_responsive = $('body > .navbar-collapse');

          window_width = $(window).width();

          fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

          if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
            if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
              $('.fixed-plugin .dropdown').addClass('open');
            }

          }

          $('.fixed-plugin a').click(function(event) {
            // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
            if ($(this).hasClass('switch-trigger')) {
              if (event.stopPropagation) {
                event.stopPropagation();
              } else if (window.event) {
                window.event.cancelBubble = true;
              }
            }
          });

          $('.fixed-plugin .active-color span').click(function() {
            $full_page_background = $('.full-page-background');

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if ($sidebar.length != 0) {
              $sidebar.attr('data-color', new_color);
            }

            if ($full_page.length != 0) {
              $full_page.attr('filter-color', new_color);
            }

            if ($sidebar_responsive.length != 0) {
              $sidebar_responsive.attr('data-color', new_color);
            }
          });

          $('.fixed-plugin .background-color .badge').click(function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('background-color');

            if ($sidebar.length != 0) {
              $sidebar.attr('data-background-color', new_color);
            }
          });

          $('.fixed-plugin .img-holder').click(function() {
            $full_page_background = $('.full-page-background');

            $(this).parent('li').siblings().removeClass('active');
            $(this).parent('li').addClass('active');


            var new_image = $(this).find("img").attr('src');

            if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
              $sidebar_img_container.fadeOut('fast', function() {
                $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                $sidebar_img_container.fadeIn('fast');
              });
            }

            if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
              var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

              $full_page_background.fadeOut('fast', function() {
                $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                $full_page_background.fadeIn('fast');
              });
            }

            if ($('.switch-sidebar-image input:checked').length == 0) {
              var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
              var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
            }

            if ($sidebar_responsive.length != 0) {
              $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
            }
          });

          $('.switch-sidebar-image input').change(function() {
            $full_page_background = $('.full-page-background');

            $input = $(this);

            if ($input.is(':checked')) {
              if ($sidebar_img_container.length != 0) {
                $sidebar_img_container.fadeIn('fast');
                $sidebar.attr('data-image', '#');
              }

              if ($full_page_background.length != 0) {
                $full_page_background.fadeIn('fast');
                $full_page.attr('data-image', '#');
              }

              background_image = true;
            } else {
              if ($sidebar_img_container.length != 0) {
                $sidebar.removeAttr('data-image');
                $sidebar_img_container.fadeOut('fast');
              }

              if ($full_page_background.length != 0) {
                $full_page.removeAttr('data-image', '#');
                $full_page_background.fadeOut('fast');
              }

              background_image = false;
            }
          });

          $('.switch-sidebar-mini input').change(function() {
            $body = $('body');

            $input = $(this);

            if (md.misc.sidebar_mini_active == true) {
              $('body').removeClass('sidebar-mini');
              md.misc.sidebar_mini_active = false;

              $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

            } else {

              $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

              setTimeout(function() {
                $('body').addClass('sidebar-mini');

                md.misc.sidebar_mini_active = true;
              }, 300);
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function() {
              window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function() {
              clearInterval(simulateWindowResize);
            }, 1000);

          });
        });
      });
    </script>
</body>

</html>