<?php session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
$parameters = getParameters();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $parameters['systemname']->value ?> Inventory</title>

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
$searching = false;
if (isset($_GET['q']) && $_GET['term'] != null && !ctype_space($_GET['term'])) {
    $searchTerm = trim($_GET['term']);
    if ($searchTerm != '+' && sizeof($searchTerm) > 0) {
        $searching = true;
    }
}

?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo "All Libraries" ?>
                <small>Inventory</small>
            </h1>
            <div>

                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li><a href="LibraryList.php">Libraries</a>
                    </li>
                    <?php
                    if ($searching) {
                        echo "
                      <li><a href='fullInventory.php'>Full Inventory</a>
                      </li>
                      <li class='active'>Searching \"" . $searchTerm . "\"</li>
                      <li><a href='fullInventory.php'>Clear Search</a>
                      </li>";
                    } else {
                        echo "<li class='active'>Full Inventory</li>";
                    }
                    ?>
                </ol>
                <?php
                if (!$searching) {
                    printSearchForm(null);
                }
                ?>

            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <?php
        if ($searching) {
            $inventoryItems = getSearchedInventory($searchTerm);
        } else {
            $inventoryItems = getFullInventory();
        }
        if (sizeof($inventoryItems) > 0) {
            //print_r($inventoryItems);
            if (sizeof($inventoryItems) >= 4) {
                $totalRows = sizeof($inventoryItems) / 6;
                $remainder = sizeof($inventoryItems) % 6;
            } else {
                $totalRows = 1;
                $remainder = 0;
            }
            //echo $totalRows . "<br/>";
            //echo $remainder;
            $n = 0;
            $i = 0;
            while ($n < $totalRows) {
                echo "<div class=\"row\">\n";
                for ($j = 0; $j < 6; $j++) {
                    if ($i < sizeof($inventoryItems)) {
                        if ($inventoryItems[$i] != null) {
                            printBookDiv($inventoryItems[$i]);
                            $i++;
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
            printErrorandExit("Error: No books found.", "fullInventory.php");
            return;
        }

        ?>



        <?php printFooter(); ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
