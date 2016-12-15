<?php

/*-----------------------------------------------*
 * Insecure:                                     *
 * Not suppressing error messages                *
 *-----------------------------------------------*/
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	ob_start();
	if(isset($_SESSION)) {
		session_destroy();
	}

	session_start();

	/*---------------------------*
	 * Insecure:                 *
	 *   No validation of input. *
	 *---------------------------*/

	$_SESSION['userName'] = $_POST['userName'];
	$UserName = $_SESSION['userName'];
	$UserPass = $_POST['userPass'];

	/*-----------------------------------------------*
	 * Insecure:                                     *
	 * Direct input of root  user, password, and db  *
	 *-----------------------------------------------*/
	$con = mysqli_connect("localhost", "root", "root","databaseVUL");
	if (!$con)
		echo "failed";

	$grabMe = "SELECT * FROM users WHERE username = '".$UserName."';";
	$result = mysqli_query($con, $grabMe);
	$row = mysqli_fetch_assoc($result);

	/*-------------------------------------------------*
	 * Insecure:                                       *
	 *   Allowing DB to validate true/false statements *
	 *-------------------------------------------------*/
	$grabme2 = "SELECT IF (password = '".$UserPass."', 'true', 'false')
							FROM users
							WHERE username = '".$row['username']."';";
	$result = mysqli_query($con, $grabme2);
	$passRow = mysqli_fetch_assoc($result);

	//Password check
	if ($passRow["IF (password = '".$UserPass."', 'true', 'false')"] == 'true'){
		$url = "dashboard.html";
	}
	else {
		$url = "index.php?username=".$row['username'];
		echo "Bad password for: ". $row['username']. "<br>";
	}

	echo "Username query: ".$grabMe;
	echo "password query: ".$grabme2;
	header('Location: '.$url);


?>
