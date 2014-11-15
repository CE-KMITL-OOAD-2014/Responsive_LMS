@extends('header_teacher')

@section('body')
<?php
	$user= Users::getFromID($mess->getSender());
	$date_at=$mess->getCreated_at();
	if($date_at!=''){
		$year = substr($date_at, 0, 4);
		$year  = $year + 543;
		$month = substr($date_at, 5, 2);
		$day = substr($date_at, 8, 2);
		$time = substr($date_at, 11, 8);
		$date = $day."-".$month."-".$year." ".$time;
	}
?>
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header ">
      <h1>ข้อความ</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อเรื่อง</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" disabled value="{{ $mess->getTitle() }}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">ข้อความจาก</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $user->getname() }}">
				</div>
			 <label class="col-sm-2 control-label">วันที่ได้รับข้อความ</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $date }}">
				</div>
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled>{{ $mess->getMessage() }}</textarea>
				</div>
			</div>
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="location.href='{{url('/teacher/message')}}';"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop