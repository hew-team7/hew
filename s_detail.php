<?php
$cn = mysqli_connect('localhost', 'root', '', 'hew');
mysqli_set_charset($cn, 'utf8');

// 店舗情報
$id = $_GET['id'];
$sql = "SELECT * FROM shop_list INNER JOIN shop_login ON shop_list.id = shop_login.id WHERE shop_list.id = '$id';";
$sresult = mysqli_query($cn, $sql);
$srow = mysqli_fetch_assoc($sresult);

// 出品商品情報
$now = date('Y-m-d');
$sql = "SELECT * FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id WHERE a.shop_id = '$id' AND a.close_date >= '$now';";
$result = mysqli_query($cn, $sql);
while ($rows = mysqli_fetch_assoc($result)) {
  $nlists[] = $rows;
}

// 登録商品情報
$sql = "SELECT * FROM shop_product WHERE shop_id = '$id';";
$result = mysqli_query($cn, $sql);
while ($rows = mysqli_fetch_assoc($result)) {
  $plists[] = $rows;
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>管理者 | 店舗一覧</title>
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
          HELOSS
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="./a_top.php">
              <i class="material-icons">dashboard</i>
              <p>TOP</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./b_list.php">
              <i class="material-icons">person</i>
              <p>購入者一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./p_list.php">
              <i class="material-icons">fastfood</i>
              <p>商品一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./l_list.php">
              <i class="material-icons">emoji_food_beverage</i>
              <p>店舗側商品通知一覧</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./s_list.php">
              <i class="material-icons">store_mall_directory</i>
              <p>店舗一覧</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./r_list.php">
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
            <a class="navbar-brand" href="javascript:;">店舗一覧</a>
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

      <div class="content">
        <div class="container-fluid">
        <a href="./s_list.php" class="btn btn-primary btn-round"><i class="material-icons">navigate_before</i>一覧に戻る</a>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title "><?php echo $srow['shop_id']; ?></h4>
                  <p class="card-category"> 管理用ID：<?php echo $srow['id']; ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" style="text-align: center;">
                      <tbody>
                        <tr>
                          <td class="text-primary">ID</td>
                          <td><?php echo $srow['id']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-primary">店舗ID</td>
                          <td><?php echo $srow['shop_id']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-primary">店舗名</td>
                          <td><?php echo $srow['name']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-primary">郵便番号・住所</td>
                          <td>〒<?php echo $srow['postal_code']; ?>　<?php echo $srow['address1'] . $srow['address2']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-primary">電話番号・メールアドレス</td>
                          <td><?php echo $srow['tel']; ?>　<?php echo $srow['mail']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-primary">登録日</td>
                          <td><?php echo $srow['registration_date']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">出品商品一覧</h4>
                  <p class="card-category"> 現在出品されている商品一覧</p>
                </div>
                <div class="card-body">
                  <div class="row">
                  <?php if(isset($nlists)): ?>
                  <?php foreach ($nlists as $nlist) : ?>
                    <div class="col-md-4 e">
                      <div class="card card-profile" style="width: 250px;">
                        <div class="card-avatar card-header-warning card-header">
                          <i class="material-icons">restaurant</i>
                        </div>
                        <div class="card-body">
                          <h6 class="card-category text-gray"><?php echo $nlist['maker_name']; ?></h6>
                          <h4 class="card-title"><?php echo $nlist['product_name']; ?></h4>
                          <p class="card-description">販売価格：<?php echo number_format($nlist['price_cut']); ?>円<br>
                            販売数：<?php echo $nlist['sell_quantity']; ?>点<br>
                            売上数：<?php echo $nlist['buy_quantity']; ?>点<br>
                            賞味期限：<?php echo $nlist['expiration_date']; ?><br>
                            掲載開始日：<?php echo $nlist['paste_date']; ?></p>
                        </div>
                        <div class="card-footer" style="border-top: solid 1px #f2f2f2;">
                          <div class="stats">
                            <p>掲載終了日：<?php echo $nlist['close_date']; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                  <?php else: ?>
                    <h4 class="card-title aaa">現在、出品されている商品はありません。</h4>
                  <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">登録商品一覧</h4>
                  <p class="card-category"> 現在登録されている商品一覧</p>
                </div>
                <div class="card-body">
                  <div class="row">
                  <?php if(isset($plists)): ?>
                  <?php foreach ($plists as $plist) : ?>
                    <div class="col-md-4 e">
                      <div class="card card-profile" style="width: 250px;">
                        <div class="card-avatar card-header-success card-header">
                          <i class="material-icons">restaurant</i>
                        </div>
                        <div class="card-body">
                          <h6 class="card-category text-gray"><?php echo $plist['maker_name']; ?></h6>
                          <h4 class="card-title"><?php echo $plist['product_name']; ?></h4>
                          <p class="card-description">価格：<?php echo number_format($plist['price']); ?>円</p>
                        </div>
                        <div class="card-footer" style="border-top: solid 1px #f2f2f2;">
                          <div class="stats">
                            <p>登録日：<?php echo $plist['create_at']; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                  <?php else: ?>
                    <h4 class="card-title aaaa">現在、登録されている商品はありません。</h4>
                  <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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