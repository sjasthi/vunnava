<?php

/* DATABASE INFORMATION GOES HERE */
  $production = true;// true in production
        $username = "root";
        $pass = "";
        if ($production) {
			DEFINE('DATABASE_HOST', 'localhost');
			DEFINE('DATABASE_DATABASE', 'icsbinco_vunnava');
			DEFINE('DATABASE_USER', 'icsbinco_vunnava');
			DEFINE('DATABASE_PASSWORD', 'Vunnava_499');
			
        } else {
           DEFINE('DATABASE_HOST', 'localhost');
			DEFINE('DATABASE_DATABASE', 'pushycart');
			DEFINE('DATABASE_USER', 'root');
			DEFINE('DATABASE_PASSWORD', '');
        }

