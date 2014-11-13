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

<h1>Test add student</h1>
<?php
	$urls = $_REQUEST['urls'];
	$urli = $_REQUEST['urli'];
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$id = $_REQUEST['id'];
	$identification_number = $_REQUEST['identification_number'];
	$name = $_REQUEST['name'];
	$surname = $_REQUEST['surname'];
	
	$data = array(		
			'username'=>$username,
			'password'=>$password,
			'id'=>$id,
			'identification_number'=>$identification_number
	);	
	$data_return = json_decode(post_to_ws($urls,$data));
	if(isset($data_return->{'status'})&&$data_return->{'status'} != NULL ){
		echo "can select";
	}
	else {
		echo "can not select";
		echo "<br>";
		$data = array(		
			'username'=>$username,
			'password'=>$password,
			'id'=>$id,
			'identification_number'=>$identification_number,
			'name'=>$name,
			'surname'=>$surname
		);	
		$data_return = json_decode(post_to_ws($urli,$data));
		if(isset($data_return->{'status'})&&$data_return->{'status'} == "true" ){
			echo "can insert";
		}
		else if(isset($data_return->{'status'})&&$data_return->{'status'} == "false"){
			echo "can not insert";
		}
		else{
			echo "error";
		}
		
		
	
	}
	
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
			<td>can select</td>		
			<td>มีข้อมูลอยู่ในฐานข้อมูลแล้ว</td>
	</tr>
	
	<tr>
			<td>can not select</td>		
			<td>ยังไม่มีข้อมูลในฐานข้อมูล</td>
	</tr>
	
	<tr>
			<td>can insert</td>		
			<td>สามารถเพิ่มข้อมูลลงในฐานข้อมูลได้</td>
	</tr>
	
	<tr>
			<td>can not insert</td>		
			<td>ไม่สามารถเพิ่มข้อมูลลงในฐานข้อมูล</td>
	</tr>
	
	<tr>
			<td>error</td>		
			<td>ไม่มีค่า status</td>
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