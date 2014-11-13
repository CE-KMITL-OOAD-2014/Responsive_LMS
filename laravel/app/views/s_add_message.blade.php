@extends('header_student')

@section('body')


<?php
	$teachers = array();
	$tmp = array();
	$id_subj=unserialize(Cookie::get('subject',null));
	$subject= Subject::getFromID($id_subj);
	for($i=0;$i<count($subject->getTeachers());$i++){
		$teachers[$i]=$subject->getTeachers()[$i]->getID();
		$tmp[$i]=Teacher::getFromID($teachers[$i]);
	}

?>
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ข้อความ</h1>
    </div> 
    <form class="form-horizontal" method="post" action="{{ url('student/add_message') }}" >         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">ชื่อเรื่อง</label>
				<div class="col-sm-10">
				  <input type="text" name="title" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
              <label class="col-sm-2 control-label">ส่งถึง</label>
              <div class="col-sm-10">
                <select class="form-control" name="receiver" >
				 <?php
					for($i=0;$i<count($teachers);$i++){
						echo '<option value="'.$teachers[$i].'" >'.$tmp[$i]->getName_user().'</option>';
					}			  
				 ?>	
						          
                </select>
              </div>
            </div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
				  <textarea rows="4" name="message" style="resize: vertical" class="form-control" placeholder=""></textarea>
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