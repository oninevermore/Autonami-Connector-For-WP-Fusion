<?php
	define("SITE_STATUS", "Debug");
	define("SITE_VERSION", "1.0.0");
	
	if($_SERVER['HTTP_HOST'] == "app.evermoretimer.com"){
		define("SITE_LOCATION", "Local");
		define("ROOT_URL", ""); 
                define("REAL_URL", "http://app.evermoretimer.com");
                
                define("DB_SERVER_NAME", "localhost");
                define("DB_USERNAME", "root");
                define("DB_PASSWORD", "root");
                define("DB_Name", "ev_timer");
                
	}else{
		define("SITE_LOCATION", "Cloud");
		define("ROOT_URL", "");
                define("REAL_URL", "https://evermorelabs.com/evermoretimer");
                
                define("DB_SERVER_NAME", "localhost");
                define("DB_USERNAME", "everlabs_evtmrusr");
                define("DB_PASSWORD", "i-5t)!;qhDkf");
                define("DB_Name", "everlabs_evermoretimer");
	}
        
        define("GOOGLE_CLIENT_ID", "336179636149-g25lpm4dge2iotnukqff2hk79rk8epq6.apps.googleusercontent.com");
        define("GOOGLE_CLIENT_SECRET", "B53tDApsPsI0_iZJTfidbuu-");
        define("GOOGLE_REDIRECT_URI", REAL_URL . "/authorize");