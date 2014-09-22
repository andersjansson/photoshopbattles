<?php
$mysqli = dbConnect();
$error = "";

if(isset($_SESSION['user_id'])){
	if(isset($_POST['changeuserinfo'])){
		$username = isset($_POST['username']) ? $_POST['username'] : "";
		$avatar	  = isset($_POST['avatar'])	  ? $_POST['avatar']   : "";
	}

	else if(isset($_POST['changepassword'])){
		$password 	 = isset($_POST['passwordchange'])         ? $_POST['passwordchange']		  : "";
		$cfmPassword = isset($_POST['passwordchange_confirm']) ? $_POST['passwordchange_confirm'] : "";
	}

	if($user = getUserDataById($mysqli, $_SESSION['user_id'])){
		/*print "<pre>";
		print_r($user);
		print "</pre>";*/

		$avatar	  	= strlen($user['avatar']   > 0)	? $user['avatar'] 	: "no_avatar.jpg";
		$info	 	= strlen($user['info']	   > 0) ? $user['info'] 	: "No information entered yet.";
		$username 	= $user['username'];
		$email	 	= $user['email'];
		$avatar_url = "img/avatar/".$avatar;

		require_once(__ROOT__."/lib/ImageHandler.php");



		/*$handler = new ImageHandler(__ROOT__."/img/test.jpg");
		$name = $handler->hashImageName();
		$handler->cropImage(__ROOT__."/img/avatar/".$name.".jpg",150,150);
		$test = $handler->scaleImage("scaled3.jpg", 800,600);
		var_dump($test);*/
		//unset($handler);

		
		
	}
}
else
	$error = "HOW DID YOU FIND ME? WHO SENT YOU?";
	//redirecta till nån sida


