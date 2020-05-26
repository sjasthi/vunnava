<?php session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
if($parameters['LibrarySingleMode']->value)
{
	header('Location: LibraryMain.php?id=0');
    exit;
}
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

    <title><?php echo $parameters['systemname']->value ?> - Libraries</title>

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
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Libraries
                <small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Libraries</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <?php
            if (isset($_GET['success'])) {
                $message = $_GET['message'];
                printSuccessMessage($message);
            }
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)) {
                    echo printWarnButton("Create a Library", "LibraryEdit.php", false);
                    echo "<br/>";
                    echo "<br/>";
                }
            }
            ?>
        </div>
    </div>
    <!-- Projects Row -->

    <?php
    $totalRows = sizeof($libraries) / 2;
    $remainder = sizeof($libraries) % 2;
    //echo $totalRows . "<br/>";
    //echo $remainder;
    $n = 0;
    $i = 0;
    while ($n < $totalRows) {
        echo "<div class='row'>";
        for ($j = 0; $j < 2; $j++) {
            if ($i < sizeof($libraries)) {
                if ($libraries[$i] != null) {
                    printLibraryItemDiv($libraries[$i]);
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
      printLibraryItemDiv($libraries[++$i]);
      echo "</div>";
    }*/


    ?>


    <!-- Pagination -->
    <!--div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
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
                </li>
            </ul>
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
