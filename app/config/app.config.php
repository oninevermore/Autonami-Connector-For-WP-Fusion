<?php
	define("SITE_STATUS", "Debug");
	define("SITE_VERSION", "1.0.0");
	
	if($_SERVER['HTTP_HOST'] == "app.evermoretimer.local"){
		define("SITE_LOCATION", "Local");
		define("ROOT_URL", "");
                define("REAL_URL", "http://app.evermoretimer.local");
                
	}else{
		define("SITE_LOCATION", "Cloud");
		define("ROOT_URL", "");
                define("REAL_URL", "https://evermorelabs.com/evermoretimer");
	}
        
        define("DB_SERVER_NAME", "localhost");
        define("DB_USERNAME", "root");
        define("DB_PASSWORD", "root");
        define("DB_Name", "ev_timer");
?>  