<div id="content-wrap">
	<div id="heading"><h2>LOG IN</h2></div>
	<div id="content">

		<?php if($success){ ?>
		<p> Logged in! </p>
		<?php } 
		else if(isset($_SESSION['user_id'])){
			?> 
				<p>You're already logged in. Are you trying to <a href="index.php?page=logout">log out</a>?</p>
			<?php
		}
		else { if(strlen($error) > 0) print "<p class='error'>$error</p>"; ?>
		<div class="form">
			<form method="POST" action="index.php?page=login" autocomplete="on">
	            <p><label for="emaillogin">Your email</label></p>
	           	<p><input id="emaillogin" name="emaillogin" required="required" type="email" 
	           		placeholder="Enter your email"/></p>

	            <p><label for="passwordlogin">Your password</label></p>
	           	<p><input id="passwordlogin" name="passwordlogin" required="required" type="password" 
	           	placeholder="Enter your password"/></p>
				
				<?php if($failed_thrice){ ?>
					<!-- Securimage stuff -->
					<p>Enter the characters shown in the image</p>
					<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
					<p><input type="text" name="captcha_code" size="10" maxlength="6" />
					<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' 
					+ Math.random(); return false">[ Different Image ]</a></p>
				<?php } ?>

	            <p class="signin button"><input name="submit" type="submit" value="Log in"/></p>
	        </form>
	        <p class="change_link">Not a member?<a href="index.php?page=register" class="to_register"> Sign up </a></p>
	        <p class="change_link">Forgot your password?<a href="index.php?page=forgotpassword" class="to_register"> Reset password </a></p>
	       <?php } ?>
        </div>
	</div>
</div>

