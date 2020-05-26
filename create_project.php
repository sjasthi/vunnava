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
 
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $parameters['systemname']->value ?> Add a Project</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- For Date Picker -->
  <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
 <link href="/resources/demos/style.css" rel="stylesheet" >
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
</head>

<body>

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
			
                Add a Project
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Add Project</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
            </ul>
        </div>
		
    </div>
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
	$project_name_error = $project_image_error = $project_image_url_error = "";
	$project_name = $proposed_by = $proposed_end_date= $proposed_start_date = $actual_end_date = 
	$actual_start_date = $description = $project_notes = $project_type = $frequency = $project_status
	= $project_image_url = $project_image = "";	


$_SESSION['confirmation_project_name'] = $_SESSION['confirmation_proposed_by'] = $_SESSION['confirmation_proposed_end_date'] =
$_SESSION['confirmation_proposed_start_date'] = $_SESSION['confirmation_description'] = 
$_SESSION['confirmation_project_notes'] = $_SESSION['confirmation_project_type'] = 
$_SESSION['confirmation_frequency']= $_SESSION['confirmation_actual_end_date'] = 
$_SESSION['confirmation_actual_start_date'] =
$_SESSION['confirmation_project_status'] = $_SESSION['confirmation_image_reference'] = 
$_SESSION['confirmation_project_image'] = $_SESSION['confirmation_project_image_url'] ="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if (empty($_POST["project_name"])){
		$project_name_error = "is required.";
	}
	else{
		$project_name = test_input($_POST["project_name"]);
	}
	
	if (empty($_POST["proposed_by"])){
		$proposed_by = "";
	}
	else{
		$proposed_by = test_input($_POST["proposed_by"]);
	}

	if (empty($_POST["proposed_end_date"])){
		$proposed_end_date = "";
	}
	else{
		$proposed_end_date = test_input($_POST["proposed_end_date"]);
	}

	if (empty($_POST["proposed_start_date"])){
		$proposed_start_date = "";
	}
	else{
		$proposed_start_date = test_input($_POST["proposed_start_date"]);
	}
	if (empty($_POST["actual_end_date"])){
		$actual_end_date = "";
	}
	else{
		$actual_end_date = test_input($_POST["actual_end_date"]);
	}

	if (empty($_POST["actual_start_date"])){
		$actual_start_date = "";
	}
	else{
		$actual_start_date = test_input($_POST["actual_start_date"]);
	}

	if (empty($_POST["description"])){
		$description = "";
	}
	else{
		$description = test_input($_POST["description"]);
	}
	
	if (empty($_POST["project_notes"])){
		$project_notes = "";
	}
	else{
		$project_notes = test_input($_POST["project_notes"]);
	}

	if (empty($_POST["project_type"])){
		$project_type = "";
	}
	else{
		$project_type = test_input($_POST["project_type"]);
	}
	
	if (empty($_POST["frequency"])){
		$frequency = "";
	}
	else{
		$frequency = test_input($_POST["frequency"]);
	}
	
	if (empty($_POST["project_status"])){
		$project_status = "";
	}
	else{
		$project_status = test_input($_POST["project_status"]);
	}

	if (empty($_POST["project_image_url"])){
		$project_image_url = "";
	}
	else{
		$project_image_url = test_input($_POST["project_image_url"]);
	}
	
// Upload project image
	if(empty($_FILES['file']['name'][0])){
		$project_image_error = "";
	}
	else{
	if (isset($_POST['submit'])) {
	$j = 0;     // Variable for indexing uploaded project image.
	$target_path = "ProjectManagementSystem/project_image/";     // Declaring Path for uploaded photo.
	$sponsor_path = "ProjectManagementSystem/project_image/";
	for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
	// Loop to get individual element from the array
	$validextensions = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "svg", "SVG");      // Extensions which are allowed.
	$ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
	$file_extension = end($ext); // Store extensions in the variable.
	$target_path = "ProjectManagementSystem/project_image/" . basename($_FILES['file']['name'][$i]);     // Set the target path with a new name of image.
	if(count($_FILES['file']['name']) > 1 ){
		if ($i == 0){
			$sponsor_path = "ProjectManagementSystem/project_image/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else if($i > 0 && $i < count($_FILES['file']['name']) - 1){
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/project_image/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else {
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/project_image/" . basename($_FILES['file']['name'][$i]);
		}
	}
	else{
			$sponsor_path = "ProjectManagementSystem/project_image/" . basename($_FILES['file']['name'][$i]); 
	}
	
	$j = $j + 1;      // Increment the number of uploaded images according to the files in array.
	if (($_FILES["file"]["size"][$i] < 24000000)     // Approx. 24mb files can be uploaded.
	&& in_array($file_extension, $validextensions)) {
	if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
	// If file moved to uploads folder.
	echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
	$project_image = $sponsor_path;
	} 

	else {     //  If File Was Not Moved.
	echo $j. ').<span id="error">Error uploading image! Please try again!.</span><br/><br/>';
	$project_image_error = "Error uploading image! Please try again!";
	}
	}

	else {     //   If File Size And File Type Was Incorrect.
	echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
	$project_image_error = "Invalid file size or type!";
	}
	}
	}
	}

	
// If no errors, go to confirmation page
	if($project_name_error === "" && $project_image_error === ""){


				//Store sessions
		$_SESSION['confirmation_project_name'] = $project_name;
		$_SESSION['confirmation_proposed_by'] = $proposed_by;
		$_SESSION['confirmation_proposed_end_date'] = $proposed_end_date;
		$_SESSION['confirmation_proposed_start_date'] = $proposed_start_date;
		$_SESSION['confirmation_actual_end_date'] = $actual_end_date;
		$_SESSION['confirmation_actual_start_date'] = $actual_start_date;
		$_SESSION['confirmation_description'] = $description;
		$_SESSION['confirmation_project_notes'] = $project_notes;
		$_SESSION['confirmation_project_type'] = $project_type;
		$_SESSION['confirmation_frequency'] = $frequency;
		$_SESSION['confirmation_project_status'] = $project_status;
		$_SESSION['confirmation_project_image'] = $project_image;
		$_SESSION['confirmation_project_image_url'] = $project_image_url;



	// Run Query
		if(isset($_POST['submit'])){
	$sql = "INSERT INTO project (project_name, proposed_by, frequency, project_status, proposed_end_date, 
	proposed_start_date, actual_end_date, actual_start_date, description, 
	project_notes, project_type, project_image, project_image_url)
	VALUES ('$project_name', '$proposed_by', '$frequency', '$project_status','$proposed_end_date', '$proposed_start_date', 
	'$actual_end_date', '$actual_start_date','$description', 
	'$project_notes','$project_type', '$project_image', '$project_image_url')";



//Close Connection

			if ($conn->query($sql) === TRUE) {
		    echo "New project created successfully.";
			}
			else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
			}
			header("Location: view_project.php");

		}
			}
		}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<span class="errors"><strong style="color: red;">* required field.</strong></span>
<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table width=50% class="suggest_dance_table">
<!-- Project Name Input -->
<tr>
<td>
<label>Project Name: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="project_name" value="<?php echo $project_name;?>">
<span class="errors"><strong style="color: red;">* <?php echo $project_name_error;?></strong></span>
</td>
</tr>

<!-- proposed byInput -->
<tr>
<td>
<label>Proposed By: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="proposed_by" value="<?php echo $proposed_by;?>">
 
</td>
</tr>

<!-- project Type Input -->
<tr>
<td>
<label>Project Type: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="project_type" value="<?php echo $project_type;?>">
</td>
</tr>

