<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/UserInformation.php';

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

    if (!checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)) {
        $id = $_SESSION['userID'];
        session_destroy();
        session_start();
        $_SESSION['userID'] = $id;
        header('Location: login.php?logout=true&message=Access Denied');
        exit;
    }
}


if(isset($_POST['createUser']))
{
	$password = $_POST['p'];
	$prepass = $password;
	$password = filter_var(($_POST['p']), FILTER_SANITIZE_STRING);
	if( $prepass != $password)
	{
		header("Location: CreateNewUser.php?success=false&message=Invalid characters in password.");
    	exit();
	}
	$userName = filter_var(($_POST['userName']), FILTER_SANITIZE_STRING);
    
	$libraryID = filter_var(($_POST['libID']), FILTER_SANITIZE_STRING);
	if($libraryID == 0 && !$parameters['AllowMultipleAdmins']->value)
	{
		header("Location: CreateNewUser.php?success=false&message=Cannot assign library 0");
    	exit();
	}
	foreach($users as $user)
	{
		if($userName == $user->name)
		{
			header("Location: CreateNewUser.php?success=false&message=Username already exists");
    		exit();
		}
	}
	
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	createUser($userName, $password, $libraryID);
	
	header("Location: Admin.php?success=true&message=Create User: " . $userName ."");
    exit();
	
}
else if (isset($_POST['deleteUser']))
{
	$userID = filter_var(($_POST['userID']), FILTER_SANITIZE_STRING);
	$userlibID = filter_var(($_POST['userLibID']), FILTER_SANITIZE_STRING);
	if($userlibID == 0)
	{
		if($parameters['AllowMultipleAdmins']->value)
		{
			if(getSuperAdminCount() <= 1)
			{
				header("Location: Admin.php?success=false&message=Cannot Delete last SUPER ADMIN (someone has to run things around here.)");
				exit();
			}
			else
			{
				deleteUser($userID);
				header("Location: Admin.php?success=true&message=SUPER ADMIN Deleted");
    			exit();
			}
		}
	}
	deleteUser($userID);
	header("Location: Admin.php?success=true&message=User Deleted");
    exit();
	
}
else if (isset($_POST['logoutAllUsers']))
{
	logoutAllUsers();
	header("Location: Admin.php?success=true&message=Users Logged Out");
    exit();
}
else if (isset($_POST['updatePassword']))
{
	$password = $_POST['p'];
	$prepass = $password;
	$password = filter_var(($_POST['p']), FILTER_SANITIZE_STRING);
	if( $prepass != $password)
	{
		header("Location: Admin.php?success=false&message=Invalid characters in password");
    	exit();
	}
	$userID = filter_var(($_POST['userID']), FILTER_SANITIZE_STRING);
	$userName = filter_var(($_POST['userName']), FILTER_SANITIZE_STRING);
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	updateUserPassword($userID, $userName, $password);
	
	header("Location: Admin.php?success=true&message=Updated password");
    exit();
}
else if (isset($_POST['updateUser'])) {
	$userID = filter_var(($_POST['userID']), FILTER_SANITIZE_STRING);
    $userName = filter_var(($_POST['userName']), FILTER_SANITIZE_STRING);
    $libraryID = filter_var(($_POST['libID']), FILTER_SANITIZE_STRING);
	if($libraryID == -1)
	{
		header("Location: Admin.php?success=false&message=Choose a library");
    	exit();
	}
	if($libraryID == 0 && $_SESSION['libraryAccessID'] != 0)
	{
		header("Location: Admin.php?success=false&message=Cannot assign library 0");
    	exit();
	}
	updateUser($userID,$userName,$libraryID);
    
    header("Location: Admin.php?success=true&message=Updated Username / Library");
    exit();
} 
else if (isset($_POST['deleteUser'])) {
    $userID = filter_var(($_POST['userID']), FILTER_SANITIZE_STRING);
	
	
    header("Location: Admin.php?success=true&message=Deleted User");
    exit();
} else {
    header("Location: 404.php");
    exit();
}