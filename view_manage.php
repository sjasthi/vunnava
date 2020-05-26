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
<div class="container top_space">
<div class="row">
		
        <div class="col-lg-12">
		<h1 style="padding-bottom: 20px"></h1>
            <h3 class="page-header">
			
                A Sponsor has been added to a Project.
				<small><?php echo $parameters['systemname']->value ?></small>
            </h3>
			
			
			
			
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Sponsor added to Project</li>
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
  
  
<?php
    require 'ProjectManagementSystem/configure.php';

		$manage_id = "";
		$project_id = $_SESSION['confirmation_project_id'];
		$sponsor_id = $_SESSION['confirmation_sponsor_id'];
		
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
	$sql = "SELECT manage_id, sponsor_id, project_id FROM manage WHERE sponsor_id = '$sponsor_id'";
		$result = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT manage_id, sponsor_id, project_id FROM manage WHERE sponsor_id = '$id'";
		$result = $conn->query($sql);
}

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab ID
    	$manage_id = $row["manage_id"];


// Display sponsor data
echo "
<table width='30%' class='view_manage_table' border='1px'>
	<tr>
		<td>
			<!-- Manage ID -->
			Manage ID: 
		</td>
		<td>
			". $row["manage_id"]."
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
		<input type="hidden" name="id" value="$manage_id"/>
		</form>';
}

else{

}

if (isset($_POST['action'])){
	if ($_POST['action'] && $_POST['id']){
	if ($_POST['action'] == 'Update'){
		header('Location: update.php?id=' . $manage_id);
	}

	else{
		header('Location: delete.php?id=' . $manage_id);
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

