<?php
require_once './config.php';
require_once './lv.php';

session_start();

	$_GET['id'] = 2;
	$_GET['user_id'] = 32000001;
	$_GET['buy_quantity'] = 2;
	$pr = get_pr($_GET['id']);
	
	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql="UPDATE shop_sell_product SET buy_quantity = buy_quantity + ".$_GET['buy_quantity']." WHERE id = ".$_GET['id'];
	mysqli_query($cn,$sql); 
	mysqli_close($cn);

	$point = $pr['sell_point']*$_GET['buy_quantity'];

	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql="INSERT INTO point(user_id, get_point) VALUES (".$_GET['user_id'].",".$point.")";

	mysqli_query($cn,$sql); 
	mysqli_close($cn);
	$ex_exp = 100*$_GET['buy_quantity'];
	//echo $ex_exp;
	$st = get_status($_GET['user_id']);

	$exp = status_set($st['exp']+$ex_exp);
	var_dump($exp);

	

	set_status($st['user_id'],$exp[0],$exp[1],$ex_exp);

	header('Location:./s_top.php');

	function get_pr($id){

	  $cn = mysqli_connect('localhost','root','','hew');
	    mysqli_set_charset($cn,'utf8');
	  $sql = "SELECT * from shop_sell_product WHERE id = ".$id;
	  
	  $result = mysqli_query($cn, $sql);
	  $row = mysqli_fetch_assoc($result);
	  mysqli_close($cn);
	  return $row;
    
	} 

?>
