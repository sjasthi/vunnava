<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';

if (!(isset($_SESSION['admin']) && $_SESSION['admin'] == true)) {
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
    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)) {

        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}
if (isset($_POST['export'])) {
	if(isset($_POST['PriceStats']))
	{
		//echo "got here";
    	$xlsName = 'PriceStats_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Library", "Min Price", "Max Price", "Average Price");
        $sheet = array($tmparray);
		$result = getPriceStats($libraryIDs);
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['name'];
            array_push($tmparray, $lib);
            $min = $row['min'];
            array_push($tmparray, $min);
            $max = $row['max'];
            array_push($tmparray, $max);
            $avg = $row['avg'];
            array_push($tmparray, $avg);
			
			array_push($sheet, $tmparray);
        }
		
	}
	if (isset($_POST['BorrowsPerLibrary']))
	{
		//echo "got here";
    	$xlsName = 'BorrowsPerLibrary_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Library", "Count");
        $sheet = array($tmparray);
		$result = getBorrowsPerLibrary();
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['Name'];
            array_push($tmparray, $lib);
            $count = $row['count'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
	//getTotalCostPerLibrary
	if (isset($_POST['TotalCostPerLibrary']))
	{
		//echo "got here";
    	$xlsName = 'TotalCostPerLibrary_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Library", "TotalPrice");
        $sheet = array($tmparray);
		$result = getTotalCostPerLibrary($libraryIDs);
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['name'];
            array_push($tmparray, $lib);
            $count = $row['totalprice'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
	//getCountsByPublisher
	if (isset($_POST['CountsByPublisher']))
	{
		//echo "got here";
    	$xlsName = 'CountsByPublisher_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Publisher", "Count");
        $sheet = array($tmparray);
		$result = getCountsByPublisher();
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['publisher'];
            array_push($tmparray, $lib);
            $count = $row['num'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
	//getCountsByContributor
	if (isset($_POST['CountsByContributor']))
	{
		//echo "got here";
    	$xlsName = 'CountsByContributor_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("DonatedBy", "Count");
        $sheet = array($tmparray);
		$result = getCountsByContributor();
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['donatedBy'];
            array_push($tmparray, $lib);
            $count = $row['num'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
	//CountsByAuthor
	if (isset($_POST['CountsByAuthor']))
	{
		//echo "got here";
    	$xlsName = 'CountsByAuthor_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Author", "Count");
        $sheet = array($tmparray);
		$result = getCountsByAuthor();
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['author'];
            array_push($tmparray, $lib);
            $count = $row['num'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
	//CountsByCreator
	if (isset($_POST['CountsByCreator']))
	{
		//echo "got here";
    	$xlsName = 'CountsByCreator_';
		$objPHPExcel = new PHPExcel();
        $tmparray = array("Creator Library", "Count");
        $sheet = array($tmparray);
		$result = getCountsByCreator();
        foreach ($result as $row) {
            $tmparray = array();
            $lib = $row['Name'];
            array_push($tmparray, $lib);
            $count = $row['num'];
            array_push($tmparray, $count);
            
			array_push($sheet, $tmparray);
        }
	}
     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     $fileName = $xlsName . date('Y/m/d') . ".xlsx";
     header("Content-Disposition: attachment; filename=\"$fileName\"");
     $worksheet = $objPHPExcel->getActiveSheet();
     foreach ($sheet as $row => $columns) {
         foreach ($columns as $column => $data) {
             $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);
         }
     }

     //make first row bold
     $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold(true);
     $objPHPExcel->setActiveSheetIndex(0);
     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
     //$objWriter->save(str_replace('.php', '.xlsx', $fileName));

     $objWriter->save('php://output');
     exit();
} else {
    header("Location: Reports.php");
    exit();
}