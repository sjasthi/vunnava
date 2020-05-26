<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
session_start();
$updatingImages = false;
$libID = null;
$parameters = getParameters();
if (isset($_POST['uploadImages'])) {

    // echo "Post set:";

    $libID = $_POST['libraryID'];
    $updatingImages = true;

    // echo "Post set:libID is : ". $libID;

    if (!isset($_SESSION['admin'])) {
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    } else
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            if (getUserExpiresTime($_SESSION['userID']) < time()) {
                $id = $_SESSION['userID'];
                session_destroy();
                session_start();
                $_SESSION['userID'] = $id;
                header('Location: login.php?logout=true&message=Login Expired');
                exit;
            }

            if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libID)) {
                $id = $_SESSION['userID'];
                session_destroy();
                session_start();
                $_SESSION['userID'] = $id;
                header('Location: login.php?logout=true&message=Access Denied');
                exit;
            }
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

    <title><?php echo $parameters['systemname']->value ?> Inventory</title>

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
printHeader();
$success = '';
$myLibrary = null;

// echo "libID: " . $libID;

if ($libID == null) {
    if (isset($_GET['id']) && $_GET['id'] > -1) {
        $libID = $_GET['id'];
    }
}

foreach ($libraries as $lib) {
    if ($lib->id == $libID) {
        $myLibrary = $lib;
    }
}

$searching = false;

if (isset($_GET['q']) && $_GET['term'] != null && !ctype_space($_GET['term'])) {
    $searchTerm = trim($_GET['term']);
    if ($searchTerm != '+' && sizeof($searchTerm) > 0) {
        $searching = true;
    }
}

if ($myLibrary == null) {
    printerrorAndExit("Error: Library was not found.", "LibraryList.php");
    return;
}

