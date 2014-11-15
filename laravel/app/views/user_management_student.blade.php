@extends('header_student')
@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>จัดการผู้ใช้งานระบบ</h1>
  </div>    
  <ul class="nav nav-tabs" id="admintab">
    <li class="active"><a href="#waitting"  data-toggle="tab">จัดการข้อมูลส่วนตัว</a></li>
    <li><a href="#edit"  data-toggle="tab">เปลี่ยนรหัสผ่าน</a></li>
    
  </ul>

  <div class="tab-content">
    <?php
      $tmp=unserialize(Cookie::get('user',null));
      if($tmp->getStatus()=='9'){
        $type='admin';
      }
      else if($tmp->getStatus()=='1'){
        $type='teacher';
      }
      else if($tmp->getStatus()=='0'){
        $type='student';
      }
      else{
        return Redirect::to('/');
      }
        
    ?>
    <div class="tab-pane active" id="waitting">
    <form class="form-horizontal" method="post" action="{{ url('user_management/waitting/'.$type) }}"> 
      <div class="form-group"></div>
      <!-- start-->
  <?php

				$tmp=unserialize(Cookie::get('user',null));
				$user=Student::getFromID($tmp->getID());
				?>
			 <div class="form-group">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
                <input type="text" name="username" class="form-control" disabled value="{{ $user->getUsername() }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">รหัสประจำตัว</label>
              <div class="col-sm-4">
                <input type="text" name="id_student" class="form-control" disabled value="{{ $user->getId_student() }}">
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
                <input type="text" disabled name="birthday_at" class="form-control mydate"  value="{{$user->getBirthday_at()}}">
              </div>
             <label class="col-sm-2 control-label">เพศ</label>
              <div class="col-sm-4">
                <label class="radio-inline">
                  <input type="radio" disabled name="sex" value="0" {{ $user->getSex()=='0'?'checked':''}} >
                  ชาย</label>
                <label class="radio-inline">
                  <input type="radio" disabled name="sex" value="1" {{ $user->getSex()=='1'?'checked':''}}>
                  หญิง </label>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">สถานที่ศึกษา</label>
              <div class="col-sm-4">
                <input type="text" disabled name="academy" class="form-control"  value="{{ $user->getAcademy()}}">
              </div>
              <label class="col-sm-2 control-label">ปีที่เข้าศึกษา</label>
              <div class="col-sm-4">
                <input type="text" disabled name="yearadmission" class="form-control"  value="{{ $user->getYearadmission()}}">
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
                  <input type="radio" disabled name="student_status" value="0" {{ $user->getStudent_status()=='0'?'checked':''}} >
                  เรียน</label>
                <label class="radio-inline">
                  <input type="radio" disabled name="student_status" value="1" {{ $user->getStudent_status()=='1'?'checked':''}} >
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
  <!--  stop-->
  <div class="form-group">
        <div class="col-sm-12 text-center">
      <button type="submit" id="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
    </form>
    </div>
    
    <div class="tab-pane" id="edit">
    <form class="form-horizontal" method="post" action="{{ url('user_management/edit/'.$type) }}"> 
    <div class="col-lg-12">  
      <div class="form-group"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">รหัสผ่านใหม่</label>
        <div class="col-sm-4">
          <input type="password" id="password" name="password" class="form-control"  value="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">ยืนยันรหัสผ่านใหม่</label>
        <div class="col-sm-4">
          <input type="password" id="confirm_password" name="confirm_password" class="form-control"  value="">
        </div>
      </div>    
    </div>
    

    <div class="form-group">
        <div class="col-sm-12 text-center">
      <button type="submit" id="submitPass"class="btn btn-success">บันทึก</button>
        </div>
    </div>
    
    </form>
    </div>
  </div>
  </div>
</div>
<script>
$('#submitPass').prop('disabled',true);
$('#password,#confirm_password').keyup(function(event){
  if($('#password').val()==$('#confirm_password').val() && $('#password').val().length>0){
    $('#submitPass').prop('disabled',false);
  }
  else{
    $('#submitPass').prop('disabled',true);
  }
 });
$('#password,#confirm_password').focusout(function(event){
  if($('#password').val()==$('#confirm_password').val() && $('#password').val().length>0){
    $('#submitPass').prop('disabled',false);
  }
  else{
    $('#submitPass').prop('disabled',true);
  }
 });
</script>
@stop