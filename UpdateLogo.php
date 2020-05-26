<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';

session_start();
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
}
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");




$target_dir = "images/logo";
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
$path_parts = pathinfo($_FILES["file"]["name"]);
$extension = $path_parts['extension'];
if($extension != 'jpg')
{
	header("HTTP/1.1 500 Bad extension");
    exit;
}
$target_file = $target_dir . "." . $extension;
$uploadOk = 1;
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
  if ($uploadOk == 0) {
     header("HTTP/1.1 500 Failed to upload");
     exit;
 } else {
     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
       } else {
           $uploadOK = 0;
           $errorReason = "Could Not Move image.";
       }
   }
if(uploadOK == 0)
{
	header("HTTP/1.1 500 bad file");
    exit;
}
else
{
 header("HTTP/1.1 200 OK");
 exit;
}
