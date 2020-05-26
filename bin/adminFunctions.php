<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Classes/PHPExcel/IOFactory.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Classes/PHPExcel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/BlogInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Borrow.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/user.php';
/*
output a dropzone form for the book and libraryID in question.
The library id will be used to determine if the library trying to update the image has rights to do so.
*/
function printImageUpdateForm($book, $libraryID)
{
    echo "<form action=\"BookUpdateImage.php\" class=\"dropzone\">";
    echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
	if (file_exists($book->image)) {
		echo "                    <img class=\"img-responsive img-hover\" src='" . $book->image . "' alt=\"\">\n";
		} else {
			echo "                    <img class=\"img-responsive img-hover\" src=\"images\books\default.png\" alt=\"\">\n";
		}
    echo "<input hidden='true' type='text' name='id' value='" . $book->item_id . "'/>";
    echo "<input hidden='true' type='text' name='libraryID' value='" . $book->createdByLibraryID . "'/>";
    //echo "<input type=\"file\" name=\"file\" />";
    echo "</form>";
	echo "<form action=\"BookDeleteImage.php\" method=\"post\">";
	echo "<input hidden='true' type='text' name='id' value='" . $book->item_id . "'/>";
	echo "<input hidden='true' type='text' name='library_id' value='" . $book->createdByLibraryID . "'/>";
	echo "<button class=\"btn btn-link\" role=\"link\" type=\"submit\" value=\"submit\">Delete Image</button></form>";
}
/*
print the book div in a dopzone div that will allow Library 0 to update it. 
*/
function printBookUpdateImageDiv($item)
{
	$parameters = getParameters();
    echo "            <div class=\"" . ($parameters['NumberBooksPerRow']->value == 4? "col-md-3" : "col-md-2") . " img-portfolio\">\n";
    echo "                <a href=\"BookMain.php?id=" . $item->item_id . "\"></a>\n";
    if (file_exists($item->image)) {
        echo "<form action=\"BookUpdateImage.php\" class=\"dropzone\">";
        echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
        echo "<input hidden='true' type='text' name='id' value='" . $item->item_id . "'/>";
        echo "<input hidden='true' type='text' name='libraryID' value='" . $item->library_id . "'/>";
        echo "<img class=\"img-responsive img-hover\" src='" . $item->image . "' title=\"" . $item->title . "\">\n";
        echo "</form>";
    } else {
        echo "<form action=\"BookUpdateImage.php\" class=\"dropzone\">";
        echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
        echo "<input hidden='true' type='text' name='id' value='" . $item->item_id . "'/>";
        echo "<input hidden='true' type='text' name='libraryID' value='" . $item->library_id . "'/>";
        echo "<img class=\"img-responsive img-hover\" src=\"images/books/default.png\" title=\"" . $item->title . "\">\n";
        echo "</form>";
    }
    echo "                <div class='bookDetails'>";
    echo "                <div><b>Title: " . $item->title . "</b></div>";
    echo "                </div>";
    echo "            </div>\n";
}
/*
Print the button on the inventory page that allows lbrary 0 to reload the page for image updates.
*/
function printInventoryImageUploadForm($libraryID,$searching,$searchTerm,$startIndex)
{
	if($searching)
	{
		echo "<form action=\"libraryInventory.php?q=true&term=" . $searchTerm. "\" method=\"post\">";
	}
	else{
		echo "<form action=\"libraryInventory.php?page=" . $startIndex ."\" method=\"post\">";
	}
    echo "<input  hidden='true' type='text' name='libraryID' value='" . $libraryID . "'>";
    echo "<input  hidden='true' type='text' name='uploadImages' value='true'>";
    echo "<button class='btn btn-warning' type='submit' value='Save'>Upload Images</button>\t";
    echo "</form>";
}
/*
Print the button that allows library 0 to turn off image upload mode on inventory page.
*/
function printDoneUploadingImagesForm($libraryID,$searching,$searchTerm,$startIndex)
{
	if($searching)
	{
		echo printWarnButton("Done uploading", "libraryInventory.php?id=" . $libraryID . "&q=true&term=". $searchTerm , false);
	}
	else{
		echo printWarnButton("Done uploading", "libraryInventory.php?id=" . $libraryID . "&page=" . $startIndex . "", false);
	}
}
/*
Print a form that allows authorized libraries to upload a new image for a book on bookmain
*/
function printLibraryImageUpdateForm($path, $libraryID)
{
    echo "<form action=\"LibraryUpdateImage.php\" class=\"dropzone\">";
    echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
    echo "<input hidden='true' type='text' name='path' value='" . $path . "'/>";
    echo "<input hidden='true' type='text' name='libraryID' value='" . $libraryID . "'/>";
    if (file_exists($path)) {
        echo "                 <img class=\"img-responsive img-hover\" src='" . $path . "' title=\"" . $path . "\">\n";
    } else {
        //echo "                    <img class=\"img-responsive img-hover\" src=\"images/books/default.png\" title=\"" . $path . "\">\n";
    }
    echo "</form>";
}
function printPressImageUpdateForm($path)
{
    echo "<form action=\"AboutUpdateImage.php\" class=\"dropzone\">";
    echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
    echo "<input hidden='true' type='text' name='path' value='" . $path . "'/>";
    if (file_exists($path)) {
        echo "                 <img class=\"img-responsive img-hover\" src='" . $path . "' title=\"" . $path . "\">\n";
    } else {
        //echo "                    <img class=\"img-responsive img-hover\" src=\"images/books/default.png\" title=\"" . $path . "\">\n";
    }
    echo "</form>";
}
/*
Print the form used to delete images in a library image editor page
*/
function printLibraryImageDeleteForm($libraryID)
{
	echo "<form action=\"LibraryDeleteImages.php\" method=\"post\" onsubmit='return confirm(\"Do you really want to delete all the images for this library?\");'>";
	echo "<input hidden='true' type='text' name='libraryID' value='" . $libraryID . "'/>";
	echo "<button class='btn btn-danger' type='submit' value='Save'>Delete all Images <span class=\"glyphicon glyphicon-trash\"></span></button>\t";
    echo "</form>";
}
function printAboutImageDeleteForm()
{
	echo "<form action=\"AboutDeleteImages.php\" method=\"post\" onsubmit='return confirm(\"Do you really want to delete all the images on this page?\");'>";
	echo "<button class='btn btn-danger' type='submit' value='Save'>Delete all Images <span class=\"glyphicon glyphicon-trash\"></span></button>\t";
    echo "</form>";
}
function deleteLibraryImages($libraryID)
{
	recursiveRemoveDirectory("images/libraries/" . $libraryID . "/");
}
function deleteAboutImages()
{
	recursiveRemoveDirectory("images/press/");
}
/*
Print the form that allows me to update or create a book
*/
function printBookForm($book, $myLibraries, $libraryID)
{
    //Title
    echo "          <div class=\"col-md-7\">\n";
    echo "                <h1>" . ($book != null ? $book->title : '') . "</h1>\n";
    if (!$book == null) {
        echo "                <h3>Edit Book Details</h3>\n";
    } else {
        echo "                <h3>Enter Book Details</h3>\n";
    }
    echo "                <form name=\"bookCreateedit\" id=\"bookedit\"   action='BookSave.php' method='post' enctype=\"multipart/form-data\" novalidate>";
    if ($book != null && $book->item_id != null) {
        echo "                <input hidden='true' type='text' name='id' value='" . $book->item_id . "'/>";
    }else
	{
		echo "                <input hidden='true' type='text' name='id' value='null'/>";
	}
	echo "					<input hidden='true' type='text' name='library_id' value='" . ($book != null ? $book->createdByLibraryID : $libraryID) . "'/>";
    echo "                <input hidden='true' type='text' name='update' value='true'/>";
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Title:</label>\n";
    echo "          <input class=\"form-control\" name='title' value=\"" . ($book != null ? $book->title : '') . "\" 
                        required data-validation-required-message=\"Please enter the title.\"  maxlength=\"1000\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    //Author
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Author:</label>\n";
    echo "          <input class=\"form-control\"  name='author' value=\"" . ($book != null ? $book->author : '') . "\" 
                        required data-validation-required-message=\"Please enter the author.\" maxlength=\"1000\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    //Publisher
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Publisher:</label>\n";
    echo "          <input class=\"form-control\" name='publisher' value=\"" . ($book != null ? $book->publisher : '') . "\" 
                        required data-validation-required-message=\"Please enter the publisher.\" maxlength=\"1000\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    //Publish Year
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Published Year:</label>\n";
    echo "          <input class=\"form-control\"  name='publishYear' value=\"" . ($book != null ? $book->publishYear : '') . "\" 
                        required data-validation-required-message=\"Please enter the publishYear.\" maxlength=\"10\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";

    //Pages
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Pages:</label>\n";
    echo "          <input class=\"form-control\" name='pages' type=\"number\" value=\"" . ($book != null ? $book->numPages : '') . "\" 
                        required data-validation-required-message=\"Please enter the pages.\" min=\"0\" data-validation-min-message=\"Must have at least 0 pages\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer pages.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";

    //DonatedBy
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Donated By:</label>\n";
    echo "          <input class=\"form-control\" name='donatedBy' value=\"" . ($book != null ? $book->donatedBy : '') . "\" 
                        required data-validation-required-message=\"Please enter the Donor.\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";

    //Price
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Price:</label>\n";
    echo "          <input class=\"form-control\"  name='price' value=\"" . ($book != null ? $book->price : '') . "\" 
                        required data-validation-required-message=\"Please enter the price.\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";

    //callNumber
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Call Number:</label>\n";
    echo "          <input class=\"form-control\" name='callNumber' value=\"" . ($book != null ? $book->callNumber : '') . "\" 
                        required data-validation-required-message=\"Please enter the call number.\" maxlength=\"50\" data-validation-maxlength-message=\"Enter fewer characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    

    if ($book == null) {
		//echo "LibID : " . $libraryID;
        echo "        <div class=\"control-group form-group\">\n";
        echo "          <div class=\"controls\">\n";
        echo "              <label>Image:</label>\n";
        echo "                <input type=\"file\" name=\"fileToUpload\"  id=\"fileToUpload\" >";
        echo "          <p class=\"help-block\"></p><br/><br/>\n";
        echo "      </div>\n";
        echo "  </div>";

        echo " <div id=\"success\"></div>";
    }

    echo "                <button class='btn btn-primary' type='submit' value='Save'>Save</button>\t";

    if (!$book == null) {
        echo printNormalButton("Cancel", ("BookMain.php?id=" . $book->item_id), false);
    } else {
        echo printNormalButton("Cancel", ("LibraryMain.php?id=" . $libraryID), false);
    }
    echo "                </form>";


    if (!$book == null) {
        echo "                <form action='BookSave.php' method='post' onsubmit='return confirm(\"Do you really want to delete " . $book->title . "?\");'>";
        echo "                <input hidden='true' type='text' name='id' value=\"" . $book->item_id . "\">";
        echo "                <input hidden='true' type='text' name='library_id' value=\"" . $book->createdByLibraryID . "\">";
        echo "                <input hidden='true' type='text' name='delete' value='true'><br/>";
        echo "                <button class='btn btn-danger' type='submit'>Delete <span class=\"glyphicon glyphicon-trash\"</span></button>";
        echo "                </form>";
    }


    echo "                </div>";
    echo "            </div>";
}
/* 
deprecated
*/
function printLibaryAssignmentForm($bookID, $libraries)
{
    echo "                <form action='BookBorrow.php' method='post'>";
    echo "                <input hidden='true' type='text' name='bookid' value=\"" . $bookID . "\">";
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Lend to another library:</label>\n";
    echo "            <select class=\"form-control\" id=\"library_id\" name=\"libraryid\" required data-validation-required-message=\"Please select a library.\">";

    foreach ($libraries as $library) {
        if ($library->id != 0) {
            echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
        }
    }
    echo "            </select>";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    echo "                <input class='btn btn-warning' type='submit' value='Lend'>";
    echo "                </form>";


}
/*
Print the form and button that allows the kickoff of a library export
*/
function printLibraryExportForm($libID, $libName, $disabled)
{
    echo "                <form action='LibraryExport.php' method='post' onsubmit='return confirm(\"Do you really want to export: " . $libName . "?\");'>";
    echo "                <input hidden='true' type='text' name='id' value=\"" . $libID . "\">";
    echo "                <input hidden='true' type='text' name='export' value=\"true\">";
    echo "                <input hidden='true' type='text' name='filename' value=\"" . $libName . "-\">";
    if ($disabled) {
        echo "                <input disabled='true' class='btn btn-warning' type='submit' value='Export Library'>";
    } else {
        echo "                <input class='btn btn-warning' type='submit' value='Export Library'>";
    }
    echo "                </form>";

}
/*

Print the button that send me to the library import page

*/
function printLibraryImportButton($importer, $importing)
{
	echo "                <form action='importer.php' method='post'>";
    echo "                <input hidden='true' type='text' name='importingLibrary' value=\"" . $importer . "\">";
	echo "                <input hidden='true' type='text' name='importingIntoLibrary' value=\"" . $importing . "\">";
	echo "                <input class='btn btn-warning' type='submit' value='Import Books'>";
    echo "                </form>";
}
/*
print the for that allows me to update the library details information for a library.

*/
function printLibraryUpdateForm($library, $myVillages)
{

    echo "          <div class=\"col-md-12\">\n";
    echo "                <h1>" . ($library != null ? truncateString($library->name , 55) : '') . "</h1>\n";
    if (!$library == null) {
        echo "                <h3>Edit Library Details</h3>\n";
    } else {
        echo "                <h3>Enter Library Details</h3>\n";
    }
    echo "       <form name=\"libraryCreateedit\" id=\"libraryedit\"   action='LibrarySave.php' method='post' enctype=\"multipart/form-data\" novalidate>";
    if (!$library == null) {
        echo "   <input hidden='true' type='text' name='id' value='" . $library->id . "'/>";
    } else {
        echo "   <input hidden='true' type='text' name='id' value='null'/>";
    }
    echo "  <input hidden='true' type='text' name='update' value='true'/>";
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Name:</label>\n";
    echo "          <input class=\"form-control\" name='libraryName' value=\"" . ($library != null ? $library->name : '') . "\" 
                        required data-validation-required-message=\"Please enter the Name.\" aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Description:</label>\n";
    echo "          <textArea rows=\"10\" cols=\"100\" class=\"form-control\" name='libraryDescription' 
                        required data-validation-required-message=\"Please enter the description.\" aria-invalid=\"false\" maxlength=\"4000\" data-validation-maxlength-message=\"Enter fewer than 4000 characters.\"  >" . ($library != null ? $library->description : '') . "</textArea>";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>District:</label>\n";
    echo "          <input class=\"form-control\" name='districtName' value=\"" . ($library != null ? $library->districtName : '') . "\" 
                          aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Mandal:</label>\n";
    echo "          <input class=\"form-control\" name='mandalName' value=\"" . ($library != null ? $library->mandalName : '') . "\" 
                          aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
   echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Village:</label>\n";
    echo "          <input class=\"form-control\" name='villageName' value=\"" . ($library != null ? $library->villageName : '') . "\" 
                          aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    echo "                <button class='btn btn-primary' type='submit' value='Save'>Save</button>\t";
    if (!$library == null) {
        echo printNormalButton("Cancel", ("LibraryMain.php?id=" . $library->id), false);
    } else {
        echo printNormalButton("Cancel", ("LibraryList.php"), false);
    }
    echo "                </form>";
    if (!$library == null && $library->id != 0) {
        echo "                <form action='LibrarySave.php' method='post' onsubmit='return confirm(\"Do you really want to delete " . $library->name . "?\");'>";
        echo "                <input hidden='true' type='text' name='id' value=\"" . $library->id . "\">";
        echo "                <input hidden='true' type='text' name='delete' value='true'><br/>";
        echo "                <button class='btn btn-danger' type='submit'>Delete <span class=\"glyphicon glyphicon-trash\"></span></button>";
        echo "                </form>";
    }

}
/*
Print the form that allows libraries to choose the import parameters and file for book import.
*/
function printImportConfirmationForm($myLibraries, $importingLibrary, $importingIntoLibrary)
{
	$parameters = getParameters();
    echo "                <div class='warning'> Choosing to delete existing inventory will empty your library before importing new books.<br/><br/>";
	echo "					<a href=\"library books list sample.xlsx\">Sample import file <span class=\"glyphicon glyphicon-download\"/></a><br/><br/>";
    echo "                <form enctype=\"multipart/form-data\" action='importer.php' method='post'>";
    echo "                <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"8000000\" />";
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
        if ($importingLibrary == 0 && !$parameters['LibrarySingleMode']->value) {
            echo "<select class=\"form-control\" id=\"importingIntoLibrary\" name=\"importingIntoLibrary\" required data-validation-required-message=\"Please select a library.\">";

            foreach ($myLibraries as $library) {
                    echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
                }
            echo "            </select>";
            echo "          <p class=\"help-block\"></p>\n";    	
		}
		else
		{
			if($parameters['LibrarySingleMode']->value)
			{
				echo "                <input hidden='true' type='text' name='importingIntoLibrary' value='0'>";
			}
			else
			{
				echo "                <input hidden='true' type='text' name='importingIntoLibrary' value=" . $importingIntoLibrary . ">";
			}
		}
}
	echo "                <input hidden='true' type='text' name='importingLibrary' value=" . $importingLibrary . ">";
    echo "                <input hidden='true' type='text' name='CONFIRM' value='true'>";
    echo "                <input type='checkbox' name='delete_existing' checked='checked'>  Delete existing inventory? <a href=\"#\" data-toggle=\"popover\" title=\"Delete Inventory\" data-content=\"Deleting existing inventory clears all books and borrowed books in all libraries for SUPER ADMIN, but for non SUPER ADMINs, it clears only your library's borrowed books.\"><span class=\"glyphicon glyphicon-question-sign\"> </span></a></input><br/><br/>";
    echo "                <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">";
    echo "                <br/><input class='btn btn-warning' type='submit' value='IMPORT'>";
    echo "                </form></div>";
}
/*

Login form

*/
function printAdminLoginForm($success, $message)
{
    if (!$success) {
        echo "<div class=\"error\" control-group form-group>";
        echo "<div>" . $message . "</div><br/>\n";
        echo "<form action=\"login.php\" enctype=\"application/x-www-form-urlencoded\" method=\"post\" control-group form-group>\n";
        echo "\n";
        echo "<div>\n";
        echo "<label for=\"webusername\">Username:</label><br />\n";
        echo "<input id=\"webusername\" name=\"webusername\" size=\"25\" type=\"text\" class=\"form-control\" required /><br/>\n";
        echo "</div>\n";
        echo "\n";
        echo "<div>\n";
        echo "<label for=\"pass\">Password:</label><br />\n";
        echo "<input id=\"pass\" name=\"pass\" size=\"25\" type=\"password\" class=\"form-control\"required /><br/><br/>\n";
        echo "</div>\n";
        echo "<div>\n";
        echo "<button class=\"btn btn-danger\" name=\"submit\" type=\"submit\">Login <span class=\"glyphicon glyphicon-user\"/></button><br/>\n";
        echo "</div>\n";
        echo "</form>";
        echo "</div>\n";
    } else {
        echo "<div class=\"success\">";
        echo "<div>" . $message . "</div><br/>\n";
        echo printSuccessButton("Libraries", "LibraryList.php", false);
        echo "\t";
        echo printWarnButton("Logout", "login.php?logout=true", false);
        echo "</div>\n";
    }

}
function printLogoutUsersForm()
{
	
	echo "                <form action='UserSave.php' method='post'>";
    echo "                <input hidden='true' type='text' name='logoutAllUsers' value='true'>";
	echo "                <input class='btn btn-warning' type='submit' value='Logout All Users'>";
    echo "                </form>";
	
}
function printUpdateUsernameForm($user,$myLibraries,$libraryIDs)
{
	$parameters = getParameters();
	echo "                <form action='UserSave.php' method='post' novalidate>";
    echo "                <input hidden='true' type='text' name='userID' value='" . $user->id . "'>";
	echo "                <input hidden='true' type='text' name='updateUser'>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Username:</label>\n";
    echo "          <input class=\"form-control\" name='userName' value=\"" . $user->name . "\" 
                        required data-validation-required-message=\"Please enter the username.\" aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	if($parameters['AllowMultipleAdmins']->value)
	{
		if(!$parameters['LibrarySingleMode']->value)
		{
			echo "<select class=\"form-control\" id=\"libID\" name=\"libID\" required data-validation-required-message=\"Please select a library.\">";

					foreach ($myLibraries as $library) 
					{
						if($parameters['AllowMultipleAdmins']->value)
						{
							if($user->libraryID == $library->id)
								{
									echo "<option selected=\"true\" value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
								else
								{
									echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
						}
						else{
							if($library->id != 0)
							{
								if($user->libraryID == $library->id)
								{
									echo "<option selected=\"true\" value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
								else
								{
									echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
							}
						}
					}
					if(!in_array($user->libraryID, $libraryIDs))
						{
							echo "<option selected=\"true\" value=\"-1\"></option>";
						}
					echo "            </select>";
					echo "          <p class=\"help-block\"></p>\n";
		}
		else
		{
			echo "<input hidden='true' type='text' name='libID' value='0'>";
		}
	}
	else
	{
	if($user->libraryID != 0 && !$parameters['LibrarySingleMode']->value)
		{
			echo "<select class=\"form-control\" id=\"libID\" name=\"libID\" required data-validation-required-message=\"Please select a library.\">";

					foreach ($myLibraries as $library) 
					{
						if($parameters['AllowMultipleAdmins']->value)
						{
							if($user->libraryID == $library->id)
								{
									echo "<option selected=\"true\" value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
								else
								{
									echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
						}
						else{
							if($library->id != 0)
							{
								if($user->libraryID == $library->id)
								{
									echo "<option selected=\"true\" value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
								else
								{
									echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
								}
							}
						}
					}
					if(!in_array($user->libraryID, $libraryIDs))
						{
							echo "<option selected=\"true\" value=\"-1\"></option>";
						}
					echo "            </select>";
					echo "          <p class=\"help-block\"></p>\n";
		}
		else{
			echo "                <input hidden='true' type='text' name='libID' value='0'>";
		}
	}
	echo "                <input class='btn btn-warning' type='submit' value='Update " . $user->name . "'>";
    echo "                </form>";
	echo "<br/>";
	if($parameters['AllowMultipleAdmins']->value)
	{
		printDeleteUserForm($user);
	}
	else{
		if($user->libraryID != 0)
					{
						printDeleteUserForm($user);
					}
	}
	
}
function printUserCreationForm($myLibraries)
{
	$parameters = getParameters();
	echo "                <form action='UserSave.php' id=\"userCreate\"  method='post' novalidate>";
	echo "                <input hidden='true' type='text' name='createUser'>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Username:</label>\n";
    echo "          <input class=\"form-control\" name='userName' 
                        required data-validation-required-message=\"Please enter the username.\" aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Password:</label>\n";
    echo "          <input type=\"password\" class=\"form-control\" name='p' 
                        required data-validation-required-message=\"Please enter the password.\" aria-invalid=\"false\" maxlength=\"500\" minlength=\"8\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" data-validation-minlength-message=\"Enter more than 8 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	if(!$parameters['LibrarySingleMode']->value)
		{
		echo "    <div class=\"control-group form-group\">\n";
		echo "      <div class=\"controls\">\n";

		echo "          <label>Library:</label>\n";
			echo "<select class=\"form-control\" id=\"libID\" name=\"libID\" required data-validation-required-message=\"Please select a library.\">";

		foreach ($myLibraries as $library) {
			if($parameters['AllowMultipleAdmins']->value)
			{
				echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
			}
			else
			{
				if($library->id != 0)
				{
					echo "<option value=\"" . $library->id . "\">" . $library->name . "</option>";
				}
			}
		}
		echo "            </select>";
		echo "          <p class=\"help-block\"></p>\n";
		echo "      </div>\n";
		echo "  </div>";
		
		}
	else
	{
		echo "                <input hidden='true' type='text' name='libID' value='0'>";
	}
	echo "<div>";
	echo "                <input class='btn btn-warning' type='submit' value='Create User'>";
    echo "                </form>";
	echo printNormalButton("Cancel","Admin.php",false);
	echo "  </div>";
	
}
function printUpdatePasswordForm($user)
{
	echo "                <form action='UserSave.php' method='post'>";
    echo "                <input hidden='true' type='text' name='userID' value='" . $user->id . "'>";
	echo "                <input hidden='true' type='text' name='userName' value='" . $user->name . "'>";
	echo "                <input hidden='true' type='text' name='updatePassword'>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Password:</label>\n";
    echo "          <input type=\"password\" class=\"form-control\" name='p' 
                        required data-validation-required-message=\"Please enter the password.\" aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" 
						minlength=\"8\" data-validation-minlength-message=\"Enter at least 8 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "                <input class='btn btn-warning' type='submit' value='Update " . $user->name . " password'>";
    echo "                </form>";
	
}
function printDeleteUserForm($user)
{
	echo "                <form action='UserSave.php' method='post' onsubmit='return confirm(\"Do you really want to delete " . $user->name . "?\");'>";
    echo "                <input hidden='true' type='text' name='userID' value='" . $user->id . "'>";
	//userLibID
	echo "                <input hidden='true' type='text' name='userLibID' value='" . $user->libraryID . "'>";
	echo "                <input hidden='true' type='text' name='deleteUser'>";
	
	echo "                <button class='btn btn-danger' type='submit' value='Delete " . $user->name . "' >Delete " . $user->name . " <span class=\"glyphicon glyphicon-trash\"></span></button>";
	
    echo "                </form>";
	
}
function printBlogEntryForm($entry)
{
	echo "          <div class=\"col-md-12\">\n";
    echo "                <h1>" . ($entry != null ? $entry->title : '') . "</h1>\n";
    if (!$entry == null) {
        echo "                <h3>Edit Blog Post</h3>\n";
    } else {
        echo "                <h3>Enter Details</h3>\n";
    }
    echo "       <form name=\"blogCreateEdit\" id=\"blogCreateEdit\"   action='BlogSave.php' method='post' enctype=\"multipart/form-data\" novalidate>";
    if (!$entry == null) {
        echo "   <input hidden='true' type='text' name='blogid' value='" . $entry->id . "'/>";
    }
	echo "   <input hidden='true' type='text' name='userID' value='" . $_SESSION['userID'] . "'/>";
	if (!$entry == null) {
        echo "   <input hidden='true' type='text' name='updateBlog' value='true'/>";
    }
	else
	{
		echo "   <input hidden='true' type='text' name='createBlog' value='true'/>";
	}
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Title:</label>\n";
    echo "          <input class=\"form-control\" name='title' value=\"" . ($entry != null ? $entry->title : '') . "\" 
                        required data-validation-required-message=\"Please enter the title.\" aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
    echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Content Body (optional):</label>\n";
    echo "          <textArea rows=\"10\" cols=\"100\" class=\"form-control\" name=\"content\" 
                          aria-invalid=\"false\" maxlength=\"10000\" data-validation-maxlength-message=\"Enter fewer than 10000 characters.\"  >" . ($entry != null ? $entry->content : '') . "</textArea>";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
	echo "          <label>Video Embed URL (optional): </label> <a href=\"#\" data-toggle=\"popover\" title=\"Embed Links\" data-content=\"Embed links can be acquired from the youtube video share link. Look for the section labeled 'Embed'.\n Embed links look like this: 'www.youtube.com/embed/S0m3ToK3n'\"><span class=\"glyphicon glyphicon-question-sign\"> </span></a>\n";
    echo "          <input class=\"form-control\" name='video' value=\"" . ($entry != null ? $entry->video : '') . "\" 
                        aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" >";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
	 echo "  </div>";
	if ($entry == null) {
        echo "        <div class=\"control-group form-group\">\n";
        echo "          <div class=\"controls\">\n";
        echo "              <label>Image (optional):</label>\n";
        echo "                <input type=\"file\" name=\"fileToUpload\"  id=\"fileToUpload\" >";
        echo "          <p class=\"help-block\"></p><br/><br/>\n";
        echo "      </div>\n";
        echo "  </div>";
    }
    echo "                <button class='btn btn-primary' type='submit' value='Save'>Save</button>\t";
    echo printNormalButton("Cancel", "blog.php?id=numEntries=20", false);
    echo "                </form>";
    if (!$entry == null) {
        echo "                <form action='BlogSave.php' method='post' onsubmit='return confirm(\"Do you really want to delete " . $entry->title . "?\");'>";
        echo "                <input hidden='true' type='text' name='blogid' value=\"" . $entry->id . "\">";
        echo "                <input hidden='true' type='text' name='deleteBlog' value='true'><br/>";
        echo "                <button class='btn btn-danger' type='submit'>Delete <span class=\"glyphicon glyphicon-trash\"></span></button>";
        echo "                </form>";
    }
	if (!$entry == null) {
		printBlogImageUpdateForm($entry);
	}
}
function printBlogEditForm($blog)
{
	echo "      <form action='BlogEdit.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='editBlog' value='true'/>";
	echo "   	<input hidden='true' type='text' name='id' value='" . $blog->id . "'/>";
	echo "      <button class='btn btn-warning' type='submit'>Edit Blog Post</button>";
    echo "       </form>";
}
function printBlogImageUpdateForm($blog)
{
	echo "<br/>";
	echo "          <div class=\"row\">";
	echo "          <div class=\"col-md-4\">\n";
    echo "<form action=\"BlogUpdateImage.php\" class=\"dropzone\">";
    echo "<div class=\"dz-message\" data-dz-message><span>Drop new image here.\n Or click here to select.</span></div>";
	if (file_exists($blog->image)) {
		echo "                    <img class=\"img-responsive img-hover\" src='" . $blog->image . "' alt=\"\">\n";
	}
    echo "<input hidden='true' type='text' name='blog_id' value='" . $blog->id . "'/>";
    echo "</form>";
	echo "<form action=\"BlogDeleteImage.php\" method=\"post\">";
	echo "<input hidden='true' type='text' name='blog_id' value='" . $blog->id . "'/>";
	echo "<button class=\"btn btn-link\" role=\"link\" type=\"submit\" value=\"submit\">Delete Image</button></form>";
	echo "</div>";
	echo "</div>";
}
function printAbouttextForm($content)
{
	echo "      <form action='AboutUpdate.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='editAboutText' value='true'/>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>About Text Body:</label>\n";
    echo "          <textArea rows=\"10\" cols=\"100\" class=\"form-control\" name=\"content\" 
                          required aria-invalid=\"false\" maxlength=\"10000\" data-validation-maxlength-message=\"Enter fewer than 10000 characters.\"  >" . $content . "</textArea>";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	echo "      <button class='btn btn-warning' type='submit'>Update Text</button>";
    echo "       </form>";
}
//printBlurbFormForm
function printBlurbForm($name,$content,$blurbName)
{
	echo "      <form action='BlurbUpdate.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='" . $blurbName . "' value='true'/>";
	if($name != null)
	{
		echo "    <div class=\"control-group form-group\">\n";
		echo "      <div class=\"controls\">\n";
		echo "          <label>Name:</label>\n";
		echo "          <input  class=\"form-control\" name=\"name\" 
							  required aria-invalid=\"false\" maxlength=\"500\" data-validation-maxlength-message=\"Enter fewer than 500 characters.\" value=\"" . $name . "\" />";
		echo "          <p class=\"help-block\"></p>\n";
		echo "      </div>\n";
		echo "      </div>\n";
	}
    echo "      <div class=\"controls\">\n";
    echo "          <label>Content Body:</label>\n";
    echo "          <textArea rows=\"10\" cols=\"100\" class=\"form-control\" name=\"content\" 
                          required aria-invalid=\"false\" maxlength=\"10000\" data-validation-maxlength-message=\"Enter fewer than 10000 characters.\"  >" . $content . "</textArea>";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
	echo "      <button class='btn btn-warning' type='submit'>Update Text</button>";
    echo "       </form>";
}
function printSystemNameForm($content)
{
	echo "      <form action='BlurbUpdate.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='editSystemName' value='true'/>";
	echo "    <div class=\"control-group form-group\">\n";
	echo "      <div class=\"controls\">\n";
	echo "          <label>System Name:</label>\n";
	echo "          <input  class=\"form-control\" name=\"content\" 
							  required aria-invalid=\"false\" maxlength=\"60\" data-validation-maxlength-message=\"Enter fewer than 60 characters.\" value=\"" . $content . "\" />";
	echo "          <p class=\"help-block\"></p>\n";
	echo "      </div>\n";
	echo "  </div>";
	echo "      <button class='btn btn-warning' type='submit'>Update System Name</button>";
    echo "       </form>";
}
function printFacebookForm($content)
{
	echo "      <form action='BlurbUpdate.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='editFacebookLink' value='true'/>";
	echo "    <div class=\"control-group form-group\">\n";
	echo "      <div class=\"controls\">\n";
	echo "          <label>Facebook Page Link:</label>\n";
	echo "          <input  class=\"form-control\" name=\"content\" 
							   aria-invalid=\"false\" maxlength=\"300\" data-validation-maxlength-message=\"Enter fewer than 300 characters.\" value='" . $content . "' />";
	echo "          <p class=\"help-block\"></p>\n";
	echo "      </div>\n";
	echo "  </div>";
	echo "      <button class='btn btn-warning' type='submit'>Update Facebook Page Link</button>";
    echo "       </form>";
}
//printPhonesForm
function printPhonesForm($phone1,$phone2)
{
	echo "      <form action='BlurbUpdate.php' method='post' >";
	echo "   	<input hidden='true' type='text' name='editPhones' value='true'/>";
	echo "    <div class=\"control-group form-group\">\n";
	echo "      <div class=\"controls\">\n";
	echo "          <label>Phone 1:</label>\n";
	echo "          <input  class=\"form-control\" name=\"phone1\" 
							  required aria-invalid=\"false\" maxlength=\"60\" data-validation-maxlength-message=\"Enter fewer than 60 characters.\" value=\"" . $phone1 . "\" />";
	echo "          <p class=\"help-block\"></p>\n";
	echo "      </div>\n";
	echo "      <div class=\"controls\">\n";
	echo "          <label>Phone 2:</label>\n";
	echo "          <input  class=\"form-control\" name=\"phone2\" 
							  required aria-invalid=\"false\" maxlength=\"60\" data-validation-maxlength-message=\"Enter fewer than 60 characters.\" value=\"" . $phone2 . "\" />";
	echo "          <p class=\"help-block\"></p>\n";
	echo "      </div>\n";
	echo "      <button class='btn btn-warning' type='submit'>Update Phones</button>";
	 echo "  </div>";
    echo "       </form>";
}
function printLogoUpdateForm()
{
	echo "<br/>";
	echo "<div class=\"row\">";
	echo " <div class=\"col-md-4\">\n";
    echo "<form action=\"UpdateLogo.php\" class=\"dropzone\">";
    echo "<div class=\"dz-message\" data-dz-message><span>Drop new logo here. <br/>(Must be .jpg)\n Or click here to select.</span></div>";
	if (file_exists("images/logo.jpg")) {
		echo "<img class=\"img-responsive img-hover\" src=\"images/logo.jpg\" alt=\"\">\n";
	}
    echo "</form>";
	echo "</div>";
	echo "</div>";
}
function printLibraryConfigForm($singleModeState, 
								$allowMultipleAdmins, 
								$hideLibraryExport, 
								$loginExpirationMinutes, 
								$blogEntriesToLoad, 
								$blogEntriesToAdd,
								$numberBooksPerPage,
								$numberBooksPerRow,
								$fromEmail,
								$contactEmail
							   )
{
	
	echo "<br/>";
	echo "<div class=\"row\">";
	echo " <div class=\"col-md-4\">\n";
    echo "<form action=\"UpdateLibraryConfigs.php\" method=\"post\">";
	echo "    <div class=\"control-group form-group\">\n";
	echo "      <div class=\"controls\">\n";
    echo "<input name=\"SingleLibraryMode\" type=\"checkbox\" " . ($singleModeState?  "checked" : '') . "> Run in Single-Library Mode</input>";
	echo "<br/>";
	echo "<input name=\"AllowMultipleAdmins\" type=\"checkbox\" " . ($allowMultipleAdmins?  "checked" : '') . "> Allow Multiple Super-Admins</input>";
	echo "<br/>";
	echo "<input name=\"HideLibraryExport\" type=\"checkbox\" " . ($hideLibraryExport?  "checked" : '') . "> Hide Library Export</input>";
	echo "<br/>";
	echo "</div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Login Expiration Minutes:</label>\n";
    echo "          <input class=\"form-control\" name='LoginExpirationminutes' type=\"number\" value=\"" . $loginExpirationMinutes .  "\" 
                        required data-validation-required-message=\"Please enter the Login Expiration Mintutes.\" min=\"5\" data-validation-min-message=\"Must be at least 5 minutes\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer minutes.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo "</div>";
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Number of blog entries to load:</label>\n";
    echo "          <input class=\"form-control\" name='BlogEntriesToLoad' type=\"number\" value=\"" . $blogEntriesToLoad .  "\" 
                        required data-validation-required-message=\"Please enter the number of entries to load.\" min=\"1\" data-validation-min-message=\"Must be at least 1 blog to load\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer blogs.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	

	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Number of blog entries to add (when more... is clicked):</label>\n";
    echo "          <input class=\"form-control\" name='BlogEntriesToAdd' type=\"number\" value=\"" . $blogEntriesToAdd .  "\" 
                        required data-validation-required-message=\"Please enter the number of blogs to add.\" min=\"1\" data-validation-min-message=\"Must be at least 1 blog added\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer blogs.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Number of books to show per page:</label>\n";
    echo "          <input class=\"form-control\" name='BooksPerPage' type=\"number\" value=\"" . $numberBooksPerPage .  "\" 
                        required data-validation-required-message=\"Please enter the number of books per page.\" min=\"1\" data-validation-min-message=\"Must be at least 1 book per page\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer books.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Number of books to show per row:</label>\n";
    echo "          <input class=\"form-control\" name='BooksPerRow' type=\"number\" value=\"" . $numberBooksPerRow .  "\" 
                        required data-validation-required-message=\"Please enter the number of books per row.\" min=\"1\" data-validation-min-message=\"Must be at least 1 book per row\" maxlength=\"11\" data-validation-maxlength-message=\"Enter fewer books.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>Contact Email:</label>\n";
    echo "          <input class=\"form-control\" name='ContactEmail' type=\"text\" value=\"" . $contactEmail .  "\" 
                        required data-validation-required-message=\"Please enter an email.\"  maxlength=\"200\" data-validation-maxlength-message=\"Enter fewer than 200 characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo "    <div class=\"control-group form-group\">\n";
    echo "      <div class=\"controls\">\n";
    echo "          <label>From Email:</label>\n";
    echo "          <input class=\"form-control\" name='FromEmail' type=\"text\" value=\"" . $fromEmail .  "\" 
                        required data-validation-required-message=\"Please enter the from email.\" maxlength=\"200\" data-validation-maxlength-message=\"Enter fewer than 200 characters.\" aria-invalid=\"false\">";
    echo "          <p class=\"help-block\"></p>\n";
    echo "      </div>\n";
    echo "  </div>";
	
	echo " <br/><br/><button class='btn btn-warning' type='submit'>Save Configuration</button>";
	 echo "  </div>";
    echo "</form>";
	echo "</div>";
	echo "</div>";
}

function updateConfigurations($SingleLibraryMode, 
	$AllowMultipleAdmins,
	$HideLibraryExport, 
    $LoginExpirationminutes, 
    $BlogEntriesToLoad,
    $BlogEntriesToAdd,
    $BooksPerPage,
    $BooksPerRow,
    $ContactEmail,
    $FromEmail)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL updateLibraryConfigs(
                \"" . $SingleLibraryMode . "\",
                \"" . $AllowMultipleAdmins . "\",
                \"" . $HideLibraryExport . "\",
                \"" . $LoginExpirationminutes . "\",
				\"" . $BlogEntriesToLoad . "\",
				\"" . $BlogEntriesToAdd . "\",
				\"" . $BooksPerPage . "\",
				\"" . $BooksPerRow . "\",
				\"" . $ContactEmail . "\",
				\"" . $FromEmail . "\"
                )";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
remove a directory and all enclosed files from the server
*/
function recursiveRemoveDirectory($directory)
{
    foreach (glob("{$directory}/*") as $file) {
        if (is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}
/*
DB insert for library
params are cleaned before they get here.
*/
function createLibrary($libraryName, $libraryDescription, $villageName, $mandalName, $districtName)
{

    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL InsertLibrary(
                \"" . $libraryName . "\",
                \"" . $libraryDescription . "\",
                \"" . $villageName . "\",
				\"" . $mandalName . "\",
				\"" . $districtName . "\"
                )";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $return = $row['@maxID'];
        $connection = null;
        $stmt = NULL;
        $db = NULL;
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/vunnava/images/libraries/' . $return . '/')) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . '/vunnava/images/libraries/' . $return . '/', 0777, true)) {
                die('Failed to create folders...');
            }
        }
        return $return;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
DB update for library
params are cleaned before they get here.
*/
function updateLibrary($libraryID, $libraryName, $libraryDescription, $villageName, $mandalName, $districtName)
{

    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL UpdateLibrary(
                \"" . $libraryID . "\",
                \"" . $libraryName . "\",
                \"" . $libraryDescription . "\",
                \"" . $villageName . "\",
				\"" . $mandalName . "\",
				\"" . $districtName . "\"
                )";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
DB delte for a library ID
param filtered before it gets here.
*/
function deleteLibrary($libraryID)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL DeleteLibrary(
                \"" . $libraryID . "\"
                )";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        recursiveRemoveDirectory($_SERVER['DOCUMENT_ROOT'] . '/vunnava/images/libraries/' . $libraryID . '/');
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
DB update for a book
Params are cleaned before they get here
*/
function updateBook($id, $callNumber, $title, $author, $publisher, $publishYear, $numPages, $donatedBy, $price, $library_id, $image)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL UpdateBook(
                \"" . $id . "\",
                \"" . $callNumber . "\",
                \"" . $title . "\",
                \"" . $author . "\",
                \"" . $publisher . "\",
                \"" . $publishYear . "\",
                \"" . $numPages . "\",
                \"" . $donatedBy . "\",    
                \"" . $price . "\",
                \"" . $library_id . "\",
                \"" . $image . "\"
                )";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
delete a book borrow record
Params are cleaned in this method.
*/
function returnBook($bookID, $libraryID)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $bookID = filter_var(($bookID), FILTER_SANITIZE_STRING);
        $libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL ReturnBook(\"" . $libraryID . "\",\"" . $bookID . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Insert a borrow record
Params are cleaned below

*/
function borrowBook($bookID, $libraryID)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $bookID = filter_var(($bookID), FILTER_SANITIZE_STRING);
        $libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL insertBorrow(\"" . $libraryID . "\",\"" . $bookID . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/* 
Update the path for a book image in the db
Params are cleaned here.
*/
function updateBookImage($bookID, $newPath)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $bookID = filter_var(($bookID), FILTER_SANITIZE_STRING);
        $newPath = filter_var(($newPath), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL UpdateBookImage(\"" . $bookID . "\",\"" . $newPath . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/* 
Delete the path for a book image
params are cleaned here
*/
function deleteBookImage($bookID)
{
	$book = getInventoryByItemId($bookID);
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $bookID = filter_var(($bookID), FILTER_SANITIZE_STRING);
		$null = NULL;
        $sqlExecSP = "CALL UpdateBookImage(\"" . $bookID . "\",\"" . $null . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
		if($book->image != 'images/books/default.png')
		{
			unlink($book->image);
		}
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
Get the user by the username and verify the entered password. 
If valid, return the relevant info.
*/
function getUser($webusername, $pass)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $webusername = filter_var(($webusername), FILTER_SANITIZE_STRING);
        $pass = filter_var(($pass), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL getUser(\"" . $webusername . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $user = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash = $row['password'];
            //echo "<br/>hello : " . $hash;
            if (password_verify($pass, $hash)) {
                $connection = null;
                $stmt = NULL;
                $db = NULL;
                $user = new user();
                $user->name = $row['username'];
                $user->id = $row['id'];
                $user->libraryID = $row['libraryID'];
                $user->token = getToken(16);
                //echo $user->token;
                $user->expires = updateUserToken($user->id, $user->token);
                return $user;
            }
        } else {
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function createUser($username, $p, $libraryID)
{
	//createUser
	
	 try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);
		$username = filter_var(($username), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL createUser(\"" . $libraryID . "\",
		\"" . $username . "\",
		\"" . $p . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
Logout a user by setting their timeout to now -1 and nullifying the token
*/
function logoutUser($id)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL logoutUser(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getSuperAdminCount()
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getSuperAdminCount()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $returnCount = $row['count'];
			$connection = null;
            $stmt = NULL;
            $db = NULL;
            return $returnCount;
        } else {
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return 0;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Update a user's token
(after a login)
*/
function updateUserToken($id, $token)
{
	$parameters = getParameters();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $token = filter_var(($token), FILTER_SANITIZE_STRING);
        $expiresTime = time() + (60 * $parameters['LoginExpirationMinutes']->value);
        $sqlExecSP = "CALL UpdateUserToken(\"" . $id . "\",
		\"" . $token . "\",
		\"" . $expiresTime . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $expiresTime;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Update a user's username and libID
*/
function updateUser($id, $userName, $libID)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $userName = filter_var(($userName), FILTER_SANITIZE_STRING);
        $libID = filter_var(($libID), FILTER_SANITIZE_STRING);
		
        $sqlExecSP = "CALL updateUsernameAndLib(\"" . $id . "\",
		\"" . $libID . "\",
		\"" . $userName . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $expiresTime;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Update a user's username and libID
*/
function deleteUser($id)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
		
        $sqlExecSP = "CALL deleteUser(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $expiresTime;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Update a user's password
*/
function updateUserPassword($id, $userName, $p)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $userName = filter_var(($userName), FILTER_SANITIZE_STRING);
		
        $sqlExecSP = "CALL updateUserPassword(\"" . $id . "\",
		\"" . $p . "\",
		\"" . $userName . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $expiresTime;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function logoutAllUsers()
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        
		
        $sqlExecSP = "CALL logoutAllUsers()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $expiresTime;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
Check if the user has access to the library ID they are trying to access
*/
function checkUserCreds($id, $token, $libID)
{
    $myLibID = getUserLibrary($id);
    //echo "my library = " . $myLibID;
    if (getUserToken($id) != $token) {
        //echo " - false 1 - token - " . $token;
        //echo " - db token: " . getUserToken($id);
        return false;
    } else if ($myLibID != $libID && $myLibID != 0) {
        //echo "Uh oh";
        //echo " - false 2 - libID - ";
        return false;
    } else {
        return true;
    }
}
/*
Get the expiration timestamp for a user ID
*/
function getUserExpiresTime($id)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL getUserExpiresTime(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $connection = null;
                $stmt = NULL;
                $db = NULL;
                $expiresTime = $row['expires'];
                return $expiresTime;
            }
        } else {
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return NULL;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
        return NULL;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }

}
/*
Get the user's library ID that they can access
*/
function getUserLibrary($id)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL getUserLibrary(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $connection = null;
                $stmt = NULL;
                $db = NULL;
                $libraryID = $row['libraryID'];
                return $libraryID;
            }
        } else {
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return NULL;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
        return NULL;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }

}
/*
Get the token in the db for the user ID
*/
function getUserToken($id)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL getUserToken(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $token = null;
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $token = $row['token'];
                //echo "token : " . $token;
                return $token;
            }
        } else {
            echo "token : " . "NULL";
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return NULL;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }

}
function createBlog($userID, $title, $content, $target_file, $video1)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $userID = filter_var(($userID), FILTER_SANITIZE_STRING);
		$title = filter_var(($title), FILTER_SANITIZE_STRING);
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$target_file = filter_var(($target_file), FILTER_SANITIZE_STRING);
		$video1 = filter_var(($video1), FILTER_SANITIZE_STRING);
		if($video1 != null)
		{
			$code = parseYouTubeUrl($video1);
			$video = "https://www.youtube.com/embed/" . $code;
		}
		else{
			$video = null;	
		}
		if($content != null)
		{
			$newText = '<p>' . implode('</p><p>', array_filter(explode("\n", $content))) . '</p>';
		}
        $sqlExecSP = "CALL insertBlogEntry(\"" . $userID . "\",
		\"" . $title . "\",
		\"" . $newText . "\",
		\"" . $target_file . "\",
		\"" . $video . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
function updateBlog($id, $userID, $title, $content, $video1)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$id = filter_var(($id), FILTER_SANITIZE_STRING);
        $userID = filter_var(($userID), FILTER_SANITIZE_STRING);
		$title = filter_var(($title), FILTER_SANITIZE_STRING);
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$video1 = filter_var(($video1), FILTER_SANITIZE_STRING);
		if($video1 != null)
		{
			$code = parseYouTubeUrl($video1);
			$video = "https://www.youtube.com/embed/" . $code;
		}
		else{
			$video = null;	
		}
		if($content != null)
		{
			$newText = '<p>' . implode('</p><p>', array_filter(explode("\n", $content))) . '</p>';
		}
        $sqlExecSP = "CALL updateBlogEntry(
		\"" . $id . "\",
		\"" . $userID . "\",
		\"" . $title . "\",
		\"" . $newText . "\",
		\"" . $video . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}

function deleteBlogEntry($id)
{
	$blog = getBlogEntryByID($id);
	if($blog->image != null)
	{
		unlink($blog->image);
	}
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		
		$id = filter_var($id, FILTER_SANITIZE_STRING);
       
        $sqlExecSP = "CALL deleteBlogEntry(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	return true;
}
function parseYouTubeUrl($url)
{
     if (stristr($url,'youtu.be/'))
        {preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
    else 
        {@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
}
function removeBlogImageUrl($blog)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		
		$id = $blog->id;
       
        $sqlExecSP = "CALL deleteBlogImageURL(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	return true;
}
function updateBlogImageUrl($blog,$path)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		
		$id = $blog->id;
       
        $sqlExecSP = "CALL updateBlogImageURL(\"" . $id . "\",
		\"" . $path . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();

        
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	return true;
}
function updateAboutText($content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		
		if($content != null)
		{
			$newText = '<p>' . implode('</p><p>', array_filter(explode("\n", $content))) . '</p>';
		}
        $sqlExecSP = "CALL updateAboutText(
		\"" . $newText . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
//updateBlurb
function updateBlurb($blurb,$name,$content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$name = filter_var(($name), FILTER_SANITIZE_STRING);
		
		if($content != null)
		{
			$newText = '<p>' . implode('</p><p>', array_filter(explode("\n", $content))) . '</p>';
		}
        $sqlExecSP = "CALL updateBlurb(
		\"" . $blurb . "\",
		\"" . $name . "\",
		\"" . $newText . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
function updateMapLink($blurb,$name,$content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$name = filter_var(($name), FILTER_SANITIZE_STRING);
		
		
        $sqlExecSP = "CALL updateBlurb(
		\"" . $blurb . "\",
		\"" . $name . "\",
		\"" . $content . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
function updateSystemName($blurb,$name,$content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$name = filter_var(($name), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL updateBlurb(
		\"" . $blurb . "\",
		\"" . $name . "\",
		\"" . $content . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
function updateFacebookLink($blurb,$name,$content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$name = filter_var(($name), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL updateBlurb(
		\"" . $blurb . "\",
		\"" . $name . "\",
		\"" . $content . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	
}
function updatePhone($blurb,$name,$content)
{
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$content = filter_var(($content), FILTER_SANITIZE_STRING);
		$name = filter_var(($name), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL updateBlurb(
		\"" . $blurb . "\",
		\"" . $name . "\",
		\"" . $content . "\"
		)";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute(); 
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	

}
/*
Generate some randomy numbers with reaosnable entropy
*/
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int)($log / 8) + 1; // length in bytes
    $bits = (int)$log + 1; // length in bits
    $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}
/*
Get a randomy token of some length
*/
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
    }

    return $token;
}
/*
DB delete of a book with an ID
Params cleaned here
*/
function deleteBook($id)
{
    $imagePath = getInventoryByItemId($id)->image;
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $id = filter_var(($id), FILTER_SANITIZE_STRING);

        $sqlExecSP = "CALL DeleteBook(\"" . $id . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
		if($imagePath != 'images/books/default.png')
		{
        	unlink($imagePath);
		}
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
Delete all books in the library and all borrows records

*/
function deleteAllBooks()
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL deleteAllBooks()";// Also deletes all borrows in the sproc
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*

Delete all the borrows for this book ID

*/
function deleteAllBorrows($libraryID)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL ReturnAllBooksByLibrary(\"" . $libraryID . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/* 
DB get of all borrow records.
*/
function getAllBorrows()
{
    $borrows = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getAllBorrows()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $borrow = new Borrow();
                $borrow->bookID = $row['bookID'];
                $borrow->libraryID = $row['libraryID'];
                array_push($borrows, $borrow);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $borrows;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/* 
DB get of all borrow records for a library.
*/
function getBorrowsByLibraryID($libraryID)
{
	$libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);
    $borrows = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getBorrowsByLibraryID(\"" . $libraryID . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $borrow = new Borrow();
                $borrow->bookID = $row['bookID'];
                $borrow->libraryID = $row['libraryID'];
                array_push($borrows, $borrow);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $borrows;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getBorrowsPerLibrary()
{
    $borrows = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getBorrowsPerLibrary()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($borrows, $row);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $borrows;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getCountsByPublisher()
{
    $counts = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getBooksByPublisher()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($counts, $row);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $counts;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getCountsByContributor()
{
    $counts = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL 	getCountsByContributor()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($counts, $row);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $counts;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getCountsByAuthor()
{
    $counts = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL 	getCountsByAuthor()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($counts, $row);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $counts;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getCountsByCreator()
{
    $counts = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL 	getCountsByCreator()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($counts, $row);
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;

        }
        return $counts;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getPriceStats($libraryIDs)
{
    $priceStats = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL 	getBookCostStats()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($priceStats, $row);
            }
		}
        foreach($libraryIDs as $libraryID)
		{
			if($libraryID != 0)
			{
				$sqlExecSP = "CALL 	getBookCostStatsByLibraryID(\"" . $libraryID . "\")";
				$stmt = $db->prepare($sqlExecSP);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						if($row['max'] != null && $row['min'] != null && $row['avg'] != null)
						{
							array_push($priceStats, $row);
						}
					}
				}
			}
		}
		$connection = null;
        $stmt = NULL;
        $db = NULL;
        return $priceStats;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	return null;
}
function getTotalCostPerLibrary($libraryIDs)
{
	$priceStats = Array();
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL 	getBookCostTotals()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if($row['totalprice'] != null)
					{
						array_push($priceStats, $row);
					}
            }
		}
        foreach($libraryIDs as $libraryID)
		{
			if($libraryID != 0)
			{
				$sqlExecSP = "CALL 	getBookCostTotalsByLibraryID(\"" . $libraryID . "\")";
				$stmt = $db->prepare($sqlExecSP);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						if($row['totalprice'] != null)
						{
							array_push($priceStats, $row);
						}
					}
				}
			}
		}
		$connection = null;
        $stmt = NULL;
        $db = NULL;
        return $priceStats;
    } catch
    (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
	return null;
}
/*
DB insert of a book
Params filtered here
*/
function createBook($callNumber, $title, $contribution_id, $libraryID, $author, $publisher, $publishYear, $numPages, $price, $donatedBy, $image)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();

        //$libraryID = rand(0,4);
        //$contribution_id = 0;

        $callNumber = filter_var(($callNumber), FILTER_SANITIZE_STRING);
        $title = filter_var(($title), FILTER_SANITIZE_STRING);
        $contribution_id = filter_var(($contribution_id), FILTER_SANITIZE_STRING);
        $libraryID = filter_var(($libraryID), FILTER_SANITIZE_STRING);
        $author = filter_var(($author), FILTER_SANITIZE_STRING);
        $publisher = filter_var(($publisher), FILTER_SANITIZE_STRING);
        $publishYear = filter_var(($publishYear), FILTER_SANITIZE_STRING);
        $numPages = filter_var(($numPages), FILTER_SANITIZE_STRING);
        $price = filter_var(($price), FILTER_SANITIZE_STRING);
        $donatedBy = filter_var(($donatedBy), FILTER_SANITIZE_STRING);
        $image = filter_var(($image), FILTER_SANITIZE_STRING);
        $return = -1;
        $sqlExecSP = "CALL InsertInventoryItem(
            \"" . $libraryID . "\",
			\"" . $callNumber . "\",
            \"" . $title . "\",
            \"" . $libraryID . "\",
            \"" . $author . "\",
            \"" . $publisher . "\",
            \"" . $publishYear . "\",
            \"" . $numPages . "\",
            \"" . $price . "\",
            \"" . $donatedBy . "\",
            \"" . $contribution_id . "\",
            \"" . $image . "\")";


        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $return = $row['maxID'];
        if ($libraryID > 0 && $return > 0) {
            $sqlExecSP = "CALL InsertBorrow(
                \"" . $libraryID . "\",
                \"" . $return . "\")";
            $stmt = $db->prepare($sqlExecSP);
            $stmt->execute();
        }
		if($libraryID > 0 && $return == 0) {
			$sqlExecSP = "CALL getBookIDByKey(
                \"" . $title . "\",
                \"" . $author 	. "\",
				\"" . $publisher . "\",
            	\"" . $publishYear . "\")";
            $stmt = $db->prepare($sqlExecSP);
            $stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
        	$return = $row['id'];
			$sqlExecSP = "CALL InsertBorrow(
                \"" . $libraryID . "\",
                \"" . $return . "\")";
            $stmt = $db->prepare($sqlExecSP);
            $stmt->execute();
		}


        $connection = null;
        $stmt = NULL;
        $db = NULL;
        return $return;
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
/*
Export of a library
Library 0 returns all books
Library n returns all borrows
*/
function exportLibrary($libID, $fileName)
{
	// We check this libraryID in the next function to determine if we should get everything or just the borrows.
    $result = getInventoryByLibraryId($libID,0,200000);
	$libID = filter_var(($libID), FILTER_SANITIZE_STRING);
    if (sizeof($result) > 0) {
        $objPHPExcel = new PHPExcel();
        $tmparray = array("ID", "Call No", "Book Title", "Author(s)", "Publisher", "Year Published", "Pages", "Price in Rupees", "Donated By", "Image", "Library ID","CreatedByLibrary");
        $sheet = array($tmparray);
        //Call No | Book Title | Author(s) | Publisher | Year Published | Pages | Price in Rupees | Donated By | Image
        foreach ($result as $row) {
            $tmparray = array();
            $id = $row->item_id;
            array_push($tmparray, $id);
            $callNum = $row->callNumber;
            array_push($tmparray, $callNum);
            $title = $row->title;
            array_push($tmparray, $title);
            $author = $row->author;
            array_push($tmparray, $author);
            $publisher = $row->publisher;
            array_push($tmparray, $publisher);
            $yearPublished = $row->publishYear;
            array_push($tmparray, $yearPublished);
            $numPages = $row->numPages;
            array_push($tmparray, $numPages);
            $price = $row->price;
            array_push($tmparray, $price);
            $donatedBy = $row->donatedBy;
            array_push($tmparray, $donatedBy);
			//if the row has an image we insert that here. 
			// Let's hope the image exists.
            $image = $row->image;
            array_push($tmparray, $image);
            array_push($tmparray, $libID);
			$createdlibID = $row->createdByLibraryID;
            array_push($tmparray, $createdlibID);

            array_push($sheet, $tmparray);
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $fileName = $fileName . date('Y/m/d') . ".xlsx";
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        $worksheet = $objPHPExcel->getActiveSheet();
        foreach ($sheet as $row => $columns) {
            foreach ($columns as $column => $data) {
                $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);
            }
        }

        //make first row bold
        $objPHPExcel->getActiveSheet()->getStyle("A1:L1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save(str_replace('.php', '.xlsx', $fileName));

        $objWriter->save('php://output');
        exit();
    }
	else{
		printerrorAndExit("Error exporting library!","LibraryList.php");
	}
}
    function Export_Database($host,$user,$pass,$name )
    {
       $tables=false;
		$backup_name=false;
	   $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
		$backup_name = $backup_name ? $backup_name : "Backup"."_(".date('m-d-Y').")".".sql";
       // $backup_name = $backup_name ? $backup_name : $name.".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
