<?php
include('core/config.php');

if((isset($_SESSION['id']) && $_SESSION['id'] != '')|| (isset($_SESSION['st_id']) && $_SESSION['st_id'] != '')){
    $sessionarr = $_SESSION;
    $commonObj->logout($sessionarr);
    header('Location:'.LOGIN_URL);
    exit();
}
else{
    header('Location:'.SITE_URL);
    exit();
}
?>