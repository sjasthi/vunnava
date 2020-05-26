<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';

// Start session to store variables
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// Allows user to return 'back' to this page
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $parameters['systemname']->value ?> Edit Sponsorship</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body class="body_background1">

<?php
$success = false;
$failure = false;
$message = '';
printHeader();
if(isset($_GET['success']))
{
	if($_GET['success'] == 'true')
	{
		$success = true;
		$message = $_GET['message'];
	}
	if($_GET['success'] == 'false')
	{
		$failure = true;
		$message =  $_GET['message'];
	}
}
?>
<div class="container submit_wrapper top_space">
<div class="row">
		
        <div class="col-lg-12">
		<h1 style="padding-bottom: 20px"></h1>
            <h1 class="page-header">
                Edit Sponsorship
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
			    <li><a href="sponsorship_list.php">Cancel Edit Sponsorship</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="active">Edit Sponsorship</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
            </ul>
        </div>
		
    </div>
<div class="col-md-2 left_nav" style="padding-left: 0;">
<link rel="stylesheet" type="text/css" href="stylesponsor.css"/>
<div id="left_menu">
  
  
  <?php
  require 'ProjectManagementSystem/configure.php';

// Establishing Connection with Server
$servername = DATABASE_HOST;
$db_username = DATABASE_USER;
$db_password = DATABASE_PASSWORD;
$database = DATABASE_DATABASE;

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully<br>";
$conn->set_charset("utf8");

// define variables and set to empty values
	$sponsor_id_error = $project_id_error = $sponsorship_image_error = "";
	$sponsor_first_name = $sponsor_id = $project_name = $project_id =
	$amount = $sponsorship_status = $sponsorship_details = $sponsorship_notes = $sponsorship_image = "";	
	$edit_sponsorship_id = "";
	$edit_sponsor_first_name = "";
	$edit_sponsor_last_name = "";
	$edit_sponsor_id = "";
	$edit_project_name = "";
	$edit_project_id = "";
	$edit_amount = "";
	$edit_sponsorship_status = "";
	$edit_sponsorship_details = "";
	$edit_sponsorship_notes = "";
	$edit_sponsorship_image= "";
	
	

