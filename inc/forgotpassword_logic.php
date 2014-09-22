<?php

$email_sent = false;
$error = "";

$db = new DBHandler();
$db->connect();

if(isset($_POST['submit'])){
	$email = isset($_POST['emailreset']) ? $_POST['emailreset'] : "";

	$success = false;

	if(emailExists($db, $email)){
		$hash = encrypt($email);

		if(hashExists($db, $email)){

			if(updateHash($db, $hash, $email, 3600))
				$success = true;
			else
				$error = "An error occured, please try again. 1";
		}
		else{
			if(insertHash($db, $hash, $email, 3600))
				$success = true;
			else
				$error = "An error occured, please try again. 2";
		}

		if($success){
			if(sendResetEmail($email, $hash))
				$email_sent = true;
			else
				$error = "There was an error sending your email, please try again.";
		}
	}

	else
		$error = "No such email is registered. Please try again.";
}

$db->close();

function sendResetEmail($email, $hash){
	
	$link = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?page=passwordreset&e=$email&r=$hash";
	$to = "$email";
	$subject = "Account Details Recovery";
	$body = "You have requested a password reset. To reset your password, click this link and follow the instructions: $link";
	$additionalheaders = "From: <noreply@photoshopbattles.com>"."\r\n";
	$additionalheaders .= "Reply-To: noprely@photoshopbattles.com";
	if(mail($to, $subject, $body, $additionalheaders))
		return true;
	else
		return false;
}

function hashExists($db, $email)
{
	$qry = "SELECT * 
			FROM reset_hashes 
			WHERE email=?";
	$variables = Array("s", $email);

	if($db->rowExists($qry, $variables))
		return true;
	else
		return false;
}

function updateHash($db, $hash, $email, $time)
{
	$expires = time()+$time;

	$qry = "UPDATE reset_hashes 
			SET expires=?, hash=? 
			WHERE email=?";
	
	$variables = Array("iss", $expires, $hash, $email);

	if($db->updateOrInsertRow($qry, $variables))
		return true;
	else
		return false;
}

function insertHash($db, $hash, $email, $time)
{
	$expires = time()+$time;

	$qry = "INSERT INTO reset_hashes VALUES (?, ?, ?)";
	
	$variables = Array("ssi", $email, $hash, $expires);

	if($db->updateOrInsertRow($qry, $variables))
		return true;
	else
		return false;
}