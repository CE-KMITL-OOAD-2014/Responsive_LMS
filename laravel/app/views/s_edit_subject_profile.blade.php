@extends('header_student')
@section('body')


<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ข้อมูลรายวิชา เศรษฐศาสตร์เพื่อธุรกิจ</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียดวิชา</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อวิชา</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" value="เศรษฐศาสตร์เพื่อธุรกิจ">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รหัสวิชา</label>
				<div class="col-sm-10">
				  <input type="text"  class="form-control"  value="90401009">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียดวิชา</label>
				<div class="col-sm-10">
			  	 <textarea rows="4" style="resize: vertical" class="form-control" placeholder="กรุณาระบุรายละเอียดของวิชา"></textarea>
				</div>
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop