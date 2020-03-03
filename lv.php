<?php

//経験値からレベルを求める関数:引数($経験値)->戻り値($row[0]=レベル ,$row[1]=次のレベルまでに必要な経験値)  
function status_set($exp){
	$lv_tb= [ //[レベル,累計経験値]
		[1,0],
		[2,100],
		[3,210],
		[4,330],
		[5,460],
		[6,600],
		[7,750],
		[8,920],
		[9,1110],
		[10,1320],
		[11,1550],
		[12,1800],
		[13,2080],
		[14,2390],
		[15,2730],
		[16,3100],
		[17,3510],
		[18,3960],
		[19,4460],
		[20,5010],
		[21,5620],
		[22,6290],
		[23,7030],
		[24,7840],
		[25,8730],
		[26,9710],
		[27,10790],
		[28,11980],
		[29,13290],
		[30,14730],
		[31,16310],
		[32,18050],
		[33,19960],
		[34,22060],
		[35,24730],
		[36,26910],
		[37,29700],
		[38,32770],
		[39,36150],
		[40,39870],
		[41,43960],
		[42,48460],
		[43,53410],
		[44,58860],
		[45,64860],
		[46,71460],
		[47,78420],
		[48,78720],
		[49,86710],
		[50,95500],


	];

	$lv = 0;
	$i = 0;

	while(1){
		if($lv_tb[$i][1] > $exp){
			$lv = $lv_tb[$i-1][0];
			$leave = $lv_tb[$i][1] - $exp;
			break;
		}
		$i++;
	}

	$row = [$lv,$leave];
	return $row;

}

function set_status($user_id,$lv,$leave,$ex_exp){
	
	$cn = mysqli_connect('localhost','root','','hew');
	mysqli_set_charset($cn,'utf8');	
	$sql="UPDATE buyer_status SET lv = ".$lv." , exp_leave = ".$leave." , exp = exp  + ".$ex_exp." , score = score + 1 WHERE user_id = '".$user_id."'";
	echo $sql;
	mysqli_query($cn,$sql); 
}

function get_status($user_id){

	$cn = mysqli_connect('localhost','root','','hew');
	mysqli_set_charset($cn,'utf8');	
	$sql= "SELECT * FROM buyer_status WHERE user_id = '".$user_id."';";//変える必要あり

	$result = mysqli_query($cn, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
};

?>