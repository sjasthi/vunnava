<?php include 'navigation.php';

// Start session to store variables
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

// Allows user to return 'back' to this page
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

 ?>

<div class="container top_space">
  <h3>Update</h3>
<?php
require 'db_configuration.php';

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
	$dance_english_name_error = $dance_category_error = $dance_image_reference_error = $dance_video_reference_error = $dance_status_error = 
	$artist_images_error = $links_error = "";

if (empty($_GET)){
	echo "No dance selected.";
	$dance_english_name = "";
	$dance_alternate_name = "";
	$dance_telugu_name = "";
	$dance_category = "";
	$dance_origin = "";
	$dance_description = "";
	$dance_image_reference = "";
	$dance_video_reference = "";
	$dance_key_words = "";	
	$dance_status = "";
	$artist_images = "";
	$links = "";
}

else{
$id = $_GET['id'];

	$dance_english_name = "";
	$dance_alternate_name = "";
	$dance_telugu_name = "";
	$dance_category = "";
	$dance_origin = "";
	$dance_description = "";
	$dance_image_reference = "";
	$dance_video_reference = "";
	$dance_key_words = "";	
	$dance_status = "";
	$artist_images = "";
	$links = "";

	$sql = "SELECT dance_id, dance_english_name, dance_alternate_name, dance_telugu_name, dance_category, dance_origin, dance_description, dance_image_reference, dance_video_reference, dance_key_words, dance_status, artist_images, links FROM dances WHERE dance_id = '$id'";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if (empty($_POST["dance_english_name"])){
		$dance_english_name_error = "is required.";
	}
	else{
		$dance_english_name = test_input($_POST["dance_english_name"]);
	}

	if (empty($_POST["dance_alternate_name"])){
		$dance_alternate_name = "";
	}
	else{
		$dance_alternate_name = test_input($_POST["dance_alternate_name"]);
	}

	if (empty($_POST["dance_telugu_name"])){
		$dance_telugu_name = "";
	}
	else{
		$dance_telugu_name = test_input($_POST["dance_telugu_name"]);
	}
	
	if ($_POST["dance_category"] === ""){
		$dance_category_error = "is required.";
	}
	else{
		$dance_category = test_input($_POST["dance_category"]);
	}

	if (empty($_POST["dance_origin"])){
		$dance_origin = "";
	}
	else{
		$dance_origin = test_input($_POST["dance_origin"]);
	}

	if (empty($_POST["dance_description"])){
		$dance_description = "";
	}
	else{
		$dance_description = mysqli_real_escape_string($conn, test_input($_POST["dance_description"]));
	}

	if (empty($_POST["dance_image_reference"])){
		$dance_image_reference = "";
	}
	else{
		$dance_image_reference = test_input($_POST["dance_image_reference"]);
		 // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$dance_image_reference)) {
      	$dance_image_reference_error = "Invalid URL"; 
  		}
	}

	if (empty($_POST["dance_video_reference"])){
		$dance_video_reference = "";
	}
	else{
		$dance_video_reference = test_input($_POST["dance_video_reference"]);
		 // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$dance_video_reference)) {
      $dance_video_reference_error = "Invalid URL"; 
  		}
	}

	if (empty($_POST["dance_key_words"])){
		$dance_key_words = "";
	}
	else{
		$dance_key_words = test_input($_POST["dance_key_words"]);
	}

	if ($_POST["dance_status"] === ""){
		$dance_status_error = "is required.";
	}
	else{
		$dance_status = test_input($_POST["dance_status"]);
	}

		// Upload images
	if (empty($_POST["artist_images"])){
		$artist_images = "";
	}
	else{
		$artist_images = test_input($_POST["artist_images"]);
	}
	if(empty($_FILES['file']['name'][0])){
		$artist_images_error = "";
	}
	else{
	if (isset($_POST['submit'])) {
	$j = 0;     // Variable for indexing uploaded image.
	$target_path = "assets/artist_images/";     // Declaring Path for uploaded images.
	$artist_path = "assets/artist_images/";
	for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
	// Loop to get individual element from the array
	$validextensions = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "svg", "SVG");      // Extensions which are allowed.
	$ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
	$file_extension = end($ext); // Store extensions in the variable.
	$target_path = "assets/artist_images/" . basename($_FILES['file']['name'][$i]);     // Set the target path with a new name of image.
	
	if(count($_FILES['file']['name']) > 1 ){
		if ($i == 0){
			$artist_path = "assets/artist_images/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else if($i > 0 && $i < count($_FILES['file']['name']) - 1){
			$artist_path = $artist_path  . "assets/artist_images/" . basename($_FILES['file']['name'][$i]) . ", "; 
		}
		else {
			$artist_path = $artist_path  . "assets/artist_images/" . basename($_FILES['file']['name'][$i]);
		}
	}
	else{
			$artist_path = "assets/artist_images/" . basename($_FILES['file']['name'][$i]); 
	}

	$j = $j + 1;      // Increment the number of uploaded images according to the files in array.


	if (($_FILES["file"]["size"][$i] < 24000000)     // Approx. 24mb files can be uploaded.
	&& in_array($file_extension, $validextensions)) {
		if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
		// If file moved to uploads folder.
		echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
			if(!empty($artist_images)){
				$artist_images = $artist_images . ",". $artist_path;
			}
			else{
				$artist_images = $artist_path;
			}
		} 

		else {     //  If File Was Not Moved.
		echo $j. ').<span id="error">Error uploading image! Please try again.</span><br/><br/>';
		$artist_images_error = "Error uploading image! Please try again";
		}	
	}

	else {     //   If File Size And File Type Was Incorrect.
		echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
		$artist_images_error = "Invalid file size or type!";
	}
	} // FOR LOOP ENDING BRACKET
	}
	}



	if (empty($_POST["links"])){
		$links = "";
	}
	else{
		$links = test_input($_POST["links"]);
		 // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$links)) {
      $links_error = "Invalid URL"; 
  		}
	}

