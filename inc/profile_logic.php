<?php
$db = new DBHandler();
$db->connect();

$errors      = Array();
$editable    = false;
$scoresArray = Array();
$limit  	 = 10;
$start		 = 1;
$score 		 = 0;

if(isset($_FILES['changeavatar']) && $_FILES['changeavatar']['error'] == 0){

	$file = $_FILES["changeavatar"]["name"];
	$temp = $_FILES["changeavatar"]["tmp_name"];

	$handler = loadImageHandler($temp);

	if($handler->success){
		$name = $handler->hashImageName($file);
		if($handler->cropImage(__ROOT__."/img/avatar/".$name.".jpg",150,150)){
			if(!updateUserAvatarById($db, $name, $_SESSION['user_id']))
				$errors[] = "Failed to update avatar.";
		}
	}
	else
		$errors = $handler->getErrors();
	
	unset($handler);
}

if(isset($_POST['editinfo'])){
	$new_info = isset($_POST['editinfo']) ? $_POST['editinfo'] : "No information entered yet.";

	if(!updateUserInfoById($db, $new_info, $_SESSION['user_id']))
		$errors[] = "Failed to update user information.";
}

if(isset($_GET['u'])){
	require_once("showposts_logic.php");
	$name 		 = $_GET['u'];
	$count 		 = countUserPosts($db, $name);
	
	if(isset($_GET['nr']))
		$start = (int)$_GET['nr'];
	
	if($start < 1 || $start > ceil($count/$limit))
		$start = 1;

	if($userdata = getUserDataByUsername($db, $name, $start, $limit)){
		$id 		= $userdata['id'];
		$username 	= sanitize($userdata['username']);
		$avatar 	= (strlen($userdata['avatar']) > 0) ? $userdata['avatar'] 			: "no_avatar";
		$info	 	= (strlen($userdata['info'])   > 0) ? sanitize($userdata['info']) 	: "No information entered yet.";

		$avatar_url = "img/avatar/".$avatar.".jpg";

		if(isset($_SESSION['user_id']) && $id == $_SESSION['user_id'])
			$editable = true;
	}
	else
		$errors[] = "Could not find user '$name'.";

}
else{
	if(isset($_SESSION['user_id']))
		header('Location: index.php?page=profile&u='.$_SESSION['username']) ;
	else
		header('Location: index.php?page=showposts');
}

function updateUserAvatarById($db, $avatar, $id)
{
	$qry = "UPDATE users 
			SET avatar=? 
			WHERE id=?";
	$variables = Array("si", $avatar, $id);

	if($db->updateOrInsertRow($qry, $variables))
		return true;

	return false;
}

function updateUserInfoById($db, $info, $id)
{
	$qry = "UPDATE users 
			SET info=? 
			WHERE id=?";
	$variables = Array("si", $info, $id);

	if($db->updateOrInsertRow($qry, $variables))
		return true;

	return false;
}

function getUserDataByUsername($db, $username)
{
	$qry = "SELECT id, username, email, created, avatar, info
			FROM users
			WHERE username = ? 
			LIMIT 1";
	$variables = Array("s", $username);
	
	if($row = $db->getSingleRow($qry, $variables))
		return $row;

	return false;
}

function countUserPosts($db, $username)
{
	$qry = "SELECT COUNT(*) as count
			FROM users AS u
			RIGHT JOIN posts AS p
			ON u.id = p.user_id
			WHERE username = ?";
	$variables = Array("s", $username);
	
	if($value = $db->getSingleValue($qry, $variables, "count"))
		return $value;

	return false;
}