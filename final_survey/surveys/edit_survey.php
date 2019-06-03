<?php # Script 10.3 - edit_user.php
// This page is for editing a user record.
// This page is accessed through view_users.php.

$page_title = 'Edit Your Survey';
include ('../header.php');
echo '<div style="text-align:center"><h1>Edit Your Survey</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} else if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>
	<div class="Form"; style="width: 7%"><a href="view_users.php">Back</a></div>'; 
	exit();
}

require_once ('../userlogin/mysqli_connect.php'); 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	// Check for a first name:
	if (empty($_POST['survey_name'])) {
		$errors[] = 'You forgot to enter your survey name.';
	} else {
		$pn = mysqli_real_escape_string($dbc, trim($_POST['survey_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['question_one'])) {
		$errors[] = 'You forgot to enter your first question.';
	} else {
		$q1 = mysqli_real_escape_string($dbc, trim($_POST['question_one']));
	}

	// Check for an email address:
	if (empty($_POST['question_two'])) {
		$errors[] = 'You forgot to enter your second question.';
	} else {
		$q2 = mysqli_real_escape_string($dbc, trim($_POST['question_two']));
	}

	// Check for an email address:
	if (empty($_POST['question_three'])) {
		$errors[] = 'You forgot to enter your third question.';
	} else {
		$q3 = mysqli_real_escape_string($dbc, trim($_POST['question_three']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		//  Test for unique survey name:
		$q = "SELECT survey_id FROM entity_survey WHERE survey_name='$pn' AND survey_id != $id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE entity_survey SET survey_name='$pn', question_one='$q1', question_two='$q2', question_three='$q3' WHERE survey_id=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message:
				$message = "The survey\'s information has been updated.";
				echo "<script type='text/javascript'>alert('$message');</script><div class=\"Form\"; style=\"width: 7%\"><a href=\"view_my_surveys.php\">Back</a></div>";
				
			} else { // If it did not run OK.
				echo '<p class="error">The survey could not be edited due to a system error. We apologize for any inconvenience.</p><div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">This survey name has already been used.</p><div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>';
		}
		
	} else { // Report the errors.

		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>';
	
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT survey_name, question_one, question_two, question_three FROM entity_survey WHERE survey_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:
	echo '<form action="edit_survey.php" method="post">
<p>Survey Name: <input type="text" name="survey_name" size="15" maxlength="15" value="' . $row[0] . '" /></p>
<p><b>Question #1:</b> <br><textarea name="question_one" cols="40" rows="5">' . $row[1] . '</textarea></p>
<p><b>Question #2:</b> <br><textarea name="question_two" cols="40" rows="5">' . $row[2] . '</textarea></p>
<p><b>Question #3:</b> <br><textarea name="question_three" cols="40" rows="5">' . $row[3] . '</textarea></p>
<p><input type="submit" name="submit" value="Submit Changes" /></p>
<input type="hidden" name="id" value="' . $id . '" />
</form></div>';

} else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p></div><div class="Form"; style="width: 7%"><a href="view_my_surveys.php">Back</a></div>';
}

mysqli_close($dbc);

?>