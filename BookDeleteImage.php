<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
session_start();
$libraryID = $_POST['library_id'];
if (!isset($_SESSION['admin'])) {
    session_destroy();
    header("HTTP/1.1 500 Unauthorized");
    exit;
} else if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if (getUserExpiresTime($_SESSION['userID']) < time()) {
        session_destroy();
        header("HTTP/1.1 500 Unauthorized");
        exit;
    }
    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $libraryID)) {
        session_destroy();
        header("HTTP/1.1 500 Unauthorized");
        exit;
    }
}
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


if (isset($_POST['id'])) {
	$bookID = $_POST['id'];
	deleteBookImage($bookID);
	header('Location: BookEdit.php?id=' . $bookID . '');
    exit;
    
} else {
    header("HTTP/1.1 500 Failed to delete");
    exit;
}
