@extends('header_admin')

@section('body')



<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดนักศึกษา</h1>
    </div>
    <form class="form-horizontal"  action="{{ url('admin_delete/student') }}" method="post">
	   <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียดนักศึกษา</div>
          <div class="panel-body">
      <div class="form-group">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
                <input type="text" name="username" class="form-control" value="{{ $user->getUsername() }}">
              </div>
              <label class="col-sm-2 control-label">password</label>
              <div class="col-sm-4">
                <input type="text" name="password" class="form-control" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">รหัสประจำตัว</label>
              <div class="col-sm-4">
                <input type="text" name="id_student" class="form-control" value="{{ $user->getId_student() }}">
              </div>
              <label class="col-sm-2 control-label">อาจารย์ที่ปรึกษา</label>
              <div class="col-sm-4">
                <input type="text" name="adviser" class="form-control"  value="{{ $user->getAdviser() }}">
              </div>
            </div>
      <div class="form-group">
              
        <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="title" class="form-control"  value="{{ $user->getTitle() }}">
              </div>
              <label class="col-sm-2 control-label">ชื่อเล่น</label>
              <div class="col-sm-4">
                <input type="text" name="nickname" class="form-control"  value="{{ $user->getNickname() }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="name" class="form-control"  value="{{ $user->getName() }}">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" name="surname" class="form-control"  value="{{$user->getSurname() }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">วัน/เดือน/ปี เกิด</label>
              <div class="col-sm-4">
                <input type="text" name="birthday_at" class="form-control mydate"  value="{{$user->getBirthday_at()}}">
              </div>
             <label class="col-sm-2 control-label">เพศ</label>
              <div class="col-sm-4">
                <label class="radio-inline">
                  <input type="radio" name="sex" value="0" {{ $user->getSex()=='0'?'checked':''}} >
                  ชาย</label>
                <label class="radio-inline">
                  <input type="radio" name="sex" value="1" {{ $user->getSex()=='1'?'checked':''}}>
                  หญิง </label>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">สถานที่ศึกษา</label>
              <div class="col-sm-4">
                <input type="text" name="academy" class="form-control"  value="{{ $user->getAcademy()}}">
              </div>
              <label class="col-sm-2 control-label">ปีที่เข้าศึกษา</label>
              <div class="col-sm-4">
                <input type="text" name="yearadmission" class="form-control"  value="{{ $user->getYearadmission()}}">
              </div>       
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">คณะ</label>
              <div class="col-sm-4">
                <input type="text" name="faculty" class="form-control"  value="{{ $user->getFaculty()}}">
              </div>
       <label class="col-sm-2 control-label">สถานภาพนักศึกษา</label>
              <div class="col-sm-4">
                <label class="radio-inline">
                  <input type="radio" name="student_status" value="0" {{ $user->getStudent_status()=='0'?'checked':''}} >
                  เรียน</label>
                <label class="radio-inline">
                  <input type="radio" name="student_status" value="1" {{ $user->getStudent_status()=='1'?'checked':''}} >
                  ไม่เรียน </label>
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">ภาควิชา</label>
              <div class="col-sm-4">
                <input type="text" name="department" class="form-control"  value="{{$user->getDepartment()}}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">สาขาวิชา</label>
              <div class="col-sm-4">
                <input type="text" name="major" class="form-control"  value="{{$user->getMajor()}}">
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
            <textarea rows="3" class="form-control" name="detail_delete">{{$user->getDetail_delete()}}</textarea>
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
  $("input").prop('disabled',true);
  $("#id").prop('disabled',false);
</script>
@stop