<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';

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
if (isset($_POST['error'])) {

    header("Location: Admin.php?id=" . 0 . "&error=true");
    exit();
}
if (!isset($_POST['backup'])) {
	 require 'ProjectManagementSystem/configure.php';
	$servername = DATABASE_HOST;
	$db_username = DATABASE_USER;
	$db_password = DATABASE_PASSWORD;
	$database = DATABASE_DATABASE;
	Export_Database($servername,$db_username,$db_password,$database );
	
} else {
    // Check for error conditions and then set the success or error...
    header("Location: Admin.php");
    exit();
}