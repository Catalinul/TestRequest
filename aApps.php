<?php  
session_start();  
$manifest = parse_ini_file("src/manifest.ini");
$_SESSION['url'] = 'index.php';  
if(!$_SESSION['user'])  
{  
  
    header("Location: auth-signin.php"); 
}  
elseif($_SESSION['user_type'] != '2' || $_SESSION['app'] != 'TestRequest'){ 
	header("Location: src/403.html"); 
}else{

include("database/db_conection.php");  
date_default_timezone_set('Europe/Bucharest');
$timestamp = date('Y-m-d G:i:s');
$team = $_SESSION['team'];
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
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
    
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
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
	function success_app(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Your application was updated',
					 icon: 'success',
					}).then(function(){
							window.location.href = "aApps.php";
					});
		}
	function success_app_new(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Your application was created',
					 icon: 'success',
					}).then(function(){
							window.location.href = "aApps.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "aApps.php";
					});
		}
	function fail_app(){
				Swal.fire({
					 title: 'Error!',
					 text: 'Oops you did not select a file.',
					 icon: 'error',
					}).then(function(){
							window.location.href = "aApps.php";
					});
		}
	async function addApp() {
		  const {value: partsRequest} = await Swal.fire ({
			title: 'Add new application',
			html:
			  '<form id="form-0" method="post">'+
			  '<div class="form-group">'+
			  '<input id="Name" name="name" class="swal2-input" placeholder="App Name">' +
			  '<input id="sla" name="sla" class="swal2-input" placeholder="SLA Testing Days">' +
			  '<input id="placeholder" name="placeholder" class="swal2-input" placeholder="App PlaceHolder">' +
			  '</div>'+
			  '</form>',
			  preConfirm: () => {
				const name = Swal.getPopup().querySelector('#Name').value
				const sla = Swal.getPopup().querySelector('#sla').value
				const placeholder = Swal.getPopup().querySelector('#placeholder').value
				if (!name) {
				    Swal.showValidationMessage(`Please enter name`)
				}else if (!sla){
					Swal.showValidationMessage(`Please enter SLA `)
				}else if (!placeholder) {
					Swal.showValidationMessage(`Please enter placeholder`)
				}else if (!(/^\d+$/.test(sla))){
					Swal.showValidationMessage(`Please enter SLA number only`)
				}
			}
		  }).then(function(result){
						if(result.value){
							document.getElementById("form-0").submit(); 
							
						}
						});
		  
		  
		};
	$(document).ready(function() {
	    
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		var searchString = urlParams.get('search');
		if (searchString == null){
			searchString = '';
		}
		$('#tableS').DataTable({
			"oSearch": { "sSearch": searchString }
		});
 
	} );
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
                    <li id="admin_area3"  class="nav-item active">
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
                                        <h5 class="m-b-10">Admin Area</h5>
                                    </div>
                                    <ul id="bcul" class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#" style="color: #111;font-weight: 600;">Applications Administration</a></li>
										
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
								
                                <!-- [ Hover-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table id="tableS" class="table table-hover aqua-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>App Name</th>
                                                            <th>App Placeholder</th>
                                                            <th>App Scenarios Path</th>
                                                            <th>App Testing SLA Days</th>
                                                            <th>Status</th>
                                                            <th><a href="javascript:addApp()"><i class="feather icon-plus-circle"></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php $us="select * from testApp";
														$runUs=mysqli_query($conn,$us);  
														while ($row = $runUs->fetch_assoc()) { ?>
                                                        <tr class="aqua-tr">
                                                            <th scope="row"><?php echo $row['idApp'];?></th>
                                                            <td><?php echo $row['appName'];?></td>
                                                            <td><?php echo $row['appPlaceholder'];?></td>
                                                            <td><?php echo $row['appScenarioPath'];?></td>
                                                            <td><?php echo $row['appSLA'];?></td>
                                                            <td><?php switch ($row['appStatus']) {
																case 0:
																	echo "Deactivated";
																	break;
																case 1:
																	echo "Active";
																	break;
															}?></td>
															<td><i onclick="app_Edit(this)" aId="<?php echo $row['idApp'];?>" aP="<?php echo $row['appScenarioPath'];?>" aS = "<?php echo $row['appStatus'];?>" aSLA = "<?php echo $row['appSLA'];?>" aN = "<?php echo $row['appName'];?>" class="feather text-success icon-edit" style="font-size:20px; cursor: pointer;padding:0px 3px;"></i><i onclick="app_EditS(this)" aId="<?php echo $row['idApp'];?>" aP="<?php echo $row['appScenarioPath'];?>" aN = "<?php echo $row['appName'];?>" class="feather text-info icon-file-plus" style="font-size:20px; cursor: pointer;padding:0px 3px;"></i></td>
															<script type="text/javascript">
															async function app_Edit(e) {
																var aId = e.getAttribute('aId');
																var aP = e.getAttribute('aP');
																var aS = e.getAttribute('aS');
																var aN = e.getAttribute('aN');
																var aSLA = e.getAttribute('aSLA');
																switch(aS){
																	  case '0':
																		var select = '<option value="0" selected> Deactivated</option>'+
																  '<option value="1">Activated</option>'
																		break;
																	   case '1':
																		 var select = '<option value="0">Deactivated</option>'+
																  '<option value="1" selected>Activated</option>'
																		 break;
																}
															  const {value: partsRequest} = await Swal.fire ({
																title: 'Edit App '+aN,
																html:
																  '<form id="form-0" method="post">'+
																  '<div class="row"'+
																  '<div class="form-group">'+
																  '<input type="hidden" value="'+aId+'"name="idApp">'+
																  '<input type="hidden" value="save" name="save">'+
																  '<label for="sla" class="col-md-3" style="margin-top: 2rem;">SLA: </label>'+
																  '<input id="sla" name="sla" class="col-md-7 swal2-input" value="'+aSLA+'">' +
																  '<label for="status" class="col-md-3" style="margin-top: 2rem;">Status: </label>'+
																  '<select id="status" name="status" class="col-md-7 swal2-input">' +
																  select +
																  '</select>'+
																  
																  '</div>'+
																  '</div>'+
																  '</form>',
																preConfirm: () => ({
																  username: $('#idApp').val(),
																  email: $('#sPath').val()
																  
																})
															  }).then(function(result){
																			if(result.value){
																				document.getElementById("form-0").submit(); 
																				
																			}
																			});
															  
															  
															};
															async function app_EditS(e) {
																var aId = e.getAttribute('aId');
																var aP = e.getAttribute('aP');
																var aN = e.getAttribute('aN');
															
															  const {value: partsRequest} = await Swal.fire ({
																title: 'Edit scenarios for: '+aN,
																html:
																  '<form id="form-0" method="post" enctype="multipart/form-data">'+
																  '<div class="form-group">'+
																  '<input type="hidden" value="'+aId+'"name="idApp">'+
																  '<input type="hidden" value="saveS" name="saveS">'+
																  '<input type="file" id="exampleInputFile" name="file" class="swal2-file" accept=".xlsx,.pdf,.doc">' +
																  '</div>'+
																  '</form>',
																preConfirm: () => ({
																  username: $('#idApp').val(),
																  file: $('#file').val()
																  
																})
															  }).then(function(result){
																			if(result.value){
																				document.getElementById("form-0").submit(); 
																				
																			}
																			});
															  
															  
															};
															</script>
                                                        </tr>
                                                        
														<?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Hover-table ] end -->
								
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



</body>
</html>
<?php 
if (isset($_POST['save'])){
		$idApp = $_POST['idApp'];
		$sPath = $_POST['sPath'];
		$sla = $_POST['sla'];
		$status = $_POST['status'];
		
		if (!mysqli_query($conn,"UPDATE testApp SET appStatus='$status',appSLA='$sla' WHERE idApp ='$idApp'")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}else{
			echo "<script type='text/javascript'>success_app();</script>";
		}
	}
if (isset($_POST['saveS'])){
		$idApp = $_POST['idApp'];
		$tmpFilePath = $_FILES['file']['tmp_name'];
		if ($tmpFilePath != ""){
			$newFilePath = "./assets/testcases/".$_FILES['file']['name'];
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				  
			}
			$sPath = "assets/testcases/".$_FILES['file']['name'];
			$query1 = $conn->query("UPDATE testApp SET appScenarioPath='$sPath' WHERE idApp ='$idApp'");
			echo "<script type='text/javascript'>success_app();</script>";
		}else{
			
			echo "<script type='text/javascript'>fail_app();</script>";
		}
		
	}
if (isset($_POST['placeholder'])){
		$name = $_POST['name'];
		$placeholder = $_POST['placeholder'];
		$sla = $_POST['sla'];
		$sPath = "assets/testcases/".$name.".xlsx";

		if (!mysqli_query($conn,"INSERT INTO testApp (appName, appPlaceholder, appScenarioPath, appSLA, appStatus) VALUES('$name','$placeholder','$sPath','$sla','1')")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}
		echo "<script type='text/javascript'>success_app_new();</script>";
	}
if ($_SESSION['user_type'] != "2"){
echo "<script type='text/javascript'>for(let i = 1; i < 6; i++){document.getElementById('admin_area'+i).remove();}</script>";
if ($_SESSION['user_type'] == "0"){
	echo "<script type='text/javascript'>document.getElementById('test_update').remove();</script>";
}else{
	echo "<script type='text/javascript'>document.getElementById('test_request').remove();</script>";
	echo "<script type='text/javascript'>document.getElementById('test_status').remove();</script>";
}
}
	 }?>