if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php
                echo truncateString($myLibrary->name , 55); ?>
                <small>Inventory</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
				<?php if(!$parameters['LibrarySingleMode']->value)
					echo "<li><a href=\"LibraryList.php\">Libraries</a>
                </li>";
				?>
                
                <li><a href="LibraryMain.php?id=<?php
                    echo $libID; ?>"><?php
                        echo truncateString($myLibrary->name , 100); ?> </a>
                </li>
                <?php

                if ($searching) {
                    echo "
                      <li><a href='libraryInventory.php?id=" . $libID . "&page=0'>Inventory</a>
                      </li>
                      <li class='active'>Searching \"" . $searchTerm . "\"</li>
                      <li><a href='libraryInventory.php?id=" . $libID . "&page=0'>Clear Search</a>
                      </li>";
                } else {
                    echo "<li class=\"active\">Inventory</li>";
                }

                ?>
            </ol>
            <?php

            if (!$searching) {
                printSearchForm($libID);
            }

            ?>
        </div>
    </div>
    <!-- /.row -->

    <!-- Projects Row -->
    <?php
	$startIndex = 0;
    if ($success == 'true') {
        printSuccessMessage($_GET['message']);
    } else
        if ($success == 'false') {
            printErrorMessage($_GET['message']);
        }

    if ($searching) {
        $inventoryItems = getSearchedInventoryByID($libID, $searchTerm);
		if (sizeof($inventoryItems) > 0) {
			echo printSuccessMessage(sizeof($inventoryItems) . " result(s) found");
		}
    } else {
		$startIndex = $_GET['page'];
		if($startIndex < 0)
		{
			$startIndex = 0;
		}
        $inventoryItems = getInventoryByLibraryId($libID,($startIndex * $parameters['NumberBooksPerPage']->value),$parameters['NumberBooksPerPage']->value);
    }

    if (sizeof($inventoryItems) > 0) {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libID) && $_SESSION['libraryAccessID'] == 0) {
                if (!$updatingImages) {
					if($searching)
					{
						printInventoryImageUploadForm($libID,true,$searchTerm,$startIndex);
					}
					else{
						printInventoryImageUploadForm($libID,false,null,$startIndex);
					}
                } else {
					if($searching)
					{
						printDoneUploadingImagesForm($libID,true,$searchTerm,$startIndex);
					}
					else{
						printDoneUploadingImagesForm($libID,false,null,$startIndex);
					}
                    echo "<br/>";
                }

                echo "<br/>";
            }
        }

        // print_r($inventoryItems);

        $totalRows = sizeof($inventoryItems) / $parameters['NumberBooksPerRow']->value;
        $pageRemainder = sizeof($inventoryItems) % $parameters['NumberBooksPerRow']->value;
		
		if($pageRemainder > 0)
		{
			$pageRemainder = 1;
		}
		if($libID == 0)
		{
			$totalBooks = getfullInventorySize();
			$pageRemainder = $totalBooks % $parameters['NumberBooksPerPage']->value;
			$pages = intval($totalBooks/$parameters['NumberBooksPerPage']->value);
		}
		else
		{
			$pageRemainder = getLibraryByID($libID,$libraries)->bookCount%$parameters['NumberBooksPerPage']->value;
			$pages = intval(getLibraryByID($libID,$libraries)->bookCount/$parameters['NumberBooksPerPage']->value);
		}
		if($pageRemainder == 0)
		{
			$pages -= 1;
		}
		$page = $startIndex;
		if($page > $pages)
		{
			$page = $pages;
		}
        // echo $totalRows . " Rows<br/>";
        // echo $remainder . " Remainder<br/>";
		// echo $totalBooks;
		// echo $pageRemainder . "<br/>";
		// echo $pages. "<br/>";

        $n = 0;
        $i = 0;
        while ($n < $totalRows) {
            echo "<div class=\"row\">\n";
            for ($j = 0; $j < $parameters['NumberBooksPerRow']->value; $j++) {
                if ($i < sizeof($inventoryItems)) {
                    if ($inventoryItems[$i] != null) {
                        if ($updatingImages) {
                            printBookUpdateImageDiv($inventoryItems[$i]);
                            $i++;
                        } else {
                            printBookDiv($inventoryItems[$i], $libID);
                            $i++;
                        }
                    }
                }
            }

            echo "</div>";
            $n++;
        }

        /*
        if($remainder > 0)
        {
        echo "<div class='row'>";
        printBookDiv($inventoryItems[++$i]);
        echo "</div>";
        }*/
    } else {
        printErrorandExit("Error: No books found.", "LibraryMain.php?id=" . $libID );
        return;
    }

    ?>


    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
				<?php 
				if($page == null)
				{
					$page = 0;
				}
				if(!$searching && $pages > 1)
				{
				echo "<li>
                    <a href=\"libraryInventory.php?id=" . $libID . "&page=0\"><span class=\"glyphicon glyphicon-step-backward\"/></a>
                </li>";
				echo "<li>
                    <a href=\"libraryInventory.php?id=" . $libID . "&page=" . (($page - 1) <= 0? 0 : ($page - 1)) . "\"><span class=\"glyphicon glyphicon-triangle-left\"</span></a>
                </li>";
				for($i = $page-6; $i < $page+7; $i++)
				{
					if($i >= 0 && $i <= $pages)
					{
						if($i == $page)
						{
							echo "<li class=\"active\">
									<a href=\"libraryInventory.php?id=" . $libID . "&page=" . $i . "\">". ($i + 1) . "</a>
								  </li>";
						}
						else
						{
							echo "<li>
									<a href=\"libraryInventory.php?id=" . $libID . "&page=" . $i  . "\">". ($i +1) . "</a>
								 </li>";
						}
					}
				}
				echo "<li>
                   <a href=\"libraryInventory.php?id=" . $libID . "&page=" . (($page + 1) >= ($pages)? $pages : ($page + 1)) . "\"><span class=\"glyphicon glyphicon-triangle-right\"</span></a>
                </li>";
				echo "<li>
                   <a href=\"libraryInventory.php?id=" . $libID . "&page=" . $pages . "\"><span class=\"glyphicon glyphicon-step-forward\"/></a>
                </li>";
				}
				
				?>
				<!--
                <li>
                    <a href="#">&laquo;</a>
                </li>
                <li class="active">
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li>
                <li>
                    <a href="#">5</a>
                </li>
                <li>
                    <a href="#">&raquo;</a>
                </li>-->
            </ul>
        </div>
	</div>
    <!-- /.row -->


    <?php
    printFooter();
    ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
