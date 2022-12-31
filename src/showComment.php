<?php
include("../database/db_conection.php");  


$html = '<ul class="list-unstyled friend-list">';

if (isset($_GET['idTest'])){
$idtest = $_GET['idTest'];

$sql = "SELECT * from testComments where idRequest = '$idtest'";

$run=mysqli_query($conn,$sql);
$i=0;
while ($row = $run->fetch_assoc()) { 
$i++;
$dateTime = $row['dateTime'];
$user = $row['user'];
$comment = $row['comment'];
$str = str_replace("'", '\'', $comment);
$html .= '<li class="mt-2 mb-1 bg-light">';
$html .= '<a href="#" class="d-flex justify-content-between">';
$html .= '<div class="text-small col-md-12 text-left">';						
$html .= '<strong>'.$user.'</strong>';						
$html .= '<p class="text-muted">'.$str.'</p>';						
$html .= '</div>';						
$html .= '</a>';						
$html .= '<div class="chat-footer text-right"><p class="text-smaller text-muted mb-0">'.$dateTime.' GMT</p></div></li>';									

}

$html .= '</ul>';							
if ($i == 0){
	$html = '<ul class="list-unstyled friend-list">';
	$html .= '<li class="mt-2 mb-1 bg-light">';
	$html .= '<a href="#" class="d-flex justify-content-between">';
	$html .= '<div class="text-small col-md-12 text-center">';	
	$html .= '<strong> No comments yet...</strong>';	
	$html .= '</div>';	
	$html .= '</a></li>';	
	$html .= '</ul>';
}
header('Content-Type: application/json');


echo json_encode(array("html" => $html));
}

?>