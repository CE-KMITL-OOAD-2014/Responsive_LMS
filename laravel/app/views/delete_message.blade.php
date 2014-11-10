@extends('header_teacher')

@section('body')

<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header ">
      <h1>ข้อความ</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อเรื่อง</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" disabled value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">ข้อความจาก</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" disabled value="">
				</div>
			 <label class="col-sm-2 control-label">วันที่ได้รับข้อความ</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control" disabled value="">
				</div>
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-8">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled></textarea>
				</div>
			</div>
			<div class="form-group ">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled></textarea>
				</div>
				<label class="col-sm-1 control-label" >ตอบกลับ</label>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-8">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled></textarea>
				</div>
			</div>
			<div class="form-group ">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder="" disabled></textarea>
				</div>
				<label class="col-sm-1 control-label" >ตอบกลับ</label>
			</div>
			
          </div>
        </div>
      </div>
	  
      <div class="col-lg-12">
        <div class="panel panel-danger">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
            <textarea rows="3" class="form-control" ></textarea>
          </div>
        </div>
      </div>
	 <div class="line_col12 col-lg-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-trash"></span> ลบ</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop