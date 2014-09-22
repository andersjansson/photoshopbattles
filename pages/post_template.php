<?php 
	$img = $post['image_url'];
?>
<div class="post">
	<div class="voting-wrap">
		<div class="voting" name="<?= $img ?>">
			<?php
				$score = getPostScore($db, $img) ? getPostScore($db, $img) : 0;
				if(isset($_SESSION['user_id'])){
					$vote = getVote($db, $img, $_SESSION['user_id']);
					$scoresArray[$img] = $vote['score'];
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
	<a href="index.php?page=view&url=<?= $img ?>">
		<img src="<?= 'img/posts/t/'.$img.'.jpg' ?>" />
	</a>
	<div class="post-info">
		<h3><a href="index.php?page=view&url=<?= $img ?>"><?= sanitize($post['title']) ?></a></h3>

		<p>
			submitted <?= timeAgo(strtotime($post['created'])) ?> by 
			<a href="index.php?page=profile&u=<?= sanitize($post['username']) ?>"><?= sanitize($post['username']) ?></a>
			<?php if($post['nsfw'] === "yes") { ?>(<span class="error">NSFW</span>)<?php } ?>
		</p>
	</div>
</div>
