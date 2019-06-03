<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Created by Jason Terrazas -->
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style.css">
		<title><?php echo (isset($page_title)) ? $page_title : 'Home Page'; ?></title>
	</head>
	<body>
		<div class="Main">
			<br>
			<img src="../new-logo.png">
			<br>
			<br>
			<ul>
				<li class="drop-button">
					<a href="../home.php">Home</a>
				</li>
				<li class="drop-button">
					<a href = "../surveys/browse_surveys.php">Take A Survey</a>
				</li>
				<li class="drop-button">
				<?php  // Displays Login/Logout buttons depending on session
					if (isset($_SESSION['user_id'])) {
						echo "<a href=\"../surveys/view_my_surveys.php\">Your Surveys</a></li>";
						if ($_SESSION['user_id'] == 1) {
								echo "<li class=\"drop-button\"><a href=\"../admin/view_users.php\">Admin Privileges</a></li>";
							}
						echo "<li class=\"drop-button\"><a href=\"../userlogin/logout.php\">Logout</a>";
					} else {
						echo "<a href=\"../userlogin/login_page.php\">Login</a>";
					}
				?>
			</li>
			</ul>
		</div>
	</body>
</html>