<?php
    ini_set('memory_limit',-1);
    set_time_limit(0);
    ini_set('display_errors', 1);
    session_start();
   
    define('SITE_URL','http://localhost/school_project/');
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/school_project/');
    define('SITE_TITLE','Institute Management System');
    
    define('FOOTER_TITLE','Developed by Anshul Pareek');
    define('IMAGE_URL',SITE_URL.'images/');
    define('SITE_LOGO',IMAGE_URL.'site_logo.png');
    define('JS_URL',SITE_URL.'js/');
    define('CSS_URL',SITE_URL.'css/');
    define('FONT_URL',SITE_URL.'fonts/');
    define('PAGE_URL',BASE_PATH.'modules/');
    define('INCLUDE_URL',BASE_PATH.'includes/');
    define('FUNCTION_URL',BASE_PATH . 'functions/');
    define('CLASSES_URL',BASE_PATH . 'classes/');
    define('HEADER',INCLUDE_URL . 'header.php');
    define('FOOTER',INCLUDE_URL . 'footer.php');
    define('LOGIN_URL',SITE_URL."modules/login.php");
    define('DB_HOST','localhost');
    define('DB_USER','root');//nationa5;
    define('DB_PASS','');//AP9799272385
    define('DB_NAME','db_nim');//nationa5_db_nim
    define('TABLE_PREFIX','tbl_');
    define('RECORD_LIMIT','20');
    date_default_timezone_set('Asia/Kolkata');
    require(CLASSES_URL.'commonClass.php');
    $commonObj = new commonClass(); 
    
?>