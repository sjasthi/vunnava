<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameters.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameter.php';
$parameters = getParameters();

//print_r($parameters);//all parameters print out ok

/* 
Return a library given an id
*/
function getLibraryByID($id, $libraries)
{
    foreach ($libraries as $library) {
        if ($library->id == $id) {
            return $library;
        }
    }
    return null;

}
/*
Return a quantity of random numbers inside of a range
*/
function UniqueRandomNumbersWithinRange($min, $max, $quantity)
{
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}
/*
Print the featured libraries carousel html
*/
function printFeaturedLibrariesCarousel($featured, $images)
{
    echo "    <header id=\"myCarousel\" class=\"carousel slide\">";
    echo "        <ol class=\"carousel-indicators\">";
    echo "             <li data-target=\"#myCarousel\" data-slide-to=\"0\" class=\"active\"></li>";
	
	
	if(!$parameters['LibrarySingleMode']->value)
	{
    	echo "             <li data-target=\"#myCarousel\" data-slide-to=\"1\"></li>";
    	echo "             <li data-target=\"#myCarousel\" data-slide-to=\"2\"></li>";
	}
    echo "         </ol>";
    echo "         <div class=\"carousel-inner\">";
    echo "             <div class=\"item active\">";
    echo "                 <div class=\"fill\" style=\"background-image:url('" . $images[0] . "');\"></div>";
    echo "                 <div class=\"carousel-caption\">";
    echo "                     <h2><p><b>" . $featured[0]->name . "</b></p></h2>";
    echo "                 </div>";
    echo "             </div>";
	
	
	if(!$parameters['LibrarySingleMode']->value)
	{
		echo "             <div class=\"item\">";
		echo "                 <div class=\"fill\" style=\"background-image:url('" . $images[1] . "');\"></div>";
		echo "                 <div class=\"carousel-caption\">";
		echo "                   <h2><p><b>" . $featured[1]->name . "</b></p>";
		echo "                     </h2>";
		echo "                 </div>";
		echo "             </div>";
		echo "             <div class=\"item\">";
		echo "                 <div class=\"fill\" style=\"background-image:url('" . $images[2] . "');\"></div>";
		echo "                 <div class=\"carousel-caption\">";
		echo "                  <h2><p><b>" . $featured[2]->name . "</b></p>";
		echo "                   </h2>";
		echo "                 </div>";
		echo "             </div>";
		echo "         </div>";
		echo "         <a class=\"left carousel-control\" href=\"#myCarousel\" data-slide=\"prev\">";
		echo "             <span class=\"icon-prev\"></span>";
		echo "         </a>";
		echo "         <a class=\"right carousel-control\" href=\"#myCarousel\" data-slide=\"next\">";
		echo "             <span class=\"icon-next\"></span>";
		echo "         </a>";
	}
    echo "     </header>";
}
/*
Print the featured libraries row on the index page
*/
function printFeaturedLibrariesPortfolio($featured, $images)
{
    echo "    <div class=\"row\">";
    echo "            <div class=\"col-lg-12\">";
    echo "                <h2 class=\"page-header\">Featured Libraries</h2>";
    echo "            </div>";
    for ($i = 0; ($i < sizeof($featured)); $i++) {
        echo "            <div class=\"col-md-4 col-sm-6\">";
        echo "                <a title=\"" . $featured[$i]->name . "\" href=\"LibraryMain.php?id=" . $featured[$i]->id . "\">";
        echo "                    <img class=\"img-responsive img-portfolio img-hover\" src=\"" . $images[$i] . "\" alt=\"\">";
        echo "                </a>";
        echo "                <p>";
        echo "                <b>" . $featured[$i]->name . "</b>";
        echo "                <p class='ellipsis' title=\"" . truncateString($featured[$i]->description, 275) . "\">" . truncateString($featured[$i]->description, 275) . "</p>";
        echo "                </p>";
        echo "            </div>";
    }
    echo "        </div>";
}
/*
Get the list of library images for a given library id
*/
function getLibraryImages($id)
{
    $dir = "images/libraries/" . $id . "/";

    //echo $dir;
    $images = glob($dir . "*");
    return $images;
}
function getAboutImages()
{
    $dir = "images/press/";

    //echo $dir;
    $images = glob($dir . "*");
    return $images;
}
/*
Print a library item div on the libraryList page
*/
function printLibraryItemDiv($item)
{
    $images = getLibraryImages($item->id);
    if (sizeof($images) > 0) {
        echo "
      <div class='col-md-6 img-portfolio'>
          <p><span class=\"glyphicon glyphicon-home\"></span> " . $item->id . "</p>
          <a href='LibraryMain.php?id=" . $item->id . "'>
          <img class='img-responsive img-hover' src='" . $images[0] . "' alt=''></a>
          <h3>
              <a href='LibraryMain.php?id=" . $item->id . "'><p>" . truncateString($item->name,50) . "</p></a>
          </h3>
          
          <p><b>" . $item->villageName . "</b></p>
          <p>" . truncateString($item->description, 100) . "</p>
      </div>
      ";
    } else {
        echo "
      <div class='col-md-6 img-portfolio'>
          <p><span class=\"glyphicon glyphicon-home\"></span> " . $item->id . "</p>
          <a href='LibraryMain.php?id=" . $item->id . "'>
          <img class='img-responsive img-hover' src='images/libraries/default.png' alt=''></a>
          <h3>
              <a href='LibraryMain.php?id=" . $item->id . "'><p>" . truncateString($item->name,50) . "</p></a>
          </h3>
          <p><b>" . $item->villageName . "</b></p>
          <p>" . truncateString($item->description, 100) . "</p>
      </div>
      ";
    }
}
/*
Truncate a string by some max
*/
function truncateString($text, $length)
{
	if(strlen($text) > $length)
	{
		$string = substr($text, 0, $length);
		$string = $string . " ...";
		return $string;
	}else
	{
		return $text;
	}
}

/*
Print the form that allows searching on the library inventory page
*/
function printSearchForm($libID)
{
    if ($libID == null) {
		echo "<form action='fullInventory.php' method='get'>\n";
		echo "    <div class=\"input-group input-group-lg\">\n";
		echo "                <input  hidden='true' type='text' name='q' value='true'>";
		echo "      <input type=\"text\" name='term' value='' required placeholder='enter title, author, or publisher' class=\"form-control\" placeholder=\"Search\">\n";
		echo "      <div class=\"input-group-btn\">\n";
		echo "        <button class=\"btn btn-default\" type=\"submit\"><i class=\"glyphicon glyphicon-search\"></i></button>\n";
		echo "      </div>\n";
		echo "    </div>\n";
		echo "  </form>";
    } else {
        	
		echo "<form action='libraryInventory.php' method='get'>\n";
		echo "    <div class=\"input-group input-group-lg\">\n";
		echo "      <input  hidden='true' type='text' name='q' value='true'>";
		echo "                <input  hidden='true' type='text' name='id' value='" . $libID . "'>";
		echo "      <input type=\"text\" name='term' value='' required placeholder='enter title, author, or publisher' class=\"form-control\" placeholder=\"Search\">\n";
		echo "      <div class=\"input-group-btn\">\n";
		echo "        <button class=\"btn btn-primary\" type=\"submit\"><i class=\"glyphicon glyphicon-search\" value='Search'></i></button>\n";
		echo "      </div>\n";
		echo "    </div>\n";
		echo "  </form><br/><br/>";
    }
}
/*
Get the inner images on the librarymain page for the carousel
*/
function getLibraryCarouselInner($item)
{
    $images = $images = getLibraryImages($item->id);
    if (sizeof($images) > 0) {
        echo "<div class=\"row\">\n";
        echo "            <div class=\"col-md-6\">\n";
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $item->id)) {
                echo printWarnButton("Update Images", "LibraryImageUpdater.php?libraryID=" . $item->id, false);
                echo "<br/>";
                echo "<br/>";
            }
        }
        echo "                <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n";
        echo "                    <!-- Indicators -->\n";
        echo "                    <ol class=\"carousel-indicators\">\n";
        echo "                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\n";
        for ($i = 1; $i < sizeof($images); $i++) {
            echo "<li data-target=\"#carousel-example-generic\" data-slide-to=\"" . $i . "\"></li>\n";
        }
        echo "                    </ol>";

        echo "<div class=\"carousel-inner\">\n";
        echo "    <div class=\"item active\">\n";
        echo "        <img class=\"img-responsive\" src=" . $images[0] . " alt=\"\">\n";
        echo "    </div>\n";

        for ($i = 1; $i < sizeof($images); $i++) {
            echo "    <div class=\"item\">\n";
            echo "        <img class=\"img-responsive\" src=" . $images[$i] . " alt=\"\">\n";
            echo "    </div>\n";
        }
        echo "</div>";

        echo "<!-- Controls -->\n";
        echo "                    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" data-slide=\"prev\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-left\"></span>\n";
        echo "                    </a>\n";
        echo "                    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" data-slide=\"next\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-right\"></span>\n";
        echo "                    </a>\n";
        echo "                </div>\n";
        echo "            </div>";
    } //default.png
    else {
        echo "<div class=\"row\">\n";
        echo "            <div class=\"col-md-6\">\n";
		if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
			if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $item->id)) {
				echo printWarnButton("Update Images", "LibraryImageUpdater.php?libraryID=" . $item->id, false);
				echo "<br/>";
				echo "<br/>";
			}
		}
        echo "                <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n";
        echo "                    <!-- Indicators -->\n";
        echo "                    <ol class=\"carousel-indicators\">\n";
        echo "                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\n";
        for ($i = 1; $i < 3; $i++) {
            echo "<li data-target=\"#carousel-example-generic\" data-slide-to=\"" . $i . "\"></li>\n";
        }
        echo "                    </ol>";

        echo "<div class=\"carousel-inner\">\n";
        echo "    <div class=\"item active\">\n";
        echo "        <img class=\"img-responsive\" src=\"images/libraries/default.png\" alt=\"\">\n";
        echo "    </div>\n";
        for ($i = 1; $i < 3; $i++) {
            echo "    <div class=\"item\">\n";
            echo "        <img class=\"img-responsive\" src=\"images/libraries/default.png\" alt=\"\">\n";
            echo "    </div>\n";
        }

        echo "</div>";

        echo "<!-- Controls -->\n";
        echo "                    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" data-slide=\"prev\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-left\"></span>\n";
        echo "                    </a>\n";
        echo "                    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" data-slide=\"next\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-right\"></span>\n";
        echo "                    </a>\n";
        echo "                </div>\n";
        echo "            </div>";

    }

}

/*
Print all the info on the library main page
*/
function printLibraryDetailsDiv($item)
{
    echo "            <div>";
    echo "                <h3>Details</h3>\n";
    echo "                <ul>\n";
	echo "                    <li>District Name: " . $item->districtName . " </li>\n";
	echo "                    <li>Mandal Name: " . $item->mandalName . " </li>\n";
    echo "                    <li>Village Name: " . $item->villageName . " </li>\n";
    echo "                    <li>Total Books: " . $item->bookCount . "</li>\n";
    echo "                </ul>\n";
    echo "            </div>";
    echo "            </div>";
    echo "            </div>";
    echo "              <div class=\"row\">\n";
    echo "            <div class=\"col-md-12\">\n";
    echo "                <h3>Description</h3>\n";
    echo "                <p class=\"ellipsis\">" . $item->description . "</p>\n";
    echo "            </div>";
    echo "            </div>";
    echo "            <div>";
}

/*
Print the buttons (if authorized) on the library main page.
Also, if success we print the library saved message
*/
function printLibraryButtons($item, $success, $importerID)
{
	$parameters = getParameters();
    echo "          <div class=\"col-md-6\">\n";
    if ($success) {
        printSuccessMessage("Library Saved.");
    }
    if ($item->bookCount > 0) {
        echo printBigButton("Books", ("libraryInventory.php?id=" . $item->id . "&page=0"), false);
        echo "<br/>";
		echo "<br/>";
    } else {
        echo printBigButton("Books", ("libraryInventory.php?id=" . $item->id . "&page=0"), true);
        echo "<br/>";
        echo "<br/>";
    }
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
        if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $item->id)) {
			if(!$parameters['HideLibraryExport']->value)
			{
				if ($item->bookCount > 0) {
					printLibraryExportForm($item->id, $item->name, false);
				} else {
					printLibraryExportForm($item->id, $item->name, true);
				}
			}
            echo "<br/>";
            printLibraryImportButton($item->id,$importerID);
            echo "<br/>";
            echo printWarnButton("Create a Book", "BookEdit.php?libraryID=" . $item->id, false);
            echo "<br/><br/>";
            echo printWarnButton("Edit Library Details", "LibraryEdit.php?id=" . $item->id, false);
        }
    }

}

/*
Print the div for a book on libraryinventory including the borrows/returns links
*/
function printBookDiv($item, $libID)
{
    echo "            <div class=\"" . ('ROW_SIZE' == 4? "col-md-3" : "col-md-2") . " img-portfolio\">\n";
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
        if ($_SESSION['libraryAccessID'] == $libID || $_SESSION['libraryAccessID'] == 0) {
            if ($item->library_id != $libID) {
                echo "<div><b> <form method=\"post\" action=\"ReturnBook.php\" /  onsubmit='return confirm(\"Do you really want to return the book: " . $item->title . "?\");'><input hidden='true' type='text' name='libraryid' value='" . $libID . "'/><input hidden='true' type='text' name='bookid' value='" . $item->item_id . "'/> <button class=\"btn btn-link\" role=\"link\" type=\"submit\" name=\"op\" value=\"submit\">Return this book</button></form></b></div>";
            }
        } elseif ($_SESSION['libraryAccessID'] != 0 && $libID == 0) {
            $returnID = $_SESSION['libraryAccessID'];
            echo "<div><b> <form method=\"post\" action=\"BookBorrow.php\"><input hidden='true' type='text' name='libraryid' value='" . $returnID . "'/><input hidden='true' type='text' name='bookid' value='" . $item->item_id . "'/> <button class=\"btn btn-link\" role=\"link\" type=\"submit\" name=\"op\" value=\"submit\">Borrow this book</button></form></b></div>";
        }
    }

    if ($libID != 0) {
        echo "                <a href=\"BookMain.php?id=" . $item->item_id . "&currentLib=" . $libID . "\">\n";
    } else {
        echo "                <a href=\"BookMain.php?id=" . $item->item_id . "\">\n";
    }
    if (file_exists($item->image)) {
        echo "<img class=\"img-responsive img-hover\" src='" . $item->image . "' title=\"" . $item->title . "\">\n";

    } else {
        echo "                    <img class=\"img-responsive img-hover\" src=\"images/books/default.png\" title=\"" . $item->title . "\">\n";
    }
    echo "                </a>\n";
    echo "                <div class='bookDetails'>";
    echo "                <div><b>Title: " . $item->title . "</b></div>";
    echo "                <div>Author: " . $item->author . "</div>";
    echo "                <div>Publisher: " . $item->publisher . "</div>";
    //echo "                <div>Library: <a href=LibraryMain.php?id=" . $item->library_id . ">" . $item->libraryName . "</a></div>";
    echo "                </div>";
    echo "            </div>\n";
}

/*
Print the bookmain book details bit
*/
function printBookDetails($book, $success, $error, $message, $libraries)
{

    echo "          <div class=\"col-md-7\">\n";
    if ($success) {
        printSuccessMessage("Book Saved");
    }
    if ($error) {
        echo "<div class='alert alert-danger'>Unable To Save Book: " . $message . "</div>";
    }
    echo "                <h1>" . $book->title . "</h1>\n";
    echo "                <ul>\n";
    echo "                    <li>Author: " . $book->author . " </li>\n";
    echo "                    <li>Publisher: " . $book->publisher . " </li>\n";
    echo "                    <li>Year: " . $book->publishYear . " </li>\n";
    echo "                    <li>Pages: " . $book->numPages . " </li>\n";
    echo "                    <li>Donated by: " . $book->donatedBy . " </li>\n";
    echo "                    <li>Price: " . $book->price . " </li>\n";
    echo "                    <li>Call Number: " . $book->callNumber . "</li>\n";
	if(!$parameters['LibrarySingleMode']->value)
	{
		echo "                    <li>Created By Library: <a href='LibraryMain.php?id=" . $book->createdByLibraryID . "'>" . truncateString($book->libraryCreatedByName, 55) . "</a></li>\n";
		echo "                    <li>Owned By Library: <a href='LibraryMain.php?id=" . $book->library_id . "'>" . truncateString($book->libraryName, 55) . "</a></li>\n";
		echo "                </ul>\n";
	}
	else{
		echo "<br/>";
	}

    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
        if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], $book->createdByLibraryID)) {
            echo printNormalPrimaryButton("Edit", "BookEdit.php?id=" . $book->item_id, false);
            echo "<br/>";
            echo "<br/>";
			if($_SESSION['libraryAccessID']==0)
			{
				if(!$parameters['LibrarySingleMode']->value)
				{
            		printLibaryAssignmentForm($book->item_id, $libraries);
				}
			}
        }
		if(isset($_GET['currentLib']))
			{
				$currentLib = $_GET['currentLib'];
			}
			else{
				$currentLib = 0;
			}
		if ($_SESSION['libraryAccessID'] == $currentLib || $_SESSION['libraryAccessID'] == 0) {
			$returnID = $_SESSION['libraryAccessID'];
			
            if ($book->library_id != $currentLib && $returnID != 0) {
                echo "</div><div class=\"col-md-12\"><br/><form method=\"post\" action=\"ReturnBook.php\" /  onsubmit='return confirm(\"Do you really want to return the book: " . $book->title . "?\");'><input hidden='true' type='text' name='libraryid' value='" . $returnID . "'/><input hidden='true' type='text' name='bookid' value='" . $book->item_id . "'/> <button class=\"btn btn-primary\" role=\"link\" type=\"submit\" name=\"op\" value=\"submit\">Return this book</button></form></form>";
            }
        } elseif ($_SESSION['libraryAccessID'] != 0 && $_GET['id'] == 0) {
            
            echo "</div><div class=\"col-md-12\"><br/><form method=\"post\" action=\"BookBorrow.php\"><input hidden='true' type='text' name='libraryid' value='" . $returnID . "'/><input hidden='true' type='text' name='bookid' value='" . $book->item_id . "'/> <button class=\"btn btn-primary\" role=\"link\" type=\"submit\" name=\"op\" value=\"submit\">Borrow this book</button></form>";
        }
    }
    echo "            </div>";
}
/*
Print the form that allows me to borrow a book from the other library
*/
function printBorrowingForm($book,$libraryID)
{
	$thisLib = null;
	if(isset($_GET['currentLib']))
	{
		$thisLib = $_GET['currentLib'];
	}
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
		if($book->library_id == 0 && $thisLib == null && $libraryID != 0)
		{
			echo "</div><div class=\"col-md-12\"><br/><div class=\"row\"><form method=\"post\" action=\"BookBorrow.php\"><input hidden='true' type='text' name='libraryid' value='" . $libraryID . "'/><input hidden='true' type='text' name='bookid' value='" . $book->item_id . "'/> <button class=\"btn btn-primary\" role=\"link\" type=\"submit\" name=\"op\" value=\"submit\">Borrow this book</button></form>";
		}
	}
}
/*
Get the inner carousel bit for the about/press page
*/
function getPressCarouselInner()
{
    $dir = "images/press/";
    $pressimages = glob($dir . "*");

    if (sizeof($pressimages) > 0) {
        echo "<div class=\"row\">\n";
        echo "            <div class=\"col-md-6\">\n";
		if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
			if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)) {
				echo printWarnButton("Update Images", "AboutImageUpdater.php", false);
				echo "<br/>";
				echo "<br/>";
			}
		}
        echo "                <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n";
        echo "                    <!-- Indicators -->\n";
        echo "                    <ol class=\"carousel-indicators\">\n";
        echo "                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\n";
        for ($i = 1; $i < sizeof($pressimages); $i++) {
            echo "<li data-target=\"#carousel-example-generic\" data-slide-to=\"" . $i . "\"></li>\n";
        }
        echo "                    </ol>";

        echo "<div class=\"carousel-inner\">\n";
        echo "    <div class=\"item active\">\n";
        echo "        <img class=\"img-responsive\" src=" . $pressimages[0] . " alt=\"\">\n";
        echo "    </div>\n";

        for ($i = 1; $i < sizeof($pressimages); $i++) {
            echo "    <div class=\"item\">\n";
            echo "        <img class=\"img-responsive\" src=" . $pressimages[$i] . " alt=\"\">\n";
            echo "    </div>\n";
        }
        echo "</div>";

        echo "<!-- Controls -->\n";
        echo "                    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" data-slide=\"prev\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-left\"></span>\n";
        echo "                    </a>\n";
        echo "                    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" data-slide=\"next\">\n";
        echo "                        <span class=\"glyphicon glyphicon-chevron-right\"></span>\n";
        echo "                    </a>\n";
        echo "                </div>\n";
        echo "            </div>";
    }
	else
	{
		echo "<div class=\"row\">\n";
        echo "            <div class=\"col-md-6\">\n";
		echo "No images found in the press folder<br/>";
		if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
			if (checkUserCreds($_SESSION['userID'], $_SESSION['userToken'], 0)) {
				echo printWarnButton("Update Images", "AboutImageUpdater.php", false);
				echo "<br/>";
				echo "<br/>";
			}
		}
		echo "</div>";
		
	}
}
function printBlogEntry($blog)
{
	echo "<!-- Blog Post Content Column -->\n";
	
	
	echo "            <a name=\"" . $blog->title  . "\"></a>";
	echo "\n";
	echo "                <!-- Blog Post -->\n";
	echo "\n";
	echo "                <!-- Title -->\n";
	echo "                <h1>" . $blog->title . "</h1>\n";
	echo "                <!-- Author -->\n";
	echo "                <p class=\"lead\">\n";
	echo "                    by " . ($blog->userName != null? $blog->userName : "Former User") ;
	echo "                </p>\n";
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)
	{
		printBlogEditForm($blog);
	}
	echo "                <!-- Date/Time -->\n";
	echo "<br/>";
	$newDate = date("d-m-Y", strtotime($blog->createdDate));
	echo "                <p><span class=\"glyphicon glyphicon-time\"></span> Posted on " . $newDate . "</p>\n";
	echo "\n";
	echo "\n";
	echo "                <!-- Preview Image -->\n";
	if($blog->image != null && file_exists($blog->image))
	{
		echo "                <img class=\"img-responsive\" src=\"" . $blog->image . "\" alt=\"\">\n";			
	}
	echo "\n";
	echo "\n";
	echo "                <!-- Post Content -->\n";
	echo "                <p class=\"lead\">" . $blog->title  . "</p>\n";
	echo "                <p> " . $blog->content  .  "</p>\n";
	echo "\n";
	if($blog->video != null)
	{
		echo "<div class=\"embed-responsive embed-responsive-16by9\" >";
		echo "<iframe  class=\"embed-responsive-item\"  frameborder=\"0\" allowfullscreen ";
		echo "src=\"" . $blog->video  . "\">";
		echo "</iframe>";
		echo "</div>";
	}
	
	echo "                <hr>\n";
	//echo "            </div>";

}
function printBigButton($text, $link, $disabled)
{
    $text = filter_var(($text), FILTER_SANITIZE_STRING);
    if ($disabled) {
        return "<div disabled='true' class='btn btn-lg btn-primary' >" . $text . "</div>";
    } else {
        return "<a class='btn btn-lg btn-primary' href='" . $link . "'><span class=\"glyphicon glyphicon-book\"></span> " . $text . "</a>";
    }
}

