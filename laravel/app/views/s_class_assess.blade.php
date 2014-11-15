@extends('header_student')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ประเมินการสอน</h1>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width= "5%">ข้อที่ </th>
			<th>หัวข้อการประเมิน</th>
           <th width= "18%"></th>
          </tr>
        </thead>
		<tbody>
      <form action = "{{url('student/set_class_assess/'.$id)}}" method="get">
		<?php
			$i=1;
			if($result!=''){
				foreach($result as $key=>$data){	
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$key.'</td>';
             echo '<td>
             <div>';
                for($n=1;$n<=5;$n++){
                  echo '<label class="radio-inline"><input type="radio"  name="score'.($i-1).'" value="'.$n.'">'.$n.'</label>';
                }
              echo '    
              </div></td>';  
   	 
					echo '</tr>';
					 $i++;
				}
			}
		?>
    <input type="hidden" name="num" value="{{$i-1}}">
      

        </tbody>
        
      </table>
    </div>


<div class="line_col12 col-sm-12"></div>
    <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
  <button type="submit" class="btn btn-success" id="submit" >บันทึก</button>
    </div>
      </form >
<div class="line_col12 col-sm-12"></div>
	
	
  </div>
</div>

@stop