<?php

const HOST = 'localhost';
const DB_NAME = 'hew_07';
const DB_USER = 'root';
const DB_PASS = '';

$_SESSION['user_id'] = 'hiraken0817';

if (isset($_POST['content'])) {
	if ($_POST['content'] != '') {
		question_db(HOST,DB_USER,DB_PASS,DB_NAME,$_SESSION['user_id'],$_POST['type'],$_POST['content']);
		header('Location:./b_question_cl.php');
	}
}

function question_db($host,$db_user,$db_pass,$db_name,$user_id,$type,$content){
	$cn = mysqli_connect($host,$db_user,$db_pass,$db_name);
	mysqli_set_charset($cn,'utf8');	
	$sql="INSERT INTO buyer_question(user_id,type,msg) VALUES ('".$user_id."','".$type."','".$content."')";
	mysqli_query($cn,$sql); 
	
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>お問い合せ　｜　購入者</title>
</head>
<body>
	<h2>お問い合せ</h2>
	<h3>お問い合わせ内容</h3>
	<form action="./b_question.php" method="post">
		<table>
			<tr>
				<td><select name="type">
					<option value="0">商品に不備がある</option>
					<option value="1">サイトの不具合について</option>
					<option value="2">登録情報について</option>
					<option value="3">商品代金の支払い・クーポンについて</option>
				</select></td>
			</tr>
			<tr>
				<td>
					<textarea name="content"></textarea>
				</td>
			</tr>
		</table>
		<button>送信</button>
	</form>


	
</body>
</html>