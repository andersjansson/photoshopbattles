<div id="content-wrap">
	<div id="heading"><h2>EDIT PROFILE</h2></div>

	<div id="content">
		<?php 
			if(strlen($error) > 0) 
				print "<p class='error'>$error</p>"; 
			if(isset($_SESSION['user_id'])) { ?>

			<div id="user">
				<div class="form">
				<form method="POST" action="index.php?page=register" autocomplete="on">
		            <p><label for="emailsignup">Your email</label></p>
		           	<p><input id="emailsignup" name="emailsignup" required="required" type="email" 
		           		placeholder="email@mail.com" value="<?= $email ?>"/></p>

		           	<p><label for="usernamesignup">Choose a username</label></p>
		           	<p><input id="usernamesignup" name="usernamesignup" required="required"
		           		placeholder="Choose a username" value="<?= $username ?>"/></p>

		            <p class="signin button"><input id="submit_button" name="submit" type="submit" value="Register"/></p>
		            <p class="change_link">Already a member?<a href="index.php?page=login" class="to_register"> Log in </a></p>
		        </form>
	        </div>
				<!--<div id="info">
					<div class="avatar">
						<img src="<?= $avatar_url ?>" />
					</div>
					<div class="user-info">
						<p class="username"><?= $username ?></p>
						<p class="info"><?= $info ?></p>
					</div>
				</div>
				<div id="edit">
					<a href="index.php?page=editprofile">Edit profile</a>
				</div>-->
			</div>

		<?php }	?>
	</div>
</div>