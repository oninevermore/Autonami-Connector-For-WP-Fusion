<?php
    //error_reporting(E_ALL);
    //error_reporting(0);
    define("ROOT_DIR", dirname(__FILE__));
    include_once(ROOT_DIR.'/app/config/app.config.php');
	include_once(ROOT_DIR.'/app/autoload.php');
        
    use App\Core\Router;
        
    $router = new Router();
    $router->init();

?>