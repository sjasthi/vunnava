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
}


if(isset($_POST['createBlog']))
{
	$userID = $_POST['userID'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$video = $_POST['video'];
	
	$userID = filter_var(($userID), FILTER_SANITIZE_STRING);
	$title = filter_var(($title), FILTER_SANITIZE_STRING);
	$content = filter_var(($content), FILTER_SANITIZE_STRING);
	$video = filter_var(($video), FILTER_SANITIZE_STRING);
	$target_file = null;
	
	if (isset($_FILES["fileToUpload"]) && is_uploaded_file($_FILES["fileToUpload"]['tmp_name'])) {
			if(!file_exists("images/blog/"))
			{
				mkdir("images/blog/");
			}
            $target_dir = "images/blog/" . getToken(16);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $path_parts = pathinfo($_FILES["fileToUpload"]["name"]);
            $extension = $extension = $path_parts['extension'];
            $target_file = $target_dir . "." . $extension;
            $uploadOk = 1;
            //echo $target_file;
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
                header("Location: blog.php?numEntries=20&success=false&message=" . $errorReason);
                exit();
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
                    $uploadOK = 0;
					header("Location: blog.php?numEntries=20&success=false&message=Could Not Move image.");
                	exit();
                }
            }
        }
	
	createBlog($userID, $title, $content, $target_file, $video);	
	header("Location: blog.php?numEntries=20&success=true&message=Created Blog Post");
    exit();
	
}
if (isset($_POST['deleteBlog']))
{
	$id = $_POST['blogid'];
	$delete = deleteBlogEntry($id);
	header("Location: blog.php?numEntries=20&success=true&message=Deleted Blog Post");
    exit();
}
if (isset($_POST['updateBlog']))
{
	$userID = $_POST['userID'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$video = $_POST['video'];
	$id = $_POST['blogid'];
	
	$id = filter_var(($id), FILTER_SANITIZE_STRING);
	$userID = filter_var(($userID), FILTER_SANITIZE_STRING);
	$title = filter_var(($title), FILTER_SANITIZE_STRING);
	$content = filter_var(($content), FILTER_SANITIZE_STRING);
	$video = filter_var(($video), FILTER_SANITIZE_STRING);
	
	updateBlog($id, $userID, $title, $content, $video);	
	header("Location: blog.php?numEntries=20&success=true&message=Updated Blog Post");
    exit();
} else {
    header("Location: 404.php");
    exit();
}