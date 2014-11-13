@extends('header_admin')
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
				$user=Admin::getFromID($tmp->getID());
				?>
				<div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="username" name="username" disabled value="{{$user->getUsername()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" id="title" name="title"  class="form-control"  value="{{$user->getTitle()}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" id="name" name="name" class="form-control"  value="{{$user->getName()}}">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" id="surname" name="surname" class="form-control"  value="{{$user->getSurname()}}">
              </div>
            </div>	
			<div class="form-group">
              <label class="col-sm-2 control-label">E-mail</label>
              <div class="col-sm-4">
                <input type="text" id="email" name="email" class="form-control"  value="{{$user->getEmail()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">โทรศัพท์</label>
              <div class="col-sm-4">
                <input type="text" id="telephone" name="telephone"  class="form-control"  value="{{$user->getTelephone()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">ตำแหน่ง</label>
              <div class="col-sm-4">
                <input type="text" id="position" name="position"  class="form-control"  value="{{$user->getPosition()}}">
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