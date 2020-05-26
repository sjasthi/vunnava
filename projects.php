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
                Project Details
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
			 <li><a href="projects_displayed.php?id=0">Back to Project List</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="active">Projects</li>
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

		$sponsor_first_name = "";
		$sponsor_id = "";
		$sponsor_last_name = "";
		$project_id = "";
		$project_name = "";
		$address = "";
		$project_image = "";
		$bio = "";
		$email = "";
		$project_status = "";
		$sponsorship_details = "";
		$sponsorship_image = "";
		$phone = "";
		$photo = "";
		$amount = "";
		$project_type = "";
		$reason = "";
		$actual_end_date = ""; 
		$already_displayed = false;

		// Split image and video strings by commas to parse for url
		$photo_array = [];
		$photo_reference_set = false;


		// Sort status
		$sort = "";
		

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

$conn->set_charset("utf8");



?>
</div>
</div>
<?php
if (empty($_GET)){
	$sql = "SELECT project_id, project_image, project_status, sponsor_id, sponsor_first_name, sponsor_last_name, project_name, address, bio, email, phone, photo, amount, sponsorship_details, sponsorship_image FROM project natural join sponsor natural join sponsorship ORDER BY project_name LIMIT 1";
		$result = $conn->query($sql);
		
		$sql = "SELECT project_id, sponsor_id, sponsor_first_name, project_image, project_status, sponsor_last_name, bio, project_name, project_type, description, actual_end_date, amount, sponsorship_details, sponsorship_image FROM project natural join sponsor natural join sponsorship ORDER BY project_id LIMIT 1";
		$result1 = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT project_id, sponsor_id, sponsor_first_name, sponsor_last_name, project_image, project_status, project_name, address, bio, email, phone, photo, amount, sponsorship_details,sponsorship_image FROM project natural join sponsor natural join sponsorship WHERE project_id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "SELECT project_id, sponsor_id, sponsor_first_name, sponsor_last_name, project_image, project_status, bio, project_name, project_type, description, actual_end_date, amount, sponsorship_details, sponsorship_image FROM project natural join sponsor natural join sponsorship WHERE project_id = '$id'";
		$result1 = $conn->query($sql);
}
if ($result->num_rows < 1) {
	$id = $_GET['id'];
	$sql = "SELECT project_id, project_name,  project_type, description, project_image, project_status, actual_end_date FROM project WHERE project_id = '$id'";
		$result1 = $conn->query($sql);
}



if ($result1->num_rows > 0) {

    while($row1 = $result1->fetch_assoc()) {
    	// Grab dance ID
    	$project_id = $row1["project_id"];
		
		
	if($already_displayed == false){//display once	
			// Display data from project table
		echo '
		<div class="dance_display_description_row3">
		
			<div id="main_content_dimension">	
				<article id="article_sponsor_right">
				
				<!-- Project Name -->
				<p class="project_name">
					<strong>Project: 
					'."(". $row1['project_id'].") ". $row1['project_name'].'
					</strong>
				</p>
				
				<!-- Project Image -->
			';
			if($row1['project_image'] != ""){//only display if exists
				echo '	
				<p class="project_image">
				<img src="'. $row1['project_image'].'" width="auto" height="300">				
				</p>
				';
			}
			echo '
				<!-- project_status -->
				<p class="project_status">
					<strong>Status:</strong> 
					'. $row1['project_status']." on ". $row1['actual_end_date'].'
				</p>

				<!-- description -->
				<p class="description">
					<strong>Project Description:</strong>  
					'. $row1['description'].'
				</p>
				</article>
		 </div>
		</div>
		';		
	}
	$already_displayed = true;
	}
}


if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab dance ID
    	$project_id = $row["project_id"];

		$photo_array = explode(',', $row["photo"]);


		
echo'</div><div style="width: auto; margin-left: 125px; margin-left: 150px;">';

if($photo_array[0] != ""){
	$photo_reference_set = true;
}
else{
	$photo_reference_set = false;
}
if($photo_reference_set == true){
	for ($i = 0; $i < sizeof($photo_array); $i++){
	if($i == 0){
		echo '<div class="item active">
					<img src="' . $photo_array[$i]. '" width="auto" height="200">
			  </div>';
	}
	else{
		echo '<div class="item">
					<img src="' . $photo_array[$i]. '" width="auto" height="200">
			  </div>';
	}
}
}
echo'

<p class="sponsor_first_name">
<!-- sponsor Name Input -->
Name:
<a href="sponsors.php?id='.$row['sponsor_id'].'">'. $row['sponsor_first_name']." ".$row['sponsor_last_name'].'</a>

</p>

';
if($row['bio'] != ""){//only display BIO if present
			echo'
			
					<p class="bio">
					<!-- BIO Input -->
					'."<strong>BIO: </strong>". $row['bio'].'
					</p>
			
			';
		}
	
echo'
			<!-- amount -->
				<p class="amount">
					<strong>Amount Donated:</strong> 
					'. $row['amount'].'
				</p>

						';
			if($row['sponsorship_details'] != ""){//only display if exists
				echo '	
				<!-- sponsorship details -->
				<p class="sponsorship details">
					<strong>Sponsorship Details:</strong>  
					'. $row['sponsorship_details'].'
				</p>
					';
						}
						echo'	
						<!-- Sponsorship Image -->
			';
			if($row['sponsorship_image'] != ""){//only display if exists
				echo '	
				<p class="project_image"> 
					<img src="'. $row['sponsorship_image'].'" width="auto" height="200">
				</p>
			';	
			}
	';
';
;
}
} 

$conn->close();

?>

<script type="text/javascript">

    // Hide carousel controls if only one image
    $('.carousel-inner').each(function() {
    if ($(this).children('div').length === 1) $(this).siblings('.carousel-control, .carousel-indicators').hide();
	});
	$('.navbar-nav li').removeClass('active');
	$('.navbar-nav li.page_projects').addClass('active');
</script>
<div><!-- footer for vunnava website -->  
			<?php
				
				echo"<div class=\"row\"><div class=\"col-md-12\">";
				printFooter();
						echo"</div></div>";
				?>
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		</div>
</body>
</html>

