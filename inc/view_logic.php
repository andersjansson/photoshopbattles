<?php
$scoresArray = Array();
$created 	= "";
$creator	= "";
$image_url	= "";
$title		= "";
$errors 	= Array();
$score 		= 0;

$db	= new DBHandler();
$db->connect();

if(isset($_GET['url'])){
	$url 	= $_GET['url'];

	if($post = getPostByImageUrl($db, $url)){

		$created = sanitize($post['created']);
		$creator = sanitize($post['username']);
		$title	 = sanitize($post['title']);
		$post_id = $post['id'];
		$score   = getPostScore($db, $url) ? getPostScore($db, $url) : 0;
	}
	else
		$errors[] = "Database connection error. Oh noes.";
}
else
	header( 'Location: index.php?page=showposts' ) ;

function getPostByImageUrl($db, $image_url)
{
	$qry = "SELECT p.*, u.username
			FROM posts AS p
			LEFT JOIN users AS u ON p.user_id = u.id
			WHERE p.image_url = ?
			LIMIT 1";
	$variables = Array("s", $image_url);

	if($row = $db->getSingleRow($qry, $variables))
		return $row;	

	return false;
}