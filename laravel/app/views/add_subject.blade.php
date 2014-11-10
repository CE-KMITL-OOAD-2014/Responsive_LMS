@extends('header_admin')

@section('body')


<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดวิชา</h1>
    </div>
    <form class="form-horizontal" method="post" action="{{ url('add_subject') }}">   
	
      <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">รหัสวิชา</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="id_subject" value="">
              </div>
              <label class="col-sm-2 control-label">ชื่อวิชา</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="name" value="">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">กลุ่ม</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="group" value="">
              </div>
			  <label class="col-sm-2 control-label">ห้องเรียน</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="room" value="">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">ตึก</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="build" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">เวลาเรียน</label>
              <label class="col-sm-1 control-label">เริ่ม</label> 
              <div class="col-sm-2">
               		<input type="time" class="form-control" name="start_at" value="">
              </div>
              <label class="col-sm-1 control-label">ถึง</label> 
              <div class="col-sm-2">
                    <input type="time" class="form-control" name="end_at" value="">
              </div>
              <label class="col-sm-1 control-label">วัน</label> 
              <div class="col-sm-2">
              		<select class="form-control" name="day">
              			<option value="0" selected>อาทิตย์</option>
						<option value="1">จันทร์</option>
						<option value="2">อังคาร</option>
						<option value="3">พุทธ</option>
						<option value="4">พฤหัสษบดี</option>
						<option value="5">ศุกร์</option>
						<option value="6">เสาร์</option>
              		</select>
              </div>
            </div>   
			<div class="form-group" >
              <label class="col-sm-2 control-label">ข้อมูลรายวิชา</label>
              <div class="col-sm-10">
                <textarea rows="4" style="resize: vertical" name="detail_thai" class="form-control" ></textarea>
              </div>
            </div> 
			<div class="form-group">
              <label class="col-sm-2 control-label">ข้อมูลรายวิชา(ENG)</label>
              <div class="col-sm-10">
                <textarea rows="4" style="resize: vertical" name="detail_eng" class="form-control" ></textarea>
              </div>
            </div>
	
          </div>
        </div>
      </div>
      
      
      <div class="line_col12 col-lg-12"></div>
      <div class="form-group">
        <div class="col-sm-12 text-center">
          <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>     
		  <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
      </div>
    </form>
  </div>
</div>
@stop
