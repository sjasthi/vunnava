<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php?logout=true&message=Access Denied');
    exit;
} else if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $libID = $_POST['library_id'];
    if (getUserExpiresTime($_SESSION['userID']) < time()) {
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Login Expired');
        exit;
    }

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
    $bookID = $_POST['id'];
    header("Location: BookMain.php?id=" . $bookID . "&error=true");
    exit();
}
if (isset($_POST['update'])) {
    $bookID = filter_var(($_POST['id']), FILTER_SANITIZE_STRING);
    $bookCallNumber = filter_var(($_POST['callNumber']), FILTER_SANITIZE_STRING);
    $bookTitle = filter_var(($_POST['title']), FILTER_SANITIZE_STRING);
    $bookAuthor = filter_var(($_POST['author']), FILTER_SANITIZE_STRING);
    $bookPublisher = filter_var(($_POST['publisher']), FILTER_SANITIZE_STRING);
    $bookPublishYear = filter_var(($_POST['publishYear']), FILTER_SANITIZE_STRING);
    $bookNumPages = filter_var(($_POST['pages']), FILTER_SANITIZE_STRING);
    $bookDonatedBy = filter_var(($_POST['donatedBy']), FILTER_SANITIZE_STRING);
    $bookPrice = filter_var(($_POST['price']), FILTER_SANITIZE_STRING);
    $bookLibID = filter_var(($_POST['library_id']), FILTER_SANITIZE_STRING);
	$null = NULL;
    if ($bookID == "null") {
        $bookID = createBook($bookCallNumber, $bookTitle, 0, $bookLibID, $bookAuthor, $bookPublisher, $bookPublishYear, $bookNumPages, $bookPrice, $bookDonatedBy, $null);
        if (isset($_FILES["fileToUpload"]) && is_uploaded_file($_FILES["fileToUpload"]['tmp_name'])) {
            $target_dir = "images/books/";
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $path_parts = pathinfo($_FILES["fileToUpload"]["name"]);
            $extension = $extension = $path_parts['extension'];
            $target_file = $target_dir . "book" . $bookID . "." . $extension;
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
                header("Location: BookMain.php?id=" . $bookID . "&error=true&reason=" . $errorReason);
                exit();
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
                    $uploadOK = 0;
                    $errorReason = "Could Not Move image.";
                }
            }
            updateBook($bookID, $bookCallNumber, $bookTitle, $bookAuthor, $bookPublisher, $bookPublishYear, $bookNumPages, $bookDonatedBy, $bookPrice, $bookLibID, $target_file);
        }
    } else {
        updateBook($bookID, $bookCallNumber, $bookTitle, $bookAuthor, $bookPublisher, $bookPublishYear, $bookNumPages, $bookDonatedBy, $bookPrice, $bookLibID, getInventoryByItemId($bookID)->image);
    }
    if ($bookID == 0) {
        $bookDup = array('callNum'=>$bookCallNumber,'title'=>$bookTitle,'author'=>$bookAuthor,'publisher'=>$bookPublisher,'publishYear'=>$bookPublishYear,'numPages'=>$bookNumPages,'donatedBy'=>$bookDonatedBy,'price'=>$bookPrice,'item_id'=>null,'library_id'=>null);
		$_SESSION['DUPBOOK'] = $bookDup;
        header("Location: BookEdit.php?libraryID=0&duplicate=true&message=\"Book already exists\"");
        exit();
    }
    header("Location: BookMain.php?id=" . $bookID . "&success=true&currentLib=" . $bookLibID . "");
    exit();
} else if (isset($_POST['delete'])) {
    $bookID = $_POST['id'];
    $libID = $_POST['library_id'];
    //echo $libID;
    // Check for error conditions and then set the success or error...
    deleteBook($bookID);
    header("Location: libraryInventory.php?id=" . $libID . "&page=0&success=true&message=Book Deleted.");
    exit();
} else {
    header("Location: BookMain.php");
    exit();
}