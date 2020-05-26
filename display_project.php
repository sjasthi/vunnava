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
    <title><?php echo $parameters['systemname']->value ?> View Project</title>
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
<div class="container top_space">
<div class="row">
		
        <div class="col-lg-12">
		<h1 style="padding-bottom: 20px"></h1>
            <h3 class="page-header">
			
                Project View.
				<small><?php echo $parameters['systemname']->value ?></small>
            </h3>
			
			
			
			
            <ol class="breadcrumb">
				<li><a href="project_list.php">Back to Project List</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="active">Project View</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
            </ul>
        </div>
		
    </div>

<?php
    require 'ProjectManagementSystem/configure.php';
		$project_id = "";
		$project_name = "";
		$proposed_by = "";
		$proposed_end_date = "";
		$proposed_start_date = "";
		$description = "";
		$project_notes = "";
		$project_type = "";
		$frequency = "";
		$actual_end_date = "";
		$actual_start_date = "";
		$project_status = "";
		$project_image = "";
		$project_image_url = "";
		$image_array = [];
 
		
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
if (empty($_GET)){
	$sql = "SELECT 	project_name, proposed_by, proposed_end_date, proposed_start_date, description, project_notes, project_type, frequency, actual_end_date, actual_start_date, project_status, project_image, project_image_url FROM project WHERE project_name = '$project_name'";
		$result = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT 	project_id, project_name, proposed_by, proposed_end_date, proposed_start_date, description, project_notes, project_type, frequency, actual_end_date, actual_start_date, project_status, project_image, project_image_url FROM project WHERE project_id = '$id'";
		$result = $conn->query($sql);
}


if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab dance ID
    	$project_name = $row["project_name"];
		$image_array = explode(',', $row["project_image"]);



// Display project data
echo "
<table width='30%' class='view_project_table' border='1px'>
<tr>
<td>
<!-- Project Name -->
Project Name: 
</td>
<td>
". $row["project_name"]."
</td>
</tr>

<tr>
<td>
<!-- Proposed By -->
Proposed By: 
</td>
<td>
". $row["proposed_by"]."
</td>
</tr>

<tr>
<td>
<!-- project_type Input -->
Project Type: 
</td>
<td>
". $row["project_type"]."
</td>
</tr>

<tr>
<td>
<!-- Frequency Input -->
Frequency: 
</td>
<td>
". $row["frequency"]."
</td>
</tr>

<tr>
<td>
<!-- Status Input -->
Status: 
</td>
<td>
". $row["project_status"]."
</td>
</tr>

<tr>
<td>
<!-- Image URL Input -->
Images URL: 
</td>
<td>
". $row["project_image_url"]."
</td>
</tr>

<tr>
<td>
<!-- DescriptionInput -->
Description: 
</td>
<td>
". $row["description"]."
</td>
</tr>

<tr>
<td>
<!-- Notes Input -->
Notes: 
</td>
<td>
". $row["project_notes"]."
</td>
</tr>

<tr>
<td>
<!-- Proposed Start Date Input -->
Proposed Start Date: 
</td>
<td>
". $row["proposed_start_date"]."
</td>
</tr>

<tr>
<td>
<!-- Proposed End Date Input -->
Proposed End Date: 
</td>
<td>
". $row["proposed_end_date"]."
</td>
</tr>

<tr>
<td>
<!-- Actual Start Date Input -->
Actual Start Date: 
</td>
<td>
". $row["actual_start_date"]."
</td>
</tr>

<tr>
<td>
<!-- Actual End Date Input -->
Actual End Date: 
</td>
<td>
". $row["actual_end_date"]."
</td>
</tr>

<tr>
<td>
<!-- Image Input -->
Image: 
</td>
<td>
";

if($image_array[0] != ""){
	for ($i = 0; $i < sizeof($image_array); $i++){
	echo '<img src="' . $image_array[$i]. '" width="500" height="400"><br>';
}
}

// Loop through image array, display photos
echo "
</td>
</tr>

</table>
<br>"
;
    }
} 

else {
    echo "0 results";
}

if(isset($_SESSION['username'])){
    echo '
		<br>
		<form method="post" action="">
		<!--<input class="orange_button" type="submit" name="action" value="Update" />-->
		<!--<input class="orange_button" type="submit" name="action" value="Delete" />-->
		<input type="hidden" name="id" value="$project_name"/>
		</form>';
}

else{

}

if (isset($_POST['action'])){
	if ($_POST['action'] && $_POST['id']){
	if ($_POST['action'] == 'Update'){
		header('Location: update.php?id=' . $project_name);
	}

	else{
		header('Location: delete.php?id=' . $project_name);
	}
}

}


$conn->close();

?>



		<div><!-- footer for vunnava website -->  
			<?php
				
				echo"</div><div class=\"row\"><div class=\"col-md-12\">";
				printFooter();
						echo"</div></div>";
				?>
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		</div>
</div>
</div>

</body>
</html>

