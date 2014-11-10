@extends('header_teacher')

@section('body')
<?php
	$date_at=$ass->getDate_at();
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
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $date}}">
				</div>
			 <label class="col-sm-2 control-label">รหัสงาน</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="{{ $ass->getId_assignment() }}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">หัวข้อ</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" disabled value="{{ $ass->getTitle() }}">
				</div>
			</div>							
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" class="form-control" disabled placeholder="{{ $ass->getDetail() }}"></textarea>
				</div>
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เอกสาร</label>
				<div class="col-sm-10">
				  <input type="file" class="form-control" disabled value="">
				</div>
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
	 <!--- <button type="button" class="btn btn-success" onclick="location.href='send_assignment.php'"><span class="glyphicon glyphicon-send " ></span> ส่งงาน</button>--->
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop