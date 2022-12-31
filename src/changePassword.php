<?php
include("../database/db_conection.php");  
$timestamp = date('Y-m-d G:i:s');
if (isset($_GET['userId'])){
$userId = $_GET['userId'];
$password = $_GET['password'];
//if (isset($_POST['userId'])){
//$userId = $_POST['userId'];
//$password = $_POST['password'];
$crypted = password_hash($password, PASSWORD_DEFAULT); 

$crypted = substr($crypted,7);

$query = $conn->query("Update users set password = '$crypted', resetToken='' WHERE idUser = '$userId'");


}


?>