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
    <title><?php echo $parameters['systemname']->value ?> View Sponsor</title>
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
			
                Sponsor View.
				<small><?php echo $parameters['systemname']->value ?></small>
            </h3>
			
			
			
			
            <ol class="breadcrumb">
				<li><a href="sponsor_list.php">Back to Sponsor List</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="active">Sponsor View</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
            </ul>
        </div>
		
    </div>
<?php
    require 'ProjectManagementSystem/configure.php';

		$sponsor_id = "";
		$sponsor_first_name = "";
		$sponsor_last_name = "";
		$email = "";
		$phone = "";
		$bio = "";
		$address = "";
		$sponsor_notes = "";
		$photo = "";
				
		$photo_array = [];
		
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
	$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name, email, phone, bio, address, sponsor_notes, photo FROM sponsor WHERE sponsor_first_name = '$sponsor_first_name' AND sponsor_last_name = '$sponsor_last_name'";
		$result = $conn->query($sql);
}

else{
$id = $_GET['id'];
	$sql = "SELECT sponsor_id, sponsor_first_name, sponsor_last_name, email, phone, bio, address, sponsor_notes, photo FROM sponsor WHERE sponsor_id = '$id'";
		$result = $conn->query($sql);
}

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    	// Grab dance ID
    	$sponsor_id = $row["sponsor_id"];

		$photo_array = explode(',', $row["photo"]);


// Display sponsor data
echo "
<table width='30%' class='view_sponsor_table' border='1px'>
<tr>
<td>
<!-- sponsor ID -->
Sponsor ID: 
</td>
<td>
". $row["sponsor_id"]."
</td>
</tr>

<tr>
<td>
<!-- Sponsor First Name Input -->
Sponsor First Name: 
</td>
<td>
". $row["sponsor_first_name"]."
</td>
</tr>

<tr>
<td>
<!-- Sponsor Last Name Input -->
Sponsor LastName: 
</td>
<td>
". $row["sponsor_last_name"]."
</td>
</tr>


<tr>
<td>
<!-- Email Input -->
Email: 
</td>
<td>
". $row["email"]."
</td>
</tr>



<tr>
<td>
<!-- Phone Input -->
Phone: 
</td>
<td>
". $row["phone"]."
</td>
</tr>

<tr>
<td>
<!-- Bio Input -->
Bio: 
</td>
<td>
". $row["bio"]."
</td>
</tr>

<tr>
<td>
<!-- Address Input -->
Address: 
</td>
<td>
". $row["address"]."
</td>
</tr>

<tr>
<td>
<!-- Notes Input -->
Notes: 
</td>
<td>
". $row["sponsor_notes"]."
</td>
</tr>

<tr>
<td>
<!-- Sponsor Picture Input -->
Sponsor Picture: 
</td>
<td>
";

if($photo_array[0] != ""){
	for ($i = 0; $i < sizeof($photo_array); $i++){
	echo '<img src="' . $photo_array[$i]. '" width="500" height="400"><br>';
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
		<input type="hidden" name="id" value="$sponsor_id"/>
		</form>';
}

else{

}
if (isset($_POST['action'])){
	if ($_POST['action'] && $_POST['id']){
		if ($_POST['action'] == 'Update'){
			header('Location: update.php?id=' . $sponsor_id);
		}

		else{
			header('Location: delete.php?id=' . $sponsor_id);
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

