<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryItem.php';
session_start();
$book = null;
$parameters = getParameters();
if (isset($_GET['libraryID']) && $_GET['libraryID'] > -1) {
    $libraryID = $_GET['libraryID'];
}
if (isset($_GET['id']) && $_GET['id'] > -1) {
    $bookID = $_GET['id'];
    $book = getInventoryByItemId($bookID);
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

    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], ($book == null ? $libraryID : $book->createdByLibraryID)) ){
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

    <title><?php echo $parameters['systemname']->value ?> Book Edit</title>

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
$book = null;
$dupbook = null;
$create = false;

if (isset($_GET['id']) && $_GET['id'] > -1) {
    $bookID = $_GET['id'];
    $book = getInventoryByItemId($bookID);
    $libraryID = $book->library_id;
    if ($book == null) {
        printerrorAndExit("Book not found.", "index.php");
    }
} else {
    if (isset($_GET['libraryID'])) {
        $libraryID = $_GET['libraryID'];
    } else {
        $libraryID = 0;
    }
    $create = true;
}
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if (!$create) {
                    echo "Edit Book";
                } else {
                    echo "Create Book";
                } ?>
                <!--small>Subheading</small-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <?php if(!$parameters['LibrarySingleMode']->value)
					echo "<li><a href=\"LibraryList.php\">Libraries</a>
                </li>";
				
                if ($libraryID != null) {
                    echo "<li><a href=\"LibraryMain.php?id=" . $libraryID . "\">" . truncateString(getLibraryByID($libraryID,$libraries)->name, 100) . "</a>";
                    echo "</li>";
                    echo "<li><a href=\"libraryInventory.php?id=" . $libraryID . "&page=0\">Inventory</a>";
                    echo "</li>";
                    echo "<li class=\"active\">" . ($book != null ? $book->title : 'Create Book') . "</li>";
                } else {
                    echo "<li class=\"active\">" . ($book != null ? $book->title : 'Create Book') . "</li>";
                }
				
                ?>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Portfolio Item Row -->
    <div class="row">
		
		<?php 
		if(isset($_GET['duplicate']) && $_GET['duplicate']=='true')
		{
				//print_r($_SESSION['DUPBOOK']);
				echo "<div class=\"col-md-12\">";
				printErrorMessage("This book already exists.");
				echo "</div>";
				$dupbook = new InventoryItem();
				$dupbook->callNumber = $_SESSION['DUPBOOK']['callNum'];
				$dupbook->title = $_SESSION['DUPBOOK']['title'];
				$dupbook->author = $_SESSION['DUPBOOK']['author'];
				$dupbook->publisher = $_SESSION['DUPBOOK']['publisher'];
				$dupbook->publishYear = $_SESSION['DUPBOOK']['publishYear'];
				$dupbook->numPages = $_SESSION['DUPBOOK']['numPages'];
				$dupbook->price = $_SESSION['DUPBOOK']['price'];
				$dupbook->donatedBy = $_SESSION['DUPBOOK']['donatedBy'];
				$dupbook->image = null;
				$dupbook->library_id = 0;
				$dupbook->createdByLibraryID = $_GET['libraryID'];
			}
		?>
        <div class="col-md-3">

            <?php
			
			if(!$book == null)
			{
				$libraryID = $book->createdByLibraryID;
                printImageUpdateForm($book, $libraryID);
            }
            ?>
        </div>
        <?php
		if($dupbook != null)
		{
			$libraryID = $dupbook->library_id;
			printBookForm($dupbook, $libraries, $libraryID);
		}
		else{
        	printBookForm($book, $libraries, $libraryID);
		}
        printFooter();
        ?>

    </div>
	</div>
    <!-- /.container -->


</body>


</html>
