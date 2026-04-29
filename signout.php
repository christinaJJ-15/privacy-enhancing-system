<?php
session_start();
if(isset($_SESSION['adminuserid'])) {
    unset($_SESSION['adminuserid']);
}
if(isset($_SESSION['userid'])) {
    unset($_SESSION['userid']);
}
if(isset($_SESSION['doctorid'])) {
    unset($_SESSION['doctorid']);
}
header("Location:index.php");
?>