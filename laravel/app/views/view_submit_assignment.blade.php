@extends('header_teacher')

@section('body')
<?php
	$date_at=$sass->getCreated_at();
	$date='';
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
      <h1>งาน</h1>
    </div> 
    <form class="form-horizontal"  action="{{ url('teacher/edit_submit_assignment') }}"  method="post" >         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่</label>
				<div class="col-sm-4">
				  <input type="hidden" name="id" class="form-control" value="{{$sass->getID()}}">
				  <input type="text" class="form-control" disabled value="{{ $date}}">
				</div>
			 <label class="col-sm-2 control-label">รหัสนักศึกษา</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{$sass->getId_student()}}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">หมายเหตุ</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled>{{ $sass->getDetail() }}</textarea>
				</div>
			</div>							
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เอกสาร</label>
				<div class="col-sm-10">
					@if($sass->getId_doc()!='0')
				  <button type="button" class="form-control" onclick="location.href='{{url('/teacher/download_file/'.$sass->getID())}}'" >
				  	Download File("{{$sass->getName_file()}}")
				  	@else
				  		<label class="control-label">ไม่มีไฟล์</label>
				  	@endif
				  </button>
				</div>
			</div>   
          </div>
        </div>
      </div>
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียดคะแนน</div>
          <div class="panel-body">		
			<div class="form-group">
			 <label class="col-sm-2 control-label">คะแนน</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" name="score" value="{{$sass->getScore()}}">
				</div>
				<div class="col-sm-4">
				  <input type="checkbox" name="scstatus" value="1" >   ไม่คิดคะแนน<br>	
				</div>
			 </div>							
			<div class="form-group">
			 <label class="col-sm-2 control-label">หมายเหตุ</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" name="detail_score" class="form-control" placeholder="กรุณาใส่รายละเอียดของคะแนน" >{{$sass->getDetail_score()}}</textarea>
				</div>
			</div>	
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
	  <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-send " ></span> บันทึก</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop