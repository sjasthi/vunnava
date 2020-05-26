<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
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
}

if(isset($_POST['SingleLibraryMode']))
{
	$SingleLibraryMode = 1;
}
else
{
	$SingleLibraryMode = 0;
}
if(isset($_POST['AllowMultipleAdmins']))
{
	$AllowMultipleAdmins = 1;
}
else
{
	$AllowMultipleAdmins = 0;
}
if(isset($_POST['HideLibraryExport']))
{
	$HideLibraryExport = 1;
}
else
{
	$HideLibraryExport = 0;
}
$LoginExpirationminutes = filter_var(($_POST['LoginExpirationminutes']), FILTER_SANITIZE_STRING);
$BlogEntriesToLoad = filter_var(($_POST['BlogEntriesToLoad']), FILTER_SANITIZE_STRING);
$BlogEntriesToAdd = filter_var(($_POST['BlogEntriesToAdd']), FILTER_SANITIZE_STRING);
$BooksPerPage = filter_var(($_POST['BooksPerPage']), FILTER_SANITIZE_STRING);
$BooksPerRow = filter_var(($_POST['BooksPerRow']), FILTER_SANITIZE_STRING);
$ContactEmail = filter_var(($_POST['ContactEmail']), FILTER_SANITIZE_STRING);
$FromEmail = filter_var(($_POST['FromEmail']), FILTER_SANITIZE_STRING);
    
updateConfigurations($SingleLibraryMode, $AllowMultipleAdmins, $HideLibraryExport, $LoginExpirationminutes, $BlogEntriesToLoad, $BlogEntriesToAdd, $BooksPerPage, $BooksPerRow, $ContactEmail, $FromEmail);
	
header("Location: Admin.php?success=true&message=Updated Configurations");
exit();