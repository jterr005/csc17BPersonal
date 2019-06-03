<?php # Script - browse_prints.php
// This page displays the available prints (products).

// Set the page title and include the HTML header:
$page_title = 'Browse our Smartphones';
include ('../header.php');

require_once ('../UserLogin/mysqli_connect.php');
 
// Default query for this page:
$q = "SELECT entity_company.company_id, CONCAT_WS(' ', company_name) AS company, phone_name, price, description, smartphone_id FROM entity_company, entity_smartphone WHERE entity_company.company_id = entity_smartphone.company_id ORDER BY entity_company.company_name ASC, entity_smartphone.phone_name ASC";

// Are we looking at a particular artist?
if (isset($_GET['aid']) && filter_var($_GET['aid'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
	// Overwrite the query:
	$q = "SELECT entity_company.company_id, CONCAT_WS(' ', company_name) AS company, phone_name, price, description, smartphone_id FROM entity_company, entity_smartphone WHERE entity_company.company_id=entity_smartphone.company_id AND entity_smartphone.company_id={$_GET['aid']} ORDER BY entity_smartphone.phone_name";
}

// Create the table head:
echo '<div class="Form"><h1>Shop</h1></div>

<table border="0" width="90%" cellspacing="4" cellpadding="5" align="center">
	<tr>
		<td align="left" width="20%"><h2><b>Company</b></h2></td>
		<td align="left" width="20%"><h2><b>Device Name</b></h2></td>
		<td align="left" width="20%"><h2><b>Price</b><h2></td>
		<td align="left" width="40%"><h2><b>Description</b><h2></td>
	</tr>';

// Display all the prints, linked to URLs:
$r = mysqli_query ($dbc, $q);
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

	// Display each record:
	echo "\t<tr>
		<td align=\"left\"><a href=\"browse_devices.php?aid={$row['company_id']}\">{$row['company']}</a></td>
		<td align=\"left\"><a href=\"view_device.php?pid={$row['smartphone_id']}\">{$row['phone_name']}</a></td>
		<td align=\"left\">\${$row['price']}</td>
		<td align=\"left\">{$row['description']}</td>
	</tr>\n";

} // End of while loop.

echo '</table>';
mysqli_close($dbc);
?>