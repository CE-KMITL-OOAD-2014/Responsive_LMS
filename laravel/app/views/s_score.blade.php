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
			/*for ($i=0;$i<count($sc);$i++) {
					  $date_at=$table_message[$i]->{'created_at'};
					  if($date_at!=''){
							$year = substr($date_at, 0, 4);
							$year  = $year + 543;
							$month = substr($date_at, 5, 2);
							$day = substr($date_at, 8, 2);

							$date_at = $day."-".$month."-".$year;
					  }
	    			  $output.= '<tr>'.   
	    			  (($table_message[$i]->{'status'}=='1')?
	    			 ' <td class=" text-center"><span class="glyphicon glyphicon-ok-sign green"></span></td>':
	    			  '<td class=" text-center"><span class="glyphicon glyphicon-info-sign yellow"></span></td>')
	    			 			   .' <td>'.$date_at.'</td>   
								 	<td>'.$table_message[$i]->{'title'}.'</td>
						            <td>'.$table_message[$i]->{'message'}.'</td>    									
									<td><div class="btn-group">
						             <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
						                <ul class="dropdown-menu pull-right" role="menu">
						  	               <li><a href="'.url('/student/view_message/'.$table_message[$i]->{'ID'}).'">ดูรายละเอียด</a></li>
							               </ul>
							             </div></td>
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