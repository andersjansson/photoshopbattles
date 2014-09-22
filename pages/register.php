<div id="content-wrap">
	<div id="heading"><h2>REGISTER A NEW ACCOUNT</h2></div>
	<div id="content">
		<?php if($success){?>
			<p>You are now registered!</p>
		<?php } else { if(strlen($error) > 0) print "<p class='error'>$error</p>";?>
			<div class="form">
				<form method="POST" action="index.php?page=register" autocomplete="on">
		            <p><label for="emailsignup">Your email</label></p>
		           	<p><input id="emailsignup" name="emailsignup" required="required" type="email" 
		           		placeholder="email@mail.com" value="<?= cleanEmail($email) ?>"/></p>

		           	<p><label for="usernamesignup">Choose a username</label></p>
		           	<p><input id="usernamesignup" name="usernamesignup" required="required"
		           		placeholder="Choose a username" value="<?= sanitize($username) ?>"/></p>

		            <p><label for="passwordsignup">Your password</label></p>
		           	<p><input title="Password needs to be at least 6 characters" id="passwordsignup" 
		           		name="passwordsignup" required="required" type="password" pattern='.{6,}' 
		           		placeholder="eg. X8df!90EO"/></p>

		            <p><label for="passwordsignup_confirm">Confirm password</label></p>
		            <p><input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" 
		            	type="password" placeholder="eg. X8df!90EO"/></p>
					
					<!-- Securimage stuff-->
					<p>Enter the characters shown in the image</p>
					<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
					<p><input type="text" name="captcha_code" size="10" maxlength="6" />
					<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' 
					+ Math.random(); return false">[ Different Image ]</a></p>

		            <p class="signin button"><input id="submit_button" name="submit" type="submit" value="Register"/></p>
		            <p class="change_link">Already a member?<a href="index.php?page=login" class="to_register"> Log in </a></p>
		        </form>
	        </div>
        <?php } ?>
	</div>
</div>

<script type="text/javascript" src="js/register.js?rel=<?= time() ?>"></script>