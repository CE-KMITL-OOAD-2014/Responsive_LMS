@extends('header_admin')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายละเอียดAdmin</h1>
    </div>
    <form class="form-horizontal" method="post" action="{{ url('/admin/add_subject') }}">    
      <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="text" name="username" class="form-control" value="">
              </div>
              <label class="col-sm-2 control-label">password</label>
              <div class="col-sm-4">
                <input type="text" name="password" class="form-control" value="">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="title" class="form-control"  value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" name="name" class="form-control"  value="">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" name="surname" class="form-control"  value="">
              </div>
            </div>	
			<div class="form-group">
              <label class="col-sm-2 control-label">E-mail</label>
              <div class="col-sm-4">
                <input type="text" name="email" class="form-control"  value="">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">โทรศัพท์</label>
              <div class="col-sm-4">
                <input type="text" name="telephone"  class="form-control"  value="">
              </div>
            </div>
          <div class="form-group">
              <label class="col-sm-2 control-label">ตำแหน่ง</label>
              <div class="col-sm-4">
                <input type="text" name="position"  class="form-control"  value="">
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
