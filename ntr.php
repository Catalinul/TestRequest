<?php  
session_start();  
$manifest = parse_ini_file("src/manifest.ini");
$_SESSION['url'] = 'index.php';  
if(!$_SESSION['user'])  
{  
  
    header("Location: auth-signin.php"); 
}  
elseif($_SESSION['user_type'] == '1' || $_SESSION['app'] != 'TestRequest'){ 
	header("Location: src/403.html"); 
}else{
include("database/db_conection.php");  
date_default_timezone_set('Europe/Bucharest');
$timestamp = date('Y-m-d G:i:s');
$team = $_SESSION['team'];
$emailTester = $_SESSION['emailTester'];


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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">
	<script type="text/javascript">
	function success_req(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Your request was sent',
					 icon: 'success',
					}).then(function(){
							window.location.href = "tStatus.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "tStatus.php";
					});
		}
	function loading(){
		Swal.fire({
                title: 'Please Wait! Sending the notification email...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
	}
	
	</script>
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
                    <li class="nav-item">
                        <a href="index.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Utilities</label>
                    </li>
                    <li id="test_request" class="nav-item active">
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
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Take a moment and add your request</h5>
                                    </div>
                                    <ul id="bcul" class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a id="a1" href="javascript:breadcrumb('1')" style="color: #111;font-weight: 600;">Request a test</a></li>
										<li class="breadcrumb-item"><a id="a2" href="javascript:breadcrumb('2')" onclick="return false;">Build your test environment</a></li>
										<li class="breadcrumb-item"><a id="a3" href="javascript:breadcrumb('3')" onclick="return false;">Select Test Scenarios</a></li>
										
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
								
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Request a new test</h5>
                                        </div>
										<form method="post" enctype="multipart/form-data" onsubmit="loading()">
                                        <div id="breadcrumb-1" class="card-body">
                                            <h5>Select the appropiate category for your test:</h5>
                                            <hr>
                                            <div class="row">
                                                <div id="br1" class="col-md-12">
                                                    
													
													<?php
													$TAPP = $_SESSION['testApp'];														
														$apps="select * from testApp where idApp IN ($TAPP) and appStatus = '1'";
													
    													$run=mysqli_query($conn,$apps);  
														while ($row = $run->fetch_assoc()) {?>
                                                        <div class="form-group form-inline">
                                                            <div class="custom-control custom-checkbox col-md-2">
																<input appname="<?php echo $row['appName'];?>" appid="<?php echo $row['idApp'];?>" scenarioPath="<?php echo $row['appScenarioPath'];?>" type="checkbox" class="custom-control-input" name="apps[]" id="app<?php echo $row['idApp'];?>" value="<?php echo $row['appName'];?>" onclick="appDisable(<?php echo $row['idApp'];?>)">
																<label class="custom-control-label float-left" for="app<?php echo $row['idApp'];?>"><?php echo $row['appName'];?></label>
															</div>
															<div class="form-group col-md-3 mb-2">
																<label for="Version<?php echo $row['idApp'];?>" class="sr-only">Version</label>
																<input type="text" class="form-control" name="versions[]" id="Version<?php echo $row['idApp'];?>" placeholder="<?php echo $row['appPlaceholder'];?>" disabled="disabled">
															</div>
															<div class="form-group col-md-7 mb-2">
																<label for="Path<?php echo $row['idApp'];?>" class="sr-only">Path to download from</label>
																<input type="text" class="form-control col-md-12" name="paths[]" id="Path<?php echo $row['idApp'];?>" placeholder="Type here any further details about your request." disabled="disabled">
															</div>
                                                        </div>
													
														<?php } ?>
                                                        
                                                    <input type="button" id="n1" class="btn btn-primary float-right"onclick="breadcrubD('2')" value="Next" disabled/>
                                                </div>
                                                
                                            </div>
										</div>
											<div id="breadcrumb-2" class="card-body" style="display:none">
												<div class="row">
												<h5 class="mt-3 col-md-10">If you don't know what to pick here, select "Choose for me!" and our team will go with the current supported versions.</h5>
												<div class="mt-3 custom-control custom-radio">
													<input type="radio" id="setDefault" name="customRadio" class="custom-control-input">
													<label class="custom-control-label" for="setDefault">Choose for me!</label>
												</div>
												</div>
												<hr>
												<div class="row">
													<div id="br2" class="col-md-6 row">
														<div class="col-md-4">
														<h5 class="mt-3">Windows</h5>
														<hr>
														<?php $env="select * from testEnv where envAppType = 'Windows' and envStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-radio">
															<input isStandard="<?php echo $row['envIsStandard'];?>" type="radio" id="customRadio<?php echo $row['idEnv'];?>" name="ServerOS[]" class="custom-control-input" value="<?php echo $row['envAppName'].' '.$row['envAppVersion'];?>" <?php echo ($row['envIsDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="customRadio<?php echo $row['idEnv'];?>"><?php echo $row['envAppName'].' '.$row['envAppVersion'];?></label>
														</div>
														
														<?php }?>
														</div>
														<div class="col-md-4">
														<h5 class="mt-3">macOS</h5>
														<hr>
														<?php $env="select * from testEnv where envAppType = 'macOS' and envStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-radio">
															<input isStandard="<?php echo $row['envIsStandard'];?>" type="radio" id="customRadio<?php echo $row['idEnv'];?>" name="EmbeddedOS[]" class="custom-control-input"  value="<?php echo $row['envAppName'].' '.$row['envAppVersion'];?>" <?php echo ($row['envIsDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="customRadio<?php echo $row['idEnv'];?>"><?php echo $row['envAppName'].' '.$row['envAppVersion'];?></label>
														</div>
														
														<?php }?>
														</div>
														<div class="col-md-4">
														<h5 class="mt-3">Linux</h5>
														<hr>
														<?php $env="select * from testEnv where envAppType = 'Linux' and envStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-radio">
															<input isStandard="<?php echo $row['envIsStandard'];?>" type="radio" id="customRadio<?php echo $row['idEnv'];?>" name="Linux[]" class="custom-control-input"  value="<?php echo $row['envAppName'].' '.$row['envAppVersion'];?>" <?php echo ($row['envIsDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="customRadio<?php echo $row['idEnv'];?>"><?php echo $row['envAppName'].' '.$row['envAppVersion'];?></label>
														</div>
														
														<?php }?>
														</div>
													</div>
													<div class="col-md-6">
														<h5 class="mt-3">Smartphones OS</h5>
														<hr>
														<div class="row">
														<?php $dapp="select distinct envAppName from testEnv where envAppType = 'applications' and envStatus = '1'";
														$rundApp=mysqli_query($conn,$dapp);  
														while ($row = $rundApp->fetch_assoc()) {
															$appNameD = $row['envAppName'];
															$envSApp="select * from testEnv where envAppName = '$appNameD'";
															$runSApp=mysqli_query($conn,$envSApp);  
															?>
													
														<div class="form-group row col-md-6">
															
																<label for="AppSelect" class="mt-2 float-left col-md-6 col-xl-6"><?php echo $row['envAppName'];?></label>
																<select name="AppSelect[]" class="form-control col-md-6 col-xl-6" id="AppSelect">
																	<option value="not" selected>I'm not sure</option>
																	<?php while ($rowS = $runSApp->fetch_assoc()) { 
																	$selected = $rowS['envIsDefault'];?>
																	<option <?php echo ($selected==1?'selected':'');?> value="<?php echo $row['envAppName']."-".$rowS['envAppVersion'];?>"><?php echo $rowS['envAppVersion'];?></option>
																	<?php }?>
																</select>
															
														</div>
														<?php } ?>
														</div>
														<div class="form-group footer">
														<h6 class="mt-3 mb-5 text-muted float-center"> Note: Where possible, all the selected hardware from below will be virtualized.</h6>
														</div>
														
													</div>
													
												</div>
												<div class="row">
													<div class="col-md-2">
														<h5 class="mt-3">Server</h5>
														<hr>
														<?php $env="select * from testHardware where hardwareType = 'Server' and hwStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" id="sHW<?php echo $row['idHW'];?>" name="ServerHW[]" class="custom-control-input" value="<?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?>"<?php echo ($row['isDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="sHW<?php echo $row['idHW'];?>"><?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?></label>
														</div>
														
														<?php }?>
														
													</div>
													<div class="col-md-3">
														<h5 class="mt-3">Desktop Computer</h5>
														<hr>
														<?php $env="select * from testHardware where hardwareType = 'Desktop' and hwStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" id="pHW<?php echo $row['idHW'];?>" name="desktopHW[]" class="custom-control-input"  value="<?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?>"<?php echo ($row['isDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="pHW<?php echo $row['idHW'];?>"><?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?></label>
														</div>
														
														<?php }?>
													</div>
													<div class="col-md-2">
														<h5 class="mt-3">Portable Computer</h5>
														<hr>
														<?php $env="select * from testHardware where hardwareType = 'Portable' and hwStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" id="kHW<?php echo $row['idHW'];?>" name="portableHW[]" class="custom-control-input"  value="<?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?>"<?php echo ($row['isDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="kHW<?php echo $row['idHW'];?>"><?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?></label>
														</div>
														
														<?php }?>
													</div>
													<div class="col-md-3">
														<h5 class="mt-3">Smartphone</h5>
														<hr>
														<?php $env="select * from testHardware where hardwareType = 'Smartphone' and hwStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" id="kiHW<?php echo $row['idHW'];?>" name="SmartphoneHW[]" class="custom-control-input"  value="<?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?>"<?php echo ($row['isDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="kiHW<?php echo $row['idHW'];?>"><?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?></label>
														</div>
														
														<?php }?>
													</div>
													<div class="col-md-2">
														<h5 class="mt-3">IoT</h5>
														<hr>
														<?php $env="select * from testHardware where hardwareType = 'IoT' and hwStatus = '1'";
														$runEnv=mysqli_query($conn,$env);  
														while ($row = $runEnv->fetch_assoc()) {?>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" id="kiHW<?php echo $row['idHW'];?>" name="SmartphoneHW[]" class="custom-control-input"  value="<?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?>"<?php echo ($row['isDefault'] == '1') ? 'checked' : ''; ?>>
															<label class="custom-control-label" for="kiHW<?php echo $row['idHW'];?>"><?php echo $row['hardwareMade'].' '.$row['hardwareModel'];?></label>
														</div>
														
														<?php }?>
													</div>
												</div>
												<br>
												<br>
												<input type="button" class="btn btn-primary float-left"onclick="breadcrubD('1')" value="Previous"/>
												<input type="button" id="n2" class="btn btn-primary float-right"onclick="breadcrubD('3')" value="Next" disabled/>
											</div>
											
											<div id="breadcrumb-3" class="card-body" style="display:none">
												<div class="row">
													<div class="col-md-12">
													<h5 class="mt-3">Select/Upload Testing Scenarios</h5>
														<hr>
														<div id="testScenariosDIV">
																												
														</div>
															<div class="form-group">
															  <label for="exampleInputFile">Upload other Test Cases     <img  src="assets/images/upload.png"/></label>
															  
															  <span id="errormsg">   No file chosen, yet</span>
															  <input hidden onchange="selectFile();" type="file" id="exampleInputFile" name="file[]" multiple accept=".xlsx,.pdf,.doc">
															</div>
													</div>
												</div>
											 <button id="submit" type="submit" class="btn btn-primary float-right" name="submit" >Submit Request</button>
											 <input type="button" class="btn btn-primary float-left"onclick="breadcrubD('2')" value="Previous"/>
                                                    
                                         
                                        </div>
										</form>
                                    </div>
                                    
                                </div>
								
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    

    <!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

<script type="text/javascript">
loading();
window.addEventListener('load', () => {
	Swal.close();
});

function FileUpload(){
	
	document.getElementById('exampleInputFile').click();
}

function selectFile(){
	
	if (document.getElementById('exampleInputFile').value){
		console.log(document.getElementById('exampleInputFile').value);
		console.log(document.getElementById('exampleInputFile').files.length);
		
		document.getElementById('errormsg').innerHTML = document.getElementById('exampleInputFile').files.length + " files uploaded";
		
	}else {
		document.getElementById('errormsg').innerHTML = "No files chosen, yet!";
	}
	
}

function testScenarios(appID,appPath,appName){
	var tsdiv = document.getElementById("testScenariosDIV");
	var div = document.createElement("div");
	div.classList.add("custom-control");
	div.classList.add("custom-checkbox");
	var input = document.createElement("input");
	input.setAttribute('type','checkbox');
	input.setAttribute('class','custom-control-input');
	input.setAttribute('name','testScenarios[]');
	input.setAttribute('value',appName);
	input.setAttribute('id','testScenarios'+appID);
	input.setAttribute('checked','true');
	var label = document.createElement("label");
	label.setAttribute('class','custom-control-label col-md-4');
	label.setAttribute('for','testScenarios'+appID);
	label.textContent = "Select default scenarios for "+appName;
	var a = document.createElement("a");
	a.setAttribute('href',appPath);
	a.setAttribute('class','btn btn-outline-secondary');
	a.setAttribute('target','_blank');
	a.textContent = "View TestCases";
	div.appendChild(input);
	div.appendChild(label);
	div.appendChild(a);
	tsdiv.appendChild(div);
}

function breadcrumb(id){
	switch(id){
		case '1':
			document.getElementById("breadcrumb-1").style.display = "block";
			document.getElementById("breadcrumb-2").style.display = "none";
			document.getElementById("breadcrumb-3").style.display = "none";
			document.getElementById("a1").style.color = "#111";
			document.getElementById("a1").style.fontWeight = "600";
			document.getElementById("a2").style.color = "#888";
			document.getElementById("a2").style.fontWeight = "normal";
			document.getElementById("a3").style.color = "#888";
			document.getElementById("a3").style.fontWeight = "normal";
			break;
		case '2':
			document.getElementById("breadcrumb-1").style.display = "none";
			document.getElementById("breadcrumb-2").style.display = "block";
			document.getElementById("breadcrumb-3").style.display = "none";
			document.getElementById("a1").style.color = "#888";
			document.getElementById("a1").style.fontWeight = "normal";
			document.getElementById("a2").style.color = "#111";
			document.getElementById("a2").style.fontWeight = "600";
			document.getElementById("a3").style.color = "#888";
			document.getElementById("a3").style.fontWeight = "normal";
			break;
		case '3':
			document.getElementById("breadcrumb-1").style.display = "none";
			document.getElementById("breadcrumb-2").style.display = "none";
			document.getElementById("breadcrumb-3").style.display = "block";
			document.getElementById("a1").style.color = "#888";
			document.getElementById("a1").style.fontWeight = "normal";
			document.getElementById("a2").style.color = "#888";
			document.getElementById("a2").style.fontWeight = "normal";
			document.getElementById("a3").style.color = "#111";
			document.getElementById("a3").style.fontWeight = "600";
			break;
		

	}

}

function breadcrubD(id){
	breadcrumb(id)
	
}

$('#setDefault').change(function() {
	
	$('#br2 input[type="radio"]').each(function() {
		if(($(this).attr('isStandard') === '1') && ($('#setDefault').is(":checked"))){
			$(this).attr('checked',true).change();		
		}else{
			$(this).attr('checked',false).change();	
		}
	});
	
});
	
	

$('#br1 input[type=checkbox]').change(function() {
	var count = 0;
	$("#testScenariosDIV").empty();
	$('#br1 input:checkbox:checked').each(function(_, value) {
		count = 1;
		var appID = $(this).attr("appid");
		var appPath = $(this).attr("scenariopath");
		var appName = $(this).attr("appname");
		testScenarios(appID,appPath,appName);
	});
	if (count == 1){$( "#n1" ).prop( "disabled", false );$( "#a2" ).attr( "onclick", null );}else{$( "#n1" ).prop( "disabled", true );$( "#n2" ).prop( "disabled", true );$( "#a2" ).attr( "onclick", "return false" );$( "#n3" ).prop( "disabled", true );$( "#a3" ).attr( "onclick", "return false" );}
	
});

$('#br2 input[type=radio]').change(function() {
	var count = 0;
	$('#br2 input:radio:checked').each(function(_, value) {
		count = 1;
	});
	if (count == 1){ $( "#n2" ).prop( "disabled", false );$( "#a3" ).attr( "onclick", null );}else{$( "#n2" ).prop( "disabled", true );$( "#a3" ).attr( "onclick", "return false" );$( "#n3" ).prop( "disabled", true );}
});



function appDisable(appId){
	var checkbox = document.getElementById("app"+appId);
	var version = document.getElementById("Version"+appId);
	var path = document.getElementById("Path"+appId);
	$('#br1 input[type=checkbox]').change(function() {
	if (checkbox.checked == true){
		version.removeAttribute("disabled");
		path.removeAttribute("disabled");
	}else{
		version.setAttribute("disabled", "disabled");
		path.setAttribute("disabled", "disabled");
		
	}
	});
}

</script>


</body>
</html>
<?php 

if (isset($_POST['submit'])){

	include('src/emailService.php');
	
	$apps =  $_POST['apps'];
	$versions = $_POST['versions'];
	$paths = $_POST['paths'];
	$userR = $_SESSION['user'];
	$emailUser = $_SESSION['emailN'];

	if (!empty($_POST['ServerOS'])){
		$ServerOS = implode(",",$_POST['ServerOS']);
	}else{$ServerOS = "Not selected";}

	if (!empty($_POST['EmbeddedOS'])){
		$EmbeddedOS = implode(",",$_POST['EmbeddedOS']);
	}else{$EmbeddedOS = "Not selected";}

	if (!empty($_POST['Linux'])){
		$Linux = implode(",",$_POST['Linux']);
	}else{$ServerOS = "Not selected";}

	$envApps = implode(",",$_POST['AppSelect']);
	
	if (!empty($_POST['testScenarios'])){
		$totalDefaultScenarios = count($_POST['testScenarios']);
		$testScenarios = implode(",",$_POST['testScenarios']);
	}else{$testScenarios = "Not selected";}

	if (!empty($_POST['ServerHW'])){
		$serverHW = implode(",",$_POST['ServerHW']);
	}else{$serverHW = "Not selected";}

	if (!empty($_POST['desktopHW'])){
		$desktopHW = implode(",",$_POST['desktopHW']);
	}else{$desktopHW = "Not selected";}

	if (!empty($_POST['portableHW'])){
		$portableHW = implode(",",$_POST['portableHW']);
	}else{$portableHW = "Not selected";}

	if (!empty($_POST['SmartphoneHW'])){
		$SmartphoneHW = implode(",",$_POST['SmartphoneHW']);
	}else{$SmartphoneHW = "Not selected";}
	
	$files = array_filter($_FILES['file']['name']); 
	$total_count = count($_FILES['file']['name']);
	$newScenarios = [];
	for( $i=0 ; $i < $total_count ; $i++ ) {
	   $tmpFilePath = $_FILES['file']['tmp_name'][$i];
	   if ($tmpFilePath != ""){
		  $newFilePath = "./assets/testcases/".$_FILES['file']['name'][$i];
		  if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			  $filename = $_FILES['file']['name'][$i];
			  array_push($newScenarios,$filename);
		  }
	   }
	}

	$tScen = $testScenarios."-AdditionalScenarios:".implode(',',$newScenarios);
	
	foreach ($apps as $key => $app){
		$toTest = "$app,$versions[$key],$paths[$key]";

		$body = '<h1> New Test request for application: <b>'.$app.'</b></h1>';
		$body .= '<p> Version: <b>'.$versions[$key].'</b></p>';
		$body .= '<p> Path to download: <b>'.$paths[$key].'</b></p>';
		$body .= '<p> User that requested: <b>'.$userR.'</b></p>';
		//sendEmail($emailTester, 'Test Request Platform - New Test Request', $body);
		//The NTR page takes a while to load because the emails take a while to get sent...

		$tEnv = "$ServerOS,$EmbeddedOS,$Linux,$envApps";
		$tHW = "$serverHW,$desktopHW,$portableHW,$SmartphoneHW";
		$result =mysqli_query($conn, "select * from testApp where appName = '$app'");
		$row = mysqli_fetch_assoc($result);
		$sla = $row['appSLA'];
		$dateSLA = date('Y-m-d', strtotime($timestamp. ' +'.$sla.' days'));
		$testInsert = "INSERT INTO testRequest (testApp, testEnv, testHW, testScenarios, testRequester, testRequesterEmail, testDateRequest, testDueDate, testStatus) VALUES ('$toTest','$tEnv','$tHW','$tScen','$userR','$emailUser','$timestamp','$dateSLA','Pending review')";
		
		if ($conn->query($testInsert) === TRUE) {
		 echo "<script type='text/javascript'>success_req();</script>"; 
		  
		} else {
		  $status = $conn->error;
		  $status = str_replace("'","`",$status);
		  echo "<script type='text/javascript'>error('".$status."');</script>";
		}
		
	}

	
};

	 if ($_SESSION['user_type'] != "2"){
echo "<script type='text/javascript'>for(let i = 1; i < 6; i++){document.getElementById('admin_area'+i).remove();}</script>";
if ($_SESSION['user_type'] == "0"){
	echo "<script type='text/javascript'>document.getElementById('test_update').remove();</script>";
}else{
	echo "<script type='text/javascript'>document.getElementById('test_request').remove();</script>";
	echo "<script type='text/javascript'>document.getElementById('test_status').remove();</script>";
}
}}?>