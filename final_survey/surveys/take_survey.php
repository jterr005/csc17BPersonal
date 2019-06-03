<?php # Script - add_print.php
// This page allows the administrator to add a print (product).

$page_title = 'Respond to a Survey';
include ('../header.php');
echo '<div class="Form"><h1>Survey Reponse</h1>';

require_once ('../userlogin/mysqli_connect.php');

$q = "SELECT survey_name, question_one, question_two, question_three FROM entity_survey";		
$r = @mysqli_query ($dbc, $q); // Run the query.
if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the survey's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);

echo '<form enctype="multipart/form-data" action="add_survey.php" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	<fieldset><legend>Fill out the form to create your own survey:</legend>
	<p><b>Survey Name:</b> <br>' . $row[0] . '</p>
	<p><b>Question #1:</b> <br>' . $row[1] . '</p>
	<p><b>Response #1:</b> <br><textarea name="answer_one" cols="40" rows="5">';

	<?php if (isset($_POST['answer_one'])) echo $_POST['answer_one']; ?>
	echo '</textarea></p>
	<p><b>Question #2:</b> <br><textarea name="question_two" cols="40" rows="5"><?php if (isset($_POST[\'question_two\'])) echo $_POST[\'question_two\']; ?></textarea></p>
	
	<p><b>Question #3:</b> <br><textarea name="question_three" cols="40" rows="5"><?php if (isset($_POST[\'question_three\'])) echo $_POST[\'question_three\']; ?></textarea></p>
	
	</fieldset>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();

	// Check for a valid user session

	// Check for a survey name:
	if (!empty($_POST['survey_name'])) {
		$pn = trim($_POST['survey_name']);
	} else {
		$errors[] = 'Please enter your survey\'s name!';
	}

	// Check for a description (not required):
	$q1 = (!empty($_POST['question_one'])) ? trim($_POST['question_one']) : NULL;

		// Check for a description (not required):
	$q2 = (!empty($_POST['question_two'])) ? trim($_POST['question_two']) : NULL;

		// Check for a description (not required):
	$q3 = (!empty($_POST['question_three'])) ? trim($_POST['question_three']) : NULL;
	
	if (empty($errors)) { // If everything's OK.

		// Add the print to the database:
		$q = 'INSERT INTO entity_survey (user_id, survey_name, question_one, question_two, question_three) VALUES (?, ?, ?, ?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'issss', $u, $pn, $q1, $q2, $q3);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {

			// Print a message:
			echo '<p>Your survey has been created.</p><div class="Form"; style="width: 7%"><a href="view_users.php">Back</a></div>';
	
			// Clear $_POST:
			$_POST = array();
	
		} else { // Error!
			echo '<p style="font-weight: bold; color: #C00">Your survey could not be processed due to a system error.</p>'; 
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
	echo 'Please try again.</p>';
}

// Display the form...
?>
<form enctype="multipart/form-data" action="add_survey.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>Fill out the form to create your own survey:</legend>
	
	<p><b>Survey Name:</b> <br><input type="text" name="survey_name" memory="30" maxlength="60" value="<?php if (isset($_POST['survey_name'])) echo htmlspecialchars($_POST['survey_name']); ?>" /></p>
	
	
	<p><b>Question #1:</b> <br><textarea name="question_one" cols="40" rows="5"><?php if (isset($_POST['question_one'])) echo $_POST['question_one']; ?></textarea></p>
	
	<p><b>Question #2:</b> <br><textarea name="question_two" cols="40" rows="5"><?php if (isset($_POST['question_two'])) echo $_POST['question_two']; ?></textarea></p>
	
	<p><b>Question #3:</b> <br><textarea name="question_three" cols="40" rows="5"><?php if (isset($_POST['question_three'])) echo $_POST['question_three']; ?></textarea></p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>

</form>

</body>
</html>