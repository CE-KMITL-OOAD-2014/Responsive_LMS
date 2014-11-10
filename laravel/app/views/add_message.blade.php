@extends('header_teacher')

@section('body')


<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
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
				  <input type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
              <label class="col-sm-2 control-label">ส่งถึง</label>
              <div class="col-sm-10">
                <select class="form-control" >
				  <option value="0"  selected>นักศึกษาทุกคน</option>
                  <option value="1" >อาจารย์</option><!---สำหรับ น.ศ.--->
                  <option value="2" >55011432</option>
				  <option value="3" >55011203</option>
				  <option value="4" >55010875</option>           
                </select>
              </div>
            </div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
				  <textarea rows="4" style="resize: vertical" class="form-control" placeholder=""></textarea>
				</div>
			</div>		  
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-envelope"></span> ส่ง</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop