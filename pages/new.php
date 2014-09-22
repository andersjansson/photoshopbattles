<div id="test"></div>

<div id="content-wrap">
	<div id="heading"><h2>NEW</h2></div>
	<div id="content">
	<?php if(strlen($error) > 0) print "<p class='error'>$error</p>"; 
	foreach($posts as $post) { 
		require("post_template.php");
	} ?> 
		<div id="paging">
			<?php generatePaging($limit, $start, $count, $page);?>
		</div>

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