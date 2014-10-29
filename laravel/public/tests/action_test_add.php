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

<h1>Test Format add student</h1>
<?php
	$url = $_REQUEST['url'];
	$id = array(		
				"55011234",
				"55011234",
				"55011234",
				"55011234",
				"55011234",
				"550114abc",
				"40000000",
				"5501012",
				"60011234~",
				"abcdefg"
							
		);
	$identification_number = array(
				"1101500705451",
				"123456789101",
				"abc0000000000",
				"56204874891414564",
				"บัตรประชาชน",
				"1101500705451",
				"1101500705451",
				"1101500705451",
				"1101500705451",
				"1101500705451"
			
		);
	$title = array(
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย",
				"นาย"
			
		);
	$name = array(		
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ",
				"ทดสอบ"
							
		);
	$surname = array(		
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง",
				"ทดลอง"
							
		);
	$date = array(		
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993",
				"10/10/1993"
							
		);
	$sex = array(		
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1"
							
		);
	$year_study = array(		
				"2014",
				"2014",
				"2014",
				"2014",
				"2014",
				"2014",
				"2014",
				"2014",
				"2014",
				"2014"
							
		);		
	$status_s = array(		
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1",
				"1"			
	);	
	$faculty = array(		
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์",
				"วิศวะกรรมศาสตร์"			
	);	
	$Department = array(		
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์"			
	);
	$Branch = array(		
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์",
				"คอมพิวเตอร์"			
	);
	$teacher = array(		
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย",
				"สมชาย"			
	);
	$test = array(		
				"true",
				"false",
				"false",
				"false",
				"false",
				"false",
				"false",
				"false",
				"false",
				"false"				
	);
	//echo $url.'?id='.$id[0].'&pass='.$pass[0];
	$numf=0;
	$numt=0;
	for($i=0;$i<10;$i++){
		$data = array(		
				'id'=>$id[$i],
				'identification_number'=>$identification_number[$i],
				'title'=>$title[$i],
				'name'=>$name[$i],
				'surname'=>$surname[$i],
				'date'=>$date[$i],
				'sex'=>$sex[$i],
				'year_study'=>$year_study[$i],
				'status_s'=>$status_s[$i],
				'faculty'=>$faculty[$i],
				'Department'=>$Department[$i],
				'Branch'=>$Branch[$i],
				'teacher'=>$teacher[$i]

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
			<td>false</td>		<td>รูปแบบการ add student ไม่ถูกต้อง</td>
	</tr>
	
	<tr>
			<td>true</td>		<td>รูปแบบการ add student ถุกต้อง</td>
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