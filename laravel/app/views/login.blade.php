<html>
<head>
	<meta charset="UTF-8">
	<link href="../css/css/bootstrap.css" rel="stylesheet">
	<link href="../css/css/tn_login.css" rel="stylesheet">
	<script src="../css/jquery-2.1.1.min.js"></script>
	<script src="../css/js/bootstrap.min.js"></script>


</head>
<body>

 
 <div class="container">
  <div class="login">
  
    <table width="100%" border="0" cellpadding="00" cellspacing="0">
	  <tr>
		<td align="center"></td>
	  </tr>
	</table>
	  <form action="{{ url('/action_login') }}" method="post">
      <p><input type="Username" name="user_id" value="" placeholder="Username" ></p>
      <p><input type="Password" name="user_password" value="" placeholder="Password"></p>   
	  <br>
      <input type="submit"  value="Login" >
	  </form> 

  </div>
</div>



</body>
</html>