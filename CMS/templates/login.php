<?php include "header.php";?>

		<div class ="container">
				<form id="loginForm" class = "form-signin" action = "phpsecured.php" method="post">
        <!--<form id="loginForm" class = "form-signin" action = "phpsecured.php" method="post">-->
						<h2 class = "form-signin-heading">Login:</h2>
              <?php if (isset($_GET) && $_GET['username']){
                  echo "<p>Incorrect password for user: ".$_GET['username']."</p>";}?>
	            <label for = "userName" class = "sr-only">Username:</label>
							<input name = "userName" id = "userName" class = "form-control" placeholder = "Username" required autofocus>
							<label for = "userPass" class = "sr-only">Password:</label>
							<input name = "userPass" type = "password" id = "userPass" class = "form-control" placeholder = "Password" required>
							<button class = "btn btn-lg btn-primary btn-block" type = "submit">Log in</button>
			 </form>
		</div>
<?php include "footer.php"; ?>
