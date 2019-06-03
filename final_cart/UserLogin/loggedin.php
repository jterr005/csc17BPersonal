<?php # Script 12.13 - loggedin.php #3
// The user is redirected here from login.php.

session_start(); // Start the session.

// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {

	// Need the functions:
	require ('login_functions.inc.php');
	redirect_user();	

}

// Set the page title and include the HTML header:
$page_title = 'Logged In!';
include ('user_login_blank.php');

// Print a customized message:
echo "<div style=\"text-align:center\"><h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['first_name']}!</p></div>
<div class=\"Main\"><ul>
<li class=\"drop-button\"><a href=\"logout.php\">Logout</a></li></ul></div>";

?>