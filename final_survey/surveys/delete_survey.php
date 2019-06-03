<?php # Script 10.2 - delete_user.php
// This page is for deleting a user record.
// This page is accessed through view_users.php.

$page_title = 'Delete a Survey';
include ('../header.php');
echo '<div style="text-align:center"><h1>Delete a Survey</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

require_once ('../userlogin/mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM entity_survey WHERE survey_id=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>This survey has been deleted.</p>
			<div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>';	

		} else { // If the query did not run OK.
			echo '<p class="error">This survey could not be deleted due to a system error.</p>
			<div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p>This survey has NOT been deleted.</p>
					<div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>';	
	}

} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT CONCAT(survey_name) FROM entity_survey WHERE survey_id=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Display the record being deleted:
		echo "<h3>Name: $row[0]</h3>
		Are you sure you want to delete this survey?";
		
		// Create the form:
		echo '<form action="delete_survey.php" method="post">
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="id" value="' . $id . '" />
	</form></div>';
	
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p></div>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);

?>