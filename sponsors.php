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
			
                Sponsor Details
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
				<li><a href="sponsors_displayed.php?id=0">Back to Sponsor List</a></li>
                <li><a href="index.php">Home</a> </li>
                <li class="active">List of Sponsors</li>
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

		$sponsor_id = "";
		$sponsor_first_name = "";
		$sponsor_last_name = "";
		$sponsorship_image = "";
		$address = "";
		$amount = "";
		$bio = "";
		$email = "";
		$phone = "";
		$photo = "";
		$project_name = "";
		$project_image = "";
		$sponsorship_details = "";
		$project_image_url = "";
		$project_id = "";
		$project_status = "";
	    $proposed_start_date = "";
		$project_type = "";
		$description = "";
		$actual_end_date = ""; 
		$already_displayed = false;
		$projects_displayed = false;
		$thank_you_photo = "ProjectManagementSystem/sponsor_photo/thank you.jpg";

		// Split image and video strings by commas to parse for url
		$photo_array = [];
		$photo_reference_set = false;
		
		$image_reference_array = [];

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
	$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name, amount, address, amount, sponsorship_details, bio, email, phone, photo, sponsorship_image FROM sponsor natural join sponsorship natural join project ORDER BY sponsor_last_name, actual_end_date LIMIT 1";
		$result = $conn->query($sql);
		
		$sql = "SELECT sponsor_id, project_name, project_image, project_image_url, project_id, amount, sponsorship_details, project_status, proposed_start_date, project_type, description, actual_end_date, sponsorship_image FROM project natural join sponsor natural join sponsorship ORDER BY sponsor_id LIMIT 1";
		$result1 = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name, address, bio, email, phone, amount, sponsorship_details, photo,sponsorship_image FROM sponsor natural join sponsorship natural join project WHERE sponsor_id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "SELECT sponsor_id, project_name, project_image, project_image_url, project_id, project_status, proposed_start_date, project_type, amount, sponsorship_details, description, actual_end_date, sponsorship_image FROM project natural join sponsor natural join sponsorship WHERE sponsor_id = '$id'";
		$result1 = $conn->query($sql);
}
if ($result->num_rows < 1) {
	$id = $_GET['id'];
	$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name, address, bio, email, phone, photo FROM sponsor WHERE sponsor_id = '$id'";
		$result = $conn->query($sql);
}
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab sponsor ID
    	$sponsor_id = $row["sponsor_id"];

		$photo_array = explode(',', $row["photo"]);
					

// Display sponsor data
echo '<div class="col-md-10 sponsors_display top_space">
<div class="sponsor_display_description">
<div class="sponsor_display_description_row1">
<div class="wrapper">
<div class="sponsor_id">
';
		if($already_displayed == false){
			if($photo_array[0] != ""){
				for ($i = 0; $i < sizeof($photo_array); $i++){
					if($i == 0){
						echo '<img src="' . $photo_array[$i]. '" width="auto" height="200">';
					}
					else{
						echo '<img src="' . $photo_array[$i]. '" width="auto" height="200">';
					}
				}
			}
			else{
				echo '<img src="' . $thank_you_photo. '" width="auto" height="200">';
				};	
				echo'
		</div>
		<p class="sponsor_first_name">
		<!-- sponsor Name Input -->
		'."<h2> ".$row['sponsor_first_name']." ". $row['sponsor_last_name']."</h2> ".'
		</p>	
	</div>';
	
	
		if($row['bio'] != ""){//only display BIO if present
			echo'
			</div>
				<div class="wrapper">
					<p class="bio">
					<!-- BIO Input -->
					'."<strong>BIO: </strong>". $row['bio'].'
					</p>
				</div>
			</div>
			';
		}
	
	
	
	
}
$already_displayed = true;//set true after displayed once
	
	
	
}
} 



if ($result1->num_rows > 0) {

    while($row1 = $result1->fetch_assoc()) {
    	// Grab dance ID
    	$sponsor_id = $row1["sponsor_id"];
		$photo_array = explode(',', $row["photo"]);
		
		
		// Display data from project table
	echo '
	<div class="dance_display_description_row3">
			';
			if($projects_displayed == false){
				$projects_displayed = true;
				echo '	
				<article id="article_donor_right">
				<h3>
					<center>Projects Sponsored</center>
				</h3></article>
				
				';
			}
			echo '
				
				<!-- Project Name -->
				<p class="project_name">
					<strong>Project: 
						<a href="projects.php?id='.$row1['project_id'].'">'."(". $row1['project_id'].") ". $row1['project_name'].'</a>
					</strong>
				</p>	
				
				<!-- Project Image -->
			';
			if($row1['project_image'] != ""){//only display if exists
				echo '	
				<p class="project_image"> 
				<img src="'. $row1['project_image'].'" width="auto" height="200">
				</p>
				
				';
			}
			echo '
				
				
				
				
				<!-- project_status -->
				<p class="project_status">
					<strong>Status:</strong> 
					'. $row1['project_status']." on ". $row1['actual_end_date'].'
				</p>

				<!-- amount -->
				<p class="amount">
					<strong>Amount Donated:</strong> 
					'. $row1['amount'].'
				</p>

				<!-- description -->
				<p class="description">
					<strong>Project Description:</strong>  
					'. $row1['description'].'
				</p>
				
				
					';
			if($row1['sponsorship_details'] != ""){//only display if exists
				echo '	
				<!-- sponsorship details -->
				<p class="sponsorship details">
					<strong>Sponsorship Details:</strong>  
					'. $row1['sponsorship_details'].'
				</p>
					';
						}
				echo'			


				
				<!-- Sponsorship Image -->
			';
			if($row1['sponsorship_image'] != ""){//only display if exists
				echo '	
				<p class="project_image"> 
					<img src="'. $row1['sponsorship_image'].'" width="auto" height="200">
				</p>
				
				';
			}
			
			//note:Iframe will only work with the first 28 digit ID from google drive following the folders/ example below
			//<!--https://drive.google.com/drive/folders/0B20X0UyYy7uTNjNjY2JraTFGbms?usp=sharing-->
			//<!--https://drive.google.com/drive/folders/0B20X0UyYy7uTeHBGdWhjV1dNckk-->
			$projectImageURL = '';
			$projectImageURL = $row1['project_image_url'];	
			if($projectImageURL != ''){//do not do Iframe if empty set
				list($url, $urlID) = explode("folders/", $projectImageURL);//split into $URLID
				$first28ID = mb_substr($urlID, 0, 28, 'utf-8');//use only first 28 characters for id
				echo'			
				<iframe src="https://drive.google.com/embeddedfolderview?id='.$first28ID.'#grid" style="width:100%; height:300px; border:0;"></iframe>
			';}echo'
		</article>
	 </div>
			
	
	

	</div>

	';
		
		
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
	$('.navbar-nav li.page_sponsors').addClass('active');
</script>

		<div><!-- footer for vunnava website -->  
			<?php
				
				echo"</div><div class=\"row\"><div class=\"col-md-12\">";
				printFooter();
						echo"</div></div>";
				?>
		</div>
</body>
</html>

