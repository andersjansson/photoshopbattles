<div id="content-wrap">
	<div id="heading"><h2>USER PROFILE</h2></div>

	<div id="content">
		<?php 
			if(!empty($errors)) 
				foreach($errors as $error){
					print "<p class='error'>$error</p>";
				}
			else{
		 ?>

			<div id="user">
				<div id="info">
					<div class="avatar">
						<img src="<?= $avatar_url ?>" />
						<?php if($editable) { ?>
							<div id="change-avatar">
								<div class="form invisible" id="avatar-edit">
									<form action="" method="post" enctype="multipart/form-data">
										<input type="file" name="changeavatar"><br>
										<input type="submit" name="submit" value="Upload">
									</form>
								</div>
								<a href="" id="change-avatar-button">Change avatar</a>
							</div>
						<?php } ?>
					</div>
					<div class="user-info">
						<p class="username"><?= $username ?></p>
						<p class="info" id="user-info"><?= $info ?></p>
						<?php if($editable) { ?>
							<div class="form invisible" id="info-edit">
								<form action="" method="post">
									<p>
										<textarea name="editinfo" cols="45" rows="10" maxlength="255"><?= $info ?></textarea>
									</p>
									<input type="submit" name="submit" value="Save changes">
								</form>
							</div>
						
							<a href="" id="change-info-button">Edit your information</a>
						<?php } ?>
					</div>
				</div>
			
				<div id="profile-posts-container">
					<div id="profile-posts-menu"> 
						<ul>Show:
						<?php if($sort == "user_top") $t="active"; else $l="active";?>
							<li class="<?= $l ?>"><a href="index.php?page=profile&u=<?= $username ?>">Latest Posts</a></li>
							<li class="<?= $t ?>"><a href="index.php?page=profile&u=<?= $username ?>&sortBy=top">Most Upvoted Posts</a></li>
						</ul> 
					</div>
				<?php if($posts){ 
					foreach($posts as $post){
						require("post_template.php");
					}
				?>
					 
					<div id="paging">
						<?php generatePaging($limit, $start, $count, "profile&u=".$post['username'])?>
					</div>
				<?php } else { ?>
					<p> This user has not made any posts yet. </p>
				<?php } ?>
				</div>
			</div>
	</div>
</div>
<?php } if($editable) { ?>
<script type="text/javascript" src="js/profile.js?rel=<?= time() ?>"></script>
<?php } ?>

<script src="js/AjaxHelper.js?v=<?= time(); ?>"></script>
<?php 
	$scoresArray = json_encode($scoresArray);
	print "<script>";
	print "var voteHelper = new VoteHelper();";
	print "voteHelper.init(".$scoresArray.");";
	print "</script>";
?>