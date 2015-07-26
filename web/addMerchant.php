<?php
require_once 'header.php';
error_reporting (E_ALL ^E_NOTICE ^E_WARNING);
        
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
<script type="text/javascript" src="maps.js"></script>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<div id="map-canvas"></div>
<?php
    if(isset($_GET['id']) && !empty($_GET['id'])){
        require_once 'dbconnection.php';
        $sql = "SELECT * FROM merchant where id=".$_GET['id'];
        $result = mysql_query($sql,$conn );
        $res = mysql_fetch_array($result);
    }
?>
<div class="dash-middle">
    <form method="post" action="add_action.php" name="addForm" id="addForm">
        Email : <input type="text" name="email" id="email" value="<?php echo $res['email'] ?>" required><br><br>
        Password: <input type="password" name="password" id="password" required><br><br>
        Retype Password: <input type="password" name="password2" id="password2" required data-conditional="confirm"><br><br>
        Restaurant Name: <input type="text" name="hotel_name" id="hotel_name" value="<?php echo $res['hotel_name'] ?>" required><br><br>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo $res['latitude'] ?>" required>
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $res['longitude'] ?>" required>
        <?php
        if(isset($_GET['id']) && !empty($_GET['id'])){
        ?>
            <input type="hidden" name="isEdit" id="isEdit" value='yes'>
            <input type="hidden" name="id" id="id" value='<?php echo $_GET['id']; ?>'>
            
        <?php
        }
        ?>
        Status: <select name="status" id="status">
            <option value="1" selected="selected">Active</option>
            <option value="2">Inactive</option>
        </select><br><br>
        <input type="button" value="Add" id="add">
    </form>
</div>

<?php
require_once 'footer.php';
?>

