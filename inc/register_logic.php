<?php
$success 	= false;
$email 		= "";
$error 		= "";
$username	= "";

if(isset($_POST['submit'])){
	$email 			= isset($_POST['emailsignup']) 				? $_POST['emailsignup']				: "";
	$password 		= isset($_POST['passwordsignup']) 			? $_POST['passwordsignup']			: "";
	$cfmPassword 	= isset($_POST['passwordsignup_confirm'])	? $_POST['passwordsignup_confirm']	: "";
	$username	 	= isset($_POST['usernamesignup'])			? $_POST['usernamesignup']			: "";

	$db = new DBHandler();
	$db->connect();

	require_once(__ROOT__."/securimage/securimage.php");
	$securimage = new Securimage();

	$error = checkRegistration($db, $email, $username, $password, $cfmPassword, $securimage);

	if(strlen($error) === 0){

		$hash = encrypt($password);

		if(insertUser($db, $email, $username, $hash)){
			$success = true;
			
			$_SESSION['user_id']  = getUserIdFromEmail($db, $email);
			$_SESSION['username'] = getUserNameFromEmail($db, $email);
		}
			else
				$error = "There was an error registering your account. Please try again.";
		
	}

	$db->close();
}

function checkRegistration($db, $email, $username, $password, $cfmPassword, $securimage)
{

	if(emailExists($db, $email)){
		$error = "This email address is already registered.";
		$email = "";
		return $error;
	}

	if(usernameExists($db, $username)){
		$error = "This username is already taken, try another.";
		$username = "";
		return $error;
	}

	if(strlen($username) > 16){
		$error = "Username cannot be longer than 16 characters, try a shorter username.";
		$username = "";
		return $error;
	}

	if(strlen($username) === 0){
		$error = "You need to enter a username.";
		return $error;
	}

	if(strlen($password) < 6){
		$error = "Your password needs to be atleast 6 characters long.";
		return $error;
	}

	if(!passwordsMatch($password, $cfmPassword)){
		$error = "Your password and password confirmation do not match.";
		return $error;
	}

	if ($securimage->check($_POST['captcha_code']) == false) {
		$error = "You didn't enter the characters shown in the image. Try again.";
		return $error;
	}
}

function insertUser($db, $email, $username, $hash)
{
	$qry= "INSERT INTO users (email, username, hash) VALUES (?,?,?)";
	$variables = Array("sss", $email, $username, $hash);

	if($db->updateOrInsertRow($qry, $variables))
		return true;

	return false;
}

