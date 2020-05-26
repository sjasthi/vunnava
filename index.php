<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
$message = '';
$timeout = false;
$parameters = getParameters();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if (getUserExpiresTime($_SESSION['userID']) < time()) {

        unset($_GET['success']);
        unset($_GET['message']);
        logoutUser($_SESSION['userID']);
        session_destroy();
        session_start();
        $timeout = true;
        $message = "Your login has been timed out.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="icon"
      type="image/png"
      href="favicon.ico">
<head>
    <?php

    if (isset($_GET['success']) && $_GET['success'] == true) {
        $message = $_GET['message'] . " " . $_SESSION['username'];
    }
	if(!$parameters['LibrarySingleMode']->value)
	{
		if (sizeof($libraryIDs) > 3) {
			$some = array_rand($libraryIDs, 3);
			$randoms = Array();
			for($i = 0; $i < 3; $i++)
			{
				$randoms[$i] = $libraryIDs[$some[$i]];
			}

			//print_r($randoms);
			//print_r($libraries);
			$images = array();
			for ($i = 0; $i < 3; $i++) {
				$path = getLibraryImages($randoms[$i]);
				//print_r($path[0]); echo "<br/>";
				if ($path != null) {
					array_push($images, $path[0]);
				} else {
					array_push($images, "images/libraries/default.png");
				}
			}
			//print_r($images);
		}
	}
	else
	{
		$libraryArray = array();
		array_push($libraryArray, getLibraryByID(0));
		$images = array();
		$path = getLibraryImages(0);
		//print_r($path[0]); echo "<br/>";
		if ($path != null) {
		array_push($images, $path[0]);
		} else {
			array_push($images, "images/libraries/default.png");
		}
		printFeaturedLibrariesCarousel($libraryArray, $images);
	}


    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $parameters['systemname']->value ?> - Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php
printHeader();
if (sizeof($libraries) > 3 && !$parameters['LibrarySingleMode']->value) {
    $libraryArray = array();
    array_push($libraryArray, (getLibraryByID($randoms[0],$libraries)));
    array_push($libraryArray, (getLibraryByID($randoms[1],$libraries)));
    array_push($libraryArray, (getLibraryByID($randoms[2],$libraries)));
    printFeaturedLibrariesCarousel($libraryArray, $images);
}

?>


<!-- Page Content -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
            <?php if (isset($_GET['success']) && $message != null) {
                printSuccessMessage($message);
            } else if ($timeout && $message != null) {
                printErrorMessage($message);
            }
            ?>

            <h1 class="page-header">
                Welcome to <?php echo $parameters['systemname']->value ?>
            </h1>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
					<?php //print_r($parameters);?>
                    <h4><i class="fa fa-fw fa-book"></i> <?php echo $parameters['blurb1']->name; ?></h4>
                </div>
                <div class="panel-body">
                    <p><?php echo $parameters['blurb1']->value; ?></p>
					<a href=<?php echo !$parameters['LibrarySingleMode']->value?  "LibraryList.php" : "LibraryMain.php?id=0" ?> class="btn btn-default">See <?php echo !$parameters['LibrarySingleMode']->value?  "Libraries" : "Library" ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-comment"></i> <?php echo $parameters['blurb2']->name; ?></h4>
                </div>
                <div class="panel-body">
                    <p><?php echo $parameters['blurb2']->value; ?></p>
                    <a href="blog.php?numEntries=20" class="btn btn-default">Visit our Blog</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-pencil"></i> <?php echo $parameters['blurb3']->name; ?></h4>
                </div>
                <div class="panel-body">
                    <p><?php echo $parameters['blurb3']->value; ?></p>
                    <a href="about.php" class="btn btn-default">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->


    <?php

    if (sizeof($libraries) > 3 && !$parameters['LibrarySingleMode']->value) {
        printFeaturedLibrariesPortfolio($libraryArray, $images);
    }
    ?>

    <!-- /.row -->

    <!-- Features Section -->
    <!--div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Modern Business Features</h2>
        </div>
        <div class="col-md-6">
            <p>The Modern Business template by Start Bootstrap includes:</p>
            <ul>
                <li><strong>Bootstrap v3.3.7</strong>
                </li>
                <li>jQuery v1.11.1</li>
                <li>Font Awesome v4.2.0</li>
                <li>Working PHP contact form with validation</li>
                <li>Unstyled page elements for easy customization</li>
                <li>17 HTML pages</li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
        </div>
        <div class="col-md-6">
            <img class="img-responsive" src="http://placehold.it/700x450" alt="">
        </div>
    </div-->
    <!-- /.row -->


    <!-- Call to Action Section -->
    <!--div class="well">
        <div class="row">
            <div class="col-md-8">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
            </div>
            <div class="col-md-4">
                <a class="btn btn-lg btn-default btn-block" href="#">Call to Action</a>
            </div>
        </div>
    </div-->


    <?php
    printFooter();
    ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Script to Activate the Carousel -->
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
</script>

</body>

</html>
