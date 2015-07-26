<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting (E_ALL ^E_NOTICE ^E_WARNING);
require_once 'dbconnection.php';

//Add
if($_POST['isEdit'] != 'yes'){
    
    $sql = "INSERT INTO merchant (email, password,hotel_name,latitude,longitude,status) 
VALUES ('".$_POST['email']."','".$_POST['password']."','".$_POST['hotel_name']."','".$_POST['latitude']."','".$_POST['longitude']."','".$_POST['status']."')";
    
    $result = mysql_query($sql,$conn );
    if ($result) {
        echo 'success';
    } else {
        echo 'failure';
    }
    mysql_close($conn);
} else {
    //Update
    $sql = "UPDATE merchant SET email='".$_POST['email']."', password='".$_POST['password']."', hotel_name='".$_POST['hotel_name']."', latitude='".$_POST['latitude']."', longitude='".$_POST['longitude']."', status='".$_POST['status']."' WHERE id=".$_POST['id'];
    
    $result = mysql_query($sql,$conn );
    
    if ($result) {
        echo 'success';
    } else {
        echo 'failure';
    }
    mysql_close($conn);
}