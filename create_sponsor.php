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
			
                Add a Sponsor
				<small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Add Sponsor</li>
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
	$sponsor_first_name_error = $sponsor_last_name_error = $photo_error = "";
	$sponsor_first_name = $sponsor_last_name = $email = $phone = $bio = $address = $sponsor_notes
	= $photo = "";	


$_SESSION['confirmation_sponsor_first_name'] = $_SESSION['confirmation_sponsor_last_name'] = $_SESSION['confirmation_email'] = $_SESSION['confirmation_phone'] =
$_SESSION['confirmation_bio'] = $_SESSION['confirmation_address'] = $_SESSION['confirmation_sponsor_notes'] = 
$_SESSION['confirmation_image_reference'] = $_SESSION['confirmation_video_reference'] = $_SESSION['confirmation_photo'] ="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if (empty($_POST["sponsor_first_name"])){
		$sponsor_fist_name_error = " is required.";
	}
	else{
		$sponsor_first_name = test_input($_POST["sponsor_first_name"]);
	}
	
	if (empty($_POST["sponsor_last_name"])){
		$sponsor_last_name_error = " is required.";
	}
	else{
		$sponsor_last_name = test_input($_POST["sponsor_last_name"]);
	}

	if (empty($_POST["email"])){
		$email_error = "";
	}
	else{
		$email = test_input($_POST["email"]);
	}

	if (empty($_POST["phone"])){
		$phone = "";
	}
	else{
		$phone = test_input($_POST["phone"]);
	}

	if (empty($_POST["bio"])){
		$bio = "";
	}
	else{
		$bio = test_input($_POST["bio"]);
	}

	if (empty($_POST["address"])){
		$address = "";
	}
	else{
		$address = mysqli_real_escape_string($conn, test_input($_POST["address"]));
	}
	
	if (empty($_POST["sponsor_notes"])){
		$sponsor_notes = "";
	}
	else{
		$sponsor_notes= mysqli_real_escape_string($conn, test_input($_POST["sponsor_notes"]));
	}



	// Upload photo
	if(empty($_FILES['file']['name'][0])){
		$photo_error = "";
	}
	else{
	if (isset($_POST['submit'])) {
	$j = 0;     // Variable for indexing uploaded image.
	$target_path = "ProjectManagementSystem/sponsor_photo/";     // Declaring Path for uploaded photo.
	$sponsor_path = "ProjectManagementSystem/sponsor_photo/";
	for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
	// Loop to get individual element from the array
	$validextensions = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "svg", "SVG");      // Extensions which are allowed.
	$ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
	$file_extension = end($ext); // Store extensions in the variable.
	$target_path = "ProjectManagementSystem/sponsor_photo/" . basename($_FILES['file']['name'][$i]);     // Set the target path with a new name of image.
	if(count($_FILES['file']['name']) > 1 ){
		if ($i == 0){
			$sponsor_path = "ProjectManagementSystem/sponsor_photo/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else if($i > 0 && $i < count($_FILES['file']['name']) - 1){
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/sponsor_photo/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else {
			$sponsor_path = $sponsor_path  . "ProjectManagementSystem/sponsor_photo/" . basename($_FILES['file']['name'][$i]);
		}
	}
	else{
			$sponsor_path = "ProjectManagementSystem/sponsor_photo/" . basename($_FILES['file']['name'][$i]); 
	}
	
	$j = $j + 1;      // Increment the number of uploaded images according to the files in array.
	if (($_FILES["file"]["size"][$i] < 24000000)     // Approx. 24mb files can be uploaded.
	&& in_array($file_extension, $validextensions)) {
	if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
	// If file moved to uploads folder.
	echo $j. ').<span id="noerror">Picture uploaded successfully!.</span><br/><br/>';
	$photo = $sponsor_path;
	} 

	else {     //  If File Was Not Moved.
	echo $j. ').<span id="error">Error uploading image! Please try again!.</span><br/><br/>';
	$photo_error = "Error uploading picture! Please try again!";
	}
	}

	else {     //   If File Size And File Type Was Incorrect.
	echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
	$photo_error = "Invalid file size or type!";
	}
	}
	}
	}
	
// If no errors, go to confirmation page
	if($sponsor_first_name_error === "" && $sponsor_last_name_error === "" && $photo_error === ""){


				//Store sessions
		$_SESSION['confirmation_sponsor_first_name'] = $sponsor_first_name;
		$_SESSION['confirmation_sponsor_last_name'] = $sponsor_last_name;
		$_SESSION['confirmation_email'] = $email;
		$_SESSION['confirmation_phone'] = $phone;
		$_SESSION['confirmation_bio'] = $bio;
		$_SESSION['confirmation_address'] = $address;
		$_SESSION['confirmation_sponsor_notes'] = $sponsor_notes;
		$_SESSION['confirmation_photo'] = $photo;



	// Run Query
		if(isset($_POST['submit'])){
	$sql = "INSERT INTO sponsor (sponsor_first_name, sponsor_last_name, email, phone, bio, address, sponsor_notes, photo)
	VALUES ('$sponsor_first_name', '$sponsor_last_name', '$email', '$phone', '$bio', '$address', '$sponsor_notes', '$photo')";



//Close Connection
			if ($conn->query($sql) === TRUE) {
		    echo "New sponsor created successfully.";
			}
			else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
			}

			header('Location: view_sponsor.php');
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
<!-- sponsor First Name Input -->
<tr>
<td>
<label>Sponsor First Name: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="sponsor_first_name" value="<?php echo $sponsor_first_name;?>">
<span class="errors"><strong style="color: red;">* <?php echo $sponsor_first_name_error;?></strong></span>
</td>
</tr>

<!-- sponsor Last Name Input -->
<tr>
<td>
<label>Sponsor Last Name: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="sponsor_last_name" value="<?php echo $sponsor_last_name;?>">
<span class="errors"><strong style="color: red;">* <?php echo $sponsor_last_name_error;?></strong></span>
</td>

<!-- Phone Input -->
<tr>
<td>
<label>Phone Number: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="phone" value="<?php echo $phone;?>">
</td>
</tr>

<!-- Email Input -->
<tr>
<td>
<label>Email: </label>
</td>
</tr>
<tr>
<td>
<input type="text" name="email" value="<?php echo $email;?>">
</td>
</tr>


<!-- Bio Input -->
<tr>
<td>
<label>BIO: </label>
</td>
</tr>
<tr>
<td>
<textarea name="bio" rows="3" cols="40" maxlength="5000"><?php echo $bio;?></textarea>
</td>
</tr>

<!-- Address Input -->
<tr>
<td>
<label>Address: </label>
</td>
</tr>
<tr>
<td>
<textarea name="address" rows="3" cols="40" placeholder="Enter address..." maxlength="5000"><?php echo $address;?></textarea>
</td>
</tr>

<!-- Sponsor Notes Input -->
<tr>
<td>
<label>Notes: </label>
</td>
</tr>
<tr>
<td>
<textarea name="sponsor_notes" rows="3" cols="40" placeholder="Enter notes..." maxlength="5000"><?php echo $sponsor_notes;?></textarea>
</td>
</tr>

<!-- Upload sponsor Photo Input -->
<tr>
<td>
<label>Sponsor Picture: </label>
</td>
</tr>
<tr>
<td>
<div id="filediv">
<input type="file" name="file[]" id="file">

<span class="errors"><?php echo $photo_error;?></span>
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
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		</div>
       
</div>
</body>
