<?php
$conn = mysqli_connect("localhost", "root", "", "auth_system");
if (!$conn) { die("DB Connection Failed"); }
session_start();
?>