<?php

/*---------------------------------------------------*
 * PHP Trick:                                        *
 * Load a configuration file that specifies whether  *
 *   the current .php file is a production or dev    *
 *   model, and if so, only suppress warnings on     *
 *   live versions of the site.                      *
 *---------------------------------------------------*/
	require_once 'config/secureConfig.php';

	//Change 'development' to 'production' to suppress warnings.
	$config = $config['development'];

	if ($config['db']['error'] == 'true')
	{
		ini_set('display_errors',1);
		ini_set('display_startup_errors',1);
		error_reporting(-1);
	}

	ob_start();
	if(isset($_SESSION)) {
		session_destroy();
	}

	session_start();

	$con = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password']);
	if (!$con)
		echo "failed";
	mysqli_select_db($con, $config['db']['dbname']) or die ("Bad database".mysqli_error());

	/*---------------------------------------------------*
	 * Secure:                                           *
	 * Uses mysqli_real_escape_string to sanatize        *
	 *   query's and removes excess characters/malicious *
	 *   code.                                           *
	 *---------------------------------------------------*/
	$_SESSION['userName'] = $_POST['userName'];
	$UserName = mysqli_real_escape_string($con, $_SESSION['userName']);
	$UserPass = mysqli_real_escape_string($con, $_REQUEST['userPass']);
	$UserName = trim($UserName);
	$UserPass = trim($UserPass);

	/*----------------------------------------------------*
	 * Secure:                                            *
	 *   Checks to makes sure input is not empty, and     *
	 *   only runs queries if there is information to run *
	 *----------------------------------------------------*/
	if (!empty($UserName)){

		$grabMe = "SELECT * FROM users WHERE user = '".$UserName."';";
		echo $grabMe;
		$result = mysqli_query($con, $grabMe);
		$row = mysqli_fetch_assoc($result);

		echo "row: ".
		var_dump($row)."<br>";

		//Check if username is null (validation)
		if ($row['user']==NULL){
			/*---------------------------------------------------*
			 * Secure:                                           *
			 * Does not return any information to user           *
			 *---------------------------------------------------*/
		  $url = "index.php";
		}
		else if (strtolower($row["user"]) === strtolower($UserName)){
			if ($row['password'] == $UserPass){
				//success
				$url = "dashboard.html";
			}
			else{
				//bad password
				$url = "index.php";
			}
		}
		else {
			//bad user name
			$url = "index.php";
		}
	}
	else {
		//General error
		$url = "index.php";
	}

	echo $UserName;
	echo $UserPass;
	header('Location: '.$url);
?>
