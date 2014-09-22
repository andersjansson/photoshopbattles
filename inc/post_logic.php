<?php 
$errors = Array();
$success = false;

if(!isset($_SESSION['user_id']))
	header('Location: index.php?page=showposts');

if(isset($_POST['submit'])){
	$title = isset($_POST['posttitle']) ? $_POST['posttitle'] : $errors[] = "You need to give your post a title.";
	$nsfw  = isset($_POST['nsfw'])	    ? $_POST['nsfw']	  : "yes";
	$nsfw  = ($nsfw == "yes") ? "no" : "yes";
	
	if(isset($_FILES['postimage']) && $_FILES['postimage']['error'] == 0){
		$filename = $_FILES['postimage']['name'];
		$temp  	  = $_FILES['postimage']['tmp_name'];

		if(strlen($title) === 0)
			$errors[] = "You need to enter a title for your post.";

		else{

			if(strlen($title) > 140)
				$errors[] = "Your post title cannot exceed 140 characters in length.";
			else{
		
				$db = new DBHandler();
				$db->connect();
				
				$handler = loadImageHandler($temp);

				if($handler->success){
					$name = $handler->hashImageName($filename);

					if(imageExists($db, $name))
						$errors[] = "This exact image has already been uploaded.";
					
					else{

						if($handler->scaleImage(__ROOT__."/img/posts/".$name.".jpg",2000,2000) 
						   && $handler->scaleImage(__ROOT__."/img/posts/m/".$name.".jpg",600,600)
						   && $handler->cropImage(__ROOT__."/img/posts/t/".$name.".jpg",150,150)){
							
							$id = $_SESSION['user_id'];

							if(insertPost($db, $title, $name, $id, $nsfw)){
								setVote($db, 0, $name, $id);
								$success = true;
							}
							else
								$errors[] = "Error: Post failed.";
						}
						else
							$errors[] = "There was a problem uploading your image, please try again.";
					}
				}
				
				unset($handler);
				$db->close();
			}
		}
	}
	else{
		if(isset($_FILES['postimage']))
			$errors[] = "File error: ".$_FILES['postimage']['error'];
		else
			$errors[] = "You need to select an image.";
	}
}

function insertPost($db, $title, $url, $user_id, $nsfw='no')
{
	$qry = "INSERT INTO posts (title, image_url, user_id, nsfw) VALUES (?,?,?,?)";
	$variables = Array("ssis", $title, $url, $user_id, $nsfw);

	if($db->updateOrInsertRow($qry, $variables))
		return true;

	return false;
}

function imageExists($db, $url)
{
	$qry = "SELECT * 
			FROM posts 
			WHERE image_url=?
			LIMIT 1";

	$variables = Array("s", $url);

	if($db->rowExists($qry, $variables))
		return true;
	else
		return false;
}