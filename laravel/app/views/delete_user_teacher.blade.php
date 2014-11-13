@extends('header_admin')

@section('body')



<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดอาจารย์</h1>
    </div>
    <form class="form-horizontal" method="post" action="{{ url('admin_delete/teacher') }}">    
       <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
      <div class="form-group">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
                <input type="text" name="username" class="form-control" value="{{ $user->getUsername() }}">
              </div>
              <label class="col-sm-2 control-label">password</label>
              <div class="col-sm-4">
                <input type="password" name="password" class="form-control" value="">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="title" class="form-control"  value="{{ $user->getTitle() }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="name" class="form-control"  value="{{ $user->getName() }}">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" name="surname" class="form-control"  value="{{ $user->getSurname() }}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อที่ใช้แสดงบนเว็บ</label>
              <div class="col-sm-4">
                <input type="text" name="name_user" class="form-control"  value="{{ $user->getName_user() }}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">E-mail</label>
              <div class="col-sm-4">
                <input type="text" name="email" class="form-control"  value="{{ $user->getEmail() }}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">โทรศัพท์</label>
              <div class="col-sm-4">
                <input type="text" name="telephone" class="form-control"  value="{{ $user->getTelephone() }}">
              </div>
            </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">ห้องพัก</label>
              <div class="col-sm-4">
                <input type="text" name="room" class="form-control"  value="{{ $user->getRoom() }}">
              </div>
            </div>  
      <div class="form-group">
              <label class="col-sm-2 control-label">ประวัติการศึกษา</label>
              <div class="col-sm-10">
                <textarea rows="3" name="history" style=" resize: vertical" class="form-control">{{ $user->getHistory() }}</textarea>
              </div>
            </div>  
      <div class="form-group">
              <label class="col-sm-2 control-label">ประสบการณ์</label>
              <div class="col-sm-10">
                <textarea rows="3" name="experience" style=" resize: vertical" class="form-control">{{ $user->getExperience() }}</textarea>
              </div>
            </div>  
          </div>
        </div>
      </div>
      <div class="line_col12 col-lg-12"></div>
      <div class="col-lg-12">
        <div class="panel panel-danger">
          <div class="panel-heading" >รายละเอียด</div>
          <div class="panel-body">
            <textarea rows="3" id="detail" class="form-control" name="detail_delete">{{$user->getDetail_delete()}}</textarea>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12 text-center">
        	<button type="button" class="btn btn-primary" onclick="location.href='{{url('admin/user_teacher')}}'"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
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