function printNormalButton($text, $link, $disabled)
{
    $text = filter_var(($text), FILTER_SANITIZE_STRING);
    if ($disabled) {
        return "<div disabled='true' class='btn btn-default' >" . $text . "</div>";
    } else {
        return "<a class='btn btn-default'  href='" . $link . "'>" . $text . "</a>";
    }
}

function printNormalPrimaryButton($text, $link, $disabled)
{
    $text = filter_var(($text), FILTER_SANITIZE_STRING);
    if ($disabled) {
        return "<div disabled='true' class='btn btn-primary' >" . $text . "</div>";
    } else {
        return "<a class='btn btn-primary'  href='" . $link . "'>" . $text . "</a>";
    }
}

function printWarnButton($text, $link, $disabled)
{
    $text = filter_var(($text), FILTER_SANITIZE_STRING);
    if ($disabled) {
        return "<div disabled='true' class='btn btn-warning' >" . $text . "</div>";
    } else {
        return "<a class='btn btn-warning'  href='" . $link . "'>" . $text . "</a>";
    }
}

function printSuccessButton($text, $link, $disabled)
{
    $text = filter_var(($text), FILTER_SANITIZE_STRING);
    if ($disabled) {
        return "<div disabled='true' class='btn btn-success' >" . $text . "</div>";
    } else {
        return "<a class='btn btn-success'  href='" . $link . "'>" . $text . "</a>";
    }
}

function printSuccessMessage($message)
{
    $message = filter_var(($message), FILTER_SANITIZE_STRING);
    echo "<div id='alert alert-success'><div class='alert alert-success'><button type='button' class=
        'close' data-dismiss='alert' aria-hidden='true'>x</button><strong>" . $message . "</strong></div></div>";
}

function printErrorMessage($message)
{
    $message = filter_var(($message), FILTER_SANITIZE_STRING);
    echo "<div id='alert alert-danger'><div class='alert alert-danger'><button type='button' class=
        'close' data-dismiss='alert' aria-hidden='true'>x</button><strong>" . $message . "</strong></div></div>";
}
/*

We do this in the case of encountering some problem.  This allows us to print the footer and close the html
*/
function printerrorAndExit($error, $returnPath)
{
    $error = filter_var(($error), FILTER_SANITIZE_STRING);
    echo "<div class=\"container\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    echo "<div class=\"alert alert-danger\" >" . $error . "\t<a href=\"" . $returnPath . "\" class=\"btn btn-danger\">Go Back</a></div>";
    printFooter();
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<script src=\"js/jquery.js\"></script>";
    echo "<script src=\"js/bootstrap.min.js\"></script>";
    exit;
}
/*

Print the page header on every page

*/
function printHeader()
{
	$parameters = getParameters();
    echo "<!-- Navigation -->\n";
    echo "  <nav class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">\n";
    echo "      <div class=\"container\">\n";
    echo "          <!-- Brand and toggle get grouped for better mobile display -->\n";
    echo "          <div class=\"navbar-header\">\n";
    echo "              <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">\n";
    echo "                  <span class=\"sr-only\">Toggle navigation</span>\n";
    echo "                  <span class=\"icon-bar\"></span>\n";
    echo "                  <span class=\"icon-bar\"></span>\n";
    echo "                  <span class=\"icon-bar\"></span>\n";
    echo "              </button>\n";
    echo "              <a class=\"navbar-brand\" href=\"index.php\"><span><img border='0' alt='Sun' src='images/logo.png' width='37' height='37'>Home</span></a>\n";
    echo "          </div>\n";
    echo "          <!-- Collect the nav links, forms, and other content for toggling -->\n";
    echo "          <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">\n";
    echo "              <ul class=\"nav navbar-nav navbar-right\">\n";
	if($parameters['LibrarySingleMode']->value == false)
	{
		echo "                  <li>\n";
		echo "                      <a href=\"LibraryList.php\">Libraries</a>\n";
		echo "                  </li>\n";
	}
	else
	{
		echo "                  <li>\n";
		echo "                      <a href=\"LibraryMain.php?id=0\">Library</a>\n";
		echo "                  </li>\n";
		
	}
    echo "                  <li>\n";
    echo "                      <a href=\"libraryInventory.php?id=0&page=0\">Books </a>\n";
    echo "                  </li>\n";
	echo "                  <li>\n";
    echo "                      <a href=\"blog.php?numEntries=" . $parameters['BlogEntriesToLoad']->value . "\">Blog </a>\n";
    echo "                  </li>\n";
	
	
	
	
	
	  echo "                  <li>\n";
		echo "                      <a href=\"sponsors_displayed.php?id=0&page=0\">Sponsors</a>\n";
		echo "                  </li>\n";
		 echo "                  <li>\n";
		echo "                      <a href=\"projects_displayed.php?id=0&page=0\">Projects</a>\n";
		echo "                  </li>\n";
		
		
		
	
    echo "                  <li>\n";
    echo "                      <a href=\"about.php\">About </a>\n";
    echo "                  </li>\n";
    echo "                  <li>\n";
    echo "                      <a href=\"contact.php\">Contact </a>\n";
    echo "                  </li>\n";
    echo "                  <li>\n";
    echo "                      <a href=\"Reports.php\">Reports </a>\n";
    echo "                  </li>\n";
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
		if($_SESSION['libraryAccessID'] == 0)
		{
			echo "                  <li>\n";
    		echo "                      <a href=\"Admin.php\">Admin </a>\n";
    		echo "                  </li>\n";
			
		}
	}
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
		
		
		
        echo "                              <li>\n<a href=\"login.php?logout=true\">Logout " . $_SESSION['username'] . " <span class=\"glyphicon glyphicon-user\"/></a></li>\n";
    } else {
        echo "                              <li>\n<a href=\"login.php\">Login <span class=\"glyphicon glyphicon-user\"/></a></li>\n";
    }
    //echo "                      </ul>\n";
    echo "                  </li\n";
    echo "              </ul>\n";
    echo "          </div>\n";
    echo "          <!-- /.navbar-collapse -->\n";
    echo "      </div>\n";
    echo "      <!-- /.container -->\n";
    echo "  </nav>";

}
/*
Print the botton tiny bit

*/
function printFooter()
{
	$parameters = getParameters();
    echo "<!-- Footer -->\n";
    echo "        <footer>\n";
    echo "<hr>";
    echo "            <div class=\"row\">\n";
    echo "                <div class=\"col-lg-12\">\n";
    echo "                    <p>Copyright © " . $parameters['systemname']->value  . " " . date("Y") ." " . $parameters['systemversion']->value  . "</p>\n";
    echo "                </div>\n";
    echo "            </div>\n";
    echo "        </footer>";
}