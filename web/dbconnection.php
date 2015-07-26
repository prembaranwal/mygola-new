<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$servername = "mysql12.000webhost.com";
$username = "a2947335_admin";
$password = "Mygola@123";

// Create connection
$conn = mysql_connect($servername, $username, $password);
mysql_select_db('a2947335_mygola');
// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
