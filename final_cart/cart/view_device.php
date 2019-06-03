<?php # Script - view_print.php
// This page displays the details for a particular print.

$row = FALSE; // Assume nothing!

if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) { // Make sure there's a smartphone ID!

	$pid = $_GET['pid'];
	
	// Get the print info:
	require ('../UserLogin/mysqli_connect.php'); // Connect to the database.
	$q = "SELECT CONCAT_WS(' ', company_name) AS company, phone_name, price, description, memory, image_name FROM entity_company, entity_smartphone WHERE entity_company.company_id=entity_smartphone.company_id AND entity_smartphone.smartphone_id=$pid";
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) == 1) { // Good to go!
		// Fetch the information:
		$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	
		// Start the HTML page:
		$page_title = $row['phone_name'];
		include ('view_device_header.php');
	
		// Display a header:
		echo "<div class=\"Form\"; align=\"center\" >
		<h2>{$row['phone_name']}</h2> sold by 
		{$row['company']}<br />";

		// Print the size or a default message:
		echo (is_null($row['memory'])) ? '(No information on storage memory available)' : $row['memory'],'GB';

		echo "<br />\${$row['price']} 
		</div><br />";
		echo "<div align=\"center\">";
		if (isset($_SESSION['user_id'])) {
			echo "<a href=\"add_cart.php?pid=$pid\">Add to Cart</a></div>";
		} 
		else {
			echo "<a href=\"../UserLogin/login_page.php\">Login to Purchase</a></div>";
		}

		// Add the description or a default message:
		echo '<div class="Form"><p align="center">' . ((is_null($row['description'])) ? '(No description available)' : $row['description']) . '</p></div>';
	
		// Get the image information and display the image:
		if ($image = @getimagesize ("../uploads/$pid")) {
			echo "<div align=\"center\"><img src=\"show_image.php?image=$pid&name=" . urlencode($row['image_name']) . "\" $image[3] alt=\"{$row['phone_name']}\" /></div>\n";	
		} else {
			echo "<div align=\"center\">No image available.</div>\n"; 
		}
	
	} // End of the mysqli_num_rows() IF.
	
	mysqli_close($dbc);

} // End of $_GET['pid'] IF.

if (!$row) { // Show an error message.
	$page_title = 'Error';
	echo '<div align="center">This page has been accessed in error!</div>';
}

?>