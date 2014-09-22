<?php

/*REQUIRED FILES*/

//require_once(__ROOT__."/lib/ImageHandler.php");



/*DB CONSTANTS*/

 /*SERVER*/

if(strpos($_SERVER['SERVER_NAME'], "lingam.se") !== false)

	require_once("asdfasdfasdf.php");



else{

/* LOCAL */

define('HOST', 				'localhost');

define('USER',				'********');

define('PASSWORD',			'*********');

define('DATABASE',			'photoshopbattles');

}



/* REQUIRES */



require_once("DBHandler.php");



/*OTHER CONSTANTS*/



define('ALLOWED_ATTEMPTS',	3);



/*DB FUNCTIONS*/



function usernameExists($db, $username)

{

	$qry = "SELECT * 

			FROM users 

			WHERE username=?";



	$variables = Array("s", $username);



	if($db->rowExists($qry, $variables))

		return true;

	else

		return false;

}



function emailExists($db, $email)

{

	$qry = "SELECT * 

			FROM users 

			WHERE email=?";

	$variables = Array("s", $email);



	if($db->rowExists($qry, $variables))

		return true;

	else

		return false;

}



function getUserIdFromEmail($db, $email){

	$qry = "SELECT id

			FROM users

			WHERE email = ? 

			LIMIT 1";

	$variables = Array("s", $email);



	if($value = $db->getSingleValue($qry, $variables, "id"))

		return $value;

	else

		return false;

}



function getUserNameFromEmail($db, $email){

	$qry = "SELECT username

			FROM users

			WHERE email = ? 

			LIMIT 1";

	$variables = Array("s", $email);



	if($value = $db->getSingleValue($qry, $variables, "username"))

		return $value;

	else

		return false;

}



function countPosts($db)

{

	$qry = "SELECT COUNT(*) as count

			FROM posts";

	

	return $db->countRows($qry);

}



function getPostScore($db, $img)

{

	$qry = "SELECT SUM(score) AS total

			FROM post_votes

			WHERE post_img_url = ?

			LIMIT 1";



	$variables = Array("s", $img);



	if($value = $db->getSingleValue($qry, $variables, "total"))

		return $value;



	return false;

}



function getVote($db, $img, $user_id)

{

	$qry = "SELECT *

			FROM post_votes

			WHERE post_img_url = ?

			AND user_id = ?

			LIMIT 1";

	$variables = Array("si", $img, $user_id);



	if($row = $db->getSingleRow($qry, $variables))

		return $row;

	else

		return false;

}



function setVote($db, $score, $img, $user_id)

{

	if($vote = getVote($db, $img, $user_id)){

		$vote_id = $vote['id'];

		$qry = "UPDATE post_votes SET score=? WHERE id=?";

		$variables = Array("ii", $score, $vote_id);

	}

		

	else{

		$qry = "INSERT INTO post_votes (post_img_url, user_id, score) VALUES (?, ?, ?)";

		$variables = Array("sii", $img, $user_id, $score);

	}

	

	if($db->updateOrInsertRow($qry, $variables))

		return true;



	return false;

}



/* UTILITY FUNCTIONS */

function generatePaging($limit, $start, $count, $page, $sort = "")

{

	$pages = ceil($count/$limit);

	$prev  = $start - 1;

	$next  = $start + 1;



	$show  = 3;

	$first = ($start - $show);

	$last  = ($start + $show);



	if($first < 1){

		$first = 1;

		$last  = ($show*2)+1;

	}

	

	if($last > $count){

		$last = $count;

		$first = ($first < 1) ? $count - ($show*2)+1 : 1;

	}



	if($prev > 0 && $pages > $show)

		print "<span class='float-left'><a href='index.php?page=$page".$sort."&nr=$prev'>Previous page</a></span>";



	for($i = $first; $i <= $last; $i++){

		if($i <= $pages){

			if($i === $start)

				print "<span>$i</span>";

			else

				print "<span><a href='index.php?page=$page".$sort."&nr=$i'>".$i."</a></span>";

		}

	}

	if($next <= $pages && $pages > $show)

		print "<span class='float-right'><a href='index.php?page=$page".$sort."&nr=$next'>Next page</a></span>";

}



function sliding_session_start($ttl)

{

	session_set_cookie_params($ttl);

	session_start();

	if(isset($_SESSION['user_id']))

		setcookie(session_name(),session_id(),time()+$ttl);

}



function sanitize($dirty)

{

	return filter_var($dirty, FILTER_SANITIZE_STRING);

}



function cleanEmail($dirty)

{

	return filter_var($dirty, FILTER_SANITIZE_EMAIL);

}



function encrypt($password)

{

	$cost = 10;

	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');



	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	

	$hash = crypt($password, $salt);



	return $hash;

}



function passwordsMatch($password, $cfmPassword)

{

	if($password == $cfmPassword)

		return true;

	else

		return false;

}



function loadImageHandler($temp)

{

	require_once(__ROOT__."/lib/ImageHandler.php");

	$handler = new ImageHandler($temp);

	return $handler;

}



function timeAgo($time)

{

	$etime = time() - $time;



    if ($etime < 1)

    {

        return '0 seconds ago';

    }



    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',

                30 * 24 * 60 * 60       =>  'month',

                24 * 60 * 60            =>  'day',

                60 * 60                 =>  'hour',

                60                      =>  'minute',

                1                       =>  'second'

                );



    foreach ($a as $secs => $str)

    {

        $d = $etime / $secs;

        if ($d >= 1)

        {

            $r = round($d);

            if($r == 24 && $str == "hour")

            	return "1 day ago";

            else

            	return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';

        }

    }

}

?>