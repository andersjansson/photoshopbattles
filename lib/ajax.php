<?php
ini_set ('display_errors', true);
error_reporting (E_ALL);
define("__ROOT__", 			dirname(__FILE__));
require_once(__ROOT__."/main.php");
sliding_session_start(600);
$db = new DBHandler();
$db->connect();

if(isset($_SESSION['user_id']))
{
	if(isset($_GET['check_login']))
	{
		print "true";
	}



	if(isset($_GET['score']) && isset($_GET['img'])){
		$score 		= (int) $_GET['score'];
		$img   		= $_GET['img'];
		$user_id    = $_SESSION['user_id'];

		setVote($db, $score, $img, $user_id);
	}

}

$db->close();	

function updatePostVote($db, $score, $img)
{
	$qry = "UPDATE posts
			SET score = (score + (?))
			WHERE image_url=?";

	$variables = Array("is", $score, $img);

	$db->updateOrInsertRow($qry, $variables);
}

?>