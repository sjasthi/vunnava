<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
$parameters = getParameters();
$libAccess = null;
if(isset($_SESSION['libraryAccessID']))
		{
			$libAccess = $_SESSION['libraryAccessID'];
		}
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>

<html>
<link rel="icon"
      type="image/png"
      href="favicon.ico">
<head>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!--meta http-equiv="X-UA-Compatible" content="IE=edge"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $parameters['systemname']->value ?> Book</title>

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

require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';

printHeader();
$saveSuccess = false;
$saveError = false;
$message = '';

if (isset($_GET['id']) && $_GET['id'] > -1) {
    $bookID = $_GET['id'];
    $book = getInventoryByItemId($bookID);
    if (isset($_GET['error'])) {
        $saveError = true;
        $message = $_GET['reason'];
    }

    if (isset($_GET['success'])) {
        $saveSuccess = true;
    }

    if ($book == null) {
        printErrorandExit("Error: Book not found.", "index.php");
        return;
    }
} else {
    printErrorandExit("Error: No Book Specified.", "index.php");
    return;
}

$currentLibrary = null;

if (isset($_GET['currentLib'])) {
    $currentLibrary = getLibraryByID($_GET['currentLib'], $libraries);
}

?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Book Details
                <!--small>Subheading</small-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
				<?php
				if(!$parameters['LibrarySingleMode']->value)
				{
                	echo "<li><a href=\"LibraryList.php\">Libraries</a></li>";
				}
				?>
                <li><a href="LibraryMain.php?id=<?php
                    echo($currentLibrary == null ? $book->library_id : $currentLibrary->id) ?>"><?php
                        echo($currentLibrary == null ? truncateString($book->libraryName, 100) : truncateString($currentLibrary->name, 100)) ?></a>
                </li>
                <li><a href="libraryInventory.php?id=<?php
                    echo($currentLibrary == null ? $book->library_id : $currentLibrary->id) ?>&page=0">Inventory</a>
                </li>
                <li class="active"> <?php
                    echo $book->title ?></li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-3">

            <?php

            if (file_exists($book->image)) {
                echo "                    <img class=\"img-responsive img-hover\" src='" . $book->image . "' alt=\"\">\n";
            } else {
                echo "                    <img class=\"img-responsive img-hover\" src=\"images/books/default.png\" alt=\"\">\n";
            }

            ?>
        </div>
        <?php
        printBookDetails($book, $saveSuccess, $saveError, $message, $libraries);
		printBorrowingForm($book,$libAccess);
        ?>

    </div>


    <?php
    printFooter() ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>