<?php
require_once './config.php';
require_once './lv.php';


session_start();

	$cn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
	mysqli_set_charset($cn,'utf8');
	$sql = "SELECT id FROM buyer_login WHERE user_id = '".$_GET['user_id']."'";
	
	$result = mysqli_query($cn,$sql);
	$row = mysqli_fetch_assoc($result);
	mysqli_close($cn);

	$pr = get_pr($_GET['id']);
	
	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql="UPDATE shop_sell_product SET buy_quantity = buy_quantity + ".$_GET['buy_quantity']." WHERE id = ".$_GET['id'];
	
	$sid = $_GET['id'];
	$sql = "SELECT * FROM shop_sell_product a INNER JOIN shop_product b ON a.product_id = b.id WHERE a.product_id = $sid;";
	$rsl = mysqli_query($cn, $sql);
	$srow = mysqli_fetch_assoc($rsl);
	$price = $srow['price_cut'];
	$quantity = $_GET['buy_quantity'];
	$uid = $row['id'];
	$shop = $row['shop_id'];

	$sql = "INSERT INTO buyer_buy_product(product_id,shop_id,user_id,quantity,buy_price) VALUES('$sid','$shop','$uid','$quantity','$price');";
	

	mysqli_query($cn,$sql); 
	mysqli_close($cn);

	$point = $pr['sell_point']*$_GET['buy_quantity'];
	

	$cn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB);
	mysqli_set_charset($cn,'utf8');	
	$sql = "SELECT MAX(id) AS id FROM point;";
	$rsl = mysqli_query($cn, $sql);
	$rows = mysqli_fetch_assoc($rsl);
	$id = $rows['id'];
	$uid = $row['id'];
	$id++;
	$sql="INSERT INTO point(id,user_id, get_point) VALUES ($id,'$uid',$point)";
	$rsl = mysqli_query($cn, $sql);
	$sql = "SELECT point FROM buyer_list WHERE id = $uid;";
	$rsl = mysqli_query($cn, $sql);
	$rows = mysqli_fetch_assoc($rsl);
	$mpoint =  $rows['point'];
	$mpoint = $mpoint + $point;
	$sql="UPDATE buyer_list SET point = $mpoint WHERE id = $uid;";
	$rsl = mysqli_query($cn, $sql);

	$sql = "SELECT rank FROM buyer_list WHERE id = $uid";
	$rsl = mysqli_query($cn, $sql);
	$rows = mysqli_fetch_assoc($rsl);
	$mrank =  $rows['rank'];
	$mrank++;
	$sql="UPDATE buyer_list SET rank = $mrank WHERE id = $uid;";
	$rsl = mysqli_query($cn, $sql);

	

	mysqli_query($cn,$sql); 
	mysqli_close($cn);
	$ex_exp = 100*$_GET['buy_quantity'];
	//echo $ex_exp;
	$st = get_status($_GET['user_id']);

	$exp = status_set($st['exp']+$ex_exp);
	

	

	set_status($st['user_id'],$exp[0],$exp[1],$ex_exp);

	header('Location:./s_login.php');

	function get_pr($id){

	  $cn = mysqli_connect('localhost','root','','hew');
	    mysqli_set_charset($cn,'utf8');
	  $sql = "SELECT * from shop_sell_product WHERE id = $id;";
	  
	  $result = mysqli_query($cn, $sql);
	  $row = mysqli_fetch_assoc($result);
	  mysqli_close($cn);
	  return $row;
    
	} 

?>
