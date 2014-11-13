@extends('header_student')
@section('body')

<?php
	$id_subj=unserialize(Cookie::get('subject',null));
	if($id_subj!=null){
		$tmp= Subject::getFromID($id_subj);
	}
	echo $tmp->toString();
	
	//echo $tmp->$studentsTmp[0]->{'id_student'};
	//echo "<br>";
	//echo $tmp->getStudents();
?>

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ข้อมูลรายวิชา {{ $subj->getName() }}</h1>
    </div>
  <div class="col-lg-12">
   <div class="panel panel-success">

	<div class="panel-heading">รายละเอียด {{ $subj->getId_subject() }} </div>
	
	<div class="panel-body">
	 <div class="form-group">  
        &nbsp&nbsp {{ $subj->getDetail_thai() }}
		<br><br>
		&nbsp&nbsp {{ $subj->getDetail_eng() }}
	       
     </div>
    </div>
   </div>
  </div>
</div>


</body>
</html>
@stop