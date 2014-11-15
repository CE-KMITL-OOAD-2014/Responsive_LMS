@extends('header_teacher')

@section('body')



<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>งาน</h1>
    </div> 
    <form class="form-horizontal" method="post" action="{{ url('teacher/add_assignment') }}" >         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">กำหนดส่งงาน</label>
				<div class="col-sm-4">
				  <input type="hidden" name="date_at" class="form-control" value="">
				  <input type="date" name="date_at" class="form-control" value="">
				</div>
			 <label class="col-sm-2 control-label">รหัสงาน</label>
				<div class="col-sm-4">
				  <input type="text" name="id_assignment" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">หัวข้อ</label>
				<div class="col-sm-10">
				  <input type="text" name="title" class="form-control" value="">
				</div>
			</div>							
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
				  <textarea rows="4" name="detail" style="resize: vertical" class="form-control" placeholder=""></textarea>
				</div>
			</div>	 
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-book"></span> สั่งงาน</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop