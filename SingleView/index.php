<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
		<title>Single View Vulnerability</title>
		<!-- Load boostrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Load sign in CSS-->
		<link href="css/signin.css" rel="stylesheet">
</head>
<body>
		<div class ="container">
			<!-- 	<form id="loginForm" class = "form-signin" action = "phpvulnerable.php" method="post"> -->
      <form id="loginForm" class = "form-signin" action = "phpsecured.php" method="post">
						<h2 class = "form-signin-heading">Login:</h2>
              <?php if ($_GET['username']){
                  echo "<p>Incorrect password for user: ".$_GET['username']."</p>";}?>
	            <label for = "userName" class = "sr-only">Username:</label>
							<input name = "userName" id = "userName" class = "form-control" placeholder = "Username" required autofocus>
							<label for = "userPass" class = "sr-only">Password:</label>
							<input name = "userPass" type = "password" id = "userPass" class = "form-control" placeholder = "Password" required>
							<button class = "btn btn-lg btn-primary btn-block" type = "submit">Log in</button>
			 </form>
		</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
