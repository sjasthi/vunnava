<?php
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
    $libraryID = $_POST['id'];
    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libraryID)) {

        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}
if (isset($_POST['error'])) {
    $libraryID = $_POST['id'];
    header("Location: LibraryMain.php?id=" . $libraryID . "&error=true");
    exit();
}
if (isset($_POST['update'])) {
    $libraryID = filter_var(($_POST['id']), FILTER_SANITIZE_STRING);
    $libraryDescription = filter_var(($_POST['libraryDescription']), FILTER_SANITIZE_STRING);
    $libraryName = filter_var(($_POST['libraryName']), FILTER_SANITIZE_STRING);
    $villageName = filter_var(($_POST['villageName']), FILTER_SANITIZE_STRING);
	$mandalName = filter_var(($_POST['mandalName']), FILTER_SANITIZE_STRING);
	$districtName = filter_var(($_POST['districtName']), FILTER_SANITIZE_STRING);


    if ($libraryID == "null") {
        $libraryID = createLibrary($libraryName, $libraryDescription, $villageName, $mandalName, $districtName);
    } else {
        updateLibrary($libraryID, $libraryName, $libraryDescription, $villageName, $mandalName, $districtName);
    }
    header("Location: LibraryMain.php?id=" . $libraryID . "&success=true&message=Library Updated.");
    exit();
} else if (isset($_POST['delete'])) {
	$libraryID = filter_var(($_POST['id']), FILTER_SANITIZE_STRING);
    $libraryID = $_POST['id'];
    //echo $libID;
    // Check for error conditions and then set the success or error...
    deleteLibrary($libraryID);
    header("Location: LibraryList.php?success=true&success=true&message=Library Deleted.");
    exit();
} else {
    header("Location: LibraryList.php");
    exit();
}
