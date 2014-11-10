@extends('header_teacher')

@section('body')

<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ใบลา</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">รหัสนักศึกษา</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" value="">
				</div>
			 <label class="col-sm-2 control-label">วันที่</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อ</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" value="">
				</div>
			 <label class="col-sm-2 control-label">นามสกุล</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">หมายเหตุ</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder=""></textarea>
				</div>			
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เอกสาร</label>

			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-ok"></span> อนุมัติ</button>
	  <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-remove"></span> ไม่อนุมัติ</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop