<html>
<head>
	<meta charset="UTF-8">
	<link href="../css/css/bootstrap.css" rel="stylesheet">
	<link href="../css/css/tn_css.css" rel="stylesheet">
	<script src="../css/jquery-2.1.1.min.js"></script>
	<script src="../css/js/bootstrap.min.js"></script>

	<title> </title>
</head>
<body>
	
<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">LMS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">จัดการผู้ใช้งาน <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="user_teacher.php">ระบบจัดการอาจารย์</a></li>       
            <li><a href="user_student.php">ระบบจัดการนักศึกษา</a></li>     
			<li><a href="user_admin.php">ระบบจัดการAdmin</a></li>  				
          </ul>
        </li>
		<li class="active"><a href="subject.php">ระบบจัดการวิชา</a></li>
		<li class=""><a href="relationship.php">ระบบจัดการความสัมพันธ์</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="user_management.php">จัดการข้อมูลส่วนตัว</a></li>      
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- Wrap all page content here -->
<div id="wrap"> 
  <!-- Begin page content -->
  <div class="container">
    <div class="page-header">
      <h1>เพิ่มนักศึกษาในวิชา</h1>
    </div>
	
 
    <div class="input-group col-lg-6"> <span class="input-group-addon">ใส่ข้อมูลที่ต้องการค้นหา</span>
      <input type="text" class="form-control" placeholder="ค้นหาจาก รหัสนักศึกษา ชื่อ นามสกุล คณะ ภาควิชา" id="search-input">
      <span class="input-group-btn">
      <button class="btn btn-success" type="button" onclick="search_ma();">ค้นหา</button>
    </span> 
	</div>
	
    <div class="input-group col-lg-6"></div>
	  
    <div class="panel panel-default" style="background-color:RGBA(255,255,255,0.5); margin-top:20px">
      <div class="panel-body">
        <div class="col-lg-2">
          <div id="outline_count_mem" class="input-group input-group-sm"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>&nbsp; จำนวนนักศึกษา</span>
            <div class="form-control" id="count_mem"> 0</div>
            <span class="input-group-addon">คน</span> </div>
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
			<th width="3%"></th> 
            <th>รหัสนักศึกษา</th>
			<th>คำนำหน้าชื่อ </th>
            <th>ชื่อ </th>
            <th>นามสกุล </th>     
			<th>คณะ </th>   
			<th>ภาควิชา </th>   
			
          </tr>
        </thead>
        <tbody>
          <tr> 
			<td><input type="checkbox" ></td>
            <td>53011285</td>
			<th>นาย</th>
            <td>สุชาติ</td>
            <td>ชาติเจริญ</td>
			<td>วิศวกรรมศาสตร์</td>
			<td>คอมพิวเตอร์</td>
          </tr>
          <tr>
			<td><input type="checkbox" ></td>
            <td>54010684</td>
			<th>นาง</th>
            <td>มาลี</td>
            <td>ลูกแมวเหมียว</td>  
			<td>วิศวกรรมศาสตร์</td>
			<td>คอมพิวเตอร์</td>
          </tr>
          <tr>  
			<td><input type="checkbox" ></td>
            <td>55010248</td>
			<th>นาย</th>
            <td>สมชาย</td>
            <td>ชายชาติทหาร</td>    
			<td>วิศวกรรมศาสตร์</td>
			<td>คอมพิวเตอร์</td>	
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
	  <button type="button" class="btn btn-primary" onclick="history.back();"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>     
      <button class="btn btn-success" onClick=""><span class="glyphicon glyphicon-plus"></span> เพิ่มนักศึกษา</button>
    </div>
<div class="line_col12 col-sm-12"></div>
	
	
  </div>
</div>


</body>
</html>
