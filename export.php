<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';

$libID = $_GET['id'];
//$libID = $_POST['id'];
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
    $libraryID = $_GET['id'];
    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libID)) {

        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}
if (isset($_POST['error'])) {

    header("Location: Admin.php?id=" . $libID . "&error=true");
    exit();
}
if (!isset($_POST['export'])) {
    $libID = $_GET['id'];
	exportLibrary($libID, 'Exported Books-');
} else {
    // Check for error conditions and then set the success or error...
    header("Location: Admin.php");
    exit();
}