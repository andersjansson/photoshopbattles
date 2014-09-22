<?php 
	$main_nav_menu = Array(
			"showposts&sortBy=hot" => "HOT",
			"showposts&sortBy=new" => "NEW",
			"showposts&sortBy=top" => "MOST UPVOTED"
	);

	if(isset($_SESSION['user_id'])){
		$nav_login = Array(
			"post" 			=> "POST IMAGE",
			"logout" 		=> "LOG OUT",
			"profile"		=> "PROFILE"
		);
	}
	else{
		$nav_login = Array(
			"login" 		=> "LOG IN",
			"register" 		=> "REGISTER"
		);
	}	
?>

<div id="header">
	<div id="logo"><a href="index.php"><h1>/r/PHOTOSHOP<span class="white">BATTLES</span></h1></a></div>
	<div id="navigation-wrap">
		<div id="navigation_main">
			<ul>
				<?php
					foreach($main_nav_menu as $page_name => $text){
						if (isset($sort) && (strpos($page_name,$sort) !== false)) {?>
							<li><a href="index.php?page=<?= $page_name ?>" class="active"><?= $text ?></a></li>
						<?php } else {?>
							<li><a href="index.php?page=<?= $page_name ?>"><?= $text ?></a></li>
						<?php }
					}
				?>
			</ul>
		</div>
		<div id="navigation_login">
			<ul>
				<?php
					foreach($nav_login as $page_name => $text){
						if($page_name == 'profile'){
							if($page == 'profile'){ ?>
								<li><a href="index.php?page=<?= $page_name ?>&u=<?= $_SESSION['username'] ?>" class="active"><?= $text ?></a></li>
							<?php }
							else { ?>
								<li><a href="index.php?page=<?= $page_name ?>&u=<?= $_SESSION['username'] ?>"><?= $text ?></a></li>
							<?php }
						}

						else{
							if($page == $page_name) { ?>
								<li><a href="index.php?page=<?= $page_name ?>" class="active"><?= $text ?></a></li>
							<?php }
							else{ ?>
								<li><a href="index.php?page=<?= $page_name ?>"><?= $text ?></a></li>
							<?php }
						}
							
					}
				?>
			</ul>
		</div>
	</div>
</div>
