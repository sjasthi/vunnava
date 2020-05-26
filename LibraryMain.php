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

    <title><?php echo $parameters['systemname']->value ?> Library</title>

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
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
printHeader();
$myLibrary = null;
$success = false;
if (isset($_GET['success'])) {
    $success = true;
}
if (isset($_GET['id']) && $_GET['id'] > -1) {
    $libID = $_GET['id'];
    foreach ($libraries as $lib) {
        if ($lib->id == $libID) {
            $myLibrary = $lib;
        }
    }
    if ($myLibrary == null) {
        printErrorandExit("Error: Library not found.", "LibraryList.php");
        return;
    }

} else {
    printErrorandExit("Error: Library not found.", "LibraryList.php");
    return;
}
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo truncateString($myLibrary->name, 100) ?>
                <!--small>Subheading</small-->
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
				<?php if (!$parameters['LibrarySingleMode']->value)
				{
					echo "<li><a href=\"LibraryList.php\">Libraries</a></li>";
				}?>
                
                <li class="active"> <?php echo truncateString($myLibrary->name, 100) ?></li>
            </ol>
        </div>
    </div>
    <!-- /.row -->


    <?php

    getLibraryCarouselInner($myLibrary);
    printLibraryButtons($myLibrary, $success, -1);
    printLibraryDetailsDiv($myLibrary);

    ?>

</div>
<!-- /.row -->

<!-- Related Projects Row -->
<?php
$randoms = UniqueRandomNumbersWithinRange(0, ($myLibrary->bookCount - 1), 4);
$books = getInventoryByLibraryId($myLibrary->id,0,($myLibrary->bookCount - 1));
if (sizeof($books) > 5) {
    $features = array();
    $book1 = $books[$randoms[0]];
    array_push($features, $book1);
    $book2 = $books[$randoms[1]];
    array_push($features, $book2);
    $book3 = $books[$randoms[2]];
    array_push($features, $book3);
    $book4 = $books[$randoms[3]];
    array_push($features, $book4);

    foreach ($features as $bookItem) {
        if (!file_exists($bookItem->image)) {
            $bookItem->image = "images/books/default.png";
        }
    }
    echo "<div class=\"row\">\n";
    echo "\n";
    echo "            <div class=\"col-lg-12\">\n";
    echo "                <h3 class=\"page-header\">Featured Books</h3>\n";
    echo "            </div>\n";
    echo "\n";
    echo "            <div class=\"col-sm-3 col-xs-6\">\n";
    echo "                <a href=\"BookMain.php?id=" . $book1->item_id . ($myLibrary->id != 0? ("&currentLib=" . $myLibrary->id) : ("")) . "\">\n";
    echo "                    <img class=\"img-responsive img-hover img-related\" src=\"" . $book1->image . "\" alt=\"\">\n";
    echo "                </a>\n";
    echo "                <p align=\"center\"><b>" . $book1->title . "</b><br/> " . $book1->author . " </p> \n";
    echo "            </div>\n";
    echo "\n";
    echo "            <div class=\"col-sm-3 col-xs-6\">\n";
    echo "                <a href=\"BookMain.php?id=" . $book2->item_id . ($myLibrary->id != 0? ("&currentLib=" . $myLibrary->id) : ("")) ."\">\n";
    echo "                    <img class=\"img-responsive img-hover img-related\" src=\"" . $book2->image . "\" alt=\"\">\n";
    echo "                </a>\n";
    echo "                <p align=\"center\"><b>" . $book2->title . "</b><br/> " . $book2->author . " </p> \n";
    echo "            </div>\n";
    echo "\n";
    echo "            <div class=\"col-sm-3 col-xs-6\">\n";
    echo "               <a href=\"BookMain.php?id=" . $book3->item_id . ($myLibrary->id != 0? ("&currentLib=" . $myLibrary->id) : ("")) ."\">\n";
    echo "                    <img class=\"img-responsive img-hover img-related\" src=\"" . $book3->image . "\" alt=\"\">\n";
    echo "                </a>\n";
    echo "                <p align=\"center\"><b>" . $book3->title . "</b><br/> " . $book3->author . " </p> \n";
    echo "            </div>\n";
    echo "\n";
    echo "            <div class=\"col-sm-3 col-xs-6\">\n";
    echo "                <a href=\"BookMain.php?id=" . $book4->item_id . ($myLibrary->id != 0? ("&currentLib=" . $myLibrary->id) : ("")) . "\">\n";
    echo "                    <img class=\"img-responsive img-hover img-related\" src=\"" . $book4->image . "\" alt=\"\">\n";
    echo "                </a>\n";
    echo "                <p align=\"center\"><b>" . $book4->title . "</b><br/> " . $book4->author . " </p> \n";
    echo "            </div>\n";
    echo "\n";
    echo "        </div>";
}
printFooter() ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
