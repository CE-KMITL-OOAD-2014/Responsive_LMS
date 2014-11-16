@extends('header_student')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>คะแนน</h1>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>งานที่ </th>
			<th>รหัสงาน</th>
            <th>คะแนน</th>
			<th>รายละเอียดคะแนน</th>
          </tr>
        </thead>
		<tbody>
		<?php
		//var_dump($sc);
			for ($i=0;$i<count($sc);$i++) {
					  $date_at=$sc[$i]->{'created_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
	    			  echo '<tr>'.   
	    			 ' <td class=" text-center">'.($i+1).'</td>'
	    			
	    			 			   .' <td>'.$sc[$i]->{'id_assignment'}.'</td>

								 	<td>'.(($sc[$i]->{'status_score'}=='0')?$sc[$i]->{'score'}:'ไม่กำหนดคะแนน').'</td>
						            <td>'.$sc[$i]->{'detail_score'}.'</td>    									
							        </tr>    ';
				}
			/*$i=1;
			if($result!=''){
				foreach($result as $key=>$data){	
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$key.'</td>';
						echo '<td>'.$data.'</td>';			 
					echo '</tr>';
					 $i++;
				}
			}*/
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