$_SESSION['confirmation_sponsor_first_name'] = 
$_SESSION['confirmation_project_name'] =
$_SESSION['confirmation_sponsor_id'] = 
$_SESSION['confirmation_project_id'] =
$_SESSION['confirmation_amount'] = 
$_SESSION['confirmation_sponsorship_status'] =
$_SESSION['confirmation_sponsorship_details'] = 
$_SESSION['confirmation_sponsorship_notes'] =
$_SESSION['confirmation_sponsorship_image'] = "";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if ($_POST["sponsor_id"] === ""){
		$sponsor_id_error = "is required.";
	}
	else{
		$sponsor_id = test_input($_POST["sponsor_id"]);
	}
	
	if ($_POST["project_id"] === ""){
		$project_id_error = "is required.";
	}
	else{
		$project_id = test_input($_POST["project_id"]);
	}
	
	if ($_POST["sponsorship_id"] === ""){
		$sponsorship_id = "";
	}
	else{
		$sponsorship_id = test_input($_POST["sponsorship_id"]);
	}

	if ($_POST["amount"] === ""){
		$amount = "";
	}
	else{
		$amount = test_input($_POST["amount"]);
	}
	
	if ($_POST["sponsorship_status"] === ""){
		$sponsorship_status = "";
	}
	else{
		$sponsorship_status = test_input($_POST["sponsorship_status"]);
	}
	
	if ($_POST["sponsorship_details"] === ""){
		$sponsorship_details = "";
	}
	else{
		$sponsorship_details = test_input($_POST["sponsorship_details"]);
	}
	
	if ($_POST["sponsorship_notes"] === ""){
		$sponsorship_notes = "";
	}
	else{
		$sponsorship_notes = test_input($_POST["sponsorship_notes"]);
	}
	
	if ($_POST["sponsorship_image"] === ""){
		$sponsorship_image = "";
	}
	else{
		$sponsorship_image = test_input($_POST["sponsorship_image"]);
	}
	
	
	

	// Upload project image
	if(empty($_FILES['file']['name'][0])){
		$sponsorship_image_error = "";
	}
	else{
	if (isset($_POST['submit'])) {
	$j = 0;     // Variable for indexing uploaded project image.
	$target_path = "ProjectManagementSystem/sponsorship_image/";     // Declaring Path for uploaded photo.
	$sponsor_path = "ProjectManagementSystem/sponsorship_image/";
	for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
	// Loop to get individual element from the array
	$validextensions = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "svg", "SVG");      // Extensions which are allowed.
	$ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
	$file_extension = end($ext); // Store extensions in the variable.
	$target_path = "ProjectManagementSystem/sponsorship_image/" . basename($_FILES['file']['name'][$i]);     // Set the target path with a new name of image.
	if(count($_FILES['file']['name']) > 1 ){
		if ($i == 0){
			$sponsor_path = "ProjectManagementSystem/sponsorship_image/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else if($i > 0 && $i < count($_FILES['file']['name']) - 1){
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/sponsorship_image/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else {
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/sponsorship_image/" . basename($_FILES['file']['name'][$i]);
		}
	}
	else{
			$sponsor_path = "ProjectManagementSystem/sponsorship_image/" . basename($_FILES['file']['name'][$i]); 
	}
	
	$j = $j + 1;      // Increment the number of uploaded images according to the files in array.
	if (($_FILES["file"]["size"][$i] < 24000000)     // Approx. 24mb files can be uploaded.
	&& in_array($file_extension, $validextensions)) {
	if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
	// If file moved to uploads folder.
	echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
	$sponsorship_image = $sponsor_path;
	} 

	else {     //  If File Was Not Moved.
	echo $j. ').<span id="error">Error uploading image! Please try again!.</span><br/><br/>';
	$sponsorship_image_error = "Error uploading image! Please try again!";
	}
	}

	else {     //   If File Size And File Type Was Incorrect.
	echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
	$sponsorship_image_error = "Invalid file size or type!";
	}
	}
	}
	}

	// If no errors, go to confirmation page
	if($sponsor_id_error === "" && $project_id_error === "" && $sponsorship_image_error === ""){


	//Store sessions
	$_SESSION['confirmation_sponsor_name'] = $sponsor_name;
	$_SESSION['confirmation_project_name'] = $project_name;
	$_SESSION['confirmation_sponsor_id'] = $sponsor_id;
	$_SESSION['confirmation_project_id'] = $project_id;
	$_SESSION['confirmation_amount'] = $amount;
	$_SESSION['confirmation_sponsorship_status'] = $sponsorship_status;
	$_SESSION['confirmation_sponsorship_details'] = $sponsorship_details;
	$_SESSION['confirmation_sponsorship_notes'] = $sponsorship_notes;
	$_SESSION['confirmation_sponsorship_image'] = $sponsorship_image;
	
	

	// Run Query
		if(isset($_POST['submit'])){
	$sql = "UPDATE sponsorship SET sponsor_id = '$sponsor_id', project_id = '$project_id', amount = '$amount',
	sponsorship_status ='$sponsorship_status', sponsorship_details = '$sponsorship_details',
	sponsorship_notes = '$sponsorship_notes', sponsorship_image ='$sponsorship_image'
	WHERE sponsorship_id = '$sponsorship_id'";

	
//Close Connection
			if ($conn->query($sql) === TRUE) {
		    echo "Sponsor added to project successfully\.";
			}
			else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
			}
			header('Location: view_edited_sponsorship.php');
		}
			}
		}
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//get project data from database to populate fields with values
	$id = $_GET['id'];
	$sql = "SELECT * FROM sponsorship WHERE sponsorship_id = '$id'";
		$result = $conn->query($sql);
		 while($row = $result->fetch_assoc()) {
			$edit_sponsorship_id = $row["sponsorship_id"]; 
			//$edit_sponsor_first_name = $row["sponsor_first_name"]; 
			//$edit_sponsor_last_name = $row["sponsor_last_name"]; 
			$edit_sponsor_id = $row["sponsor_id"]; 
			//$edit_project_name = $row["project_name"]; 
			$edit_project_id = $row["project_id"]; 
			$edit_amount = $row["amount"]; 
			$edit_sponsorship_status = $row["sponsorship_status"]; 
			$edit_sponsorship_details = $row["sponsorship_details"]; 
			$edit_sponsorship_notes = $row["sponsorship_notes"]; 
			$edit_sponsorship_image = $row["sponsorship_image"]; 
	
		}
