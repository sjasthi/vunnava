<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
session_start();
if (isset($_POST['libraryID']) && $_POST['libraryID'] > -1) {
    $libraryID = $_POST['libraryID'];
}
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


if (isset($_POST['error'])) {
    $libraryID = $_POST['libraryID'];
    header("Location: LibraryMain.php?id=" . $libraryID . "&error=true&message=no ID sent.");
    exit();
}
if (isset($_POST['libraryID'])) {

    $libraryID = $_POST['libraryID'];
    //echo $libraryID;
    $target_dir = "images/libraries/";
    $target_dir = $target_dir . $libraryID . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir);
    }
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $path_parts = pathinfo($_FILES["file"]["name"]);
    $extension = $extension = $path_parts['extension'];
    if (isset($_POST['path']) && $_POST['path'] != null && $_POST['path'] != "") {
        $target_file = $_POST['path'];
        unlink($target_file);
    } else {
        $target_file = $target_dir . getToken(16) . $libraryID . "." . $extension;
        unlink($target_file);
    }
    $uploadOk = 1;
    //echo $target_file;
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check == false) {
        $uploadOk = 0;
        $errorReason = "not an image.";
    }
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    if ($_FILES["file"]["size"] > 5000000) {
        $uploadOk = 0;
        $errorReason = "image was too large.";
    }
    $allowableExtensions = array("jpeg", "jpg", "png", "PNG", "JPG", "JPEG");
    if (!in_array($extension, $allowableExtensions)) {
        $uploadOk = 0;
        $errorReason = "image has a bad extension.";
    }
    if ($uploadOk == 0) {
        header("Location: LibraryMain.php?id=" . $libraryID . "&error=true&messgae=" . $errorReason);
        exit();
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        } else {
            $uploadOK = 0;
            $errorReason = "Could Not Move image.";
        }
    }
    header("Location: LibraryMain.php?id=" . $libraryID . "&success=true");
    exit();
} else {
    header("Location: LibraryMain.php?id=" . $libraryID . "&error=true&message=Something went wrong.");
    exit();
}