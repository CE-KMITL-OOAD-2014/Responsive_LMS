@extends('header_student')

@section('body')


<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ส่งงาน</h1>
    </div> 
    <form class="form-horizontal" method="post" action="{{ url('student/add_submit_assignment') }}" enctype="multipart/form-data">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">					
			<div class="form-group">
			 <label class="col-sm-2 control-label">หมายเหตุ</label>
				<div class="col-sm-10">
				  <input type="hidden" name="id_ass" class="form-control" value="{{ $ass->getID() }}">
				  <textarea rows="4" name="detail" style="resize: vertical" class="form-control" placeholder=""></textarea>
				</div>
			</div>	
			<div class="form-group">
			 <label class="col-sm-2 control-label" for="exampleInputFile">เพิ่มเอกสาร</label>
				<div class="col-sm-4">
					<input type="file" name="id_doc">
				</div>   
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-envelope"></span> ส่ง</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop