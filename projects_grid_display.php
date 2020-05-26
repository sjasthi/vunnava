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

<?php
require 'ProjectManagementSystem/configure.php';

		$project_id = "";
		$project_name = "";
		$project_image = "";
		$dance_english_name = "";
		$dance_alternate_name = "";
		$dance_telugu_name = "";
		$dance_category = "";
		$dance_origin = "";
		$dance_description = "";
		$dance_image_reference = "";
		$dance_video_reference = "";
		$dance_key_words = "";

		// Split image and video strings by commas to parse for url
		$image_reference_array = [];

		$count = 0;
		$count_temp = 0;
		$row_count = 0;
		$homepage_show_total = 10;

// Establishing Connection with Server
$servername = DATABASE_HOST;
$db_username = DATABASE_USER;
$db_password = DATABASE_PASSWORD;
$database = DATABASE_DATABASE;

   		$homepage_show_total = '10';
   		$homepage_show_per_row = '5';

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully<br>";
$conn->set_charset("utf8");

	$sql = "SELECT * FROM project";
		$result = $conn->query($sql);



if ($result->num_rows > 0) {
		echo 
		'
		<div class="container top_space">
		';


    while($row = $result->fetch_assoc()) {
    	// Grab dance ID
    	$project_id = $row["project_id"];

    	$image_reference_array = explode(',', $row["project_image"]);


		if($image_reference_array[0] != "" && $count != $homepage_show_total){

			if($row_count == 0){
				echo '
				<div class="row">
				<div class="test_row_1">
				';
			}

			if($row_count < $homepage_show_per_row){
				echo '
				<div class="thumbnail_wrapper">
				<div class="thumbnail">
				<a href="projects.php?id=' .$row["project_id"]. '">
				<div class="thumbnail_image_wrapper" style="background:url(' . $image_reference_array[0]. ') no-repeat;">
				<img class="img-responsive" src="images/people/steven.jpg" width="150" height="150" alt="">
				</div>
			 	<div class="caption">
			 	';

			 
			 	echo '<p style="text-align: center">'. $row["project_name"].'</p>';
			 	
			 	
			 	echo '
			 	</div>
			 	</a>
			 	</div>
			 	</div>
				 ';

				 $row_count++;
			}

			if($row_count == $homepage_show_per_row){
				echo '
				</div>
				</div>
				';
			}


			if ($row_count >= $homepage_show_per_row){
				$row_count = 0;
			}

		$count++;
		}
	}

	

	echo'
	</div>
	';
}
	    



else {
    echo "0 results";
}

$conn->close();

?>

<footer>
<?php
				
				echo"</div><div class=\"row\"><div class=\"col-md-12\">";
				printFooter();
						echo"</div></div>";
				?>
</footer>	
</body>
</html>

