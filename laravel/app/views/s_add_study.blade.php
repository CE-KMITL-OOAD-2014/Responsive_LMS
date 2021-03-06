@extends('header_student')

@section('body')


<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>จัดการการเรียน</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่ประกาศ</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control mydate" value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่เปลี่ยนแปลงวันเรียน</label>
				<div class="col-sm-10">
				  <input type="text"  class="form-control mydate" value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
			  	 <textarea rows="4" style="resize: vertical" class="form-control" placeholder="กรุณาระบุรายละเอียดของการเปลี่ยนแปลงวันเรียน"></textarea>
				</div>
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop