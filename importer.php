<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
$parameters = getParameters();
$myLibraries = $libraries;
$importingLibrary = -1;
$importingIntoLibrary = -1;
/*
Check to see if we are admin and have rights to be importing 
*/
if (!(isset($_SESSION['admin']) && $_SESSION['admin'] == true)) {
    header('Location: login.php');
} else
	{
		$importingLibrary = $_SESSION['libraryAccessID'];
		if(isset($_POST['importingIntoLibrary']))
		{
			if($importingLibrary > 0)
			{
				$importingIntoLibrary = $importingLibrary;
			}
			else
			{
				$importingIntoLibrary = $_POST['importingIntoLibrary'];	
			}
		}
		if (getUserExpiresTime($_SESSION['userID']) < time()) {
			$id = $_SESSION['userID'];
			session_destroy();
			session_start();
			$_SESSION['userID'] = $id;
			header('Location: login.php?logout=true&message=Login Expired');
			exit;
		}

		if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $importingLibrary)) {
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

    <title><?php echo $parameters['systemname']->value ?> Importer</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="./css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover(); 
		});
	</script>
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
$execute = false;

// Check if image file is a actual image or fake image

/* 

Check the file that was uploaded if any and determine if we should accept it.
*/
if (isset($_POST['CONFIRM'])) {

    $target_dir = "bin/data/";
    $targetFileBaseName = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . getToken(16) . $targetFileBaseName;
    $uploadOk = 1;
    $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $fileName = pathinfo($target_file, PATHINFO_FILENAME);

    if ($target_file == null or $target_file == '') {
        $uploadOk = 0;
        printerrorAndExit("Oops. No file.", "importer.php");
        return;
    }
    if (file_exists($target_file)) {
        $uploadOk = 0;
        printerrorAndExit("The file you uploaded already exists.", "importer.php");
        return;
    }
    if ($_FILES["fileToUpload"]["size"] > $_POST["MAX_FILE_SIZE"]) {
        $uploadOk = 0;
        printerrorAndExit("The file you uploaded exceeds the allowed size.", "importer.php");
        return;
    }
    if ($fileType != "xlsx") {
        $uploadOk = 0;
        printerrorAndExit("The file you uploaded is not the right type.", "importer.php");
        return;
    }
    if ($uploadOk == 0) {
        printerrorAndExit("Sorry, your file was not uploaded.", "importer.php");
        // if everything is ok, try to upload file
    } else {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/pushcart/bin/data/')) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/pushcart/bin/data/', 0777, true)) {
                die('Failed to create folders...');
            }
        }
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $inputFileName = $target_file;
            $execute = true;
        } else {
            printerrorAndExit("Sorry, there was a problem uploading the file.", "importer.php");
            return;
        }
    }
}

/*
if the file upload is good...
*/
if ($execute) {
    go($inputFileName, $importingLibrary, $importingIntoLibrary);
}
else {
	$thisLibrary = getLibraryByID($importingLibrary,$libraries);
    echo "<div class=\"container\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    echo "<h1 class=\"page-header\">\n";
	echo "                Import\n";
	echo "				<small>Tupudu Bandi</small>\n";
	echo "				\n";
	echo "            </h1>\n";
	echo "			\n";
	echo "            <ol class=\"breadcrumb\">\n";
	echo "                <li><a href=\"index.php\">Home</a>\n";
	echo "                </li>\n";
	echo "                <li><a href=\"LibraryList.php\">Libraries</a>\n";
	echo "                </li>\n";
	echo "                <li><a href=\"LibraryMain.php?id=" . $thisLibrary->id. "\">" . truncateString( $thisLibrary->name, 100) . "</a>\n";
	echo "                </li>\n";
	echo "                <li class=\"active\">Import</li>\n";
	echo "            </ol>\n";

    printImportConfirmationForm($myLibraries, $importingLibrary, $importingIntoLibrary);
    printFooter();
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<script src=\"js/jquery.js\"></script>";
    echo "<script src=\"js/bootstrap.min.js\"></script>";
    return;
}
 

/*
import the file line by line
*/
function go($inputFileName, $importingLibrary, $importingIntoLibrary)
{
    if (isset($_POST['delete_existing'])) {
        if ($importingLibrary == 0) {
            deleteAllBooks();// also deletes all borrows
			//Delete all images in images/books
			$files = glob('images/books/*');
			$leave_files = array('default.png');
			foreach($files as $file)
			{
				if(is_file($file) && !in_array(basename($file), $leave_files))
				{
					unlink($file);
				}
			}
        } else {
			if($importingIntoLibrary > 0)
			{
				deleteAllBorrows($importingIntoLibrary);
			}
        }
    }
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    echo "<div class=\"container\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    if (!file_exists($inputFileName)) {
        printerrorAndExit("The file does not exist.","importer.php");
        return;
    }


    echo "<h1 class=\"page-header\">Importing books...</h1>";
    for ($row = 2; $row <= $highestRow; $row++) {
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		// ignore blank lines and header lines
        if ($rowData[0][2] != '' && $rowData[0][2] != 'Book Title') {
            echo "Importing book: " . $rowData[0][2] . "<br/>";
            //($callNumber,$title,$contribution_id,$libraryID,$author,$publisher,$publishYear,$numPages,$price,$donatedBy,$image)
			if($highestColumn != 'K' && $highestColumn != 'L')
			{   unlink($inputFileName);
				printerrorAndExit("The file has incorrect number of columns. Highest Column Value is: " . $highestColumn,"importer.php");
        		return;
			}
			if(intval($rowData[0][6]) < 0)
			{
				unlink($inputFileName);
				printerrorAndExit("Page number value is bad on row: " . $row . " value is: " . $rowData[0][6],"importer.php");
        		return;
			}
            createBook(
                ($rowData[0][1]),//callnumber
                ($rowData[0][2]),//title
                0,//contributionID
                $importingIntoLibrary,//libid - from the form or from the session
                ($rowData[0][3]),//author
                ($rowData[0][4]),//publisher
                ($rowData[0][5]),//publishyear
                $rowData[0][6],//numPages
                $rowData[0][7],//price
                ($rowData[0][8]),//donatedby
                $rowData[0][9]//images
            );
        }

    }
    echo "<div class=\"success\"> All books imported.</div>";
    unlink($inputFileName);
    printFooter();
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>
</div>        <!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>