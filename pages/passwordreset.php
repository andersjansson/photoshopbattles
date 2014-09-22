<div id="content-wrap">
	<div id="heading"><h2>RESET PASSWORD</h2></div>
	<div id="content">

		<?php if(strlen($error) > 0) { ?>
			<p class='error'><?= $error ?></p>
		<?php } if($success && $updated === false) { ?>
		<div class="form">
			<form method="POST" action="index.php?page=passwordreset" autocomplete="on">
				<p><label for="passwordreset">Choose a new password</label></p>
		           	<p><input title="Password needs to be at least 6 characters" id="passwordreset" 
		           		name="passwordreset" required="required" type="password" pattern='.{6,}' 
		           		placeholder="eg. X8df!90EO"/></p>

		            <p><label for="passwordreset_confirm">Confirm password</label></p>
		            <p><input id="passwordreset_confirm" name="passwordreset_confirm" required="required" 
		            	type="password" placeholder="eg. X8df!90EO"/></p>
		            <p class="signin button"><input id="submit_button" name="submit" type="submit" value="Register"/></p>
		    </form>
		</div>
		<?php } if($updated) { ?>
					<p>Your password has been updated. <a href="index.php?page=login">Go try it out!</a></p>
				<?php } ?>
	</div>
</div>