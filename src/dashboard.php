<?php
session_start();

if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: index.php");
}

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    include("includes/header.php");
    include("includes/sidebar.php");
}

?>

<div class="container" id="dashArea">
<div class="container" id="dashPhilContainer">
    <p id="dashPhil">PhIL</p>
</div>
</div>
