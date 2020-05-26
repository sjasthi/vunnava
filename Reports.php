<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
session_start();
$parameters = getParameters();

?>
<!DOCTYPE html>
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

    <title><?php echo $parameters['systemname']->value ?> Reports</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Page Content -->
<div class="container">
<?php 
printHeader();
?>
     
    <div class="row">
		
        <div class="col-lg-12">
            <h1 class="page-header">
                Reports
				<small><?php echo $parameters['systemname']->value ?></small>
				
            </h1>
			
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Reports</li>
            </ol>
        </div>
		
    </div>
        

            <?php
			if(!$parameters['LibrarySingleMode']->value)
			{
				$borrows = getBorrowsPerLibrary();
				if(sizeof($borrows) > 0)
				{
					 echo "<div class=\"row\">
					 <script type=\"text/javascript\">
					  google.charts.load('current', {'packages':['corechart']});
					  google.charts.setOnLoadCallback(drawChart);
					  function drawChart() {

						var data = google.visualization.arrayToDataTable([
						  ['Library', 'Borrows'],"; 
						  for($i = 0; $i < sizeof($borrows)-1; $i++ )
						  {
							echo "[\"" . $borrows[$i]['Name'] . "\", " . $borrows[$i]['count']  . "],";
						  }
						  echo "[\"" . $borrows[sizeof($borrows)-1]['Name'] . "\", " . $borrows[sizeof($borrows)-1]['count']. "]"; 
						echo "]);

						var options = {
						  title: 'Borrowed Books Per Library',
						  pieHole: 0.4
						};

						var chart = new google.visualization.PieChart(document.getElementById('piechart'));

						chart.draw(data, options);
					  }
					 </script>";
					echo "<div id=\"piechart\" style=\"width: 900px; height: 500px;\"></div>";
					if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
						echo "<div class=\"col-md-12\">\n";
						echo "<form action=\"ExportReports.php\" method=\"post\">";
						echo "<input hidden=\"true\" name=\"BorrowsPerLibrary\" value=\"BorrowsPerLibrary\"/>";
						echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
						echo "<button class='btn btn-warning' type='submit'>export</button>";
						echo "</form>";
						echo "</div>";
						echo "</div>";
						echo "<hr>";
					}
					else{
						echo "</div>";
						echo "<hr>";
					}

				}
				else{
					echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Borrowed Books Per Library</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
				}
			}
			
			
			$priceStats = getPriceStats($libraryIDs);
			//print_r($priceStats);
			if($priceStats[0]['min'] != null || $priceStats[0]['max'] != null)
			{
				echo "<div class=\"row\">
				<script type=\"text/javascript\">
						  google.charts.load('current', {'packages':['corechart']});
						  google.charts.setOnLoadCallback(drawVisualization);

						  function drawVisualization() {
							// Some raw data (not necessarily accurate)
							var data = google.visualization.arrayToDataTable([
							 ['Library', 'Min price',  'Max Price', 'Average Price'],";
							 for($i = 0; $i < sizeof($priceStats)-1; $i++)
							 {
								 echo " [\"" . $priceStats[$i]['name'] . "\", " . $priceStats[$i]['min']  . ", " . $priceStats[$i]['max']  . ", " . $priceStats[$i]['avg']  . "],";
							 }
							 echo " [\"" . $priceStats[sizeof($priceStats)-1]['name'] . "\", " . $priceStats[sizeof($priceStats)-1]['min']  . ", " . $priceStats[sizeof($priceStats)-1]['max']  . ", " . $priceStats[sizeof($priceStats)-1]['avg'] . "]";

							echo "]);

						var options = {
						  title : 'Book Prices Per Library',
						  vAxis: {title: 'Rupees'},
						  hAxis: {title: 'Library'},
						  seriesType: 'bars',
						  series: {2: {type: 'line'}}
						};

						var chart = new google.visualization.ComboChart(document.getElementById('Borrows_chart_div'));
						chart.draw(data, options);
					  }
					</script>";
				echo "<div id=\"Borrows_chart_div\" style=\"width: 900px; height: 500px;\"></div>";
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"PriceStats\" value=\"PriceStats\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<hr>";
				}
				else
				{
					echo "</div>";
					echo "<hr>";
				}
				
			}
			else{
				
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Book Prices Per Library</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
			}
	
	
			$totalCosts = getTotalCostPerLibrary($libraryIDs);
			//print_r($totalCosts);
			if(sizeof($totalCosts) > 0)
			{
				echo "<div class=\"row\">
				<script type=\"text/javascript\">
				  google.charts.load(\"current\", {packages:[\"corechart\"]});
				  google.charts.setOnLoadCallback(drawTotalCostsChart);
				  function drawTotalCostsChart() {
					var data = google.visualization.arrayToDataTable([

					  ['Library', 'Total Costs in Rupees'],";
					  for($i = 0; $i < sizeof($totalCosts)-1; $i++)
					  {
						  //print_r($totalCosts);
						  echo "[\"". $totalCosts[$i]['name'] ."\", ". $totalCosts[$i]['totalprice'] ."],";
					  }
					  echo "[\"". $totalCosts[sizeof($totalCosts)-1]['name']  ."\", ". $totalCosts[sizeof($totalCosts)-1]['totalprice']  ."]
					  ]);";
					echo "
					var options = {
						title: 'Total Cost of Books in Libraries',
						chartArea: {width: '50%'},
						hAxis: {
						  title: 'Total Cost',
						  minValue: 300
						},
						vAxis: {
						  title: 'Library'
						}
					  };
					  var chart = new google.visualization.BarChart(document.getElementById('Costs_chart_div'));

					chart.draw(data, options);
					  }
				</script>";
				echo "<div id=\"Costs_chart_div\" style=\"width: 900px; height: 500px;\"></div>";
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"TotalCostPerLibrary\" value=\"TotalCostPerLibrary\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<hr>";
				}
				else
				{
					echo "</div>";
					echo "<hr>";
				}
			}
			else
			{
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Total Cost of Books in Libraries</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
			}
	
			$counts = getCountsByPublisher();
			if(sizeof($counts) > 0)
			{
				echo "<div class=\"row\">
				 <script type=\"text/javascript\">
				  google.charts.load('current', {'packages':['corechart']});
				  google.charts.setOnLoadCallback(drawCountsChart);

				  function drawCountsChart() {

					var data = google.visualization.arrayToDataTable([
					  ['Number', 'Publisher'],"; 
					  for($i = 0; $i < sizeof($counts)-1; $i++ )
					  {
						  if($counts[$i]['publisher'] == null)
						  {
							  $counts[$i]['publisher']  = 'NONE';
						  }
						echo "[\"" . $counts[$i]['publisher'] . "\", " . $counts[$i]['num']  . "],";
					  }
					  echo "[\"" . $counts[sizeof($counts)-1]['publisher'] . "\", " . $counts[sizeof($counts)-1]['num']. "]"; 
					echo "]);

					var options = {
					  title: 'Book Counts By Publisher \\n (excludes counts below 3)',
					  pieHole: 0.4
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechartPublisherCounts'));

					chart.draw(data, options);
				  }
				 </script>";
				echo "<div class=\"row\"><div id=\"piechartPublisherCounts\" style=\"width: 900px; height: 500px;\"></div></div>";
				//CountsByPublisher
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"CountsByPublisher\" value=\"CountsByPublisher\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<hr>";
				}
				else
				{
					echo "</div>";
					echo "<hr>";
				}
			}
			else
			{
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Book Counts By Publisher</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
			}
	
			$counts = getCountsByAuthor();
			if(sizeof($counts) > 0)
			{
				echo "<div class=\"row\">
				 <script type=\"text/javascript\">
				  google.charts.load('current', {'packages':['corechart']});
				  google.charts.setOnLoadCallback(drawCountsByAuthorChart);

				  function drawCountsByAuthorChart() {

					var data = google.visualization.arrayToDataTable([
					  ['Number', 'Publisher'],"; 
					  for($i = 0; $i < sizeof($counts)-1; $i++ )
					  {
						  if($counts[$i]['author'] == null)
						  {
							  $counts[$i]['author']  = 'NONE';
						  }
						echo "[\"" . $counts[$i]['author'] . "\", " . $counts[$i]['num']  . "],";
					  }
					  echo "[\"" . $counts[sizeof($counts)-1]['author'] . "\", " . $counts[sizeof($counts)-1]['num']. "]"; 
					echo "]);

					var options = {
					  title: 'Book Counts By Author \\n (excludes counts below 3)',
					  pieHole: 0.4
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechartAuthorCounts'));

					chart.draw(data, options);
				  }
				 </script>";
				echo "<div class=\"row\"><div id=\"piechartAuthorCounts\" style=\"width: 900px; height: 500px;\"></div></div>";
				//getCountsByAuthor
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"CountsByAuthor\" value=\"CountsByAuthor\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<hr>";
				}
				else
				{
					echo "</div>";
					echo "<hr>";
				}
			}
			else
			{
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Book Counts By Author</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
			}
	
			$counts = getCountsByContributor();
			if(sizeof($counts) > 0)
			{
				echo "<div class=\"row\">
				 <script type=\"text/javascript\">
				  google.charts.load('current', {'packages':['corechart']});
				  google.charts.setOnLoadCallback(drawCountsDontationChart);

				  function drawCountsDontationChart() {

					var data = google.visualization.arrayToDataTable([
					  ['Number', 'Publisher'],"; 
					  for($i = 0; $i < sizeof($counts)-1; $i++ )
					  {
						  if($counts[$i]['donatedBy'] == null)
						  {
							  $counts[$i]['donatedBy']  = 'NONE';
						  }
						echo "[\"" . $counts[$i]['donatedBy'] . "\", " . $counts[$i]['num']  . "],";
					  }
					  echo "[\"" . $counts[sizeof($counts)-1]['donatedBy'] . "\", " . $counts[sizeof($counts)-1]['num']. "]"; 
					echo "]);

					var options = {
					  title: 'Book Counts By Donor',
					  pieHole: 0.4
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechartContributorCounts'));

					chart.draw(data, options);
				  }
				 </script>";
				echo "<div class=\"row\"><div id=\"piechartContributorCounts\" style=\"width: 900px; height: 500px;\"></div></div>";
				//CountsByContributor
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"CountsByContributor\" value=\"CountsByContributor\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
					echo "<hr>";
				}
				else
				{
					echo "</div>";
					echo "<hr>";
				}
			}
			else
			{
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Book Counts By Donor</b> </h5> <br/> <h6>No Data to display...</h6></div></div><hr>";
			}
	
		
			$counts = getCountsByCreator();
			if(sizeof($counts) > 0)
			{
				echo "<div class=\"row\">
				 <script type=\"text/javascript\">
				  google.charts.load('current', {'packages':['corechart']});
				  google.charts.setOnLoadCallback(drawCountsCreatorChart);

				  function drawCountsCreatorChart() {

					var data = google.visualization.arrayToDataTable([
					  ['Number', 'Publisher'],"; 
					  for($i = 0; $i < sizeof($counts)-1; $i++ )
					  {
						  if($counts[$i]['Name'] == null)
						  {
							  $counts[$i]['Name']  = 'NONE';
						  }
						echo "[\"" . $counts[$i]['Name'] . "\", " . $counts[$i]['num']  . "],";
					  }
					  echo "[\"" . $counts[sizeof($counts)-1]['Name'] . "\", " . $counts[sizeof($counts)-1]['num']. "]"; 
					echo "]);

					var options = {
					  title: 'Book Counts By Creator Library',
					  pieHole: 0.4
					};

					var chart = new google.visualization.PieChart(document.getElementById('piechartCreatorCounts'));

					chart.draw(data, options);
				  }
				 </script>";
				echo "<div class=\"row\"><div id=\"piechartCreatorCounts\" style=\"width: 900px; height: 500px;\"></div></div>";
				//CountsByCreator
				if (isset($_SESSION['admin']) && $_SESSION['libraryAccessID'] == 0) {
					echo "<div class=\"col-md-12\">\n";
					echo "<form action=\"ExportReports.php\" method=\"post\">";
					echo "<input hidden=\"true\" name=\"CountsByCreator\" value=\"CountsByCreator\"/>";
					echo "<input hidden=\"true\" name=\"export\" value=\"export\"/>";
					echo "<button class='btn btn-warning' type='submit'>export</button>";
					echo "</form>";
					echo "</div>";
					echo "</div>";
				}
			}
			else
			{
				echo "<div class=\"row\"><div class=\"col-md-12\"><h5> <b>Book Counts By Creator Library</b> </h5> <br/> <h6>No Data to display...</h6></div>";
			}
			
			?>

           

        <!-- Footer -->
			<?php
			printFooter();
			?>

    <!--/div>
    <!-- /.container -->

    
	</div>
</body>

</html>
