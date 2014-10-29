@extends('header_admin')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดAdmin</h1>
    </div>
    <form class="form-horizontal" action="{{ url('admin_edit/admin') }}" method="post" >
	
      <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body"> 
			<div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="username" name="username" value="{{$user->getUsername()}}">
              </div>
              <label class="col-sm-2 control-label">password</label>
              <div class="col-sm-4">
                <input type="text" class="form-control"  id="password" name="password" value="">
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
          </div>
        </div>
      </div>
      <div class="line_col12 col-lg-12"></div>
      <div class="form-group">
        <div class="col-sm-12 text-center">
          <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
          <button type="button"  class="btn btn-success" id="edit">แก้ไข</button>
          <button type="button"  class="btn btn-danger" id="cancel">ยกเลิก</button>
		  <button type="submit" class="btn btn-success" id="submit" >บันทึก</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $('#cancel').hide();
  $('#submit').hide();
  $('#edit').show();
  $("input").prop('disabled',true);
  $('#edit').click(function(){
      $("input").prop('disabled',false);
      $('#edit').hide();
        $('#submit').show();
      $('#cancel').show();
  });
  $('#cancel').click(function(){
      $("input").prop('disabled',true);
      $('#cancel').hide();
        $('#submit').hide();
      $('#edit').show();
  });
</script>
@stop