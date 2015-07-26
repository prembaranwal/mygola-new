<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting (E_ALL ^E_NOTICE ^E_WARNING);
require_once 'dbconnection.php';
session_start();
if(empty($_SESSION["adminId"])){
    header("Location: signin.html");
    die();
}
$sql = "SELECT * FROM merchant";
$result = mysql_query($sql,$conn );

while($res = mysql_fetch_array($result)){
    $final_res[] = $res;
}
   
?>
<?php
require_once 'header.php';
?>
        <div class="dash-middle">
            <button><a href="addMerchant.php">Add New</a></button>
            <br><br>
        <table border="1" width="100%" id="summary_table">
<?php
if (is_array($final_res) && !empty($final_res)) {
    echo "<tr><td><b>Restaurant</b></td><td><b>Email</b></td><td><b>Status</b></td></tr>";
    foreach ($final_res as $arr){
        $status = ($arr['status']==1)?'Active':'Inactive';
        echo "<tr><td><a href='addMerchant.php?id=".$arr['id']."'>".$arr['hotel_name']."</a></td><td>".$arr['email']."</td><td>".$status."</td></tr>";    
    }
} else {
    echo "<tr><td>No merchants regsitered!</td></tr>";
}
?>
        </table>
        </div>
<?php
require_once 'footer.php';
?>