<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/BlogInformation.php';
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


if (isset($_POST['blog_id'])) {
	$blogID = $_POST['blog_id'];
	$blog = getBlogEntryByID($blogID);
	removeBlogImageUrl($blog);
	unlink($blog->image);
	
	header('Location: blog.php?numEntries=20&success=true&message=Deleted Image');
    exit;
    
} else {
    header("HTTP/1.1 500 Failed to delete");
    exit;
}