<html>
<head>
	<meta charset="UTF-8">
	<link href="../css/css/bootstrap.css" rel="stylesheet">
	<script src="../css/jquery-2.1.1.min.js"></script>
	<script src="../css/js/bootstrap.min.js"></script>

<style>
	table,th,td
	{
		border:1px solid black;
		border-collapse:collapse;
	}
</style>
</head>
<body>

<h1>Test Format Login</h1>
<?php
	$url = $_REQUEST['url'];
	$id = array(		
				"tes t",
				"tes",
				"ทดสอบ",
				"test~",
				"test",
				"test",
				"test",
				"tester",
				"Test01",
				"test"						
		);
	$pass = array(
				"12345",
				"1234",
				"1234",
				"1234",
				"123",
				"123 4",
				"1234~",
				"123456789",
				"123456",
				"1234"
		);
	$test = array(		
				"false",
				"false",
				"false",
				"false",
				"false",
				"false",
				"false",
				"true",
				"true",
				"true"				
	);	
	//echo $url.'?id='.$id[0].'&pass='.$pass[0];
	$numf=0;
	$numt=0;
	for($i=0;$i<10;$i++){
		$data = array(		
				'id'=>$id[$i],
				'pass'=>$pass[$i]
	);	
		$data_return = json_decode(post_to_ws($url,$data));
		if(isset($data_return->{'status'})&&$data_return->{'status'} != $test[$i] ){
			$numf++;
			echo "false";
		}
		else if(isset($data_return->{'status'})&&$data_return->{'status'} == $test[$i] ){
			$numt++;
			echo "true";
		}
		else{
			$numf++;
			echo "false";
		}
		echo "<br>";

	}
	echo "false = ".$numf;
	echo "<br>";
	echo "true = ".$numt;

?>
<br>
<br>
<table style="width:300">
	<tr>
		<td>
			Status
		</td>
		<td>
			Status statusDetails
		</td>
	</tr>
	<!-- SELECT ZONE -->
	<tr>
			<td>false</td>		<td>รูปแบบการ id password ไม่ถูกต้อง</td>
	</tr>
	
	<tr>
			<td>true</td>		<td>รูปแบบการ id password ถุกต้อง</td>
	</tr>
	
	<!-- END SELECT ZONE -->

	
</table>
<?php
function post_to_ws($url ,array $data)
{
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	
	return $result;
}
?>