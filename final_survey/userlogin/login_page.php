<?php # Script 12.1 - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include ('user_login_blank.php');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
} 

// Display the form:
?>
<div style="text-align:center">
<h1>Login</h1>
<form id="demoMatch" name="demoMatch" action="login_process.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" pattern="^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,})$"/> </p>
	<p>Password: <input type="password" name="pass" size="20" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{4,25}$"/></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>
<form action = "registration_page.php" method="get">
	<p><input formaction="password.php" type="submit" name="passwordchange" value="Forgot Password" />
		<input type="submit" name="register" value="New? Come Register!" /></p>
</form>
</div>