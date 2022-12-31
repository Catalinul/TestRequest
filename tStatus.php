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
$username = $_SESSION['user'];
$emailN = $_SESSION['emailN'];
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
	function success_test(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Test was updated',
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
	async function addComm(idTest){
		const password = await Swal.fire({
			title: 'Add a comment',
			input: 'text',
			inputAttributes: {
				maxlength: 400,
				autocapitalize: 'off',
				autocorrect: 'off'
			},
			showCancelButton: true
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "GET",
					url: 'src/addComment.php?idTest='+idTest+'&username=<?php echo $username;?>&comment=' + result.value,
					cache: false,
					success: function(response) {
						Swal.fire({
							title: 'Success!',
							text: 'Your comment was added.',
							icon: 'success',
						}).then(function(){
							window.location.href = "tStatus.php";
						})
					},
					failure: function (response) {
						Swal.fire(
							"Internal Error",
							"Oops, something went wrong.", // had a missing comma
							"error"
						)
					}
				});
			}
		});
													
	}
	async function showComm(idTest){
		$.ajax({
			type: "GET",
			url: 'src/showComment.php?idTest='+idTest,
			dataType: 'json',
			cache: false,
			success: function(response) {
				console.log(response);
				
				 Swal.fire({
					title: 'Comments:',
					html: response.html,
				}) 
			},
			error: function (request, error) {
				console.log(error);
			}
		});
		
													
	}	
	$(document).ready(function() {
	    document.getElementById('tableS').style.zoom = '85%';
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		var searchString = urlParams.get('search');
		if (searchString == null){
			searchString = '';
		}
		$('#tableS').DataTable({
			"order":[[4,"desc"]],
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
					<li  id="test_status" class="nav-item active">
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
                                        <h5 class="m-b-10">Request information</h5>
                                    </div>
                                    <ul id="bcul" class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#" style="color: #111;font-weight: 600;">Testing Status</a></li>
										
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
                                                        <tr class="text-center">
                                                            <th>#</th>
                                                            <th>Application Name</th>
                                                            <th>App Version</th>
                                                            <th>Test Requester</th>
                                                            <th>Date Requested</th>
                                                            <th>Due Requested</th>
                                                            <th>Date Completed</th>
                                                            <th>Tester</th>
                                                            <th>Test Results</th>
                                                            <th>TestCases</th>
                                                            <th>Status</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php if ($_SESSION['testStatus'] =='0'){
														$us="select * from testRequest where testRequester = '$username'";}else{$us="select * from testRequest";}
														$runUs=mysqli_query($conn,$us);  
														$i=1;
														while ($row = $runUs->fetch_assoc()) { 
														$app = explode(",",$row['testApp']);
														$results = json_decode($row['testResult'],true);
														if($results){
															$pass = $results[0]['pass'];
															$fail = $results[0]['fail'];
															$na = $results[0]['na'];
															$testCases = $results[0]['testCases'];
														}
														$requester = $row['testRequester'];
														$q1="select * from users where username = '$requester'";
														$runq1=mysqli_query($conn,$q1);
														$rowq1 = $runq1->fetch_assoc();
														
														$dateTimeR = $row['testDateRequest'];
														$dt = new DateTime($dateTimeR);
														$dateR = $dt->format('Y-m-d');
														?>
                                                        <tr <?php echo ($row['testStatus'] == 'On Hold')?'class="aqua-tr blink-text"':'class="aqua-tr"' ?>>
                                                            <th scope="row"><?php echo $i;?></th>
                                                            <td><?php echo $app[0];?></td>
                                                            <td><?php echo $app[1];?></td>
                                                            <td><?php echo $rowq1['surname']." ".$rowq1['name'];?></td>
                                                            <td><?php echo $dateR;?></td>
                                                            <td><?php echo $row['testDueDate'];?></td>
                                                            <td><?php echo $row['testCompletedDate'];?></td>
                                                            <td><?php echo $row['testUser'];?></td>
                                                            <td <?php echo (!(empty($fail)))?'class="text-danger"':'class="text-success"';?>><?php if(!(empty($results))){echo "Pass:".$pass.",Fail:".$fail.",N/A:".$na;}?></td>
                                                            <td class="text-center"><?php if(!(empty($results))){?><a href="<?php echo $testCases;?>" class="btn btn-success" style="font-size:12px">Download <br/>Results</a> <?php }?></td>
                                                            <td class="text-center"><?php echo $row['testStatus'];?></td>
															<td><i style="font-size:20px;padding:0px 3px;"  rN="<?php echo $app[0];?>" rV="<?php echo $app[1];?>" rId="<?php echo $row['idTest'];?>"  class=
															"feather <?php switch ($row['testStatus']){ 
															case 'In Progress':
																$output = 'btn icon-minus-circle text-danger disabled';
															break;
															case 'On Hold':
																$output = 'btn icon-edit text-success';
															break;
															default:
																$output = 'btn icon-minus-circle text-danger disabled';
															}																		echo $output; ?>"
															 <?php echo ($row['testStatus'] == 'On Hold')?'onclick="Edit(this)"':'';?> ></i><i title="Add Comment" onclick="addComm('<?php echo $row['idTest'];?>')" class="feather btn icon-message-circle text-info" style="font-size:20px; cursor: pointer;padding:0px 3px;"></i><i title="View Comments" onclick="showComm('<?php echo $row['idTest'];?>')" class="feather btn icon-message-square text-info" style="font-size:20px; cursor: pointer;padding:0px 3px;"></i></td>
															<script type="text/javascript">
															async function Edit(e) {
																var rId = e.getAttribute('rId');
																var rN = e.getAttribute('rN');
																var rV = e.getAttribute('rV');
																
															  const {value: test} = await Swal.fire ({
																title: 'Respond to request',
																html:
																  '<form id="form-1" method="post" enctype="multipart/form-data">'+
																  '<div class="form-group text-left">'+
																  '<input type="hidden" value="'+rId+'"name="idRF">'+
																  '<input type="hidden" value="'+rN+'"name="rN">'+
																  '<input type="hidden" value="'+rV+'"name="rV">'+
																  '<input type="hidden" value="finish" name="finish">'+
																 
																  '<div class="form-group">'+
																  '<label for"status" class="mt-4 float-left col-md-5">Change status</label>'+
																  '<select id="status" name="status" class="swal2-select col-md-5">' +
																  '<option value="In Progress">Test Hotfix</option>'+
																  '<option value="Completed">Complete request</option>'+
																  '</select>'+
																  '</div>'+
																  '</div>'+
																  '</form>',
																confirmButtonText: 'Next',
																preConfirm: () => {
																  															  
																}
															  }).then(function(result){
																if(result.value){
																	var status = $('#status').val();
																	if (status == "In Progress"){
																	const {value: progress} = Swal.fire ({
																	title: 'Set new testing information',
																	html:
																	  '<form id="form-2" method="post" enctype="multipart/form-data">'+
																	  '<div class="form-group text-left">'+
																	  '<input type="hidden" value="'+rId+'"name="idRF">'+
																	  '<input type="hidden" value="'+status+'"name="statusT">'+
																	  '<input type="hidden" value="'+rN+'"name="appName">'+
																	  '<input type="hidden" value="continue" name="continue">'+
																	  '<div class="row">'+
																	  '<div class="form-label-group col-lg-4 text-center">'+
																	  '<label for"version" >Version </label>'+
																	   '<input type="input" id="version" name="version" class="form-control" required>' +
																	  '</div>'+
																	  '<div class="form-label-group col-lg-8 text-center">'+
																	  '<label for"path">Path </label>'+
																	   '<input type="input" id="path" name="path" class="form-control" required>' +
																	  '</div>'+
																	  '</div>'+
																	  '</div>'+
																	  '</form>',
																	confirmButtonText: 'Submit information',
																	preConfirm: () => {
																	  const version = Swal.getPopup().querySelector('#version').value
																	  const path = Swal.getPopup().querySelector('#path').value
																	  if (!path) {
																		  Swal.showValidationMessage(`Please enter PATH to download the new version`)
																	  }else if (!version) {
																		  Swal.showValidationMessage(`Please enter what version to download`)
																	  }
																	  }
																	
																	  }).then(function(result){
																					if(result.value){
																						document.getElementById("form-2").submit(); 
																						
																					}
																		});
																		 
																
																	}else{
																	document.getElementById("form-1").submit();
																	}
																};
																});
															};
															</script>
                                                        </tr>
                                                        
														<?php $i++;} ?>
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

include('src/emailService.php');

if (isset($_POST['continue'])){
		$idR = $_POST['idRF'];
		$status = $_POST['statusT'];
		$appName = $_POST['appName'];
		$version = $_POST['version'];
		$path = $_POST['path'];
		$array = array($appName,$version,$path);
		$testApp = implode(",",$array);
		$result =mysqli_query($conn, "select * from testApp where appName = '$appName'");
		$row = mysqli_fetch_assoc($result);
		$sla = $row['appSLA'];
		$dateSLA = date('Y-m-d', strtotime($timestamp. ' +'.$sla.' days'));
		
		if (!mysqli_query($conn,"UPDATE testRequest SET testApp='$testApp',testStatus='$status',testModifiedDate='$timestamp',testDueDate='$dateSLA', testResult=NULL WHERE idTest ='$idR'")){
			$st = mysqli_error($conn);
			$st = str_replace("'","`",$st);
			echo "<script type='text/javascript'>error('".$st."');</script>";
		}else{
			echo "<script type='text/javascript'>success_test();</script>";
		}
		$body = '<h1> New <b>FIX</b> Test request for application: <b>'.$appName.'</b></h1>';
		$body .= '<p> Version: <b>'.$version.'</b></p>';
		$body .= '<p> Path to download: <b>'.$path.'</b></p>';
		$body .= '<p> User that requested: <b>'.$username.'</b></p>';
		sendEmail($emailTester, 'Test Request Platform - New Fix Test Request', $body);
	}

if (isset($_POST['finish'])){
		$idR = $_POST['idRF'];
		$appN = $_POST['rN'];
		$appV = $_POST['rV'];
		$status = $_POST['status'];
		
		if (!mysqli_query($conn,"UPDATE testRequest SET testStatus='$status',testCompletedDate='$timestamp',testModifiedDate='$timestamp' WHERE idTest ='$idR'")){
			$st = mysqli_error($conn);
			$st = str_replace("'","`",$st);
			echo "<script type='text/javascript'>error('".$st."');</script>";
		}else{
			echo "<script type='text/javascript'>success_test();</script>";
		}
		$body = "<h2> Testing for app ".$appN.", version ".$appV." is Completed </h2>";
		//aici ar trebui sa fie un DL pentru echipa de testare
		//sendEmail($emailTester, 'Test Request Platform - Test Request Update', $body); 
	}

if ($_SESSION['user_type'] != "2"){ //admin
echo "<script type='text/javascript'>for(let i = 1; i < 6; i++){document.getElementById('admin_area'+i).remove();}</script>";
if ($_SESSION['user_type'] == "0"){ //requester
	echo "<script type='text/javascript'>document.getElementById('test_update').remove();</script>";
}else{ //tester
	echo "<script type='text/javascript'>document.getElementById('test_request').remove();</script>";
	echo "<script type='text/javascript'>document.getElementById('test_status').remove();</script>";
}}
	 }?>