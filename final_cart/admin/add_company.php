<?php # Script - add_artist.php
// This page allows the administrator to add an artist.

$page_title = 'Add A New Company';
include ('../header.php');
echo '<div class="Form"><h1>Add a Company</h1>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	
	// Validate the country of origin (neither required):
	$oc = (!empty($_POST['origin_country'])) ? trim($_POST['origin_country']) : NULL;

	// Check for a last_name...
	if (!empty($_POST['company_name'])) {
		
		$cn = trim($_POST['company_name']);
		
		// Add the company to the database:
		require_once ('../UserLogin/mysqli_connect.php');
		$q = 'INSERT INTO entity_company (company_name, origin_country) VALUES (?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ss', $cn, $oc);
		mysqli_stmt_execute($stmt);
		
		// Check the results....
		if (mysqli_stmt_affected_rows($stmt) == 1) {
			echo '<p>The company has been added.</p><div class="Form"; style="width: 7%"><a href="view_users.php">Back</a></div>';
			$_POST = array();
		} else { // Error!
			$error = 'The new company could not be added to the database!';
		}
		
		// Close this prepared statement:
		mysqli_stmt_close($stmt);
		mysqli_close($dbc); // Close the database connection.
		
	} else { // No last name value.
		$error = 'Please enter the company\'s name!';
	}
	
} // End of the submission IF.

// Check for an error and print it:
if (isset($error)) {
	echo '<h1>Error!</h1>
	<p style="font-weight: bold; color: #C00">' . $error . ' Please try again.</p>';
}

// Display the form...
?>
<form action="add_company.php" method="post">
	
	<fieldset><legend>Fill out the form to add a company:</legend>
	
	<p><b>Company Name:</b> <br><input type="text" name="company_name" size="10" maxlength="20" value="<?php if (isset($_POST['company_name'])) echo $_POST['company_name']; ?>" /></p>
	<p><b>Country of Origin:</b> <br><input type="text" name="origin_country" size="10" maxlength="20" value="<?php if (isset($_POST['origin_country'])) echo $_POST['origin_country']; ?>" /></p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>

</form>