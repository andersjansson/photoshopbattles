<?php if(isset($_SESSION['user_id'])) { ?>
<div class="form" id="info-edit">
	<form action="" method="post">
		<p>
			<textarea name="content" cols="45" rows="10" maxlength="255"></textarea>
		</p>
		<input type="hidden" name="id" value="<?= $post_id ?>">
		<input type="submit" name="submit" value="Comment">
	</form>
</div>
<div id="comments">
	<?php } 
	if($comments){
	foreach($comments AS $comment){ ?>
		<div class="comment">
			<p>
				<a href="index.php?page=profile&u=<?= sanitize($comment['username']) ?>"><?= sanitize($comment['username']) ?></a>
				 <?= timeAgo(strtotime($comment['created'])) ?> 
			</p>
			<p class="comment-content"><?= $comment['content'] ?></p>
		</div>
	<?php }}
	else
		print "This post has no comments."; ?>
</div>


