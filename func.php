<?php

/** 購入者に関するSQL */

//*** メールアドレス一覧を呼び出す関数 */
function buyer_mail_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT buyer_list.mail from buyer_list INNER JOIN buyer_login ON buyer_list.id = buyer_login.id;";
  $result = mysqli_query($cn, $sql);
  $marrays = array();
  while ($mrows = mysqli_fetch_assoc($result)) {
    $marrays[] = $mrows;
  }
  mysqli_close($cn);
  return var_dump($marrays);
}

//*** ユーザーIDを一覧を呼び出す関数 */
function buyer_id_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT buyer_login.user_id from buyer_login INNER JOIN buyer_list ON buyer_login.id = buyer_list.id;";
  $result = mysqli_query($cn, $sql);
  $rarrays = array();
  while ($rrows = mysqli_fetch_assoc($result)) {
    $rarrays[] = $rrows;
  }
  mysqli_close($cn);
  return $rarrays;
}



/** 店側に関するSQL */
function shop_mail_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT shop_list.mail from shop_list INNER JOIN shop_login ON shop_list.id = shop_login.id;";
  $result = mysqli_query($cn, $sql);
  $sarrays = array();
  while ($srows = mysqli_fetch_assoc($result)) {
    $sarrays[] = $srows;
  }
  mysqli_close($cn);
  return var_dump($sarrays);
}

//*** ユーザーIDを一覧を呼び出す関数 */
function shop_id_list(){
  $cn = mysqli_connect('localhost','root','','hew_07');
	mysqli_set_charset($cn,'utf8');
  $sql = "SELECT shop_login.shop_id from shop_login INNER JOIN shop_list ON shop_login.id = shop_list.id;";
  $result = mysqli_query($cn, $sql);
  $siarrays = array();
  while ($sirows = mysqli_fetch_assoc($result)) {
    $siarrays[] = $sirows;
  }
  mysqli_close($cn);
  return $siarrays;
}

?>