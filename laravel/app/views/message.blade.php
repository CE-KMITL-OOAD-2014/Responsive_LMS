@extends('header_teacher')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>ข้อความ</h1>
    </div>
	<div class="panel panel-default">
    <div class="panel-body">
    <div class="input-group col-lg-12">
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data" value="show_data_01" checked>
        <span class="glyphicon glyphicon-ok-sign green"></span>อ่านแล้ว</label>
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data" value="show_data_02" checked>
        <span class="glyphicon glyphicon-info-sign yellow"></span>ยังไม่ได้อ่าน</label>
    </div>  
    </div>
    </div>
    <div class="form-inline col-lg-12">
      <label class="checkbox-inline">
        <input type="checkbox" id="search_date" value="search_date">
        ค้นหาจากวันที่ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </label>
      <input type="text" class="form-control mydate" id="start_date" placeholder="วันที่เริ่มต้น">
      <input type="text" class="form-control mydate" id="end_date" placeholder="วันที่สิ้นสุด">
    </div>
	
    <div class="input-group col-lg-6"></div>
	  
    <div class="panel panel-default" style="background-color:RGBA(255,255,255,0.5); margin-top:20px">
      <div class="panel-body">
        <div class="col-lg-2">
          <div id="outline_count_mem" class="input-group input-group-sm"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>&nbsp; จำนวนข้อความ</span>
            <div class="form-control" id="count_mem"> 0</div>
            <span class="input-group-addon">ข้อความ</span> </div>
        </div>
      </div>
    </div>

<ul class="pager">
      <li class="previous"><a href="#" onclick=" to_first_page()"><span class="glyphicon glyphicon-step-backward"></span> หน้าแรก</a></li>
      <li id="page_previous_1"><a id="a_previous_1" href="#" onclick=""><span class="glyphicon glyphicon-chevron-left"></span> หน้าก่อนหน้า</a></li>
      <li class="disabled">&nbsp; <a style="cursor:default; border-radius:3px; color:#6A6A6A;" id="page_display_1">หน้าที่ 1 / 6</a> &nbsp; </li>
       <!-- ADD LI HERE -->
      <li><a style=" background:none; border:hidden;height:26px; padding-left:0px">
        <div class="input-group" style="width:135px;z-index:0">
          <input type="text" class="form-control" placeholder="ไปยังหน้าที่" style="height:32px" id="go_page_field">
          <span class="input-group-btn">
          <button class="btn btn-primary" type="button" style="height:32px" id="go_btn" onclick="go_to_page();">ไป</button>
          </span> </div>
        </a></li>
        <!-- END ADD LI HERE -->
        
      <li id="page_next_1"><a id="a_next_1" href="#" onclick="pageinc()">หน้าถัดไป <span class="glyphicon glyphicon-chevron-right"></span></a></li>
      <li class="next"><a href="#" onclick="to_last_page()">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
			<th width="5%" >Status</th>
            <th>วันที่ได้รับข้อความ</th>
            <th>ชื่อเรื่อง </th>
            <th>รายละเอียด </th>
            <th width="8%"></th>
          </tr>
        </thead>
        <tbody>
          <tr>         
			<td class=" text-center"><span class="glyphicon glyphicon-ok-sign green"></span></td>
            <td>30/03/57</td>
            <td>สอบถามการบ้าน</td>
            <td>ถามวิธีการทำในวิชาPrograming</td>     
            <td><div class="btn-group">
                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
                <ul class="dropdown-menu pull-right" role="menu">
                  <li><a href="{{ url('/teacher/replay_message') }}">ตอบข้อความ</a></li>
                  <li><a href="{{ url('/teacher/delete_message') }}">ลบข้อความ</a></li>
                </ul>
              </div></td>
          </tr>
          <tr>
			<td class=" text-center"><span class="glyphicon glyphicon-info-sign yellow"></span></td>
            <td>28/04/57</td>
            <td>สอบถามคะแนนสอบ</td>
            <td>อยากทราบคะแนนสอบกลางภาคของวิชา Programing</td>
            <td><div class="btn-group">
                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">ดำเนินการ <span class="caret"></span> </button>
                <ul class="dropdown-menu pull-right" role="menu">
                  <li><a href="{{ url('/teacher/replay_message') }}">ตอบข้อความ</a></li>
                  <li><a href="{{ url('/teacher/delete_message') }}">ลบข้อความ</a></li>
                </ul>
              </div></td>
          </tr>     
        </tbody>
      </table>
    </div>
    <ul class="pager">
      <li class="previous"><a href="#" onclick=""><span class="glyphicon glyphicon-step-backward"></span> หน้าแรก</a></li>
      <li id="page_previous_1"><a id="a_previous_1" href="#" onclick=""><span class="glyphicon glyphicon-chevron-left"></span> หน้าก่อนหน้า</a></li>
      <li class="disabled">&nbsp; <a style="cursor:default; border-radius:3px; color:#6A6A6A;" id="page_display_1">หน้าที่ 1 / 6</a> &nbsp; </li>
      <li><a style=" background:none; border:hidden;height:26px; padding-left:0px">
        <div class="input-group" style="width:135px;z-index:0">
          <input type="text" class="form-control" placeholder="ไปยังหน้าที่" style="height:32px" id="go_page_field">
          <span class="input-group-btn">
          <button class="btn btn-primary" type="button" style="height:32px" id="go_btn" onclick="go_to_page();">ไป</button>
          </span> </div>
        </a></li>
      <li id="page_next_1"><a id="a_next_1" href="#" onclick="pageinc()">หน้าถัดไป <span class="glyphicon glyphicon-chevron-right"></span></a></li>
      <li class="next"><a href="#" onclick="to_last_page()">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>

<div class="line_col12 col-sm-12"></div>
    <div class="col-lg-12 text-center">
      <button class="btn btn-success" onClick="location.href='{{ url('/teacher/add_message') }}'"><span class="glyphicon glyphicon-envelope"></span> ส่งข้อความ</button>
    </div>
<div class="line_col12 col-sm-12"></div>
	
	
  </div>
</div>


</body>
</html>
@stop