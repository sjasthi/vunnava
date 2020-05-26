<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
$parameters = getParameters();
session_start();
if (isset($_GET['libraryID']) && $_GET['libraryID'] > -1) {
    $libraryID = $_GET['libraryID'];
}
if (!isset($_SESSION['admin'])) {
    header('Location: login.php?logout=true&message=Access Denied');
    exit;
} else if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if (getUserExpiresTime($_SESSION['userID']) < time()) {
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Login Expired');
        exit;
    }

    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libraryID)) {
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}
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

    <title><?php echo $parameters['systemname']->value ?> Library Image Updater</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/dropzone.css" type="text/css" rel="stylesheet"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/validate.js"></script>
    <script src="js/dropzone.js"></script>
</head>

<body>

<?php


printHeader();
if (isset($_GET['libraryID'])) {
    $libraryID = $_GET['libraryID'];
	$myLibrary = getLibraryByID($libraryID,$libraries);
} else {
    printErrorAndExit("No Library Found.", "index.php");
}
if (isset($_GET['error'])) {
    printErrorAndExit($_GET['message'], "LibraryImageUpdater.php?libraryID=" . $libraryID);
}
if (isset($_GET['success'])) {
    printErrorAndExit($_GET['message'], "LibraryImageUpdater.php?libraryID=" . $libraryID);
}
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Library Images
                <!--small>Subheading</small-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li><a href="LibraryList.php">Libraries</a>
                </li>
                <?php
                echo "<li><a href=\"LibraryMain.php?id=" . $libraryID . "\">" . truncateString($myLibrary->name, 100) . "</a>";
                echo "</li>";
                echo "<li class=\"active\">Edit Library Images</li>";
                ?>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-12">
            <!--div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
            <!--ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>


            <!-- Controls -->
            <!--a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div-->
            <?php
			
			echo "<div class=\"col-md-12 img-portfolio\">\n";
			echo "<div class=\"row\">\n";
			echo "<div class=\"col-md-2 img-portfolio\">\n";
			echo printWarnButton("Done Uploading" , ("LibraryMain.php?id=" . $libraryID) , false);
			echo "</div>\n";
			echo "<div class=\"col-md-2 img-portfolio\">\n";
			printLibraryImageDeleteForm($libraryID);
			echo "</div>\n";
 			echo "</div>\n";

            $images = null;
            $images = getLibraryImages($libraryID);
            $n = 0;
            $i = 0;
            while ($n < 2) {
                echo "<div class=\"row\">\n";
                for ($j = 0; $j < 5; $j++) {
                    echo "<div class=\"col-md-2 img-portfolio\">\n";
                    if ($i < 10) {

                        if (sizeof($images) > $i && $images[$i] != null) {
                            printLibraryImageUpdateForm($images[$i], $libraryID);
                            $i++;
                        } else {
                            printLibraryImageUpdateForm(null, $libraryID);
                            $i++;
                        }
                    }
                    echo "</div>\n";
                }
                echo "</div>";
                $n++;
            }


            /*
                                for($i=0; $i < 10; $i++)
                                {
                                    echo "            <div class=\"col-md-5 img-portfolio\">\n";
                                    if(sizeof($images) > $i && $images[$i] != null)
                                    {
                                        printLibraryImageUpdateForm( $images[$i], $libraryID);
                                    }
                                    else
                                    {
                                        printLibraryImageUpdateForm(null, $libraryID);
                                    }
                                    echo "            </div>";
                                }*/

            ?>
        </div>
    </div>


    <?php printFooter(); ?>

</div>
<!-- /.container -->


</body>


</html>
