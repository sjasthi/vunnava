<?php
define("LOGINEXPIRATIONLENGTH", 60);//minutes a login is good for before getting logged out
define("CONTACTEMAIL", "somebody@metrostate.edu");//send to address on contact form 
define("FROM_EMAIL", "noreply@topudubandi.com");//sent from email on contact form
define("CHUNK_SIZE", 36);//number of items per page. Multiples of the size in the row (4 or 6) is optimal.
define("ROW_SIZE", 6);//Must be either 4 or 6 items per row
define("ALLOW_MULTIPLE_SUPER_ADMINS", false);//allow creation of multiple admins for library 0
define("SINGLE_LIBRARY_MODE", false);//render all pages with only one library available. Library 0
define("NUM_BLOGS_TO_SHOW", 10);//Number of blog posts to show initially
define("NUM_BLOGS_TO_ADD", 10);//Number of blog posts to add when the user clicks more
define("HIDE_LIBRARY_EXPORT", false);//Hide the export for very large setups