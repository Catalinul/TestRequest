<?php  
session_start();  
$manifest = parse_ini_file("src/manifest.ini");
$_SESSION['url'] = 'index.php';  
if(!$_SESSION['user'])  
{  
  
    header("Location: auth-signin.php"); 
}  
else{

include("database/db_conection.php");  

date_default_timezone_set('Europe/Bucharest');

$timestamp = date('Y-m-d G:i:s');
$username=$_SESSION['user'];
$team = $_SESSION['team'];

if ($_SESSION['testStatus'] == '0'){
$st = "Select * FROM testRequest Where testRequester = '$username'"; 
$sh = "Select * FROM testRequest Where testRequester = '$username' and testStatus = 'On Hold'";
$sp = "Select * FROM testRequest Where testRequester = '$username' and testStatus = 'In Progress'";
$sc = "Select * FROM testRequest Where testRequester = '$username' and testStatus = 'Completed'";
}else{
$st = "Select * FROM testRequest"; 
$sh = "Select * FROM testRequest Where testStatus = 'On Hold'";
$sp = "Select * FROM testRequest Where testStatus = 'In Progress'";
$sc = "Select * FROM testRequest Where testStatus = 'Completed'";	
}

$rt=mysqli_query($conn,$st);  
$numRT = mysqli_num_rows($rt);
$rh=mysqli_query($conn,$sh);  
$numRH = mysqli_num_rows($rh);
$rp=mysqli_query($conn,$sp);  
$numRP = mysqli_num_rows($rp);
$rc=mysqli_query($conn,$sc);  
$numRC = mysqli_num_rows($rc);
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Test Request platform</title>
 
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Test Request platform" />
    <meta name="keywords" content="Test Request platform"/>
    <meta name="author" content="Catalin Pirvu"/>

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">
	<script src="https://www.gstatic.com/charts/loader.js"> </script>
	<script src="https://www.google.com/jsapi"></script>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            
            <div class="navbar-brand header-logo">
                <a href="index.php" class="b-brand">
                    <div class="b-bg">
                        <img width="100%" src="assets/images/logo_icon.png"></img>
                    </div>
                    <span class="b-title">Test Request</span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
					<li class="nav-item"><a class="nav-link"><span class="pcoded-micon"><i class="feather icon-globe"></i></span><span class="pcoded-mtext"><?php echo $team;?></span></li></a>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nav-item active">
                        <a href="index.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Utilities</label>
                    </li>
                    <li id="test_request" class="nav-item">
                        <a href="ntr.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-plus"></i></span><span class="pcoded-mtext">New Test Request</span></a>
                    </li>
					<li  id="test_status" class="nav-item">
                        <a href="tStatus.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-list"></i></span><span class="pcoded-mtext">Test Status</span></a>
                    </li>
                    <li  id="test_update" class="nav-item">
                        <a href="tUpdate.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-refresh-cw"></i></span><span class="pcoded-mtext">Test Update</span></a>
                    </li>
                    <li id="admin_area1" class="nav-item pcoded-menu-caption">
                        <label>Admin Area</label>
                    </li>
					<li id="admin_area2"  class="nav-item">
                        <a href="aUsers.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Users</span></a>
                    </li>
                    <li id="admin_area3"  class="nav-item">
                        <a href="aApps.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-layout"></i></span><span class="pcoded-mtext">Applications</span></a>
                    </li>
                    <li id="admin_area4"  class="nav-item">
                        <a href="aEnvironmentS.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-disc"></i></span><span class="pcoded-mtext">Environment Software</span></a>
                    </li>
					<li id="admin_area5"  class="nav-item">
                        <a href="aEnvironmentH.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Environment Hardware</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="index.php" class="b-brand">
                   <div class="b-bg">
                       <i class="feather icon-trending-up"></i>
                   </div>
                   <span class="b-title">Test Request</span>
               </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
                <li>
                    <span class="mt-3" id="spanMonth" style="font-size:30px"></span>
                    <select onchange="change()" id="changeMonth" class="form-select">
						<option value="" selected disabled hidden>Choose month:</option>
                    </select>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
            
                <li>
                    <div class="dropdown drp-user">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right profile-notification">

                            <div class="pro-head">
                                <img src="<?php echo $_SESSION['icon'];?>" class="img-radius" alt="User-Profile-Image">
                                <span><?php echo $_SESSION['surname']." ".$_SESSION['name'];?></span>
                                <span class="m-2 text-right">V<?php echo $manifest["version"];?></span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="profile.php" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                                <li><a href="logout.php" class="dropdown-item"><i class="feather icon-lock"></i> Log out</a></li>
                            </ul>
                            
                        </div>
                    </div> 
                </li>
                <li> 
                    <a href="logout.php" class="dud-logout" title="Logout"><i class="feather icon-log-out"></i></a>
                </li>
                
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
							
							<div class="row">
							
								<div class="col-md-6 col-xl-3">
									<div class="card order-card border border-info rounded">
										<div onclick="goto('')" class="card-block" style="padding:5px 5px 5px 5px; cursor:pointer">
                                            <h3 class="text-center m-b-10"><b class="m-l-30 float-left" style="color: #7a7a7e">Total Requests</b><span class="m-r-30 float-right"  style="color: #7a7a7e"><?php echo $numRT;?></span></h3>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-xl-3">
									<div class="card order-card border border-danger rounded">
										<div onclick="goto('On Hold')" class="card-block" style="padding:5px 5px 5px 5px; cursor:pointer">
                                            <h3 class="text-center m-b-10"><b class="m-l-30 float-left" style="color: #7a7a7e">On Hold</b><span class="m-r-30 float-right"  style="color: #7a7a7e"><?php echo $numRH;?></span></h3>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-xl-3">
									<div class="card order-card border border-warning rounded">
										<div onclick="goto('In Progress')" class="card-block" style="padding:5px 5px 5px 5px; cursor:pointer">
                                            <h3 class="text-center m-b-10"><b class="m-l-30 float-left" style="color: #7a7a7e">In Progress</b><span class="m-r-30 float-right"  style="color: #7a7a7e"><?php echo $numRP;?></span></h3>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-xl-3">
									<div class="card order-card border border-success rounded">
										<div onclick="goto('Completed')" class="card-block" style="padding:5px 5px 5px 5px; cursor:pointer">
											<h3 class="text-center m-b-10"><b class="m-l-30 float-left" style="color: #7a7a7e">Completed</b><span class="m-r-30 float-right"  style="color: #7a7a7e"><?php echo $numRC;?></span></h3>
										</div>
									</div>
								</div>
                             
							</div>
							
							
							<div class="row">
                              
                                <!--[ year  sales section ] end-->
                                <!--[ Recent Users ] start-->
                                <div class="col-xl-4 col-md-12 m-b-30">
									<div id="myChartPie" class="card" style="height:400px"></div>
                                </div>
								<div class="col-xl-4 col-md-12 m-b-30">
									<div id="myChartBar" class="card" style="height:400px" ></div>
                                </div>
                                <!--[ Recent Users ] end-->

                                <!-- [ statistics year chart ] start -->
                                <div class="col-xl-4 col-md-12 m-b-30">
									<div id="myChartPie2" class="card" style="height:400px" ></div>
                                    
                                </div>
                                <!-- [ statistics year chart ] end -->
                              

                            </div>
							
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
	<script>
function goto(x){
	
	window.location.href = "tStatus.php?search="+x;
	
}	
function change(){
	setCookie("month", $("#changeMonth").val());
	location.reload();
}	
function setCookie(cname, cvalue) {
  document.cookie = cname + "=" + cvalue;
  console.log("month set to: "+cvalue);
}

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

google.charts.load("visualization", "1", {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);



	var cookieM = getCookie("month");
	var selectBox = document.getElementById('changeMonth');
	const monthNames = ["January", "February", "March", "April", "May", "June",
	  "July", "August", "September", "October", "November", "December"
	];
	var currentMonth = getCookie("month");
	for( var i = 0, l = monthNames.length; i<l; i++){
		var option = monthNames[i];
		if (i == currentMonth){
		selectBox.options.add(new Option(option, i, true));
		}else{
		selectBox.options.add(new Option(option, i, false));
		}
	}
	





function drawChart() {

document.getElementById("spanMonth").innerHTML = monthNames[currentMonth];
	
var dataPie = google.visualization.arrayToDataTable([
  ['Test Category', 'No Tests'],
  <?php 
  $month = $_COOKIE['month'];
  if ($_SESSION['testStatus'] == '0'){ 
  //daca user-ul NU este admin requester va vedea doar categoriile la care are acces
  $sql="SELECT * FROM ( SELECT SUBSTRING_INDEX(testApp,',',1) as appName, SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na, (SUM(JSON_EXTRACT(testResult, '$[0].pass'))+SUM(JSON_EXTRACT(testResult, '$[0].fail'))+sum(JSON_EXTRACT(testResult,'$[0].na'))) as Total FROM testRequest WHERE (Month(testCompletedDate) = $month+1) AND (testRequester = '$username') GROUP BY appName) as t";
  }else{ //daca e admin requester va avea acces la toate categoriile de test
  $sql="SELECT * FROM ( SELECT SUBSTRING_INDEX(testApp,',',1) as appName, SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na, (SUM(JSON_EXTRACT(testResult, '$[0].pass'))+SUM(JSON_EXTRACT(testResult, '$[0].fail'))+sum(JSON_EXTRACT(testResult,'$[0].na'))) as Total FROM testRequest WHERE Month(testCompletedDate) = $month+1 GROUP BY appName) as t";  
  }

  $result=mysqli_query($conn,$sql);  
  $counter = 0;
  $numResult = mysqli_num_rows($result);

  if ($numResult == 0){
	echo "['No Values',0]";  
  }else{
	  while($row = $result->fetch_assoc()){
		  if (++$counter == $numResult){
			  echo "['".$row['appName']."',".$row['Total']."]";
		  }else{
			  echo "['".$row['appName']."',".$row['Total']."],";
		  }
	  }
  }
	  ?>
]);

var optionsPie = {
  title:'Total Tests Executed for '+monthNames[currentMonth],
  is3D: true
};

var chartPie = new google.visualization.PieChart(document.getElementById('myChartPie'));
  chartPie.draw(dataPie, optionsPie);
  
  
var dataBar = google.visualization.arrayToDataTable([
  ['Tests', 'Success Rate'],
  <?php 
  $month = $_COOKIE['month'];
  if ($_SESSION['testStatus'] == '0'){
  $sql1="SELECT * FROM ( SELECT SUBSTRING_INDEX(testApp,',',1) as appName, SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na, (SUM(JSON_EXTRACT(testResult, '$[0].pass'))+SUM(JSON_EXTRACT(testResult, '$[0].fail'))+sum(JSON_EXTRACT(testResult,'$[0].na'))) as Total FROM testRequest WHERE (Month(testCompletedDate) = $month+1) AND (testRequester = '$username') GROUP BY appName) as t";}
  else{
  $sql1="SELECT * FROM ( SELECT SUBSTRING_INDEX(testApp,',',1) as appName, SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na, (SUM(JSON_EXTRACT(testResult, '$[0].pass'))+SUM(JSON_EXTRACT(testResult, '$[0].fail'))+sum(JSON_EXTRACT(testResult,'$[0].na'))) as Total FROM testRequest WHERE Month(testCompletedDate) = $month+1 GROUP BY appName) as t";	
  }
  $result1=mysqli_query($conn,$sql1);  
  $counter1 = 0;
  $numResult1 = mysqli_num_rows($result1);
  if ($numResult1 == 0){
	echo "['No Values',0]";  
  }else{
	  while($row1 = $result1->fetch_assoc()){
		  $totalPF = $row1['pass'] + $row1['fail'];
		  if ($totalPF == 0){
			$successR = 100;
		  }else{
			$successR = round(($row1['pass'] / $totalPF * 100),2);
		  }
		  if (++$counter1 == $numResult1){
			  echo "['".$row1['appName']."',".$successR."]";
		  }else{
			  echo "['".$row1['appName']."',".$successR."],";
		  }
	  }
  }
	  ?>
]);

var view = new google.visualization.DataView(dataBar);
view.setColumns([0,1,{calc: "stringify",sourceColumn: 1, type: "string", role: "annotation" }]);

var optionsBar = {
  title: 'Success Rate for '+monthNames[currentMonth],
  legend: 'none',
  hAxis: { 
    viewWindowMode:'explicit',
	format: "#'%'",
    viewWindow: {
        max:100,
        min:0
    }
  }
};

var chartBar = new google.visualization.BarChart(document.getElementById('myChartBar'));
chartBar.draw(view, optionsBar);  
  


var dataPie2 = google.visualization.arrayToDataTable([//primeste doar un vector 2d
  ['Status', 'Total'], //primul element este header-ul tabelei
   <?php $month = $_COOKIE['month'];
  if ($_SESSION['testStatus'] == '0'){ // in cazul in care user-ul NU este admin requester atunci isi va vedea doar testele proprii
  $sql2="SELECT * FROM ( SELECT SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na FROM testRequest WHERE (Month(testCompletedDate) = $month+1) AND (testRequester = '$username')) as t";
  }else{ //daca e admin requester le vede pe toate in grafic
  $sql2="SELECT * FROM ( SELECT SUM(JSON_EXTRACT(testResult, '$[0].pass')) as pass, SUM(JSON_EXTRACT(testResult, '$[0].fail')) as fail, SUM(JSON_EXTRACT(testResult,'$[0].na')) as na FROM testRequest WHERE Month(testCompletedDate) = $month+1) as t";}

  $result2=mysqli_query($conn,$sql2);  
  
   $row2 = $result2->fetch_assoc();
	if (empty($row2['pass'])){
	echo "['No Values',0]";  
    } else {  
	  $pass = $row2['pass'];
	  $fail = $row2['fail'];
	  $na = $row2['na'];
	  echo "['PASS',".$pass."],";
	  echo "['FAIL',".$fail."],";
	  echo "['N/A',".$na."]";}?>]);

var optionsPie2 = {
  title:'Overall status for '+monthNames[currentMonth],
  is3D: true
};

var chartPie2 = new google.visualization.PieChart(document.getElementById('myChartPie2'));
chartPie2.draw(dataPie2, optionsPie2);
   
  
}




</script>

</body>
</html>
<?php  if ($_SESSION['user_type'] != "2"){
echo "<script type='text/javascript'>for(let i = 1; i < 6; i++){document.getElementById('admin_area'+i).remove();}</script>";
if ($_SESSION['user_type'] == "0"){
	echo "<script type='text/javascript'>document.getElementById('test_update').remove();</script>";
}else{
	echo "<script type='text/javascript'>document.getElementById('test_request').remove();</script>";
	echo "<script type='text/javascript'>document.getElementById('test_status').remove();</script>";
}
}}?>