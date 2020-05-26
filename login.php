<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
$parameters = getParameters();
session_start();

$success = false;
$message = '';
$message = null;
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
if (isset($_GET['logout']) && $_GET['logout'] == true) {
    if ($message == null) {
        $message = 'You have been logged out.';
    }
    logoutUser($_SESSION['userID']);
    session_destroy();
    header('Location: login.php?message=' . $message . '');
    exit;
}
if (isset($_SESSION['admin'])) {
    header('Location: index.php?success=true&message=You are already logged in as ');
} else {
    if (isset($_POST['webusername']) && isset($_POST['pass'])) {
        $webusername = filter_var($_POST['webusername'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        $currentUser = getUser($webusername, $pass);
        //obviously this password should be on transmitted through an https setting.
        if ($currentUser != null) {
            $_SESSION['admin'] = true;
            $_SESSION['libraryAccessID'] = $currentUser->libraryID;
            $_SESSION['userID'] = $currentUser->id;
            $_SESSION['username'] = $currentUser->name;
            $_SESSION['userToken'] = $currentUser->token;
            $_SESSION['expires'] = $currentUser->expires;
            header('Location: index.php?success=true&message=You have been logged in as ');
        } else {
            session_destroy();
            $success = false;
            $message = "Invalid credentials.";

        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<link rel="icon"
      type="image/png"
      href="favicon.ico">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $parameters['systemname']->value ?> Admin Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
printHeader();
echo "<div class=\"container\">";
echo "<br/>";
printAdminLoginForm($success, $message);

printFooter();

?>
      <!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>