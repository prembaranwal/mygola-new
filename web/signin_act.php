<?php

/**
 * Function to handle super admin login
 */
error_reporting (E_ALL ^E_NOTICE ^E_WARNING);
require_once 'dbconnection.php';
if(isset($_POST['vUsername']) && !empty($_POST['vUsername']) && 
        isset($_POST['vPassword']) && !empty($_POST['vPassword'])){
    
    $sql = "SELECT iId FROM admin where vUsername = '".$_POST['vUsername']."' AND  vPassword = '".$_POST['vPassword']."' AND eStatus = 'Active'";
    
    $result = mysql_query($sql,$conn );
    $res = mysql_fetch_assoc($result);
    
    if ($res['iId'] > 0) {
        session_start();
        $_SESSION["adminId"] =  $res['iId'];
        echo 'success';
    } else {
        echo 'failure';
    }
    mysql_close($conn);
    
} else {
    echo 'failure';
}

