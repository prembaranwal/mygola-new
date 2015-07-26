<?php
require_once 'header.php';
?>
<div class="middle">
    <form method="post" action="signin_act.php" name="signin" id="signin">
        Username : <input type="text" name="vUsername" id="vUsername" required><br><br>
        Password: <input type="password" name="vPassword" id="vPassword" required><br><br>
        <input type="button" value="Login" id="submit">
    </form>
</div>
<?php
require_once 'footer.php';
?>

