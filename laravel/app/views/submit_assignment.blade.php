@extends('header_teacher')

@section('body')

<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>รายการงานที่ส่ง</h1>
    </div>
    
    <div class="panel panel-default">
    <div class="panel-body">
    <div class="input-group col-lg-12">
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data" value="show_data_01" checked>
        <span class="glyphicon glyphicon-ok-sign green"></span>งานที่ตรวจแล้ว</label>
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data" value="show_data_02" checked>
        <span class="glyphicon glyphicon-info-sign yellow "></span>งานที่กำลังตรวจ</label>
      <label class="checkbox-inline">
        <input type="checkbox" id="show_data" value="show_data_03" checked>
        <span class="glyphicon glyphicon-remove-sign red"></span>งานที่ยังไม่ตรวจ</label>
	  <span class="input-group-btn">
        <button class="btn btn-success" type="button" onclick="search_cata();">ค้นหา</button>
      </span> 
		
    </div>  
    </div>
    </div>

      



    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%" >Status</th>
            <th>วันที่ส่งงาน </a></th>
            <th>รหัสงาน </a></th>
            <th>หัวข้อ</th>
            <th>รหัสนักศึกษา</th>
			<th>หมายเหตุ</th>
            <th width="8%"></th>
          </tr>
        </thead>
		<tbody>

        </tbody>
      </table>
    </div>

	
	
  </div>
</div>

@stop