?>

<span class="errors"><strong style="color: red;">* required field.</strong></span>
<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table width=50% class="suggest_dance_table">

<!-- Sponsorship ID Input -->
<tr>
<td>
<label>Sponsorship ID: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="sponsorship_id" value="<?php echo $edit_sponsorship_id;?>" value="<?php echo $sponsorship_id;?>"readonly>
</td>
</tr>

<!-- Sposnsor First Name Input -->
<tr>
	<td>
	<label>
		<span class="errors">
			<strong style="color: red;">* <?php echo $sponsor_id_error;?></strong>
		</span>
		Sponsor Name: 
	</label>
	</td>
</tr>
<tr>
	<td>
		<?php
		echo "<select sponsor first name='sponsor_id'>";
		$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name FROM sponsor ORDER BY sponsor_first_name";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			
				$sql = "SELECT sponsor_first_name, sponsor_last_name FROM sponsor WHERE sponsor_id = '$edit_sponsor_id'";
				$result2 = $conn->query($sql);
				if ($result2->num_rows > 0) {
						while ($row = $result2->fetch_assoc()) {
						$sponsor_id = $row['sponsor_id'];
						$sponsor_first_name = $row['sponsor_first_name']; 
						$sponsor_last_name = $row['sponsor_last_name']; 
						echo '<option value="'.$edit_sponsor_id.'">'.$sponsor_first_name." ".$sponsor_last_name." (".$edit_sponsor_id.")".'</option>';						
					}	
				}
				
			while ($row = $result->fetch_assoc()) {
				$sponsor_id = $row['sponsor_id'];
				$sponsor_first_name = $row['sponsor_first_name']; 
				$sponsor_last_name = $row['sponsor_last_name']; 
				echo '<option value="'.$sponsor_id.'">'.$sponsor_first_name." ".$sponsor_last_name." (".$sponsor_id.")".'</option>';        
			}	
		}
		echo "</select>";
		?>
		
	</td>
</tr>


<!-- Project Name Input -->
<tr>
	<td>
		<label>
			<span class="errors">
				<strong style="color: red;">* <?php echo $project_id_error;?></strong>
			</span>
			Project Name: 
		</label>
	</td>
</tr>
<tr>
	<td>
		<?php
		echo "<select project name='project_id'>";
		$sql = "SELECT project_id, project_name FROM project ORDER BY project_name";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			
				$sql = "SELECT project_id, project_name FROM project WHERE project_id = '$edit_project_id'";
				$result3 = $conn->query($sql);
				if ($result3->num_rows > 0) {
					while ($row = $result3->fetch_assoc()) {
						$project_id = $row['project_id'];
						$project_name = $row['project_name']; 
						echo '<option value="'.$edit_project_id.'">'.$project_name." (".$edit_project_id.")".'</option>';                 
					}	
				}
				
			while ($row = $result->fetch_assoc()) {
				$project_id = $row['project_id'];
				$project_name = $row['project_name']; 
				echo '<option value="'.$project_id.'">'.$project_name." (".$project_id.")".'</option>';                 
			}	
		}
		echo "</select>";
		?>
	</td>
</tr>

