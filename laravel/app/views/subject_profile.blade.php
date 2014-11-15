@extends('header_teacher')

@section('body')


<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ข้อมูลรายวิชา {{ $subj->getName() }} </h1>
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
 <div class="line_col12 col-sm-12"></div>
    <div class="col-lg-12 text-center">
      <button class="btn btn-success" onClick="location.href='{{ url('/teacher/edit_subject_profile') }}'"><span class="glyphicon glyphicon-wrench"></span> แก้ไขรายละเอียด</button>
    </div>
 <div class="line_col12 col-sm-12"></div>
  </div>
</div>


</body>
</html>
@stop