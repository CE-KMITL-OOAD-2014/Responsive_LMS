@extends('header_lms')

@section('body')
<?php
	$tmp=unserialize(Cookie::get('user',null));
	echo $tmp->toString();
	
	$id_subj=unserialize(Cookie::get('subject',null));
	$tmp=Subject::getFromID($id_subj);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	//echo $tmp->toString();
?>

<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>เลือกวิชาเรียน</h1>
    </div> 
    <form class="form-horizontal"  method="post" action="{{ url('teacher/action_lms') }}">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">วิชาเรียน</div>
          <div class="panel-body">		
			<div class="form-group">
              <label class="col-sm-2 control-label">วิชา</label>
              <div class="col-sm-10">
                <select class="form-control" name="subject">
				<?php
					for($i=0;$i<count($subjecttmp);$i++){
						echo '<option value="'.$subjecttmp[$i]->getID().'" >'.$subjecttmp[$i]->getName().'</option>';
					}				  
				?>				  
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
      <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-home"></span> เลือก</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>

</body>
</html>
@stop