<!-- Amount Input -->
<tr>
<td>
<label>Amount: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="amount" value="<?php echo $edit_amount;?>" value="<?php echo $amount;?>">
</td>
</tr>

<!-- Status Input -->
<tr>
<td>
<label>Status: </label>
</td>
</tr>
<tr>
<td>
<select name="sponsorship_status">
				<option <?php if (isset($sponsorship_status) && $sponsorship_status=="<?php echo $edit_sponsorship_status;?>") echo "selected";?>><?php echo $edit_sponsorship_status;?></option>
				<option <?php if (isset($sponsorship_status) && $sponsorship_status=="Paid") echo "selected";?>>Paid</option>
				<option <?php if (isset($sponsorship_status) && $sponsorship_status=="Pledged") echo "selected";?>>Pledged</option>
				<option <?php if (isset($sponsorship_status) && $sponsorship_status=="Other") echo "selected";?>>Other</option>
				</select>
</td>
</tr>

<!-- Sponsorship Detail Input -->
<tr>
<td>
<label>Sponsorship Details: </label>
</td>
</tr>
<tr>
<td>
<textarea name="sponsorship_details" rows="3" cols="40" maxlength="5000"><?php echo $edit_sponsorship_details;?><?php echo $sponsorship_details;?></textarea>
</td>
</tr>

<!-- Sponsorship Notes Input -->
<tr>
<td>
<label>Sponsorship Notes: </label>
</td>
</tr>
<tr>
<td>
<textarea name="sponsorship_notes" rows="3" cols="40" maxlength="5000"><?php echo $edit_sponsorship_notes;?><?php echo $sponsorship_notes;?></textarea>
</td>
</tr>

<!-- New Sponsorship Image Input -->
<tr>
<td>
<label>New Image: </label>
</td>
</tr>
<tr>
<td>
<div id="filediv">
<input type="file" name="file[]" id="file">

<span class="errors"><?php echo $sponsorship_image_error;?></span>
</div>
</td>
</tr>

<!-- Sponsorship Current Image Input -->
<tr>
<td>
<label>Current Image: </label>
</td>
</tr>
<tr>
<td>
<input type="text" size="50" name="sponsorship_image" value="<?php echo $edit_sponsorship_image;?>" value="<?php echo $sponsorship_image;?>"readonly>
</td>
</tr>


<!-- Submit Button -->
<tr>
<td>
<input class="orange_button" type="submit" name="submit" value="Update Sponsorship">
</td>
</tr>
</table>
</form>

<div><!-- footer for vunnava website -->  
			<?php
				
				echo"</div><div class=\"row\"><div class=\"col-md-12\">";
				printFooter();
						echo"</div></div>";
				?>
		</div>

</div>

<script type="text/javascript">
var abc = 0;      // Declaring and defining global increment variable.
$(document).ready(function() {
//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
$('#add_more').click(function() {
$(this).before($("<div/>", {
id: 'filediv'
}).fadeIn('slow').append($("<input/>", {
name: 'file[]',
type: 'file',
id: 'file'
}), $("<br/><br/>")));
});
// Following function will executes on change event of file input to select different file.
$('body').on('change', '#file', function() {
if (this.files && this.files[0]) {
abc += 1; // Incrementing global variable by 1.
var z = abc - 1;
var x = $(this).parent().find('#previewimg' + z).remove();
$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src='' width='500px' height='400px'/></div>");
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$(this).hide();
$("#abcd" + abc).append($("<img/>", {
id: 'img',

}).click(function() {
$(this).parent().parent().remove();
}));
}
});
// To Preview Image
function imageIsLoaded(e) {
$('#previewimg' + abc).attr('src', e.target.result);
};
$('#upload').click(function(e) {
var name = $(":file").val();
if (!name) {
alert("First Image Must Be Selected");
e.preventDefault();
}
});

$('.navbar-nav li').removeClass('active');
$('.navbar-nav li.page_create_project').addClass('active');

});

</script>
</body>
