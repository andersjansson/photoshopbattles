<div id="content-wrap">
	<div id="heading"><h2>POST IMAGE</h2></div>
	<div id="content">

		<?php
		if($success){ ?>
			<p>Success!</p>
		<?php }	else{
			if(!empty($errors)) 
				foreach($errors as $error){	print "<p class='error'>$error</p>"; }
			if(isset($_SESSION['user_id'])) { ?>

				<div class="form">
					<form action="index.php?page=post" method="post" enctype="multipart/form-data">
			            <p><label for="postimage">Select an image</label></p>
			           	<p><input type="file" name="postimage"><br>

			           	<p><label for="posttitle">Choose a title</label></p>
			           	<p><input id="posttitle" name="posttitle" maxlength="120"
			           		placeholder="Choose a title for your post"/></p>

			           	<p> <label for="nsfw">Is this image Safe For Work?</label></p>
			           	<input type="radio" name="nsfw" value="yes" checked>Yes
						<input type="radio" name="nsfw" value="no">No

			            <p class="signin button"><input id="post_button" name="submit" type="submit" value="Post"/></p>
			        </form>
			    </div>
			<?php } else { ?>
				<p class="error">WHO SENT YOU? HOW DID YOU FIND ME?</p>
		<?php }} ?>
	</div>
</div>