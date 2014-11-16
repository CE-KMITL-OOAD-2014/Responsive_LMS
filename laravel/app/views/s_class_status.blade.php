@extends('header_student')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>สถานะขณะเรียน</h1>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width= "5%">ข้อที่ </th>
			<th>สถานะ</th>
            <th width= "8%"></th>
          </tr>
        </thead>
		<tbody>
          <?php
			$i=1;
			if($result!=''){
				foreach($result as $key=>$data){	
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$key.'</td>';
                              echo '<td><button type="submit" class="btn btn-success" id="submit" onclick="location.href=\' '.url("student/set_class_status/".$id."/".($i-1)).' \'">เลือกสถานะ</button> </td>'; 
					echo '</tr>';
					 $i++;
				}
			}
		?>
          
        </tbody>
        
      </table>
    </div>


<div class="line_col12 col-sm-12"></div>
    <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
    </div>
<div class="line_col12 col-sm-12"></div>
	
	
  </div>
</div>

@stop