<html>
<head>
	<meta charset="UTF-8">
	<link href="../css/css/bootstrap.css" rel="stylesheet">
	<script src="../css/jquery-2.1.1.min.js"></script>
	<script src="../css/js/bootstrap.min.js"></script>

	<!-- BEFIRST-IT STYLE FOR POSTCATSAVINGS : E-DOCUMENT -->
<link href="../css/css/befirst_it.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/css/befirst-login.css">
<!-- Add on CSS here vvvv -->
</head>
<body>

<!-- Wrap all page content here -->
<div id="wrap">
<!-- Begin page content -->
 <div class="container">
<!-- POPUP NOTIFICATION
    ========================================-->
	<div class="container marketing" style="margin-top:30px">
	  <div class="col-md-12">
		<div id="formContainer">
		  <!--<form id="login"  method="post" action="action_login.php">-->
		  <form id="login"  action="{{ url('/action_login') }}" method="post">
			<a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
			<input type="text" name="user_id" id="loginEmail" placeholder="Username"/>
			<input type="password" name="user_password" id="loginPass" placeholder="Password" />
			<input type="submit" value="login"/>
			<!--<input type="submit" name="submit" value="login" onclick="form_login()"  />-->
		  </form>
		</div>
		<div class="col-md-12" style="text-align:center;" > <a href="../login/register.php" id="register-btn" class="btn btn-warning" style="display:none;width:288px; color:#fff; border-radius:0px 0px 5px 5px">register</a> </div>
	  </div>
	</div>
 </div>
</div>

</body>
</html>