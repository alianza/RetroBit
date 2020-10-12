<?php include_once('../dbconfig.php'); ?>

<div class="currents">

    <?php  include_once('current.php'); ?>

</div>

<div class="recents">

    <?php include_once('recents.php'); ?>

</div>

<form action="index.php" method='get' enctype='multipart/form-data'>
    <input type="submit" class="fab material-icons" value="settings">
    <input type="hidden" name="page" value="config">
</form>
