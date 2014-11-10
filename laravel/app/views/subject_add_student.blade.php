@extends('header_admin')

@section('body')




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
      <button class="btn btn-success" type="button" onclick="search_data();">ค้นหา</button>
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
      <li class="previous"><a href="#" onclick="to_first_page();"><span class="glyphicon glyphicon-step-backward"></span> หน้าแรก</a></li>
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
      <li class="next"><a href="#" onclick="to_last_page();">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
      <th>รหัสนักศึกษา</th>
        <th>คำนำหน้าชื่อ</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>คณะ</th>     
      <th>ภาควิชา</th>   
      <th width="8%"></th> 
          </tr>
        </thead>
        <tbody id="table_student">
       
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
      <li class="next"><a href="#" onclick="to_last_page();">หน้าสุดท้าย <span class="glyphicon glyphicon-step-forward"></span></a></li>
    </ul>


<div class="line_col12 col-sm-12"></div>
  
      <div class="page-header">
        <h1>ตารางแสดงนักศึกษา</h1>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
          <tr>
      <th>รหัสนักศึกษา</th>
        <th>คำนำหน้าชื่อ</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>คณะ</th>     
      <th>ภาควิชา</th>   
      <th width="8%"></th> 
          </tr>
        </thead>
        <tbody>
          <?php
            for($i=0;$i<count($subj->getStudents());$i++){
              echo'
                <tr>   
                <td >'.$subj->getStudents()[$i]->getId_student().'</td>
                <td id="title'.$subj->getStudents()[$i]->getID().'">'.$subj->getStudents()[$i]->getTitle().'</td>
                <td id="name'.$subj->getStudents()[$i]->getID().'">'.$subj->getStudents()[$i]->getName().'</td>
                <td id="surname'.$subj->getStudents()[$i]->getID().'">'.$subj->getStudents()[$i]->getSurname().'</td>
               <td>'.$subj->getStudents()[$i]->getFaculty().'</td>
          <td>'.$subj->getStudents()[$i]->getDepartment().'</td>
          <td><div class="btn-group">
            <button type="button" class="btn btn-primary" onclick="delete_student(\''.$subj->getStudents()[$i]->getID().'\');" id="del'.$subj->getStudents()[$i]->getID().'">ลบออกจากวิชา</button>
            </div></td>
          </tr>


              ';
            }
            
          ?>
                  </tbody>
        </table>
      </div>
  
  </div>
</div>
<div class="line_col12 col-sm-12"></div>
<form class="form-horizontal" method="post" action="{{ url('subject_edit_student') }}">
    <input type="hidden" name="id" value="{{$subj->getID()}}">
    <div id="data">

    </div>
    <div class="col-lg-12 text-center">
      <button type="button" class="btn btn-primary" onclick="location.href='{{url('admin/subject')}}'"><span class="glyphicon glyphicon-circle-arrow-left" ></span> ย้อนกลับไปหน้าก่อนหน้า</button>     
      <button class="btn btn-danger" type="button" onClick="location.reload();">ยกเลิก</button>
      <button class="btn btn-success" type="submit" onClick=""><span class="glyphicon glyphicon-plus"></span>บันทึก</button>
    </div> 
</form>
<script type="text/javascript">
  var lastpage;
  var currentPage; 
  var condition;
  var count_mem;
  var tmp;
  var students = new Array();
  var removestudents = new Array();
  <?php
    for($i=0;$i<count($subj->getStudents());$i++){
      echo 'students.push("'.$subj->getStudents()[$i]->getID().'");';
    }
  ?>
  currentPage=1;
  search_data();
  function search_data() {
        tmp='';
        updateValElement();
        $.get('{{ url("search_student/search_subject_add") }}',{condition:condition ,currentPage:currentPage },function(data){
            $('#table_student').html(data);
            for (var i = 0; i < students.length; i++) { 
               $('#'+students[i]).hide(); 
            }
            for(var i=0;i < removestudents.length;i++){
            //  alert(removestudents[i]);
              $('#del'+removestudents[i]).hide();
            }  
            for (var i = 0; i < students.length; i++) { 
              tmp=tmp+'<input type="hidden" name="students[]" class="form-control" value="'+students[i]+'">';
           }
         $('#data').html(tmp);

           
            
        });
      //updateValElement();
            
  }
  function updateValElement(){
       condition={word:$('#search-input').val()};
      $.get('{{ url("search_student/get_lastpage") }}',{condition:condition},function(data){
           lastpage=data;
           if(currentPage>lastpage){
               currentPage=1;
            }
          $('#page_display_1,#page_display_2').html('หน้าที่ '+currentPage+' / '+lastpage);
       });
      $.get('{{ url("search_student/get_count") }}',{condition:condition},function(data){
           count_mem=data;
           $('#count_mem').html(data); 
       });
           

  }
  function add_student(id){
      students.push(id);
      var index = removestudents.indexOf(id);
      if (index > -1) {
         removestudents.splice(index, 1);
         $('#del'+id).show();
      }
      search_data();
  }
  function delete_student(id){
    if(confirm("ต้องการลบ"+  $('#title'+id).html() +" "+$('#name'+id).html()+" "+ $('#surname'+id).html()+ " ออกจากวิชาใช่หรือไม่?")){
      removestudents.push(id);
      var index = students.indexOf(id);
      if (index > -1) {
         students.splice(index, 1);
      }


    }
     search_data();

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
  $()

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
  $('#search-input').keypress(function(event){
      if(event.keyCode == 13){
          search_data();
          
      }
  });
</script>
@stop
