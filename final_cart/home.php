<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Created by Jason Terrazas -->
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
		<title><?php echo (isset($page_title)) ? $page_title : 'Home Page'; ?></title>
	</head>
	<body>
		<div class="Main">
			<br>
			<img src="new-logo.png">
			<br>
			<br>
			<ul>
				<li class="drop-button">
					<a href="home.php">Home</a>
				</li>
				<li class="drop-button">
					<a href = "cart/browse_devices.php">Shop</a>
					<ul class = "drop">
						<?php // Displays Different Companies depending on what's available
						require_once ('UserLogin/mysqli_connect.php');

						$q = "SELECT company_id, CONCAT_WS(' ', company_name) FROM entity_company ORDER BY company_name ASC";		
						$r = mysqli_query ($dbc, $q);
						if (mysqli_num_rows($r) > 0) {
							while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
								$current_company_id = $row[0];
								$current_company_name = $row[1];
								echo "<li><a href=\"cart/browse_devices.php?aid=$current_company_id\">$current_company_name</a></li>";
							}
						}

						?>
					</ul>
				</li>
				<li class="drop-button">
				<?php  // Displays Login/Logout buttons depending on session
					if (isset($_SESSION['user_id'])) {
						echo "<a href=\"cart/view_cart.php\">Your Cart</a></li>";
						if ($_SESSION['user_id'] == 12) {
								echo "<li class=\"drop-button\"><a href=\"admin/view_users.php\">Admin Privileges</a></li>";
							}
						echo "<li class=\"drop-button\"><a href=\"UserLogin/logout.php\">Logout</a>";
					} else {
						echo "<a href=\"UserLogin/login_page.php\">Login</a>";
					}
				?>
			</li>
			</ul>

			<div class="Text">
				<br>
				<h1>Welcome to Smartphone Hub</h1>
				<dl>
					<dt>&emsp;Our Company's Smartphone Specs:</dt>
					<dd>- High Quality Metal & Glass Body</dd>
					<dd>- OLED or High Refresh Rate LCD Displays</dd>
					<dd>- Long Lasting Battery</dd>
					<dd>- Software Support For 4 Years After Launch</dd>
					<dd>- Camera Better Than Google's Pixel 3</dd>
				</dl>
			</div>

			<div class="Picture">
				<img src="homegif.gif" width="300px">
			</div>

		</div>
	</body>
</html>