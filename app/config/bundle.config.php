<?php
	define("CSS_BUNDLE", array(
		"92bc1fe4.bootstrap.css", 
		"vendor/select2/select2.css",
		"vendor/uniformjs/css/uniform.default.css",
		"vendor/datatables.css",
		"cssmenu.css",
		"aaf5c053.proton.css",
		"vendor/animate.css",
		"bootstrap-combined.min.css",
		"6227bbe5.font-awesome.css",
		"open-sans_fonts.css",
		"app/credit-card.css"
	));
	
	define("JS_BUNDLE", array(
		"vendor/jquery.min.js", 
		"vendor/modernizr.js",
		"vendor/jquery.cookie.js",
		"e1d08589.bootstrap.min.js",
		"vendor/bootstrap-switch.js",
		"vendor/select2.min.js",
		"vendor/jquery.uniform.min.js",
		"9f7a46ed.proton.js",
		"proton/ba45a7b8.sidebar.js",
		"proton/de9cba6c.forms.js",
		"vendor/jquery.jstree.js",
		"vendor/jquery.dataTables.min.js",
		"vendor/datatables.js",
		"vendor/mixpanel.js",
		"bootstrap-contextmenu.js",
		"jquery.jeditable.js",
		"jquery.jeditable.charcounter.js",
		"app/cc.js",
		"common.js"
	));
	
        //Set first SITE_STATUS value to "Live" and set MINIFY_BUNDLE to true to enable minify bundle feature
        //It is recommended to delete first the output files(/scripts/bundle.min.js & /resources/styles/bundle.min.css) to get fresh bundle output.
        
	define("MINIFY_BUNDLE", true);
?>