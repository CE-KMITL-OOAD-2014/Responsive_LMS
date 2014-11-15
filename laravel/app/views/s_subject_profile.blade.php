@extends('header_student')
@section('body')



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