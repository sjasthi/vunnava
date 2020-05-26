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


if(isset($_POST['editBlurb1']))
{
	
	$content = $_POST['content'];
	$name = $_POST['name'];
	updateBlurb('blurb1',$name,$content);	
	header("Location: Admin.php?success=true&message=Updated Blurb 1 Text");
    exit();
	
}
if(isset($_POST['editBlurb2']))
{
	
	$content = $_POST['content'];
	$name = $_POST['name'];
	
	updateBlurb('blurb2',$name,$content);	
	header("Location: Admin.php?success=true&message=Updated Blurb 2 Text");
    exit();
	
}
if(isset($_POST['editBlurb3']))
{
	
	$content = $_POST['content'];
	$name = $_POST['name'];
	
	updateBlurb('blurb3',$name,$content);	
	header("Location: Admin.php?success=true&message=Updated Blurb 3 Text");
    exit();
	
}
if(isset($_POST['editAboutAddress']))
{
	
	$content = $_POST['content'];
	$name = 'addresslocation';
	updateBlurb('aboutaddress',$name,$content);	
	header("Location: Admin.php?success=true&message=Updated Address Location");
    exit();
	
}
if(isset($_POST['editSystemName']))
{
	
	$content = $_POST['content'];
	$name = 'name';
	updateSystemName('systemname',$name,$content);	
	header("Location: Admin.php?success=true&message=Updated System Name");
    exit();
	
}
//editPhones
if(isset($_POST['editPhones']))
{
	
	$phone1 = $_POST['phone1'];
	$phone2 = $_POST['phone2'];
	$name1 = 'phone1';
	$name2 = 'phone2';
	updatePhone($name1,$name1,$phone1);	
	updatePhone($name2,$name2,$phone2);
	header("Location: Admin.php?success=true&message=Updated Phones");
    exit();
	
}
if(isset($_POST['editMapLocation']))
{
	
	$content = $_POST['content'];
	$name = 'locationURL';
	updateFacebookLink('maplocation', $name, $content);	
	header("Location: Admin.php?success=true&message=Updated Map Location");
    exit();
	
}
//editFacebookLink
if(isset($_POST['editFacebookLink']))
{
	
	$content = $_POST['content'];
	$name = 'facebook';
	updateFacebookLink('facebooklink', $name, $content);	
	header("Location: Admin.php?success=true&message=Updated Facebook Page link");
    exit();
	
}