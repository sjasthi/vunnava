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
    <title><?php echo $parameters['systemname']->value ?> Edit a Sponsorship</title>
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
			
                A Sponsorship has been edited.
				<small><?php echo $parameters['systemname']->value ?></small>
            </h3>
			
			
            <ol class="breadcrumb">
				<li><a href="sponsorship_list.php">Back to Sponsorship List</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="active">Sponsorship Edited</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
    
            </ul>
        </div>
		
    </div>
  
  
<?php
    require 'ProjectManagementSystem/configure.php';

		$sponsorship_id = "";
		$project_id = $_SESSION['confirmation_project_id'];
		$sponsor_id = $_SESSION['confirmation_sponsor_id'];
		$amount = $_SESSION['confirmation_amount'];
		$sponsorship_status = $_SESSION['confirmation_sponsorship_status'];
		$sponsorship_details = $_SESSION['confirmation_sponsorship_details'];
		$sponsorship_notes = $_SESSION['confirmation_sponsorship_notes'];
		$sponsorship_image = $_SESSION['confirmation_sponsorship_image'];
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
	$sql = "SELECT sponsorship_id, sponsor_id, project_id, amount, sponsorship_status, sponsorship_details, sponsorship_notes, sponsorship_image FROM sponsorship WHERE sponsor_id = '$sponsor_id' AND project_id = '$project_id' ";
		$result = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT sponsorship_id, sponsor_id, project_id, amount, sponsorship_status, sponsorship_details, sponsorship_notes, sponsorship_image FROM sponsorship WHERE sponsorship_id = '$id'";
		$result = $conn->query($sql);
}

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab ID
    	$sponsorship_id = $row["sponsorship_id"];
		$image_array = explode(',', $row["sponsorship_image"]);


// Display sponsor data
echo "
<table width='30%' class='view_sponsorship_table' border='1px'>
	<tr>
		<td>
			<!-- sponsorship ID -->
			Sponsorship ID: 
		</td>
		<td>
			". $row["sponsorship_id"]."
		</td>
	</tr>

	<tr>
		<td>
			<!-- Sponsor ID Input -->
			Sponsor ID: 
		</td>
		<td>
			". $row["sponsor_id"]."
		</td>
	</tr>


	<tr>
		<td>
			<!-- Project ID Input -->
			Project ID: 
		</td>
		<td>
			". $row["project_id"]."
		</td>
	</tr>
	
	
	<tr>
		<td>
			<!-- Amount Input -->
			Amount: 
		</td>
		<td>
			". $row["amount"]."
		</td>
	</tr>
	
	<tr>
		<td>
			<!-- Status Input -->
			Status: 
		</td>
		<td>
			". $row["sponsorship_status"]."
		</td>
	</tr>
	
	<tr>
		<td>
			<!-- Details Input -->
			Details: 
		</td>
		<td>
			". $row["sponsorship_details"]."
		</td>
	</tr>
	
	<tr>
		<td>
			<!-- Notes Input -->
			Notes: 
		</td>
		<td>
			". $row["sponsorship_notes"]."
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
<br>
	
	
	
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
		<input type="hidden" name="id" value="$sponsorship_id"/>
		</form>';
}

else{

}

if (isset($_POST['action'])){
	if ($_POST['action'] && $_POST['id']){
	if ($_POST['action'] == 'Update'){
		header('Location: update.php?id=' . $sponsorship_id);
	}

	else{
		header('Location: delete.php?id=' . $sponsorship_id);
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

</body>
</html>