<!-- Frequency Input -->
<tr>
<td>
<label>Frequency: </label>
</td>
</tr>
<tr>
<td>
<select name="frequency">
				<option <?php if (isset($frequency) && $frequency=="Onetime") echo "selected";?>>Onetime</option>
				<option <?php if (isset($frequency) && $frequency=="Monthly") echo "selected";?>>Monthly</option>
				<option <?php if (isset($frequency) && $frequency=="Yearly") echo "selected";?>>Yearly</option>
				<option <?php if (isset($frequency) && $frequency=="Other") echo "selected";?>>Other</option>
				</select>
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
<select name="project_status">
				<option <?php if (isset($project_status) && $project_status=="Submitted") echo "selected";?>>Submitted</option>
				<option <?php if (isset($project_status) && $project_status=="Proposed") echo "selected";?>>Proposed</option>
				<option <?php if (isset($project_status) && $project_status=="Completed") echo "selected";?>>Completed</option>
				<option <?php if (isset($project_status) && $project_status=="In Progress") echo "selected";?>>In Progress</option>
				<option <?php if (isset($project_status) && $project_status=="Cancelled") echo "selected";?>>Cancelled</option>
				<option <?php if (isset($project_status) && $project_status=="Other") echo "selected";?>>Other</option>
				</select>
</td>
</tr>

<!-- Image URL Input -->
<tr>
<td>
<label>Image URL: </label>
</td>
</tr>
<tr>
<td>
<textarea name="project_image_url" rows="1" cols="40" placeholder="https://www.wikipedia.com/project/images" maxlength="5000"><?php echo $project_image_url;?></textarea>
</td>
</tr>

<!-- Description Input -->
<tr>
<td>
<label>Description: </label>
</td>
</tr>
<tr>
<td>
<textarea name="description" rows="2" cols="40" placeholder="Project Description..." maxlength="5000"><?php echo $description;?></textarea>
</td>
</tr>

<!-- Project Notes Input -->
<tr>
<td>
<label>Notes: </label>
</td>
</tr>
<tr>
<td>
<textarea name="project_notes" rows="3" cols="40" placeholder="Enter notes..." maxlength="5000"><?php echo $project_notes;?></textarea>
</td>
</tr>

<!-- proposed_start_date Input -->
<tr>
<td>
<label>Proposed Start Date: </label>
</td>
</tr>
<tr>
<td>
<input type="text" id="proposed_start_date" class="datepicker" name="proposed_start_date" value="<?php echo $proposed_start_date;?>">
</td>
</tr>


<!-- proposed_end_date Input -->
<tr>
<td>
<label>Proposed End Date: </label>
</td>
</tr>
<tr>
<td>
<input type="text" id="proposed_end_date" class="datepicker" name="proposed_end_date" value="<?php echo $proposed_end_date;?>">
</td>
</tr>


<!-- actual_start_date Input -->
<tr>
<td>
<label>Actual Start Date: </label>
</td>
</tr>
<tr>
<td>
<input type="text" id="actual_start_date" class="datepicker" name="actual_start_date" value="<?php echo $actual_start_date;?>">

</td>
</tr>

<!-- actual_end_date Input -->
<tr>
<td>
<label>Actual End Date: </label>
</td>
</tr>
<tr>
<td>
<input type="text" id="actual_end_date" class="datepicker" placeholder="*Displayed by this date." name="actual_end_date" value="<?php echo $actual_end_date;?>">
</td>
</tr>

<!-- Upload Project Image Input -->
<tr>
<td>
<label>Project Image: </label>
</td>
</tr>
<tr>
<td>
<div id="filediv">
<input type="file" name="file[]" id="file">

<span class="errors"><?php echo $project_image_error;?></span>
</div>
</td>
</tr>



<!-- Submit Button -->
<tr>
<td>
<input class="orange_button" type="submit" name="submit" value="Submit">
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


<script>
	  $(function() {
		   $('input').filter('.datepicker').datepicker({
			//changeMonth: true,
			//changeYear: true,
		   // showOn: 'button',
		   // buttonImage: 'jquery/images/calendar.gif',
		   //buttonImageOnly: true
		   });
	  });
 </script> 

</body>
</html>
