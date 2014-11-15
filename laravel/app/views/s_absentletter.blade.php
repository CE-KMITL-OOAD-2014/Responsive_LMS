@extends('header_student')
@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายการใบลา</h1>
    </div>
    
    <div class="panel panel-default">
    <div class="panel-body">
    <div class="input-group col-lg-12">
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data_01" value="show_data_01" onclick="search_data();" checked>
        <span class="glyphicon glyphicon-ok-sign green"></span>ใบลาที่อนุมัติแล้ว</label>
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data_02" value="show_data_02" onclick="search_data();" checked>
        <span class="glyphicon glyphicon-info-sign yellow"></span>ใบลาที่กำลังรออนุมัติ</label>
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data_03" value="show_data_03" onclick="search_data();" checked>
        <span class="glyphicon glyphicon-remove-sign red"></span>ใบลาที่ไม่อนุมัติ</label>
    </div>  
    </div>
    </div>


    <div class="panel panel-default" style="background-color:RGBA(255,255,255,0.5); margin-top:20px">
      <div class="panel-body">
        <div class="col-lg-2">
          <div id="outline_count_mem" class="input-group input-group-sm"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>&nbsp; จำนวนใบลา</span>
            <div class="form-control" id="count_mem"> 0</div>
            <span class="input-group-addon">ใบลา</span> </div>
        </div>
      </div>
    </div>

<ul class="pager">
      <li class="previous"><a href="#" onclick=" to_first_page();"><span class="glyphicon glyphicon-step-backward"></span> หน้าแรก</a></li>
      <li id="page_previous_1"><a id="a_previous_1" href="#" onclick="pagePrev();"><span class="glyphicon glyphicon-chevron-left"></span> หน้าก่อนหน้า</a></li>
      <li class="disabled">&nbsp; <a style="cursor:default; border-radius:3px; color:#6A6A6A;" id="page_display_1">หน้าที่ 1 / 6</a> &nbsp; </li>
       <!-- ADD LI HERE -->
      <li><a style=" background:none; border:hidden;height:26px; padding-left:0px">
        <div class="input-group" style="width:135px;z-index:0">
          <input type="text" class="form-control" placeholder="ไปยังหน้าที่" style="height:32px" id="go_page_field_1">
          <span class="input-group-btn">
          <button class="btn btn-primary" type="button" style="height:32px" id="go_btn" onclick="go_to_page1();">ไป</button>
          </span> </div>
        </a></li>
        <!-- END ADD LI HERE -->
        
      <li id="page_next_1"><a id="a_next_1" href="#" onclick="pageNext();">หน้าถัดไป <span class="glyphicon glyphicon-chevron-right"></span></a></li>
      <li class="next"><a href="#" onclick="to_last_page()">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%" >Status</th>
            <th>วันที่ส่งใบลา </th>
            <th>วันที่ลา </th>
            <th>หมายเหตุ</th>
          </tr>
        </thead>
		<tbody id="table_absentletter">
       
        </tbody>
        
      </table>
    </div>
    <ul class="pager">
      <li class="previous"><a href="#" onclick="to_first_page();"><span class="glyphicon glyphicon-step-backward"></span> หน้าแรก</a></li>
      <li id="page_previous_2"><a id="a_previous_2" href="#" onclick="pagePrev();"><span class="glyphicon glyphicon-chevron-left"></span> หน้าก่อนหน้า</a></li>
      <li class="disabled">&nbsp; <a style="cursor:default; border-radius:3px; color:#6A6A6A;" id="page_display_2">หน้าที่ 1 / 6</a> &nbsp; </li>
      <li><a style=" background:none; border:hidden;height:26px; padding-left:0px">
        <div class="input-group" style="width:135px;z-index:0">
          <input type="text" class="form-control" placeholder="ไปยังหน้าที่" style="height:32px" id="go_page_field_2">
          <span class="input-group-btn">
          <button class="btn btn-primary" type="button" style="height:32px" id="go_btn" onclick="go_to_page2();">ไป</button>
          </span> </div>
        </a></li>
      <li id="page_next_2"><a id="a_next_2" href="#" onclick="pageNext();">หน้าถัดไป <span class="glyphicon glyphicon-chevron-right"></span></a></li>
      <li class="next"><a href="#" onclick="to_last_page()">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>

<div class="line_col12 col-sm-12"></div>
    <div class="col-lg-12 text-center">
      <button class="btn btn-success" onClick="location.href='{{ url('/student/s_add_absentletter') }}'"><span class="glyphicon glyphicon-plus"></span> เพิ่มใบลา</button>
    </div>
<div class="line_col12 col-sm-12"></div>

	
	
  </div>
</div>

<script type="text/javascript">
  var lastpage;
  var currentPage; 
  var condition;
  var count_mem;
  currentPage=1;
  search_data();
  function search_data() {
  
        updateValElement();
        $.get('{{ url("student/search_absentletter/search") }}',{condition:condition ,currentPage:currentPage },function(data){
            $('#table_absentletter').html(data);
        });
  }
  function updateValElement(){
    condition={approve:$('#show_data_01').prop("checked")?'1':'0',Pending:$('#show_data_02').prop("checked")?'1':'0',unapprove:$('#show_data_03').prop("checked")?'1':'0'};
      $.get('{{ url("student/search_absentletter/get_lastpage") }}',{condition:condition},function(data){
           lastpage=data;
          $('#page_display_1,#page_display_2').html('หน้าที่ '+currentPage+' / '+lastpage)
       });
      $.get('{{ url("student/search_absentletter/get_count") }}',{condition:condition},function(data){
           count_mem=data;
           $('#count_mem').html(count_mem); 
       });
  }
  function pageNext(){
      if(currentPage<lastpage){
          currentPage++;
          search_data();
      }
  }
  function pagePrev(){
      if(currentPage>1){
          currentPage--;
          search_data();
      }
  }
  function  to_first_page(){
      currentPage=1;
      search_data();
  }
  function  to_last_page(){
      currentPage=lastpage;
      search_data();
  }
  function  go_to_page1(){
      var n= $('#go_page_field_1').val()
      if (n !='' && n>=1 && n<=lastpage){
        currentPage=n;
      }
      search_data();
  }
  function  go_to_page2(){
      var n= $('#go_page_field_2').val()
      if (n !='' && n>=1 && n<=lastpage){
        currentPage=n;
      }
      search_data();
  }
  $('#go_page_field_1').keypress(function(event){
      if(event.keyCode == 13){
          go_to_page1();
      }
  });
  $('#go_page_field_2').keypress(function(event){
      if(event.keyCode == 13){
          go_to_page2();
      }
  });
</script>
@stop