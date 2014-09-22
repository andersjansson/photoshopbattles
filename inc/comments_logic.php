<?php
$commentErrors = Array();

$db = new DBHandler();
$db->connect();

if(isset($_POST['submit'])){
	$commenter_id = $_SESSION['user_id'];
	$content = $_POST['content'];

	$qry = "INSERT INTO comments (commenter_id, post_id, parent_id, content)
			VALUES (?, ?, ?, ?)";

	$variables = Array("iiis", $commenter_id, $post_id, 0, $content);

	if(!$db->updateOrInsertRow($qry, $variables))
		$commentErrors[] = "Error: Could not post comment. Sorry.";
}

$qry = "SELECT c.*, u.username
		FROM comments AS c
		LEFT JOIN users AS u 
		ON u.id = c.commenter_id
		WHERE post_id = ?
		ORDER BY created DESC";

$variables = Array("i", $post_id);

$comments = $db->getAssocArray($qry, $variables);

$db->close();