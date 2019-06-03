<?php # Script - add_print.php
// This page allows the administrator to add a print (product).

$page_title = 'Add A New Smartphone';
include ('../header.php');
echo '<div class="Form"><h1>Add a Smartphone</h1>';

require_once ('../UserLogin/mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();

	// Check for a phone name:
	if (!empty($_POST['phone_name'])) {
		$pn = trim($_POST['phone_name']);
	} else {
		$errors[] = 'Please enter the phone\'s name!';
	}
	
	// Check for an image:
	if (is_uploaded_file ($_FILES['image']['tmp_name'])) {

		// Create a temporary file name:
		$temp = '../uploads/' . md5($_FILES['image']['name']);
	
		// Move the file over:
		if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {

			echo '<p>Your photo has been uploaded!</p>';
	
			// Set the $i variable to the image's name:
			$i = $_FILES['image']['name'];
	
		} else { // Couldn't move the file over.
			$errors[] = 'Your photo could not be moved.';
			$temp = $_FILES['image']['tmp_name'];
		}

	} else { // No uploaded file.
		$errors[] = 'Your photo was not uploaded.';
		$temp = NULL;
	}
	
	// Check for memory size (not required):
	$s = (!empty($_POST['memory'])) ? trim($_POST['memory']) : NULL;

	// Check for a price:
	if (is_numeric($_POST['price']) && ($_POST['price'] > 0)) {
		$p = (float) $_POST['price'];
	} else {
		$errors[] = 'Please enter the phone\'s price!';
	}

	// Check for a description (not required):
	$d = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;
	
	// Validate the company...
	if ( isset($_POST['company']) && filter_var($_POST['company'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
		$a = $_POST['company'];
	} else { // No company selected.
		$errors[] = 'Please select the phone\'s company!';
	}
	
	if (empty($errors)) { // If everything's OK.

		// Add the print to the database:
		$q = 'INSERT INTO entity_smartphone (company_id, phone_name, price, memory, description, image_name) VALUES (?, ?, ?, ?, ?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'isddss', $a, $pn, $p, $s, $d, $i);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {

			// Print a message:
			echo '<p>The smartphone has been added.</p><div class="Form"; style="width: 7%"><a href="view_users.php">Back</a></div>';
	
			// Rename the image:
			$id = mysqli_stmt_insert_id($stmt); // Get the print ID.
			rename ($temp, "../uploads/$id");
	
			// Clear $_POST:
			$_POST = array();
	
		} else { // Error!
			echo '<p style="font-weight: bold; color: #C00">Your submission could not be processed due to a system error.</p>'; 
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.
	
	// Delete the uploaded file if it still exists:
	if ( isset($temp) && file_exists ($temp) && is_file($temp) ) {
		unlink ($temp);
	}
	
} // End of the submission IF.

// Check for any errors and print them:
if ( !empty($errors) && is_array($errors) ) {
	echo '<h1>Error!</h1>
	<p style="font-weight: bold; color: #C00">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo 'Please reselect the smartphone image and try again.</p>';
}

// Display the form...
?>
<form enctype="multipart/form-data" action="add_device.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>Fill out the form to add a new smartphone to the shopping list:</legend>
	
	<p><b>Device Name:</b> <br><input type="text" name="phone_name" memory="30" maxlength="60" value="<?php if (isset($_POST['phone_name'])) echo htmlspecialchars($_POST['phone_name']); ?>" /></p>
	
	<p><b>Image:</b> <br><input type="file" name="image" /></p>
	
	<p><b>Company:</b><br> 
	<select name="company"><option>Select One</option>
	<?php // Retrieve all the companies and add to the pull-down menu.
	$q = "SELECT company_id, CONCAT_WS(' ', company_name) FROM entity_company ORDER BY company_name ASC";		
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) > 0) {
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['company']) && ($_POST['company'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	} else {
		echo '<option>Please add a new company first.</option>';
	}
	mysqli_close($dbc); // Close the database connection.
	?>
	</select></p>
	
	<p><b>Price:</b> <br><input type="text" name="price" memory="10" maxlength="10" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" /><br> <small>Do not include the dollar sign or commas.</small></p>
	
	<p><b>Memory:</b> <br><input type="text" name="memory" memory="30" maxlength="60" value="<?php if (isset($_POST['memory'])) echo htmlspecialchars($_POST['memory']); ?>" /></p>
	
	<p><b>Description:</b> <br><textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea></p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>

</form>

</body>
</html>