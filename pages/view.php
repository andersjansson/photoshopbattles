<div id="content-wrap">
	<div id="heading">
		<h2>VIEW POST</h2>
	</div>

	<div id="content">
		<?php if(!empty($errors)) foreach($errors as $error){print "<p class='error'>$error</p>";} else { ?>
		<div class="view">
			<div id="view-top-container">
				<a href="<?= "img/posts/".$url.".jpg" ?>">
					<img src="<?= "img/posts/m/".$url.".jpg" ?>"/>
				</a>
			</div>
			
			<div id="view-info">
				<div class="voting-wrap">
					<div class="voting" name="<?= $url ?>">
						<?php
							$score = getPostScore($db, $url) ? getPostScore($db, $url) : 0;

							if(isset($_SESSION['user_id'])){
								$vote = getVote($db, $url, $_SESSION['user_id']);
								$scoresArray[$url] = $vote['score'];
								switch($vote['score']){
									case 1:
										$up   = " orange";
										$down = "";
										break;
									case -1:
										$down = " blue";
										$up   = "";
										break;
									default:
										$down = "";
										$up   = "";
								}
							}
							else{
								$up   = "";
								$down = "";
							}
						?>
						<span class="icon-arrow-up<?= $up ?>"></span>
						<span class="score"><?php print $score; ?></span>
						<span class="icon-arrow-down<?= $down ?>"></span>
					</div>
				</div>
				<p class="title"><?= $title ?> <span>created <?= $created ?> by <a href="index.php?page=profile&u=<?= $creator ?>"><?= $creator ?></a></span></p>
				
				
			</div>
			
		</div>
		<?php }
		require_once(__ROOT__."/inc/comments_logic.php");
		require_once(__ROOT__."/pages/comments.php");
		?>
	</div>
</div>
<script src="js/AjaxHelper.js?v=<?= time(); ?>"></script>
<?php 
	$scoresArray = json_encode($scoresArray);
	print "<script>";
	print "var voteHelper = new VoteHelper();";
	print "voteHelper.init(".$scoresArray.");";
	print "</script>";
?>