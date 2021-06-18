<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/db_functions.php';

// Start session to store variables
if(!isset($_SESSION)) { 
	// Allows user to return 'back' to this page
	ini_set('session.cache_limiter','public');
	session_cache_limiter(false);

    session_start(); 
}
 ?>
 
<!doctype html>
<html lang="en">
<link rel="icon"
      type="image/png"
      href="favicon.ico">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $parameters['systemname']->value ?> List Projects</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- For Date Picker -->
  <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
 <link href="/resources/demos/style.css" rel="stylesheet" >
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet"/>

</head>

<body>

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
                Project List
				<small><?php echo $parameters['systemname']->value ?></small>
				 <a href="export.php?id=0">
				 <div>
					 <a href="projects_displayed.php?id=0"><img src="images/chart.png" width="100px" height="100px"/></a>
					 <a href="projects_displayed.php?id=1"><img src="images/grid.png" width="100px" height="100px"/></a>
				 </div>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Project List</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
            </ul>
        </div>
		
    </div>
	
<?php
$projects = get_projects();

if($_GET['id'] == 0) {
	?>

			<div id="wrap">

				<div class="container">


					<table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">

						<thead>

							<tr>

								<th>Picture</th>

								<th>Name</th>

								<th>Description</th>

								<th>Project Status</th>

							</tr>

						</thead>

						<tbody>

	<?php

	if (!is_null($projects)) {
		foreach ($projects as $project) {
			$id = $project['project_id'];
			$image = $project['project_image'];
			$name = $project['project_name'];
			$description = $project['description'];
			$status = $project['project_status'];
			echo '<tr><td><a href="projects.php?id=' . $id . '">';
			if ($image != "") {
				echo '<img class="img-responsive" src="' . $image . '" width="200" height="200" alt="">';
			} else {
				echo '<img class="img-responsive" src="ProjectManagementSystem/project_image/do_not_delete.png" width="200" height="200" alt="">';
			}
			echo '</a></td>
			<td><a href="projects.php?id=' . $id . '">' . $name . '</a></td>
			<td>'.$description."</td>
			<td>" . $status . "</td></tr>";
		}
	} else {
		echo "0 results";
	}
	?>
		</tbody>

		<tfoot>

			<tr>

				<th>Picture</th>

				<th>Name</th>

				<th>Description</th>


				<th>Project Status</th>
				
			</tr>

		</tfoot>

		</table>

		</div>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>

			<script type="text/javascript">

			$(document).ready(function() {

	$('#info').DataTable();

	});

			</script>

	<?php
} else {
	echo'<table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">';
	if (!is_null($projects)) { 
		echo '<div class="container top_space">';
				$i = 0;
				echo'<tr>';
		foreach ($projects as $project) {
			$id = $project['project_id'];
			$image = $project['project_image'];
			$name = $project['project_name'];
			$description = $project['description'];
			$status = $project['project_status'];
			
			if ($i > 3){//start a new row every 4 pictures
				echo'</tr><tr>';
			}
			echo '<td>
				<div class="thumbnail_wrapper">
					<div class="thumbnail">
						<a href="projects.php?id=' . $id . '">';
							if ($image != ""){
								echo '<img class="img-responsive" src="' . $image . '" width="200" height="200" alt="">';
							} else {
								echo '<img class="img-responsive" src="ProjectManagementSystem/project_image/do_not_delete.png" width="200" height="200" alt="">';
							} 
							echo '<div class="caption">
								<p style="text-align: center">' . $name . '</p>
							</div>
						</a>
					</div>
				</div>
			</td>';
			if ($i > 3){
				$i = 0;
			}
			$i++;
		}
	} else {
		echo "0 results";
	}
	echo' </tr></table> ';
}
?>	


<div><!-- footer for vunnava website -->  
<?php

echo"</div><div class=\"row\"><div class=\"col-md-12\">";
printFooter();
echo"</div></div>";
?>
			
</body>

</html>