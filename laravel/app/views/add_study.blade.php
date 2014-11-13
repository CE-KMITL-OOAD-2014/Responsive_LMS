@extends('header_teacher')

@section('body')
    <?php
  $day=array('อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสฯ','ศุกร์','เสาร์');
  $daynow = date('w'); 

   $dayTmp=$subj->getDay()-$daynow;
   if($dayTmp<=0){
      $dayTmp = 7+$dayTmp;
   }
  $tmpSubjects = $subj->getAllSubjectFromStudent();
  $i=0;
  $dateTmp = new DateTime(date("Y-m-d"));
  $dateTmp->modify("+".$dayTmp ." day");
  $date_next = $dateTmp->format("d/m/Y");
?>

<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">

    <div class="page-header">
      <h1>จัดการการเรียน</h1>
    </div> 
    <form class="form-horizontal"  action=""  method="post" onsubmit="" id="">         
	  <div class="col-lg-12">
        <div class="panel panel-success">
          <div class="panel-heading">รายละเอียด</div>
          <div class="panel-body">
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่ประกาศ</label>
				<div class="col-sm-10">
				  <input type="text" name="date_at" class="form-control mydate" value="{{date("d/m/Y");}}">
				</div>
			</div>
			<div class="form-group">
			 <label class="col-sm-2 control-label">วันที่เรียน</label>
              <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" class="change" name="change" value="0" checked >
                  วันเวลาปกติ ({{$day[$subj->getDay()]}} {{substr($subj->getStart_at(),0,5);}} - {{substr($subj->getEnd_at(),0,5);}})</label>
                <label class="radio-inline">
                  <input type="radio" class="change" name="change" value="1">
                  เปลี่ยนวัน - เวลา </label>
              </div>
            </div>  
            <div class="form-group move">
             	<label class="col-sm-2 control-label">ย้ายไปวันที่</label>
              		<label class="col-sm-1 control-label">เริ่ม</label> 
              		<div class="col-sm-2">
               			<input type="time" id="start_at" class="form-control edit" name="start_at" value="{{substr($subj->getStart_at(),0,5);}}">
              		</div>
             		 <label class="col-sm-1 control-label">ถึง</label> 
             		 <div class="col-sm-2">
                   		 <input type="time" id="end_at" class="form-control edit" name="end_at" value="{{substr($subj->getEnd_at(),0,5);}}">
              		 </div>
              		<label class="col-sm-1 control-label">วัน</label> 
             		  <div class="col-sm-2">
              		<select class="form-control edit" id="day" name="day" >
              			<option value="0"  {{$subj->getDay()=='0'?'selected':''}}  >อาทิตย์</option>
						<option value="1" {{$subj->getDay()=='1'?'selected':''}}  >จันทร์</option>
						<option value="2" {{$subj->getDay()=='2'?'selected':''}} >อังคาร</option>
						<option value="3" {{$subj->getDay()=='3'?'selected':''}} >พุธ</option>
						<option value="4" {{$subj->getDay()=='4'?'selected':''}} >พฤหัสษบดี</option>
						<option value="5" {{$subj->getDay()=='5'?'selected':''}} >ศุกร์</option>
						<option value="6" {{$subj->getDay()=='6'?'selected':''}} >เสาร์</option>
              		</select>
              </div>
	          </div>
            @foreach ($tmpSubjects as $tmp)
            <div class="form-group move">
            	@if ($i == '0')
            		 <label class="col-sm-2 control-label">ช่วงเวลาที่ย้ายไม่ได้</label>
				@else
					<label class="col-sm-2 control-label"></label>
				@endif
			
				<div class="col-sm-4">
			  		 <label class="col-sm-2 control-label">วิชา</label>
			  		 <div class="col-sm-8">
			  		 		<input type="text" class="form-control" disabled name="name" value="{{$tmp->getName()}}">
			  		 </div>
				</div>
			</div>   
			<div class="form-group move">
              <label class="col-sm-offset-1 col-sm-2 control-label">เริ่ม</label> 
              <div class="col-sm-2">
               		<input type="time" class="form-control" disabled name="start_at" value="{{$tmp->getStart_at()}}">
              </div>
              <label class="col-sm-1 control-label">ถึง</label> 
              <div class="col-sm-2">
                    <input type="time" class="form-control" disabled name="end_at" value="{{$tmp->getEnd_at()}}">
              </div>
              <label class="col-sm-1 control-label">วัน</label> 
              <div class="col-sm-2">
              		<input type="text" class="form-control" disabled name="day" value="{{$day[$tmp->getDay()]}}">
              </div>
            </div>   
            <?php $i++ ?>
            @endforeach
			<div class="form-group">
			 <label class="col-sm-2 control-label">รายละเอียด</label>
				<div class="col-sm-10">
			  	 <textarea rows="4" style="resize: vertical" class="form-control" id="detail" name="detail" placeholder="กรุณาระบุรายละเอียดของการเปลี่ยนแปลงวันเรียน"></textarea>
				</div>
			</div>   
          </div>
        </div>
      </div>
	<div class="line_col12 col-sm-12"></div>
	 <div class="col-lg-12 text-center">
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
     </div>
	<div class="line_col12 col-sm-12"></div>
    </form>
  </div>