// If no errors, submit changes
	if($dance_english_name_error === "" && $dance_category_error === "" && $dance_image_reference_error === "" && $dance_video_reference_error === "" && $artist_images_error === "" && $links_error === ""){

		$sqlUpdate = "UPDATE dances
		SET dance_english_name = '$dance_english_name', dance_alternate_name = '$dance_alternate_name', dance_telugu_name = '$dance_telugu_name', dance_category = '$dance_category', dance_origin = '$dance_origin', dance_description = '$dance_description', dance_image_reference = '$dance_image_reference', dance_video_reference = '$dance_video_reference', dance_key_words  = '$dance_key_words', dance_status = '$dance_status', artist_images = '$artist_images', links = '$links'
		WHERE dance_id ='$id'";

		$update = $conn->query($sqlUpdate);


	if ($conn->query($sql) === TRUE) {
    echo "New record created successfully.";
	}
	else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

		header('Location: search.php?update=success');

	}

}

}

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
if(isset($_SESSION['username'])){

$artist_images = $row['artist_images'];

echo '
<span class="error">* required field.</span>
<form method="post" enctype="multipart/form-data" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id.'">';

echo'
<table width=50% class="suggest_dance_table">

<!-- Dance Name in English Input -->
<tr>
<td>
Name (English): 
</td>
<td>
<input type="text" name="dance_english_name" value="'.$row['dance_english_name'].'">
<span class="error">* <?php echo $dance_english_name_error;?></span>
</td>
</tr>

<!-- Dance Name in Telugu Input -->
<tr>
<td>
Name (Telugu): 
</td>
<td>
<input type="text" name="dance_telugu_name" value="'.$row['dance_telugu_name'].'">
</td>
</tr>

<!-- Alternate Dance Name Input -->
<tr>
<td>
Other Names: 
</td>
<td><input type="text" name="dance_alternate_name" value="'.$row['dance_alternate_name'].'">
</td>
</tr>
';

echo '
<!-- Dance Category Input -->
<tr>
<td>
Category: 
</td>
<td>
<select name="dance_category">';
	if (isset($row['dance_category']) && $row['dance_category']=="Folk"){
		echo '<option selected>Folk</option>';
	}
	else{
		echo '<option>Folk</option>';
	}
	if (isset($row['dance_category']) && $row['dance_category']=="Classical"){
		echo '<option selected>Classical</option>';
	}
	else{
		echo '<option>Classical</option>';
	}
	if (isset($row['dance_category']) && $row['dance_category']=="Traditional"){
		echo '<option selected>Traditional</option>';
	}
	else{
		echo '<option>Traditional</option>';
	}
	if (isset($row['dance_category']) && $row['dance_category']=="Other"){
		echo '<option selected>Other</option>';
	}
	else{
		echo '<option>Other</option>';
	}
				// <option'; if (isset($row['dance_category']) && $row['dance_category']=="Folk") echo 'selected'; echo '>Folk</option>';
				// echo '
				// <option'; if (isset($row['dance_category']) && $row['dance_category']=="Classical") echo 'selected';echo '>Classical</option>';
				// echo '
				// <option'; if (isset($row['dance_category']) && $row['dance_category']=="Traditional") echo 'selected';echo '>Traditional</option>';
				// echo '
				// <option'; if (isset($row['dance_category']) && $row['dance_category']=="Other") echo 'selected';echo '>Other</option>';
				// echo '</select>
		echo'</select>
		<span class="error">* <?php echo $dance_category_error;?></span>
</tr>
';

echo '
<!-- Dance Origin Input -->
<tr>
<td>
Origin: 
</td>
<td>
<input type="text" name="dance_origin" value="'.$row["dance_origin"].'">
</td>
</tr>

<!-- Dance Description Input -->
<tr>
<td>
Description: 
</td>
<td>
<textarea name="dance_description" rows="5" cols="40" maxlength="5000" placeholder="Enter description...">'.$row['dance_description'].'</textarea>
</td>
</tr>

<!-- Dance Image Reference Input -->
<tr>
<td>
Images: 
</td>
<td>
<textarea name="dance_image_reference" rows="5" cols="40" maxlength="5000" placeholder="www.image.com/image1, www.image.com/image2, www.image.com/image3, etc...">'.$row['dance_image_reference'].'</textarea>
<span class="error">'.$dance_image_reference_error.'</span>
</td>
</tr>

<!-- Dance Video Reference Input -->
<tr>
<td>
Videos: 
</td>
<td>
<textarea name="dance_video_reference" rows="5" cols="40" maxlength="5000" placeholder="www.youtube.com/video1, www.youtube.com/video2, www.youtube.com/video3, etc...">'.$row['dance_video_reference'].'</textarea>
<span class="error">'.$dance_video_reference_error.'</span>
</td>
</tr>

<!-- Upload Image Input -->
<tr>
<td>
Artist Images:
</td>
<td>
<div id="filediv">
<textarea name="artist_images" rows="5" cols="40" maxlength="5000" placeholder="assets/artist_images/placeholder.png, assets/artist_images/placeholder2.png, etc...">'.$row['artist_images'].'</textarea>
<input type="file" name="file[]" id="file">
<input type="button" id="add_more" value="Add More Files" />
<span class="error">'. $artist_images_error .'</span>
</div>
</td>
</tr>

<!-- Links Input -->
<tr>
<td>
Links:
</td>
<td>
<textarea name="links" rows="5" cols="40" placeholder="www.wikipedia.com/dances, www.wikipedia.com/dances2, www.wikipedia.com/dances3, etc..." maxlength="5000">'.$row['links'].'</textarea>
<span class="error">'.$links_error.'</span>
</td>
</tr>

<!-- Dance Key Words Input -->
<tr>
<td>
Key Words: 
</td>
<td>
<input type="text" name="dance_key_words" value="'.$row['dance_key_words'].'" placeholder="Word1, Word2, etc...">
</td>
</tr>

<!-- Status Input -->
<tr>
<td>
Status:
</td>
<td>
<select class="dropdown" name="dance_status">';
		if (isset($row['dance_status']) && $row['dance_status']=="Submitted"){
			echo '<option selected>Submitted</option>';
		}
		else{
			echo '<option>Submitted</option>';
		}
		if (isset($row['dance_status']) && $row['dance_status']=="Selected"){
			echo '<option selected>Selected</option>';
		}
		else{
			echo '<option>Selected</option>';
		}
		if (isset($row['dance_status']) && $row['dance_status']=="In Progress"){
			echo '<option selected>In Progress</option>';
		}
		else{
			echo '<option>In Progress</option>';
		}
		if (isset($row['dance_status']) && $row['dance_status']=="Done"){
			echo '<option selected>Done</option>';
		}
		else{
			echo '<option>Done</option>';
		}

				// <option'; if (isset($row['dance_status']) && $row['dance_status']=="Submitted") echo "selected";echo '>Submitted</option>';
				// echo '
				// <option'; if (isset($row['dance_status']) && $row['dance_status']=="Selected") echo "selected";echo '>Selected</option>';
				// echo '
				// <option'; if (isset($row['dance_status']) && $row['dance_status']=="In Progress") echo "selected";echo '>In Progress</option>';
				// echo '
				// <option'; if (isset($row['dance_status']) && $row['dance_status']=="Done") echo "selected";echo '>Done</option>';
				
echo '
</select>
<span class="error">* <?php echo $dance_status_error;?></span>
</td>
</tr>

	<tr>
	<td>
	<input class="orange_button" type="submit" name="submit" value="Submit Update">
	</td>
	</tr>';

	echo $artist_images;
}
}
}

else{
	echo "<b>Only admins can update.</b>";
}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>


</table>
</form>

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
$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$(this).hide();
$("#abcd" + abc).append($("<img/>", {
id: 'img',
src: 'x.png',
alt: 'delete'
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
});

</script>
</body>
<footer>
<?php include 'footer.php'; ?>
</footer>