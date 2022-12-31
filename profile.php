<?php  
session_start();  
$manifest = parse_ini_file("src/manifest.ini");
$_SESSION['url'] = 'index.php';  
if(!$_SESSION['user'])  
{  
  
    header("Location: auth-signin.php");
	
}
elseif($_SESSION['app'] != 'TestRequest'){ 
	header("Location: src/403.html"); 
}else{
include("database/db_conection.php");  
date_default_timezone_set('Europe/Bucharest');
$timestamp = date('Y-m-d G:i:s');
$userID = $_SESSION['userID'];
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
	function success(){
				Swal.fire({
					 title: 'Your picture was changed!',
					 text: 'You will now be sign-out',
					 icon: 'success',
					}).then(function(){
							window.location.href = "logout.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "profile.php";
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
                                        <h5 class="m-b-10">Profile Area</h5>
                                    </div>
                                    <ul id="bcul" class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#" style="color: #111;font-weight: 600;">Profile Settings</a></li>
										
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
										<div class="card-body">
											<div class="e-profile">
											  <div class="row">
												<div class="col-12 col-sm-auto mb-3">
												  <div class="mx-auto" style="width: 140px;">
													<div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; width: 150px; background-color: rgb(233, 236, 239);">
													 <img src="<?php echo $_SESSION['icon'];?>" class="d-flex justify-content-center align-items-center rounded" style="height:inherit;width:inherit" alt="User-Profile-Image">
													</div>
												  </div>
												</div>

												<div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
												  <div class="text-center text-sm-left mb-2 mb-sm-0">
													<h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $_SESSION['surname']." ".$_SESSION['name']?></h4>
													<p class="mb-0"><?php echo $_SESSION['email'];?></p>
													<br>

													<div class="mt-2">
													<form name="chPhoto" method="post" enctype="multipart/form-data">
													  <input hidden onchange="chPhoto.submit()" type="file" id="exampleInputFile" name="file[]" accept=".jpeg,.png,.jpg">
													  <input type="hidden" name="chhPhoto" value="1"/>
													  <button class="btn btn-primary" type="button" name="change" onclick="FileUpload()">
														<i class="fa fa-fw fa-camera"></i>
														<span>Change Photo</span>
													  </button>
													</form>
													</div>

												  </div>

												  <div class="text-center text-sm-right">
													<span class="badge badge-secondary"><?php switch ($_SESSION['user_type']) {
																case 0:
																	echo "Requester";
																	break;
																case 1:
																	echo "Tester";
																	break;
																case 2:
																	echo "Administrator";
																	break;
															}?></span>
													
												  </div>
												</div>
											  </div>
											 
											  <div class="tab-content pt-3">
												<div class="tab-pane active">
												  <form class="form" method="post">
													<div class="row">
													  <div class="col">
														<div class="row">
														  <div class="col">
															<div class="form-group">
															  <label>Username</label>
															  <input class="form-control" type="text" name="username" placeholder="johnny.s" value="<?php echo $_SESSION['user'];?>">
															</div>
														  </div>
														  <div class="col">
															<div class="form-group">
															  <label>Email</label>
															  <input name="email" class="form-control" type="text" placeholder="user@example.com" value="<?php echo $_SESSION['email'];?>">
															</div>
														  </div>
														</div>
														
													  </div>
													</div>
													<div class="row">
													  <div class="col-12 col-sm-12 mb-3">
														<div class="mb-2"><b>Change Password</b></div>
														<div class="row">
														  
														  <div class="col">
															<div class="form-group">
															  <label>New Password</label>
															  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Should contain at least one lower case, one digit and minimum length:8"  id="newPassword" name="newPassword" class="form-control" type="password" placeholder="••••••">
															</div>
														  </div>
														  <div class="col">
															<div class="form-group">
															  <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
															  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="confirmPassword" name="confirmPassword" class="form-control" type="password" placeholder="••••••"></div>
														  </div>
														  
														</div>
														<div class="row">
														<p id="error" class="mb-2 text-danger"></p>
														</div>
													  </div>
													  
													</div>
													<div class="row">
													<div class="col-12 col-sm-5 mb-3">
														<div class="row">
														  <div class="col">
															<div class="form-group">
															  <label>Email for notifications</label>
															  <input name="email" class="form-control" type="email" placeholder="user@example.com" value="<?php echo $_SESSION['emailN'];?>">
															</div>
														  </div>
														  <div class="col" style="margin-top: 2.3rem!important;">
															
															<div class="custom-controls-stacked px-2">
															  <div class="custom-control custom-checkbox">
																<input type="checkbox" name="receiveNotifications" class="custom-control-input" id="notifications-blog" value="1" <?php echo ($_SESSION['notification'] == 1)?'checked':'';?>>
																<label class="custom-control-label" for="notifications-blog">Subscribe for status update</label>
															  </div>
															  
															</div>
														  </div>
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col d-flex justify-content-end">
														<input class="btn btn-primary" name="submit" type="submit" value="Save Changes" />
													  </div>
													</div>
												  </form>

												</div>
											  </div>
									
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

function FileUpload(){
	
	document.getElementById('exampleInputFile').click();
}

$('#confirmPassword').on('keyup', function () {
  if ($('#newPassword').val() == $('#confirmPassword').val()) {
    $('#error').html('');
  } else 
    $('#error').html('Passwords do not match');
});







</script>


</body>
</html>
<?php 
if (isset($_POST['chhPhoto'])){
	
	
	$files = array_filter($_FILES['file']['name']); 
	$total_count = count($_FILES['file']['name']);
	$newIcon = [];
	
	for( $i=0 ; $i < $total_count ; $i++ ) {
	   $tmpFilePath = $_FILES['file']['tmp_name'][$i];
	   if ($tmpFilePath != ""){
		  $newFilePath = "./assets/images/user/".$_FILES['file']['name'][$i];
		  if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			  $newFilePath = "./assets/images/user/".$_FILES['file']['name'][$i];
			  array_push($newIcon,$newFilePath);
		  }
	   }
	}
	$iconName = implode(',',$newIcon);
	
	if (!mysqli_query($conn,"UPDATE users SET icon='$iconName' WHERE idUser ='$userID'")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}else{
			echo "<script type='text/javascript'>success();</script>";
		}
}
	
if (isset($_POST['username'])){
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$emailN = $_POST['emailN'];
	$pass = $_POST['confirmPassword'];
	if($_POST['receiveNotifications'] == 1){
		$rN = 1;
	}else{
		$rN = 0;
	}
	if(!empty($pass)){
		$crypted = password_hash($pass, PASSWORD_DEFAULT); 
		$crypted = substr($crypted,7);
		
		$sql = "Update users set password = '$crypted', username = '$username', email='$email', emailN='$emailN', receiveEmail='$rN' WHERE idUser = '$userID'";
		
	}else{
		
		$sql = "Update users set username = '$username', email='$email', emailN='$emailN', receiveEmail='$rN' WHERE idUser = '$userID'";
	}
	
	if (!mysqli_query($conn,$sql)){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}else{
			echo "<script type='text/javascript'>success();</script>";
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
}}?>