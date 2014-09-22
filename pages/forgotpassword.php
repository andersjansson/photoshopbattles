<div id="content-wrap">
	<div id="heading"><h2>FORGOT YOUR PASSWORD?</h2></div>
	<div id="content">	
		<div class="form">
			<?php if($email_sent){ ?>
				<p>An email has been sent to <?= $email ?> with instructions on how to reset your password.</p>
			<?php } else { if(strlen($error) > 0) :?>
				<p class="error"><?= $error ?></p>
			<?php endif; ?>
			<form method="POST" action="index.php?page=forgotpassword" autocomplete="on">
				<p><label for="emailreset">Enter the email address you registered with. An email containing 
					instructions on how to reset your password will be sent to you.</p></label>
		        <p><input id="emailreset" name="emailreset" required="required" type="email" 
		        	placeholder="Enter your email"/><input name="submit" type="submit" value="Reset Password"/>
		    </form>
		    <?php } ?>
		</div>
	</div>
</div>