<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
$parameters = getParameters();
session_start();
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
    if (isset($_GET['id']) && $_GET['id'] > -1) {
        $libID = $_GET['id'];
    }
    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libID)) {

        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
} ?>
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

    <title><?php echo $parameters['systemname']->value ?> Library</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/validate.js"></script>
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
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/VillageInformation.php';
printHeader();
$myLibrary = null;
if (isset($_GET['id']) && $_GET['id'] > -1) {
    $libID = $_GET['id'];
    foreach ($libraries as $lib) {
        if ($lib->id == $libID) {
            $myLibrary = $lib;
        }
    }

}
	//print_r($myLibrary);
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-18">
            <h1 class="page-header"><?php echo($myLibrary != null ? 'Libary Edit' : 'Create Library') ?>
                <!--small>Subheading</small-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <?php if(!$parameters['LibrarySingleMode']->value)
					echo "<li><a href=\"LibraryList.php\">Libraries</a>
                </li>";
				?>
                <li class="active"> <?php echo($myLibrary != null ? truncateString($myLibrary->name, 100): 'Create Library') ?></li>
            </ol>
        </div>
    </div>

    <!-- /.row -->

    <!-- Portfolio Item Row -->

    <?php
    ///getLibraryCarouselInner($myLibrary);
    printLibraryUpdateForm($myLibrary, $villages);
    ?>
    <?php printFooter() ?>
</div>
<!-- /.row -->

<!-- Related Projects Row -->

<!-- /.row -->


<!-- /.container -->

</body>

</html>
