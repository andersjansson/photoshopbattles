<?php

$db = new DBHandler();

$db->connect();



$scoresArray = Array();

$limit  	 = 10;

$start		 = 1;

$error  	 = "";

$count 		 = countPosts($db);

$score       = 0;



if(isset($_GET['nr'])){

	$start = (int)$_GET['nr'];

	

	if($start < 1 || $start > ceil($count/$limit))

		$start = 1;

}



if(isset($_GET['u'])){

	$username = $_GET['u'];

	if(isset($_GET['sortBy']) && $_GET['sortBy'] == "top")

		$sort = "user_top";

	else

		$sort = "user_latest";

}



else if(isset($_GET['sortBy']))

	$sort = $_GET['sortBy'];

else

	$sort = "hot";



switch($sort){

	case "top":

		$qry = "SELECT p.*, SUM(pv.score) AS high_score, u.username

				FROM      post_votes AS pv

				LEFT JOIN posts AS p ON p.image_url = pv.post_img_url

				LEFT JOIN users AS u ON p.user_id = u.id

				GROUP BY  p.image_url

				ORDER BY  high_score DESC

  				LIMIT ? , ?";

  		$heading = "MOST UPVOTED";

  		break;

	case "new":

		$qry = "SELECT p.* , u.username

				FROM posts AS p

				LEFT JOIN users AS u ON p.user_id = u.id

				ORDER BY created DESC

				LIMIT ? , ?";

		$heading = "NEW";

  		break;

  	case "user_latest":

  		$qry = "SELECT p.*, u.username

				FROM users AS u

				RIGHT JOIN posts AS p ON u.id = p.user_id

				WHERE u.username = '".$username."'

				ORDER BY p.created DESC 

				LIMIT ? , ?";

		break;

	case "user_top":

  		$qry = "SELECT p.*, SUM(pv.score) AS high_score, u.username

				FROM post_votes AS pv

				LEFT JOIN posts AS p ON p.image_url = pv.post_img_url

				LEFT JOIN users AS u ON p.user_id = u.id

				WHERE u.username = '".$username."'

				GROUP BY  p.image_url

				ORDER BY high_score DESC

				LIMIT ? , ?";

		break;

	case "hot":

		//falls through

	default:

		$qry = "SELECT p.* , u.username
				FROM post_votes AS pv
				LEFT JOIN posts AS p ON p.image_url = pv.post_img_url
				LEFT JOIN users AS u ON p.user_id = u.id
				GROUP BY p.image_url
				ORDER BY ROUND((
				(CASE
					WHEN SUM(pv.score) > 1 THEN 1
					WHEN SUM(pv.score) < 1 THEN -1
					ELSE 0
				END)
				*LOG10(GREATEST(ABS(SUM(pv.score)),1)))
				+((UNIX_TIMESTAMP(p.created)-1381707538)/45000),7) DESC
  				LIMIT ? , ?";

		$heading = "HOT";
}



$posts = getAllPosts($db, (($start -1) * $limit), $limit, $qry);

	

function getAllPosts($db, $start, $limit, $qry)
{
	$variables = Array("ii", $start, $limit);

	if($rows = $db->getAssocArray($qry, $variables))
		return $rows;

	return false;
}



?>