</div>
<script type="text/javascript">
var day = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสฯ','ศุกร์','เสาร์'];
var daynow = {{$daynow}};
var getDay = {{$subj->getDay()}};
var dayTmp = getDay-daynow ;
if(dayTmp<=0){
  dayTmp=7+dayTmp;
}
var date = Date.parse('{{date("Y-m-d")}}');
var date_next_tmp = date + dayTmp*23*60*60*1000;
date_next_tmp = new Date(date_next_tmp);
var date_next=date_next_tmp.getDate()+'/'+(date_next_tmp.getMonth()+1)+'/'+date_next_tmp. getFullYear();
$('.move').hide();
$('#detail').html('เรียนตามปกติ วัน{{$day[$subj->getDay()]}} ที่ {{$date_next}} เวลา {{substr($subj->getStart_at(),0,5);}} - {{substr($subj->getEnd_at(),0,5);}}');
$('.change').click(function(){
  getDay = $('#day').val();
  dayTmp = getDay-daynow ;
  if(dayTmp<=0){
    dayTmp=7+dayTmp;
  }
  date_next_tmp = date + dayTmp*23*60*60*1000;
  date_next_tmp = new Date(date_next_tmp);
  date_next=date_next_tmp.getDate()+'/'+(date_next_tmp.getMonth()+1)+'/'+date_next_tmp. getFullYear();
	if($(this).val()=='0'){
		$('.move').hide();
		$('#detail').html('เรียนตามปกติ วัน {{$day[$subj->getDay()]}} ที่ {{ $date_next}} เวลา {{substr($subj->getStart_at(),0,5);}} - {{substr($subj->getEnd_at(),0,5);}}');
	}
	else{		
		$('.move').show();
		$('#detail').html('ย้ายไปเรียน วัน'+day[$('#day').val()]+' ที่ '+date_next+' เวลา '+$('#start_at').val() +' - '+$('#end_at').val() );

	}
});
$('.edit').change(function(){
    getDay = $('#day').val();
  dayTmp = getDay-daynow ;
  if(dayTmp<=0){
    dayTmp=7+dayTmp;
  }
  date_next_tmp = date + dayTmp*23*60*60*1000;
  date_next_tmp = new Date(date_next_tmp);
  date_next=date_next_tmp.getDate()+'/'+(date_next_tmp.getMonth()+1)+'/'+date_next_tmp. getFullYear();
		$('#detail').html('ย้ายไปเรียนวัน '+day[$('#day').val()]+' ที่ '+date_next+' เวลา '+$('#start_at').val() +' - '+$('#end_at').val() );
});
</script>
@stop