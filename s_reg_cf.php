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
$code = $_SESSION['code'];
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
  $sql = "SELECT MAX(id) AS id FROM shop_plofile;";
	$rsl = mysqli_query($cn, $sql);
	$row = mysqli_fetch_assoc($rsl);
	$kid = $row['id'];
	$kid++;
  $sql2 = "INSERT INTO shop_plofile(shop_id) VALUES($kid,'$id');";
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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>店舗登録</title>
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

  <div class="wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-7 i">
            <div class="card">
              <div class="card-header card-header-success">
                <h4 class="card-title" style="text-align: center;">入力情報確認</h4>
                <p class="card-category"></p>
              </div>
              <form action="./s_reg_cf.php" method="POST">
                <div class="card-body">
                  <div class="table-responsive">
                    <label class="z" style="margin: 30px 0 10px 0; font-size: 1.2em;">メールアドレス/ユーザーID/パスワード</label>
                    <table class="table">
                      <tr>
                        <td>メールアドレス</td>
                        <td><?php echo $mail; ?></td>
                      </tr>
                      <tr>
                        <td>ユーザーID</td>
                        <td><?php echo $id; ?></td>
                      </tr>
                      <tr>
                        <td>パスワード</td>
                        <td><?php echo $lpass; ?></td>
                      </tr>
                    </table>

                    <label class="z" style="margin: 20px 0 10px 0; font-size: 1.2em;">店舗の基本情報</label>
                    <table class="table">
                      <tr>
                        <td>店舗名</td>
                        <td><?php echo $name; ?></td>
                      </tr>
                      <tr>
                        <td>店舗名(フリガナ)</td>
                        <td><?php echo $kname; ?></td>
                      </tr>
                    </table>

                    <label class="z" style="margin: 20px 0 10px 0; font-size: 1.2em;">店舗の住所</label>
                    <table class="table">
                      <tr>
                        <td>電話番号</td>
                        <td><?php echo $tel; ?></td>
                      </tr>
                      <tr>
                        <td>郵便番号</td>
                        <td>〒<?php echo $code; ?></td>
                      </tr>
                      <tr>
                        <td>都道府県,市町村</td>
                        <td><?php echo $paddr; ?></td>
                      </tr>
                      <tr>
                        <td>番地・号・マンション</td>
                        <td><?php echo $addr; ?></td>
                      </tr>
                    </table>

                    <label class="z" style="margin: 20px 0 10px 0; font-size: 1.2em;">収入のお振込先の情報</label>
                    <table class="table">
                      <tr>
                        <td>銀行名</td>
                        <td><?php echo $bname; ?></td>
                      </tr>
                      <tr>
                        <td>支店名/支店コード</td>
                        <td><?php echo $branch; ?></td>
                      </tr>
                      <tr>
                        <td>口座番号</td>
                        <td><?php echo $bnumber; ?></td>
                      </tr>
                    </table>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 offset-lg-2">
                      <input type="submit" value="入力した内容を修正する" name="ng"  class="btn btn-success waves-effect waves-light">
                    </div>
                    <div class="col-lg-2 offset-lg-2">
                      <input type="submit" value="入力した内容で登録する" name="ok"  class="btn btn-success waves-effect waves-light">
                    </div>
                  </div>
                </div>
              </form>
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