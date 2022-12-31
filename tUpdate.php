<?php  
session_start();  
$manifest = parse_ini_file("src/manifest.ini");
$_SESSION['url'] = 'index.php';  
if(!$_SESSION['user'])  
{  
  
    header("Location: auth-signin.php"); 
}  
elseif($_SESSION['user_type'] == '0' || $_SESSION['app'] != 'TestRequest'){ 
	header("Location: src/403.html"); 
}else{

include("database/db_conection.php");  
date_default_timezone_set('Europe/Bucharest');
$timestamp = date('Y-m-d G:i:s');
$username = $_SESSION['user'];
$team = $_SESSION['team'];
$emailToNotify = $_SESSION['emailN'];
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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles"> <!--sweeat alert-->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/> <!--tabelele sunt facute cu jquerry -->
    
	
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
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
							window.location.href = "tUpdate.php";
					});
		}
	function start_creation(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Lab creation started',
					 icon: 'success',
					}).then(function(){
							window.location.href = "tUpdate.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "tUpdate.php";
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
							window.location.href = "tUpdate.php";
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
	async function showInfo(idTest){
		$.ajax({
			type: "GET",
			url: 'src/info.php?idTest='+idTest,
			dataType: 'json',
			cache: false,
			success: function(response) {
				console.log(response);
				
				 Swal.fire({
					title: 'Request information:',
					html: response.html,
				}) 
			},
			error: function (request, error) {
				console.log(error);
			}
		});
		
													
	}
	$(document).ready(function() {
	    document.getElementById('tableS').style.zoom = '90%';
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
                    <li  id="test_update" class="nav-item active">
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
                                                        <tr>
                                                            <th>#</th>
                                                            <th>App Name</th>
                                                            <th>App Vers</th>
                                                            <th>Path for Download</th>
                                                            <th>Tester</th>
                                                            <th>Scenarios</th>
                                                            <th>Status</th>
                                                            <th>#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php $us="select * from testRequest where testStatus != 'Completed' ORDER BY testDueDate ASC";
														$runUs=mysqli_query($conn,$us);  
														$i=1;
														while ($row = $runUs->fetch_assoc()) { 
														$app = explode(",",$row['testApp']);
														$sql1 = "select * from testApp where appName = '$app[0]'";
														$runs1 = mysqli_query($conn,$sql1);
														$rows1 = $runs1->fetch_assoc();
														
														?>
                                                        <tr class="aqua-tr">
                                                            <th scope="row"><?php echo $i;?></th>
                                                            <td style="word-wrap: break-word;min-width: 50px;max-width: 100px;white-space: normal !important;"><?php echo $app[0];?></td>
                                                            <td style="word-wrap: break-word;min-width: 50px;max-width: 100px;white-space: normal !important;"><?php echo $app[1];?></td>
                                                            <td style="word-wrap: break-word;min-width: 50px;max-width: 100px;white-space: normal !important;"><?php echo $app[2];?></td>
                                                            <td><?php echo $row['testUser'];?></td>
                                                            <td><?php echo (strpos($row['testScenarios'],$app[0])!== false)?'<a class="text-primary stretched-link" target="_blank" style="cursor: pointer;" href="'.$rows1['appScenarioPath'].'">Standard</a>':''; preg_match('/AdditionalScenarios:(.*)/',$row['testScenarios'], $matches); echo (!empty($matches[1]))?' <a class="text-warning stretched-link" target="_blank" style="cursor: pointer;"  href="assets/testcases/'.$matches[1].'">Additional</a>':'';?></td>
                                                            <td id="st<?php echo $i;?>"><?php echo $row['testStatus'];?></td>
															<td style="font-size:20px"><i onclick="testR(this)" rId="<?php echo $row['idTest'];?>"  tS="<?php echo $row['testStatus'];?>" rd="<?php echo $row['testDueDate'];?>" ue="<?php echo $row['testRequesterEmail'];?>" appN = "<?php echo $app[0];?>" appV="<?php echo $app[1];?>" class="feather <?php 
															$sts = $row['testStatus'];
															switch ($row['testStatus']){ 
															case 'Pending review':
																$output = 'icon-user-plus text-warning';
															break;
															case 'In Progress':
																$output = 'icon-file-plus text-success';
															break;
															case 'On Hold':
																$output = 'icon-lock text-danger';
															break;
															default:
																$output = 'icon-alert-circle text-danger';
															}
															echo $output; ?> px-2" <?php echo (($row['testStatus'] == 'In Progress') || ($row['testStatus'] == 'Pending review'))?'style="cursor: pointer;"':'disabled';?> id="is<?php echo $i;?>"></i><i title="Show info"  onclick="showInfo('<?php echo $row['idTest'];?>')" class="feather icon-info text-info px-2" style="cursor: pointer"></i><i title="Add Comment"  onclick="addComm('<?php echo $row['idTest'];?>')" class="feather icon-message-circle text-info px-2" style="cursor: pointer"></i><i title="Show Comments"  onclick="showComm('<?php echo $row['idTest'];?>')" class="feather icon-message-square text-info px-2" style="cursor: pointer"></i><i id="bc<?php echo $i;?>"  onclick="create(this)" tS="<?php echo $row['testStatus'];?>" rId="<?php echo $row['idTest'];?>"  style="cursor: pointer;"></i></td>
															
															
															<script type="text/javascript">
															async function testR(e) {
																var rId = e.getAttribute('rId');
																var tS = e.getAttribute('tS');
																var rd = e.getAttribute('rd');
																var ue = e.getAttribute('ue');
																var appN = e.getAttribute('appN');
																var appV = e.getAttribute('appV');
																switch(tS){
																	  case 'Pending review':
																		const {value: pending} = await Swal.fire ({
																title: 'Start Testing ',
																html:
																  '<form id="form-0" method="post">'+
																  '<div class="form-group text-left">'+
																  '<input type="hidden" value="'+rId+'"name="idR">'+
																  '<input type="hidden" value="'+ue+'"name="ue">'+
																  '<input type="hidden" value="'+appN+'"name="appN">'+
																  '<input type="hidden" value="'+appV+'"name="appV">'+
																  '<input type="hidden" value="start" name="start">'+
																  '<div class="form-group">'+
																  '<label for"date" class="mt-4 float-left col-md-4">Due Date </label>'+
																  '<input id="date" type="date" value="'+rd+'" name="date" class="swal2-select col-md-4">'+
																  '</div>'+
																  '</div>'+
																  '</form>',
																preConfirm: () => ({
																  username: $('#date').val()
																  
																})
															  }).then(function(result){
																			if(result.value){
																				document.getElementById("form-0").submit(); 
																				
																			}
																			});
																		break;
																	   case 'In Progress':
																		 const {value: progress} = await Swal.fire ({
																title: 'Upload results',
																html:
																  '<form id="form-1" method="post" enctype="multipart/form-data">'+
																  '<div class="form-group text-left">'+
																  '<input type="hidden" value="'+rId+'"name="idRF">'+
																  '<input type="hidden" value="'+ue+'"name="ue">'+
																  '<input type="hidden" value="'+appN+'"name="appN">'+
																  '<input type="hidden" value="'+appV+'"name="appV">'+
																  '<input type="hidden" value="finish" name="finish">'+
																  '<div class="row">'+
																  '<div class="form-group">'+
																  '<label for"scenarios" class="mt-4 float-left col-md-3">Results </label>'+
																   '<input type="file" id="scenarios" name="file" class="swal2-file col-md-7" accept=".xlsx,.pdf,.doc" required>' +
																  '</div>'+
																  '<div class="form-label-group col-lg-4 text-center">'+
																  '<label for"pass" >Pass </label>'+
																   '<input type="input" id="pass" name="pass" class="form-control" required>' +
																  '</div>'+
																  '<div class="form-label-group col-lg-4 text-center">'+
																  '<label for"fail">Fail </label>'+
																   '<input type="input" id="fail" name="fail" class="form-control" required>' +
																  '</div>'+
																  '<div class="form-label-group col-lg-4 text-center">'+
																  '<label for"na">N/A </label>'+
																   '<input type="input" id="na" name="na" class="form-control" required>' +
																  '</div>'+
																  '</div>'+
																  '<div class="form-group">'+
																  '<label for"status" class="mt-4 float-left col-md-3">Status </label>'+
																  '<select id="status" name="status" class="swal2-select col-md-4">' +
																  '<option value="On Hold">On Hold</option>'+
																  '<option value="Completed">Completed</option>'+
																  '</select>'+
																  '</div>'+
																  '</div>'+
																  '</form>',
																preConfirm: () => {
																  const pass = Swal.getPopup().querySelector('#pass').value
																  const fail = Swal.getPopup().querySelector('#fail').value
																  const na = Swal.getPopup().querySelector('#na').value
																  const file = Swal.getPopup().querySelector('#scenarios').value
																  if (!pass) {
																	  Swal.showValidationMessage(`Please enter PASS results`)
																  }else if (!fail) {
																	  Swal.showValidationMessage(`Please enter FAIL results`)
																  }else if (!na) {
																	  Swal.showValidationMessage(`Please enter NA results`)
																  }else if (!file) {
																	  Swal.showValidationMessage(`Please upload results`)
																  }
																}
															  }).then(function(result){
																			if(result.value){
																				document.getElementById("form-1").submit(); 
																				
																			}
																			});
																		 break;
																}
																
																
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


if (isset($_POST['start'])){
		$idR = $_POST['idR'];
		$ue = $_POST['ue'];
		$date = $_POST['date'];
		if (!mysqli_query($conn,"UPDATE testRequest SET testUser='$username',testDueDate='$date',testStatus='In Progress', testModifiedDate='$timestamp' WHERE idTest ='$idR'")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo ("Error description: ".mysqli_error($conn));
			echo "<script type='text/javascript'>error('".$status."');</script>";
			
		}else{
			echo "<script type='text/javascript'>success_test();</script>";
		}
		
	}
if (isset($_POST['finish'])){
		$idR = $_POST['idRF'];
		$ue = $_POST['ue'];
		$appN = $_POST['appN'];
		$appV = $_POST['appV'];
		$pass = $_POST['pass'];
		$fail = $_POST['fail'];
		$na = $_POST['na'];
		$na = $_POST['na'];
		$testS = $_POST['status'];
		$tmpFilePath = $_FILES['file']['tmp_name'];
		
		if ($tmpFilePath != ""){
			$newFilePath = "./assets/testResult/".$_FILES['file']['name'];
			
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				$sPath = "assets/testResult/".$_FILES['file']['name'];
				$data[0]['pass'] = $pass;
				$data[0]['fail'] = $fail;
				$data[0]['na'] = $na;
				$data[0]['testCases'] = $sPath;
				$testResult = json_encode($data);
				if ($testS == 'Completed'){
					$sql = "UPDATE testRequest SET testStatus='$testS', testModifiedDate='$timestamp', testResult='$testResult',testCompletedDate='$timestamp' WHERE idTest ='$idR'";
					$body = "<h2> Testing for app ".$appN.", version ".$appV." is Completed </h2>";
					$body .= "<h2> Results: pass - ".$pass.", fail - ".$fail.", N/A - ".$na."</h2>";
					$body .= "<h4> <a href=http://".$_SERVER['HTTP_HOST']."/".$sPath.">Download results</a>  </h4>";

				}else{
					$sql = "UPDATE testRequest SET testStatus='$testS', testModifiedDate='$timestamp', testResult='$testResult' WHERE idTest ='$idR'";
					$body = "<h2> Testing for app ".$appN.", version ".$appV." is ".$testS." </h2>";
					$body .= "<h2> Results: pass - ".$pass.", fail - ".$fail.", N/A - ".$na."</h2>";
					$body .= "<h4> <a href=http://".$_SERVER['HTTP_HOST']."/".$sPath.">Download results</a>  </h4>";
				}
				if (!mysqli_query($conn,$sql)){
					$status = mysqli_error($conn);
					$status = str_replace("'","`",$status);
					echo ("Error description: ".mysqli_error($conn));
					echo "<script type='text/javascript'>error('".$status."');</script>";
					
				}else{
					echo "<script type='text/javascript'>success_test();</script>";
				}
				//sendEmail($ue, 'Test Request Platform - Test Request Update', $body);
			}else{
				echo "test file name:".$newFilePath;
			}
		}
		
		
		
		
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