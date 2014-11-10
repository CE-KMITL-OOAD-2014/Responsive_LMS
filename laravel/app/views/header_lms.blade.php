<html>
<head>
	<meta charset="UTF-8">
	<link href="{{ asset('css/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/css/tn_css.css') }}" rel="stylesheet">
	<script src="{{ asset('css/jquery-2.1.1.min.js') }}"></script>
	<script src="{{ asset('css/js/bootstrap.min.js') }}"></script>

	<title> </title>
</head>
<body>
	<?php
    if(!isset($active)){
      $active=array('','');
    }
  ?>
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
      <a class="navbar-brand {{$active[0]}}" href="{{ url('/') }}">LMS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="{{$active[1]}}"><a href="{{ url('/teacher/user_management') }}">จัดการข้อมูลส่วนตัว</a></li>      
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div>
  @yield('body')
</div>
</body>
</html>
