@extends('header_teacher')

@section('body')
<?php
	$date_at=$absent->getDate_at();
	if($date_at!=''){
		$year = substr($date_at, 0, 4);
		$year  = $year + 543;
		$month = substr($date_at, 5, 2);
		$day = substr($date_at, 8, 2);
		$date = $day."-".$month."-".$year;
	}
?>
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ใบลา</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">รหัสนักศึกษา</label>
				<div class="col-sm-4">
				  <input type="hidden" class="form-control" value="">
				  <input type="text" class="form-control" disabled value="{{ $absent->getId_student() }}">
				</div>
			 <label class="col-sm-2 control-label">วันที่ลา</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $date }}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อ</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $absent->getName_student() }}">
				</div>
			 <label class="col-sm-2 control-label">นามสกุล</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $absent->getSurname_student() }}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">หมายเหตุ</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical"disabled  class="form-control" placeholder="">{{ $absent->getDetail() }}</textarea>
				</div>			
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เอกสาร</label>
			 <div class="col-sm-10">
				@if($absent->getId_doc()!='0')
				  <button type="button" class="form-control" onclick="location.href='{{url('/teacher/download_file_absent/'.$absent->getID())}}'" >
				  	Download File("{{$absent->getName_file()}}")
				 @else
				  		<label class="control-label">ไม่มีไฟล์</label>
				 @endif
				 </div>	
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button type="button" class="btn btn-success" onclick="location.href='{{url('teacher/action_approve/'.$absent->getID() )}}'" ><span class="glyphicon glyphicon-ok"></span> อนุมัติ</button>
	  <button type="button" class="btn btn-success" onclick="location.href='{{url('teacher/action_unapprove/'.$absent->getID() )}}'"><span class="glyphicon glyphicon-remove"></span> ไม่อนุมัติ</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop