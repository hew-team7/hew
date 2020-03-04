<?php

require_once('func.php');
require_once('error.php');

$codes = [];

session_start();

if (isset($_POST['check'])) {
  //** メアド、ID、パスワードに関するエラーチェック */
  $mail = $_POST['mail'];
  $id = $_POST['id'];
  $pass = $_POST['pass'];
  //** メアド */
  if ($mail == "") { //** 空白チェック */
    $codes[] = '101';
  } else if (!(filter_var($mail, FILTER_VALIDATE_EMAIL))) { //** 正しいメアドかどうか */
    $codes[] = '102';
  }

  //** ユーザーID */
  if ($id == '') {
    $codes[] = '201'; //*** 空欄の場合、エラーを出す */
  } else {
    $ilists = buyer_id_list();
    foreach ($ilists as $ilist) {
      if ($id == $ilist['user_id']) {
        $codes[] = '202'; //*** これまでに登録されたログインIDと被っている場合、エラーを出す */
      }
    }
  }

  //** パスワード */
  if ($pass == "") { //** 空白かどうか */
    $codes[] = '301';
  } elseif (strlen($pass) < 8) { //** 8文字以上かどうか */
    $codes[] = '302';
  } elseif (!(preg_match("/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i", $pass))) { //** 正しく設定されているか(英数字) */
    $codes[] = '303';
  }


  //** 氏名に関するエラーチェック */
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $kfn = $_POST['kfn'];
  $kln = $_POST['kln'];
  //** 氏名(漢字) */
  if ($fn == "" || $ln == "") { //** 空白かどうか */
    $codes[] = '401';
  }

  //** 氏名(カタカナ) */
  if ($kfn == "" || $kln == "") { //** 空白かどうか */
    $codes[] = '501';
  }


  //** 住所に関するエラーチェック */
  $code = $_POST['zip01'];
  $paddr = $_POST['addr21'];
  $addr = $_POST['addr'];
  //** 郵便番号 */
  if ($code == "") { //** 空白かどうか */
    $codes[] = '601';
  }

  //** 都道府県,市町村 */
  if ($paddr == "") { //** 空白かどうか */
    $codes[] = '701';
  }

  //** 住所 */
  if ($addr == "") { //** 空白かどうか */
    $codes[] = '801';
  }


  //** エラーが一つもない場合セッションに値を入れる */
  if (empty($codes)) {


    $_SESSION['mail'] = $mail;
    $_SESSION['id'] = $id;
    $_SESSION['pass'] = $pass;

    $_SESSION['fn'] = $fn;
    $_SESSION['ln'] = $ln;
    $_SESSION['kfn'] = $kfn;
    $_SESSION['kln'] = $kln;

    $_SESSION['code'] = $code;
    $_SESSION['paddr'] = $paddr;
    $_SESSION['addr'] = $addr;

    //** 銀行口座 */
    if (!($_POST['bname'] == "")) {
      $_SESSION['bname'] = $_POST['bname'];
    }
    if (!($_POST['branch'] == "")) {
      $_SESSION['branch'] = $_POST['branch'];
    }
    if (!($_POST['bnumber'] == "")) {
      $_SESSION['bnumber'] = $_POST['bnumber'];
    }

    header('location:b_reg_cf.php');
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
  <div id="header">
    <img src="./images/logo/698942.png">
  </div>

  <div id="wrapper">
    <!-- End Navbar -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 i">
            <div class="card">
              <div class="card-header card-header-warning">
                <h4 class="card-title" style="text-align: center;">会員登録</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <form action="b_reg_in.php" method="POST">
                  <label class="p" style="margin: 50px 0 10px 0; font-size: 1.2em;">メールアドレス/ユーザーID/パスワード</label>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="bmd-label-floating">メールアドレス<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="mail" autocomplete="off" value="<?php echo isset($_SESSION['mail']) ? $_SESSION['mail'] : (isset($_POST['mail']) ? $_POST['mail'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '101') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '102') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '103') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">ユーザーID<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="id" autocomplete="off" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_POST['id']) ? $_POST['id'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '201') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '202') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">パスワード <span class="red2">※8文字以上の英数字</span><span class="red">必須</span></label>
                        <input type="text" class="form-control" name="pass" autocomplete="off" value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass'] : (isset($_POST['pass']) ? $_POST['pass'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '301') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '302') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php elseif ($code == '303') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <label class="p" style="margin: 50px 0 10px 0; font-size: 1.2em;">ユーザーの基本情報</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">氏名 姓) <span class="red">必須</span></span></label>
                        <input type="text" class="form-control" name="fn" autocomplete="off" value="<?php echo isset($_SESSION['fn']) ? $_SESSION['fn'] : (isset($_POST['fn']) ? $_POST['fn'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '401') : ?>
                            <p class="red2 attention"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">氏名 名) <span class="red">必須</span></span></label>
                        <input type="text" class="form-control" name="ln" autocomplete="off" value="<?php echo isset($_SESSION['ln']) ? $_SESSION['ln'] : (isset($_POST['ln']) ? $_POST['ln'] : ''); ?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">氏名(フリガナ) セイ) <span class="red">必須</span></label>
                        <input type="text" class="form-control" name="kfn" autocomplete="off" value="<?php echo isset($_SESSION['kfn']) ? $_SESSION['kfn'] : (isset($_POST['kfn']) ? $_POST['kfn'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '501') : ?>
                            <p class="red2 attention"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">氏名(フリガナ) メイ) <span class="red">必須</span></label>
                        <input type="text" class="form-control" name="kln" autocomplete="off" value="<?php echo isset($_SESSION['kln']) ? $_SESSION['kln'] : (isset($_POST['kln']) ? $_POST['kln'] : ''); ?>">
                      </div>
                    </div>
                  </div>

                  <label class="p" style="margin: 50px 0 10px 0; font-size: 1.2em;">ユーザーの住所</label>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="bmd-label-floating">郵便番号(ハイフン有)<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="zip01" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr21','addr21');" maxlength="3" autocomplete="off" value="<?php echo isset($_SESSION['code']) ? $_SESSION['code'] : (isset($_POST['zip21']) ? $_POST['zip21'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '601') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label class="bmd-label-floating">都道府県,市町村<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="addr21" autocomplete="off" value="<?php echo isset($_SESSION['paddr']) ? $_SESSION['paddr'] : (isset($_POST['addr21']) ? $_POST['addr21'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '701') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">番地/号/マンション名<span class="red">必須</span></label>
                        <input type="text" class="form-control" name="addr" size="36" autocomplete="off" value="<?php echo isset($_SESSION['addr']) ? $_SESSION['addr'] : (isset($_POST['addr']) ? $_POST['addr'] : ''); ?>">
                        <?php foreach ($codes as $code) : ?>
                          <?php if ($code == '801') : ?>
                            <p class="red2"><?php echo ERROR[$code]; ?></p>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                    </div>
                  </div>

                  <label class="p" style="margin: 50px 0 10px 0; font-size: 1.2em;">支払い情報(クレジットカード情報)</label>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">銀行名</span></label>
                        <input type="text" class="form-control" name="bname" autocomplete="off" value="<?php echo isset($_SESSION['bcode']) ? $_SESSION['bcode'] : (isset($_POST['bcode']) ? $_POST['bcode'] : ''); ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">支店名/支店コード</label>
                        <input type="text" class="form-control" name="branch" value="<?php echo isset($_SESSION['branch']) ? $_SESSION['branch'] : (isset($_POST['branch']) ? $_POST['branch'] : ''); ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">口座番号</label>
                        <input type="text" class="form-control" name="bnumber" value="<?php echo isset($_SESSION['bnumber']) ? $_SESSION['bnumber'] : (isset($_POST['bnumber']) ? $_POST['bnumber'] : ''); ?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 offset-lg-5">
                      <input type="submit" value="確認" class="btn btn-warning waves-effect waves-light" style="margin: 30px 0;" name="check">
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
</body>

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