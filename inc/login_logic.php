<?php

$error 			= "";
$securimage 	= "";
$success 		= false;
$failed_thrice 	= false;

if(isset($_SESSION['login_attempts'])){
	if($_SESSION['login_attempts'] >= ALLOWED_ATTEMPTS){
		$failed_thrice = true;
		require_once(__ROOT__."/securimage/securimage.php");
		$securimage = new Securimage();
	}
}
else
	$_SESSION['login_attempts'] = 1;

if(isset($_POST['submit'])){
	$email 		= isset($_POST['emaillogin']) 		? $_POST['emaillogin']		: "";
	$password 	= isset($_POST['passwordlogin']) 	? $_POST['passwordlogin']	: "";

	$db = new DBHandler();
	$db->connect();

	$id = getUserIdFromEmail($db, $email);
	$name = getUserNameFromEmail($db, $email);

	if($id == false || $name == false)
		$error = "Your email and/or password is incorrect.";
	else
		$error = checkLogin($db, $email, $password, $securimage);

	if(strlen($error) === 0){
		unset($_SESSION['login_attempts']);
		$_SESSION['user_id']  = $id;
		$_SESSION['username'] = $name;
		$success = true;
	}

	else{
		$_SESSION['login_attempts'] += 1;
	}

	$db->close();
}

function checkLogin($db, $email, $password, $securimage)
{
	if($email == "" || $password == ""){
		$error = "You need to enter both email and password.";
		return $error;
	}

	if($securimage !== "" && $_SESSION['login_attempts'] >= ALLOWED_ATTEMPTS+1){
		if (!isset($_POST['captcha_code']) || $securimage->check($_POST['captcha_code']) == false) {
			$error = "You didn't enter the characters shown in the image. Try again.";
			return $error;
		}
	}

	$qry = "SELECT hash FROM users WHERE email=? LIMIT 1";
	$variables = Array("s", $email);

	if($hash = $db->getSingleValue($qry, $variables, "hash"))
		if(matchPassword($password, $hash))
			return;

	$error = "Your email and/or password is incorrect.";
	return $error;
}

function matchPassword($password, $hash)
{
	if ( crypt($password, $hash) == $hash ) {
 		return true;
	}
	else
		return false;
}