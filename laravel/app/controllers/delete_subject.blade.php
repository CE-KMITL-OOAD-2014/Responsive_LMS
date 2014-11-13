@extends('header_admin')

@section('body')




<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดนักศึกษา</h1>
    </div>
    <form class="form-horizontal" action="{{ url('delete_subject') }}" method="post">
	 
      <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
            <div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" value="{{$subj->getID()}}">
              <label class="col-sm-2 control-label">รหัสวิชา</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="id_subject" value="{{$subj->getId_subject()}}">
              </div>
              <label class="col-sm-2 control-label">ชื่อวิชา</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="name" value="{{$subj->getName()}}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">กลุ่ม</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="group" value="{{$subj->getGroup()}}">
              </div>
        <label class="col-sm-2 control-label">ห้องเรียน</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="room" value="{{$subj->getRoom()}}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">ตึก</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="build" value="{{$subj->getBuild()}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">เวลาเรียน</label>
              <label class="col-sm-1 control-label">เริ่ม</label> 
              <div class="col-sm-2">
                  <input type="time" class="form-control" name="start_at" value="{{$subj->getStart_at()}}">
              </div>
              <label class="col-sm-1 control-label">ถึง</label> 
              <div class="col-sm-2">
                    <input type="time" class="form-control" name="end_at" value="{{$subj->getEnd_at()}}">
              </div>
              <label class="col-sm-1 control-label">วัน</label> 
              <div class="col-sm-2">
                  <select class="form-control" name="day" >
                    <option value="0" >อาทิตย์</option>
            <option value="1" {{$subj->getDay()=='1'?'selected':''}}  >จันทร์</option>
            <option value="2" {{$subj->getDay()=='2'?'selected':''}} >อังคาร</option>
            <option value="3" {{$subj->getDay()=='3'?'selected':''}} >พุทธ</option>
            <option value="4" {{$subj->getDay()=='4'?'selected':''}} >พฤหัสษบดี</option>
            <option value="5" {{$subj->getDay()=='5'?'selected':''}} >ศุกร์</option>
            <option value="6" {{$subj->getDay()=='6'?'selected':''}} >เสาร์</option>
                  </select>
              </div>
            </div>   
      <div class="form-group" >
              <label class="col-sm-2 control-label">ข้อมูลรายวิชา</label>
              <div class="col-sm-10">
                <textarea rows="4" style="resize: vertical" name="detail_thai" class="form-control" >{{$subj->getDetail_thai()}}</textarea>
              </div>
            </div> 
      <div class="form-group">
              <label class="col-sm-2 control-label">ข้อมูลรายวิชา(ENG)</label>
              <div class="col-sm-10">
                <textarea rows="4" style="resize: vertical" name="detail_eng" class="form-control" >{{$subj->getDetail_eng()}}</textarea>
              </div>
            </div>
  
          </div>
        </div>
      </div>
      
      
      <div class="line_col12 col-lg-12"></div>
      <div class="col-lg-12">
        <div class="panel panel-danger">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
            <textarea rows="3" id="detail"class="form-control" name="detail_delete" ></textarea>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12 text-center">
        	<button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
          <button type="submit" class="btn btn-success" >ยืนยันการลบผู้ใช้งาน</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $("textarea").prop('disabled',true);
  $("input").prop('disabled',true);
  $("#id").prop('disabled',false);
  $("#detail").prop('disabled',false);
</script>
@stop