<?php
include("../database/db_conection.php");  


$html = '<ul class="list-unstyled friend-list">';

if (isset($_GET['idTest'])){
$idtest = $_GET['idTest'];

$sql = "SELECT * from testRequest where idTest = '$idtest'";

$run=mysqli_query($conn,$sql);
$i=0;
while ($row = $run->fetch_assoc()) { 
$i++;

$testEnv = $row['testEnv'];
$testHW = $row['testHW'];
$testRQ = $row['testRequester'];
$testDR = $row['testDateRequest'];
$testDD = $row['testDueDate'];

$q1="select * from users where username = '$testRQ'";
$runq1=mysqli_query($conn,$q1);
$rowq1 = $runq1->fetch_assoc();


$html .= '<li class="mt-2 mb-1 bg-light">';
$html .= '<div class="text-small row text-left">';						
$html .= '<div class="col-md-6">Requester: </div><div class="col-md-6 text-right">'.$rowq1['surname']." ".$rowq1['name'].'</div>';	
$html .= '<div class="col-md-6">Date request: </div><div class="col-md-6 text-right">'.$testDR.'</div>';									
$html .= '<div class="col-md-6">Due Date: </div><div class="col-md-6 text-right">'.$testDD.'</div>';											
$html .= '</div>';						
$html .= '</li>';	
$html .= '<li class="mt-2 mb-1 bg-light">';
$html .= '<a href="#" class="d-flex justify-content-between">';
$html .= '<div class="text-small col-md-12 text-left">';						
$html .= '<strong>Test Environment</strong>';						
$html .= '<p class="text-muted">'.$testEnv.'</p>';						
$html .= '</div>';						
$html .= '</a></li>';						
$html .= '<li class="mt-2 mb-1 bg-light">';
$html .= '<a href="#" class="d-flex justify-content-between">';
$html .= '<div class="text-small col-md-12 text-left">';						
$html .= '<strong>Test Hardware</strong>';						
$html .= '<p class="text-muted">'.$testHW.'</p>';						
$html .= '</div>';						
$html .= '</a></li>';								

}

$html .= '</ul>';							
if ($i == 0){
	$html = '<ul class="list-unstyled friend-list">';
	$html .= '<li class="mt-2 mb-1 bg-light">';
	$html .= '<a href="#" class="d-flex justify-content-between">';
	$html .= '<div class="text-small col-md-12 text-center">';	
	$html .= '<strong> No information yet...</strong>';	
	$html .= '</div>';	
	$html .= '</a></li>';	
	$html .= '</ul>';
}
header('Content-Type: application/json');


echo json_encode(array("html" => $html));
}

?>