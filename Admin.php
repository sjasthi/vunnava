<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/UserInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
session_start();
$success = false;
$error = false;
$message = '';
$parameters = getParameters();
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $success = true;
	$message = $_GET['message'];
}
if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $error = true;
	$message = $_GET['message'];
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

    <title><?php echo $parameters['systemname']->value ?> Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
	<script src="js/dropzone.js"></script>
	<link href="css/dropzone.css" type="text/css" rel="stylesheet"/>
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover(); 
		});
	</script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/validate.js"></script>
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
            <h1 class="page-header">
                Admin
				<small>system management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Admin</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-12">
		<?php
			if($success)
			{
				printSuccessMessage($message);
			}
			else if($error)
			{
				printErrorMessage($message);
			}
					
 echo 
    '
    <div class="container top_space">
    <center>
    <table>
    <tr>
    <td style="padding: 20px">
        <center>
        <a href="library_list.php">
        <img src="images/library.png" width="150px" height="150px"/>
        <br>
        Libraries
        </a>
        </center>
    </td>
	
    <td style="padding: 20px">
        <center>
        <a href="book_list.php">
        <img src="images/book.png" width="150px" height="150px"/>
        <br>
        Books
        </a>
        </center>
    </td>
	
    <td style="padding: 20px">
        <center>
        <a href="project_list.php">
        <img src="images/Projects.png" width="150px" height="150px"/>
        <br>
        Projects
        </a>
        </center>
    </td>
	
    <td style="padding: 20px">
        <center>
        <a href="sponsor_list.php">
        <img src="images/Sponsors.png" width="150px" height="150px"/>
        <br>
        Sponsors
        </a>
        </center>
    </td>
	
    <td style="padding: 20px">
        <center>
        <a href="sponsorship_list.php">
        <img src="images/Sponsorships.png" width="150px" height="150px"/>
        <br>
        Sponsorships
        </a>
        </center>
    </td>
	
    <td style="padding: 20px">
        <center>
        <a href="UserManagement.php">
        <img src="images/Members.png" width="150px" height="150px"/>
        <br>
        Members
        </a>
        </center>
    </td>
    </tr>
    <tr>
    <td style="padding: 20px">
        <center>
        <a href="Configure.php">
        <img src="images/Configure.png" width="150px" height="150px"/>
        <br>
        Configure
        </a>
        </center>
    </td>
    <td style="padding: 20px">
        <center>
        <a href="backup.php">
        <img src="images/Backup.png" width="150px" height="150px"/>
        <br>
        Backup
        </a>
        </center>
    </td>
    <td style="padding: 20px">
        <center>
        <a href="exceptions_list.php">
        <img src="images/Exceptions.png" width="150px" height="150px"/>
        <br>
        Exceptions
        </a>
        </center>
    </td>
    <td style="padding: 20px">
        <center>
        <a href="export.php?id=0">               
        <img src="images/Export.png" width="150px" height="150px"/>
        <br>
        Export
        </a>
        </center>
    </td>
    <td style="padding: 20px">
        <center>
        <a href="importer.php">
        <img src="images/Import.png" width="150px" height="150px"/>
        <br>
        Import
        </a>
        </center>
    </td>
    <td style="padding: 20px">
        <center>
        <a href="help.html">
        <img src="images/Help.png" width="150px" height="150px"/>
        <br>
        Help
        </a>  
        </center>
		</td>
    </tr>
	</table>
    </center>
    </div>
    ';
	printFooter();
      ?>

</body>


</html>
