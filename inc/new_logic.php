<?php

$mysqli 	 = dbConnect();
$limit  	 = 10;
$start		 = 1;
$error  	 = "";
$count 		 = countPosts($mysqli);

if(isset($_GET['nr'])){
	$start = (int)$_GET['nr'];
	
	if($start < 1 || $start > ceil($count/$limit))
		$start = 1;
}

if(!$posts = getAllPostsByDate($mysqli, (($start -1) * $limit), $limit))
	$error = "Error: Could not fetch posts.";

function getAllPostsByDate($mysqli, $start, $limit)
{
	$stmt = $mysqli->prepare("SELECT p.*, u.username
								FROM posts AS p
								LEFT JOIN users as u ON p.user_id = u.id
								ORDER BY created DESC
								LIMIT ? , ?");
	$stmt->bind_param("ii", $start, $limit);
	$stmt->execute();

	if($result = $stmt->get_result()){
		$allThePosts = Array();

		while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
	        $allThePosts[] = $row;
    	}

    	return $allThePosts;
	}

	return false;
}

function countPosts($mysqli)
{
	$stmt = $mysqli->prepare("SELECT COUNT(*) as count
								FROM posts");
	$stmt->execute();
	if($result = $stmt->get_result()){
		$row = $result->fetch_assoc();
		return $row['count'];
	}

	return false;
}
?>