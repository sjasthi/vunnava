<?php session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
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

    <title><?php echo $parameters['systemname']->value ?> Use Cases</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
printHeader();
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <small><?php echo $parameters['systemname']->value ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Use Cases</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Intro Content -->
    <h2><?php echo $parameters['systemname']->value . ' Use Cases'?></h2>
	<ul>
        <li><h5>Un-Authenticated</h5></li>
		<ul>
			<li>View Index Page</li>
			<ul>
				<li>Click Index page Blurb Links</li>
				<li>Community Libraries</li>
				<li>Blog</li>
				<li>More Info</li>
				<li>Featured Libraries</li>
				<li>Header Links</li>
			</ul>
			<li>About Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Carousel is accurate and contains images</li>
				<li>About text is accurate (is currently placeholder text)</li>
				<li>facebook link functions</li>
				<li>Our Team section contains functional links and data</li>
			</ul>
			<li>Blog Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Blog entries are ordered newest first</li>
				<li>Entries have a creator name</li>
				<li>facebook link functions</li>
				<li>Videos Render and play</li>
				<li>Dates are formatted subcontinent-style</li>
				<li>More button reloads page with ?numEntries+=10</li>
			</ul>
			<li>Contact Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Map Renders</li>
				<li>Contact Details render</li>
				<li>facebook link functions</li>
				<li>Send message requires all fields</li>
				<li>Messages send to a non existent email currently</li>
			</ul>
			<li>View Libraries Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Lists all libraries</li>
				<li>Each library can be visited</li>
				<li>Abbreviated Library info is accurate</li>
			</ul>
			<li>View Library Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Images are displayed or a default image</li>
				<li>Library Details are displayed (District, Mandal, Village, Total Books)</li>
				<li>Description is accurate</li>
				<li>Books button is enable or disabled based on count of books > 0</li>
				<li>Randomly featured books appear if count of books > 5</li>
			</ul>
			<li>View Books Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Is available from any library where book count > 0</li>
				<li>Search bar is available</li>
				<li>Title, Author, and Publisher can be searched</li>
				<li>Number of results is displayed after a search</li>
				<li>Search results are not paginated</li>
				<li>Books are paginated if more than 36 exist</li>
				<li>Pagination functions properly</li>
				<li>Book images are displayed if they exist otherwise placeholder</li>
				<li>Each book image is a link to the book page for that book</li>
			</ul>
			<li>View Books Page</li>
			<ul>
				<li>Breadcrumbs are accurate</li>
				<li>Is available from any book in a library book list</li>
				<li>Displays a helpful error for books that don't exist</li>
				<li>All book details are displayed</li>
				<li>Created by library and Owned by Library links work</li>
				<li>Book image is displayed if exists else a default</li>
			</ul>
			<li>Login Page</li>
			<ul>
				<li>Displays username and password fields</li>
				<li>Invalid logins fail with a message</li>
				<li>Valid logins redirect to the index page with a success message</li>
				<li>Once logged in, reports becomes available in the header links</li>
				<li>Once logged in, Login link becomes log out with username</li>
			</ul>
		</ul>
        <li><h5>Authenticated</h5></li>
		<ul>
			<li>View Libraries Page</li>
				<ul>
					<li>Does not change</li>
				</ul>
			<li>View Library Page</li>
			<ul>
				<li>Access to admin functions only for authorized library</li>
				<li>Upload images button activated upload mode</li>
				<li>Images can all be deleted</li>
				<li>Done uploading button returns to library page</li>
				<li>Export library exports an excel sheet of all library entries</li>
				<li>Import Books sends you to the import page</li>
				<li>Create Book button send you to the create book form</li>
				<li>Edit library details sends you to the library edit form and edits can be made.</li>
				<li>Saving edits provides a helpful success message</li>
			</ul>
			<li>Import Page</li>
			<ul>
				<li>Import sample file is provided</li>
				<li>New books can be imported</li>
				<li>Books are saved in library id 0</li>
				<li>A borrowed copy is available to your library after import</li>
				<li>Help text renders when clicked</li>
				<li>Duplicate books are not created when imported (Same title, author, publisher, and publish year)</li>
				<li>No import occurs if no file is selected (helpful error)</li>
				<li>Invalid file types are not imported</li>
			</ul>
			<li>View Books Page</li>
			<ul>
				<li>Every book can be returned to library 0</li>
				<li>Any book in library 0 (Topudu Bandi main library) can be borrowed</li>
				<li>After borrowing a book, you can see it in your library</li>
				<li>Borrowed books can be returned from your library</li>
			</ul>
			<li>View Book Page</li>
			<ul>
				<li>Any book that is in your library can be returned with the return this book button</li>
				<li>Any book that was created by your library can be edited by your library</li>
				<li>Books that your library is borrowing but were created by another library cannot be edited by you</li>
			</ul>
			<li>Edit/Create Book Page</li>
			<ul>
				<li>Any book that was created by your library can be edited by clicking the edit button</li>
				<li>Changes can be made and saved in edit mode</li>
				<li>Books can be deleted if they were created by you</li>
				<li>Deleted books do no leave borrowed references lying around (i.e. another library borrowed a book you created and then you delete it</li>
				<li>From your library page you can create a new book</li>
				<li>When a new book is saved, you are sent to it, and a success message appears</li>
				<li>All fields are required</li>
				<li>Duplicate books cannot be created</li>
				<li>Book images can be deleted or updated</li>
			</ul>
			<li>Reports Page</li>
			<ul>
				<li>Authenticated users can see this page</li>
				<li>Data looks reasonably accurate</li>
			</ul>
			<li>Blog Page</li>
			<ul>
				<li>New blog entries can be created</li>
				<li>Entering a link to a youtube video will save such that the video renders</li>
				<li>Images can be saved with a blog post</li>
				<li>Blog posts can be edited</li>
				<li>Edited blog posts change owners but not dates</li>
				<li>Only the title is required to make a blog entry</li>
				<li>Blog post images can be updated and deleted</li>
				<li>Blog posts can be deleted</li>
			</ul>
			<li>Logout Link</li>
			<ul>
				<li>Logs out the current user</li>
				<li>A nice success message is displayed</li>
			</ul>
		</ul>
    </ul>

<?php printFooter(); ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
