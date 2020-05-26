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
    <title><?php echo $parameters['systemname']->value ?> Add a Sponsor</title>
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
                Manage Projects
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Assign Sponsor to Project</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
                <li>
					<?php
					$fbLink = $parameters['facebooklink']->value;
					if($fbLink != null && $fbLink != '')
					{
                    	echo "<a target=\"_blank\" href=\"" . $fbLink .  "\"><i
                                class=\"fa fa-facebook-square fa-2x\"></i></a>";
					}?>
                </li>
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
	$sponsor_id_error = $project_id_error = "";
	$sponsor_name = $sponsor_id = $project_name = $project_id = "";	
	

$_SESSION['confirmation_sponsor_name'] = 
$_SESSION['confirmation_project_name'] =
$_SESSION['confirmation_sponsor_id'] = 
$_SESSION['confirmation_project_id'] ="";


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

	
	// If no errors, go to confirmation page
	if($sponsor_id_error === "" && $project_id_error === ""){


	//Store sessions
	$_SESSION['confirmation_sponsor_name'] = $sponsor_name;
	$_SESSION['confirmation_project_name'] = $project_name;
	$_SESSION['confirmation_sponsor_id'] = $sponsor_id;
	$_SESSION['confirmation_project_id'] = $project_id;

	// Run Query
		if(isset($_POST['submit'])){
	$sql = "INSERT INTO manage (sponsor_id, project_id)
	VALUES ('$sponsor_id', '$project_id')";

//Close Connection
			if ($conn->query($sql) === TRUE) {
		    echo "Sponsor added to project successfully\.";
			}
			else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
			}
			header('Location: view_manage.php');
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

<!-- Sposnsor Name Input -->
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
		echo "<select sponsor name='sponsor_id'>";
		$sql = "SELECT sponsor_id, sponsor_name FROM sponsor ORDER BY sponsor_name";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$sponsor_id = $row['sponsor_id'];
				$sponsor_name = $row['sponsor_name']; 
				echo '<option value="'.$sponsor_id.'">'.$sponsor_name.'</option>';        
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
			while ($row = $result->fetch_assoc()) {
				$project_id = $row['project_id'];
				$project_name = $row['project_name']; 
				echo '<option value="'.$project_id.'">'.$project_name.'</option>';                 
			}	
		}
		echo "</select>";
		?>
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
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		</div>

</div>
</body>
