<?php session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
$parameters = getParameters();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php?logout=true&message=Access Denied');
    exit;
} 
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if (getUserExpiresTime($_SESSION['userID']) < time()) {
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Login Expired');
        exit;
    }
	if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)){
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
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

    <title><?php echo $parameters['systemname']->value ?> About Image Update</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dropzone.css" type="text/css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
    <script src="js/dropzone.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
printHeader();
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">About Image Update
                <small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">About</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Intro Content -->
	<div class="row">
    	<div class="col-lg-12">
    <?php 
	echo "<div class=\"col-md-2 img-portfolio\">\n";
	echo printWarnButton("Done Uploading" , ("about.php") , false);
	echo "</div>";
	echo "<div class=\"col-md-2 img-portfolio\">\n";
	echo printAboutImageDeleteForm();
	echo "</div>";
	echo "</div>";
	$images = null;
            $images = getAboutImages();
			$rows = sizeof($images)/5;
			$mod = sizeof($images)%5;
			//echo $rows;
			//echo $mod;
			if($rows < 2)
			{
				$rows = 2;
			}
            $n = 1;
            $i = 0;
            while ($n <= $rows) {
                echo "<div class=\"row\">\n";
                for ($j = 0; $j < 5; $j++) {
                    echo "<div class=\"col-md-2 img-portfolio\">\n";

                        if (sizeof($images) > $i && $images[$i] != null) {
                            printPressImageUpdateForm($images[$i]);
                            $i++;
                        } else {
                            printPressImageUpdateForm(null);
                            $i++;
                        }
                    echo "</div>\n";
                }
                echo "</div>";
                $n++;
            }
			if($mod > 0 && sizeof($images) > 10)
			{
				$m = 0;
				while ($m < $mod) {
					echo "<div class=\"row\">\n";
						echo "<div class=\"col-md-2 img-portfolio\">\n";
						if (sizeof($images) > $i && $images[$i] != null) {
							printPressImageUpdateForm($images[$i]);
								$i++;
							} else {
								printPressImageUpdateForm(null);
								$i++;
							}
						echo "</div>\n";
					$m++;
				}
				
			}
	
	echo "</div>";
	?>
		
<!-- /.row -->


   <!-- <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
            <div class="caption">
                <h3>John Smith<br>
                    <small>Job Title</small>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
            <div class="caption">
                <h3>John Smith<br>
                    <small>Job Title</small>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
            <div class="caption">
                <h3>John Smith<br>
                    <small>Job Title</small>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
            <div class="caption">
                <h3>John Smith<br>
                    <small>Job Title</small>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/750x450" alt="">
            <div class="caption">
                <h3>John Smith<br>
                    <small>Job Title</small>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<!-- Our Customers -->
<!--div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Our Customers</h2>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <img class="img-responsive customer-img" src="http://placehold.it/500x300" alt="">
    </div>
</div-->
<!-- /.row -->


<?php printFooter(); ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
