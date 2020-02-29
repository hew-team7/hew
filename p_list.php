<?php
$cn = mysqli_connect('localhost', 'root', '', 'hew_07');
mysqli_set_charset($cn, 'utf8');

// 現在出品されている商品
$now = date('Y-m-d');
$sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date >= '$now';";
$result = mysqli_query($cn, $sql);
$nlists = array();
while ($rows = mysqli_fetch_assoc($result)) {
  $nlists[] = $rows;
}
array_multisort(array_map("strtotime", array_column($nlists, "close_date")), SORT_ASC, $nlists);

if(isset($_POST['search1'])){
  if(!($_POST['add1'] == "")){
    $add1 = $_POST['add1'];
    $add1 = '%' . $add1 . '%';
    $sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date >= '$now' AND address1 LIKE '$add1';";
  }
  if(!($_POST['add2'] == "")){
    $add2 = $_POST['add2'];
    $add2 = '%' . $add2 . '%';
    $sql .= " AND address1 LIKE '$add2';";
  }
  $result = mysqli_query($cn, $sql);
  $nlists = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $nlists[] = $rows;
  }
}

if(isset($_POST['search2'])){
  if(!($_POST['pend'] == "")){
    $pend = $_POST['pend'];
    $pend = '%' . $pend . '%';
    $sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date >= '$now' AND close_date LIKE '$pend';";
  }
  $result = mysqli_query($cn, $sql);
  $nlists = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $nlists[] = $rows;
  }
}


// 掲載終了した商品
$sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date < '$now';";
$result = mysqli_query($cn, $sql);
$elists = array();
while ($rows = mysqli_fetch_assoc($result)) {
  $elists[] = $rows;
}
array_multisort(array_map("strtotime", array_column($elists, "close_date")), SORT_DESC, $elists);

if(isset($_POST['search3'])){
  if(!($_POST['add3'] == "")){
    $add3 = $_POST['add1'];
    $add3 = '%' . $add3 . '%';
    $sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date < '$now' AND address1 LIKE '$add1';";
  }
  if(!($_POST['add4'] == "")){
    $add4 = $_POST['add4'];
    $add4 = '%' . $add4 . '%';
    $sql .= " AND address1 LIKE '$add4';";
  }
  $result = mysqli_query($cn, $sql);
  $elists = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $elists[] = $rows;
  }
}

if(isset($_POST['search4'])){
  if(!($_POST['pend'] == "")){
    $epend = $_POST['pend'];
    $epend = '%' . $pend . '%';
    $sql = "SELECT c.name AS sname,b.name AS pname,price_cut,sell_quantity,buy_quantity,close_date,address1,address2 FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id INNER JOIN shop_list c ON a.shop_id = c.id WHERE close_date < '$now' AND close_date LIKE '$pend';";
  }
  $result = mysqli_query($cn, $sql);
  $elists = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    $elists[] = $rows;
  }
}
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
          Creative Tim
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
          <li class="nav-item active">
            <a class="nav-link" href="./p_list.php">
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
            <a class="navbar-brand" href="javascript:;">商品一覧</a>
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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">現在出品中の商品一覧</h4>
                  <p class="card-category">現在売られている商品の一覧</p>
                </div>
                <div class="card-body">
                  <form action="./p_list.php" method="POST" class="navbar-form">
                    <div class="row a">
                      <h5 class="card-title aa">都道府県・市町村で絞る</h5>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">都道府県</label>
                          <input type="text" name="add1" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">市町村</label>
                          <input type="text" name="add2" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <button type="submit" name="search1" class="btn btn-primary pull-right">検索</button>
                    </div>
                    <div class="row a">
                      <h5 class="card-title aa">掲載終了日で絞る<small>(※表の掲載終了日と同じ形式で入力してください)</small></h5>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">掲載終了日</label>
                          <input type="text" name="pend" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <button type="submit" name="search2" class="btn btn-primary pull-right">検索</button>
                    </div>
                  </form>
                  <h5>
                    <?php if((isset($_POST['add1'])) && !($_POST['add1'] == "")): ?>
                      検索条件：
                      <?php echo $_POST['add1']; ?>
                    <?php endif ?>
                    <?php if((isset($_POST['add2'])) && !($_POST['add2'] == "")): ?>
                      <?php echo $_POST['add2']; ?>
                    <?php endif ?>
                    <?php if((isset($_POST['pend'])) && !($_POST['pend'] == "")): ?>
                      検索条件：<?php echo $_POST['pend']; ?>
                    <?php endif ?>
                  </h5>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>店舗名</th>
                        <th>商品名</th>
                        <th>販売価格</th>
                        <th>販売数</th>
                        <th>売上数</th>
                        <th>掲載終了日</th>
                        <th>詳細</th>
                      </thead>
                      <tbody>
                        <?php foreach ($nlists as $nlist) : ?>
                          <tr>
                            <td><?php echo $nlist['sname']; ?></td>
                            <td><?php echo $nlist['pname']; ?></td>
                            <td><?php echo $nlist['price_cut']; ?></td>
                            <td><?php echo $nlist['sell_quantity']; ?></td>
                            <td><?php echo $nlist['buy_quantity']; ?></td>
                            <td class="text-primary"><?php echo $nlist['close_date']; ?></td>
                            <td>詳細</td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">掲載終了の商品一覧</h4>
                  <p class="card-category">掲載が終了された商品の一覧</p>
                </div>
                <div class="card-body">
                  <form action="./p_list.php" method="POST" class="navbar-form">
                    <div class="row a">
                      <h5 class="card-title aa">都道府県・市町村で絞る</h5>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">都道府県</label>
                          <input type="text" name="add3" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">市町村</label>
                          <input type="text" name="add3" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <button type="submit" name="search3" class="btn btn-primary pull-right">検索</button>
                    </div>
                    <div class="row a">
                      <h5 class="card-title aa">掲載終了日で絞る<small>(※表の掲載終了日と同じ形式で入力してください)</small></h5>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">掲載終了日</label>
                          <input type="text" name="epend" class="form-control" autocomplete="off">
                        </div>
                      </div>
                      <button type="submit" name="search4" class="btn btn-primary pull-right">検索</button>
                    </div>
                  </form>
                  <h5>
                    <?php if((isset($_POST['add3'])) && !($_POST['add3'] == "")): ?>
                      検索条件：
                      <?php echo $_POST['add3']; ?>
                    <?php endif ?>
                    <?php if((isset($_POST['add4'])) && !($_POST['add4'] == "")): ?>
                      <?php echo $_POST['add4']; ?>
                    <?php endif ?>
                    <?php if((isset($_POST['epend'])) && !($_POST['epend'] == "")): ?>
                      検索条件：<?php echo $_POST['epend']; ?>
                    <?php endif ?>
                  </h5>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>店舗名</th>
                        <th>商品名</th>
                        <th>販売価格</th>
                        <th>販売数</th>
                        <th>売上数</th>
                        <th>掲載終了日</th>
                        <th>詳細</th>
                      </thead>
                      <tbody>
                        <?php foreach ($elists as $elist) : ?>
                          <tr>
                            <td><?php echo $elist['sname']; ?></td>
                            <td><?php echo $elist['pname']; ?></td>
                            <td><?php echo $elist['price_cut']; ?></td>
                            <td><?php echo $elist['sell_quantity']; ?></td>
                            <td><?php echo $elist['buy_quantity']; ?></td>
                            <td class="text-primary"><?php echo $elist['close_date']; ?></td>
                            <td>詳細</td>
                          </tr>
                        <?php endforeach ?>
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