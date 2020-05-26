<?php session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
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

    <title><?php echo $parameters['systemname']->value ?> About</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

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
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
printHeader();
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">About
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
    <?php getPressCarouselInner(); ?>
	<div class="col-md-6">
    <h2><?php echo $parameters['abouttext']->name . ' ' .  $parameters['systemname']->value ?></h2>
	<ul class="list-unstyled list-inline list-social-icons">
                <?php
					$fbLink = $parameters['facebooklink']->value;
					if($fbLink != null && $fbLink != '')
					{
                    	echo "<a target=\"_blank\" href=\"" . $fbLink .  "\"><i
                                class=\"fa fa-facebook-square fa-2x\"></i></a>";
					}?>
                <!--li>
                    <a href="#"><i class="fa fa-linkedin-square fa-2x"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-google-plus-square fa-2x"></i></a>
                </li-->
            </ul>
    <p><?php echo $parameters['abouttext']->value; ?></p>
		</div>
</div>
<!-- /.row -->

<!-- Team Members -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Our Team</h2>
    </div>
    <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="images/people/steven.jpg" alt="">
            <div class="caption">
                <h3>Steven J Struhar<br>
                    <small>Web app guy</small>
                </h3>
                <p>Standard software guy</p>
                <ul class="list-inline">
                    <li><a href="https://www.facebook.com/thissteven.steven.length"><i
                                    class="fa fa-2x fa-facebook-square"></i></a>
                    </li>
                    <li><a href="https://www.linkedin.com/in/steve-struhar-96214442"><i
                                    class="fa fa-2x fa-linkedin-square"></i></a>
                    </li>
                    <li><a href="https://twitter.com/stevenstruhar30"><i class="fa fa-2x fa-twitter-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
   <div class="col-md-4 text-center">
        <div class="thumbnail">
            <img class="img-responsive" src="images/people/damian.jpg" width='150' height='150' alt="">
            <div class="caption">
                <h3>Damian Schlosser<br>
                    <small>Sponsors/Projects Engineer</small>
                </h3>
                <p>Technology Guru</p>
                
            </div>
        </div>
    </div>
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
