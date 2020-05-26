<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/BlogInformation.php';
session_start();
$parameters = getParameters();

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

    <title><?php echo $parameters['systemname']->value ?> Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php

$success = false;
$failure = false;
$message = '';
printHeader();
if(isset($_GET['success']))
{
	if($_GET['success'] == 'true')
	{
		$success = true;
		$message = $_GET['message'];
	}
	if($_GET['success'] == 'false')
	{
		$failure = true;
		$message =  $_GET['message'];
	}
	
}
?>

<!-- Page Content -->
<div class="container">

     
    <div class="row">
		
        <div class="col-lg-12">
            <h1 class="page-header">
                Blog
				<small><?php echo $parameters['systemname']->value ?></small>
				
            </h1>
			
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Blog</li>
            </ol>
			<ul class="list-unstyled list-inline list-social-icons">
                <li>
					<?php
					$fbLink = $parameters['facebooklink']->value;
					if($fbLink != null && $fbLink != '')
					{
                    	echo "<a target=\"_blank\" href=\"" . $fbLink .  "\"><i
                                class=\"fa fa-facebook-square fa-2x\"></i></a>";
					}?>
                </li>
                <!--li>
                    <a href="#"><i class="fa fa-linkedin-square fa-2x"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-google-plus-square fa-2x"></i></a>
                </li-->
            </ul>
        </div>
		
    </div>
	
        <div class="row">

            <?php
			if($success)
			{
				printSuccessMessage($message);
			}
			else if ($failure)
			{
				printErrorMessage($message);
			}
			$limit = 1000;
			if(isset($_GET['numEntries']) && $_GET['numEntries'] > 0)
			{
				$limit = $_GET['numEntries'];
			}
			if (isset($_SESSION['admin']) && $_SESSION['admin'] == true)
			{
				echo "<div class=\"col-lg-12\">\n";
				echo printWarnButton("Create Blog Post","BlogEdit.php",false);
				echo "</div>";
			}
			//echo "</div>";
			echo "<div class=\"col-lg-8\">";
			$blogs = getBlogEntries(0,$limit);
			foreach($blogs as $blog)
			{
				printBlogEntry($blog);
			}
			?>
			</div>
			<div class="col-md-4">

                <!-- Blog Search Well -->
                <!--div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                <!--/div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Posts</h4>
                            <ul class="list-unstyled">
								<?php
									foreach($blogs as $blog)
									{
										echo "<li><a href=\"#" . $blog->title . "\">" . $blog->title ."</a></li><br/>";
									}
								$limit += $parameters['BlogEntriesToAdd']->value;
								$location = "blog.php?numEntries=" . $limit;
								echo printNormalButton("More...", $location , false);
								?>
                            </ul>
                        </div>
                        <!--div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>`
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div-->
                    <!--/div>
                    <!-- /.row -->
                <!--/div>

                

            </div>

        </div>
        <!-- /.row -->

        <!--hr>

        <!-- Footer -->
		</div>
				</div>
			<?php
			$limit += $parameters['BlogEntriesToAdd']->value;
			$location = "blog.php?numEntries=" . $limit;
			echo"<div class=\"row\"><div class=\"col-md-12\">";
			echo printNormalButton("More...", $location , false);
			?>
	<div>
            <!-- Blog Sidebar Widgets Column -->
            
        <?php
			
			echo"</div><div class=\"row\"><div class=\"col-md-12\">";
			printFooter();
					echo"</div></div>";
			?>

    <!--/div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	</div>
</body>

</html>
