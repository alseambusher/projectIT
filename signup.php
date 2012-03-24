<?php 
include("scripts/basicfunctions.php");
include("includes/header.inc.php");
?>
<script type="text/javascript" src="scripts/signup_validation.js"></script>
<style type="text/css">
table.signup h4 {
  font-size: 10px;
  font-weight: normal;
  color: #999;
  margin: 2px 0 3px 0;
  width: 85%;
  padding: 0;
}
</style>
<hr />
<div id="latest-post-wrap">
<div id="latest-post" class="post">
	<p class="byline"><span>A web based data management tool</a></span></p>
	<h1 class="title">Signup to it@nitk</h1>
		<p>
		<?php if($_GET['message'])
			echo "<h2 style='color:red'>".$_GET['message']."</h2>";
		?>
		<form method="POST" action="scripts/basicfunctions_remote.php?action=signup">
			<div class="signup">
				<h3>Choose a username</h3>
				<h4>No spaces or special characters allowed.</h4>
        		<input class="big" id="new_account_username" name="new_account_username" size="15" type="text" onkeyup="validation_username();" />
				<a id="user"style="color:red" value=""></a>
				
				<h3 class="group">What's your full name?</h3>
				<input class="big" id="new_account_name" name="new_account_name" size="30" type="text"onkeyup="validation_fullname();" />
				<a id="full_user"></a>
        
				<h3 class="group">Your email address</h3>
				<input class="big" id="new_account_email_address" name="new_account_email_address" size="30" type="text"onkeyup="validation_email();" />
				<a id="email"></a>
				<h3>Enter your email address <strong>again</strong></h3>
				<input class="big" id="new_account_email_address_confirmation" name="new_account_email_address_confirmation" size="30" type="text"onkeyup="validation_confirm_email();" />
				<a id="email_again"></a>

				<h3 class="group">New password</h3>
				<h4>Password should have a minimum of 6 characters</h4>
				<input class="big" id="new_account_password" name="new_account_password" size="20" type="password"onkeyup="validation_password();" />
				<a id="pass"></a>

				<h3>Type the password <strong>again</strong></h3>
				<input class="big" id="new_account_password_confirmation" name="new_account_password_confirmation" size="20" type="password"onkeyup="validation_confirm_password();" />
				<a id="pass_confirm"></a>
				
				<h3>Account type</h3>
				<select name="new_account_type" id="new_account_type">
					<option value="student">Student</option>
					<option value="teaching_staff">Teaching Staff</option>
				</select>
      
				<p><input name="new_account[terms_of_service]" value="0" type="hidden" />
				<input id="new_account_terms_of_service" name="new_account[terms_of_service]" value="1" type="checkbox" checked="checked" onclick="if(this.checked!=true)document.getElementById('error_checkbox').innerHTML='you have to agree to terms and conditions';else document.getElementById('error_checkbox').innerHTML='';error_update();"  /> 
				Yes, I agree Terms of Service and Privacy Policy.</p>
				<a id="terms"></a>
        
				<input type="hidden" name="error_final" id="error_final" value=""/><br />
				<a style="color:red;" id="error_checkbox"></a>
        
				<p><input value="Signup now" type="submit"></p>
		</form>
		</p>
	</div>
</div>
</div>
<hr />
<? include("includes/footer.inc.php"); ?>	
</body>
</html>
