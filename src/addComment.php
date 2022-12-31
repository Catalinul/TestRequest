<?php
include("../database/db_conection.php");  
$timestamp = date('Y-m-d H:i:s');
if (isset($_GET['idTest'])){
$idtest = $_GET['idTest'];
$comment = $_GET['comment'];
$username = $_GET['username'];

$_comment = mysqli_real_escape_string($conn, $comment);

$query = $conn->query("INSERT INTO testComments (idRequest, comment, dateTime, user) VALUES ('$idtest','$_comment','$timestamp','$username')");

echo "error: ".mysqli_error($conn);
}


?>