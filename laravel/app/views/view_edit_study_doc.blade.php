@extends('header_teacher')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>เพิ่มเอกสารการเรียน</h1>
    </div>
    <form class="form-horizontal">
	
      <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อเอกสาร</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" value="">
              </div>     
			  <label class="col-sm-2 control-label">วันที่เพิ่มเอกสาร</label>
              <div class="col-sm-4">
                <input type="date" class="form-control "  value="">
              </div>       
            </div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">คำอธิบาย</label>
				<div class="col-sm-10">
			  	 <textarea rows="4" style="resize: vertical" class="form-control" placeholder="กรุณาระบุรายละเอียดของเอกสารการเรียน"></textarea>
				</div>
			</div>   
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เพิ่มเอกสาร</label>
				<div class="col-sm-4">
					<input type="file" id="exampleInputFile">
				</div>   
			</div>             
          </div>
        </div>
      </div>
      
      
      <div class="line_col12 col-lg-12"></div>
      <div class="form-group">
        <div class="col-sm-12 text-center">
          <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
          <button type="button" class="btn btn-success">แก้ไข</button>
		  <button type="button" class="btn btn-success">บันทึก</button>
        </div>
      </div>
    </form>
  </div>
</div>


</body>
</html>
@stop