<?php

$error = "";
$hashmatch = true;
$success = true;
$updated = false;

$db = new DBHandler();
$db->connect();

if(isset($_GET['r']) && isset($_GET['e'])){
	$reset_code = $_GET['r'];
	$email 		= $_GET['e'];

	$hash = _getResetHash($db,$email);

	if($reset_code !== $hash){
		$error 		= "There was an error. Click <a href='index.php?page=forgotpassword'>here</a> to try another reset.";
		$hashmatch 	= false;
		$success	= false;
	}
	else{
		$_SESSION['temp_email'] = $email;
	}

	if(expired($db, $email)){
		$error = "Your password reset has expired. Please go <a href='index.php?page=forgotpassword'>here</a> to try another reset.";
		unset($_SESSION['temp_email']);
		$success = false;
	}
}

else if(isset($_POST['submit'])){
	$password 		= isset($_POST['passwordreset']) 			? $_POST['passwordreset']			: "";
	$cfmPassword 	= isset($_POST['passwordreset_confirm'])	? $_POST['passwordreset_confirm']	: "";

	$email	= $_SESSION['temp_email'];

	if(passwordsMatch($password, $cfmPassword)){
	
		$hash = encrypt($password);

		if(updatePassword($db, $email, $hash)){
			unset($_SESSION['temp_email']);
			$updated = true;
		}
				
		else{
			$error = "An unexpected error occurred while updating your password. Please try again. If the problem
					  persists, please go <a href='index.php?page=forgotpassword'>here</a> to try another reset.";
		}
				
	}
	else
		$error = "Passwords do not match, try again.";
}

else{
	$db->close();
	header( 'Location: index.php?page=showposts' ) ;
}
$db->close();

function updatePassword($db, $email, $hash){

	$qry = "UPDATE users SET hash=? WHERE email=?";
	$variables = Array("ss", $hash, $email);

	if($db->updateOrInsertRow($qry, $variables))
		return true;

	return false;
}

function expired($db, $email){
	$time = time();

	$qry = "SELECT expires
			FROM reset_hashes
			WHERE email = ? 
			LIMIT 1";
	$variables = Array("s", $email);

	if($expires = $db->getSingleValue($qry, $variables, "expires")){
		if($time > $expires)
			return true;
		else
			return false;
	}
	return false;
}

function _getResetHash($db, $email)
{
	$qry = "SELECT hash
			FROM reset_hashes
			WHERE email = ?";
	$variables = Array("s", $email);

	if($value = $db->getSingleValue($qry, $variables, "hash"))
		return $value;
	else
		return false;
}