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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
	<script type="text/javascript">
	function success_user(){
				Swal.fire({
					 title: 'Yuppi!',
					 text: 'Your user was updated.',
					 icon: 'success',
					}).then(function(){
							window.location.href = "aUsers.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "aUsers.php";
					});
		}
	async function addUser() {
		  const {value: partsRequest} = await Swal.fire ({
			title: 'Add new user',
			html:
			  '<form id="form-0" method="post">'+
			  '<div class="form-group">'+
			  '<input id="Name" name="name" class="swal2-input" placeholder="first name">' +
			  '<input id="Surname" name="surname" class="swal2-input" placeholder="last name">' +
			  '<input id="Username" name="username" class="swal2-input" placeholder="username">' +
			  '<input id="Email" name="email" class="swal2-input" placeholder="email">' +
			  '<select id="role" name="role" class="swal2-input">' +
			  '<option value="0">Requester</option>'+
			  '<option value="1">Tester</option>'+
			  '<option value="2">Admin</option>'+
			  '</select>'+
			  '<input id="Password" name="password" class="swal2-input" placeholder="password">' +
			  '</div>'+
			  '</form>',
			preConfirm: () => ({
			  username: $('#username').val(),  //verifc ca inputul nu e gol
			  email: $('#email').val()
			  
			})
		  }).then(function(result){
						if(result.value){
							document.getElementById("form-0").submit(); }
						});
		};
		
		async function change(idUser){
												const password = await Swal.fire({
														  title: 'Type new password',
														  input: 'password',
														  inputPlaceholder: 'Minimum 8 characters',
														  inputAttributes: {
															maxlength: 20,
															autocapitalize: 'off',
															autocorrect: 'off'
														  },
														  showCancelButton: true,
														  preConfirm: (password) => {
															var re = /^(?=.*\d)(?=.*[.!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
															console.log(password);
															console.log(re.test(password));
															if(!re.test(password)){
																Swal.showValidationMessage(`Password must contain minimum 8 chars which contain at least one numeric digit and a special character`)	
															}
																}
														}).then((result) => {
														  if (result.value) {
															$.ajax({
																type: "GET",
																url: 'src/changePassword.php?userId='+idUser+'&password=' + result.value,
																cache: false,
																success: function(response) {
																	Swal.fire({
																	 title: 'Success!',
																	 text: 'Your password was changed.',
																	 icon: 'success',
																	}).then(function(){
																			window.location.href = "aUsers.php";
																	})
																},
																failure: function (response) {
																	Swal.fire(
																	"Internal Error",
																	"Oops, your password was not changed.", // had a missing comma
																	"error"
																	)
																}
															});
														  }
														});
													
												}
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
	<style>
		hr.solid {
			border-top: 3px solid #bbb;
		}
		.swal2-actions {
			z-index: 0;
		}
	</style>

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
					<li id="admin_area2"  class="nav-item active">
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
                                        <h5 class="m-b-10">Admin Area</h5>
                                    </div>
                                    <ul id="bcul" class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#" style="color: #111;font-weight: 600;">User Administration</a></li>
										
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
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>User Rights</th>
                                                            <th>Appication Rights</th>
                                                            <th>Is Admin Requester</th>
                                                            <th>Receive Email</th>
                                                            <th>Status</th>
                                                            <th>Change Password</th>
															<th><a href="javascript:addUser()"><i class="feather icon-user-plus"></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
														<?php $us="select * from users";
														$runUs=mysqli_query($conn,$us);  
														$i=1;
														while ($row = $runUs->fetch_assoc()) { 														?>
                                                        <tr class="aqua-tr">
                                                            <th scope="row"><?php echo $i;?></th>
                                                            <td><?php echo $row['surname'];?></td>
                                                            <td><?php echo $row['name'];?></td>
                                                            <td><?php echo $row['username'];?></td>
                                                            <td><?php echo $row['email'];?></td>
                                                            <td><?php switch ($row['rights']) {
																case 0:
																	echo "Requester";
																	break;
																case 1:
																	echo "Tester";
																	break;
																case 2:
																	echo "Admin";
																	break;
															}?></td>
															<td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space: normal !important;"><?php 
															$TAPP = $row['testApp'];
															$aps = [];
															$apps="select * from testApp where idApp IN ($TAPP)";
															$run=mysqli_query($conn,$apps);  
															while($row1 = $run->fetch_assoc()){
															$AplName = $row1['appName'];
															array_push($aps,$AplName);
															} $allApps = implode(",",$aps);
															  echo $allApps;?></td>
															<td><?php echo ($row['testStatusAll'] == '1')?'Yes':'No';?></td>
															<td><?php echo ($row['receiveEmail'] == '1')?'Yes':'No';?></td>
															<td><?php echo ($row['status'] == '1')?'Enabled':'Disabled';?></td>
															<td><a href="javascript:change('<?php echo $row['idUser'];?>')">change</a></td>
															<td><i onclick="user_Edit<?php echo $i;?>(this)" uId="<?php echo $row['idUser'];?>" uSt="<?php echo $row['status'];?>" uSA="<?php echo $row['testStatusAll'];?>" uRA="<?php echo $row['receiveEmail'];?>" uS="<?php echo $row['rights'];?>" uA="<?php echo $allApps;?>" uUs = "<?php echo $row['username'];?>" class="feather text-success icon-edit"></td>
															<script type="text/javascript">
															async function user_Edit<?php echo $i;?>(e) {
																$(function() {
																	$('#multiselectapps<?php echo $i;?>').multiselect({
																		enableClickableOptGroups: true,
																		includeSelectAllOption:false,
																		nonSelectedText: 'Select applications'
																	});
																});
																var uId = e.getAttribute('uId');
																var uS = e.getAttribute('uS');
																var uA = e.getAttribute('uA');
																var uUs = e.getAttribute('uUs');
																var uSt = e.getAttribute('uSt');
																var uSA = e.getAttribute('uSA');
																var uRA = e.getAttribute('uRA');
																
																switch(uS){
																	  case '0':
																		var select = '<option value="0" selected> Requester</option>'+
																  '<option value="1">Tester</option>'+
																  '<option value="2">Admin</option>'
																		break;
																	   case '1':
																		 var select = '<option value="0">Requester</option>'+
																  '<option value="1" selected>Tester</option>'+
																  '<option value="2">Admin</option>'
																		 break;
																		case '2':
																		 var select = '<option value="0">Requester</option>'+
																  '<option value="1">Tester</option>'+
																  '<option value="2" selected>Admin</option>'
																		 break;
																}
																switch(uSt){
																	  case '0':
																		var selectS = '<option value="0" selected>Yes</option>'+
																  '<option value="1">No</option>'
																		break;
																	   case '1':
																		 var selectS = '<option value="0">Yes</option>'+
																  '<option value="1" selected>No</option>'
																		 break;
																}
																switch(uSA){
																	  case '0':
																		var selectSA = '<option value="0" selected>No</option>'+
																  '<option value="1">Yes</option>'
																		break;
																	   case '1':
																		 var selectSA = '<option value="0">No</option>'+
																  '<option value="1" selected>Yes</option>'
																		 break;
																}
																switch(uRA){
																	  case '0':
																		var selectRA = '<option value="0" selected>No</option>'+
																  '<option value="1">Yes</option>'
																		break;
																	   case '1':
																		 var selectRA = '<option value="0">No</option>'+
																  '<option value="1" selected>Yes</option>'
																		 break;
																}
																
															  await Swal.fire ({
																title: 'Edit user '+uUs,
																html:
																  '<form id="form-0" method="post">'+
																  '<div class="form-group form-inline">'+
																  '<div class="col-md-6">'+
																  '<input type="hidden" value="'+uId+'"name="idUser">'+
																  '<input type="hidden" value="save" name="save">'+
																  '<label for="role" style="justify-content: left;font-size: 15px;font-weight: bold;">Change role</label>'+
																  '</div>'+
																  '<div class="col-md-6">'+
																  '<select id="role" name="role" class="swal2-select">' +
																  select +
																  '</select>'+
																  '</div></div>'+
																  '<hr class="solid">'+
																  '<div class="form-group form-inline">'+
																  '<div class="col-md-6">'+
																  '<label for="status" style="justify-content: left;font-size: 15px;font-weight: bold;">User disabled</label>'+
																  '</div>'+
																  '<div class="col-md-6">'+
																  '<select id="status" name="status" class="swal2-select">' +
																  selectS +
																  '</select>'+
																  '</div></div>'+
																  '<hr class="solid">'+
																  '<div class="form-group form-inline">'+
																  '<div class="col-md-6">'+
																  '<label for="status" style="justify-content: left;font-size: 15px;font-weight: bold;">Give admin requester</label>'+
																  '</div>'+
																  '<div class="col-md-6">'+
																  '<select id="statusAll" name="statusAll" class="swal2-select" >' +
																  selectSA +
																  '</select>'+
																  '</div></div>'+
																  '<hr class="solid">'+
																  '<div class="form-group form-inline">'+
																  '<div class="col-md-6">'+
																  '<label for="status" style="justify-content: left;font-size: 15px;font-weight: bold;">Receive notifications</label>'+
																  '</div>'+
																  '<div class="col-md-6">'+
																  '<select id="receiveEmail" name="receiveEmail" class="swal2-select" >' +
																  selectRA +
																  '</select>'+
																  '</div></div>'+
																  '<hr class="solid">'+
																  '<div class="form-group form-inline">'+
																  '<div class="col-md-6">'+
																  '<label for="status" style="justify-content: left;font-size: 15px;font-weight: bold;">Select Application rights</label>'+
																  '</div>'+
																  '<div class="col-md-6">'+
																  '<select id="multiselectapps<?php echo $i;?>" name="someaps[]" class="swal2-select" multiple="multiple">'+
																  <?php $appss="select * from testApp where appStatus = '1'";
															$run2=mysqli_query($conn,$appss);  
															while($row2 = $run2->fetch_assoc()){
															$AppsName = $row2['appName'];
															$AppsId = $row2['idApp'];
															$arrayAps = explode(',',$allApps);
															
															echo "'";
															echo '<option value="'.$AppsId.'"';
															if(in_array($AppsName,$arrayAps)){
																echo ' selected';
															}
															echo '>'.$AppsName.'</option>';
															echo "'+\n";
															}?>
																  '</select>'+
																  '</div></div>'+
																  '</form>',
																preConfirm: () => ({
																  username: $('#username').val(),
																  email: $('#email').val()
																  
																})
															  }).then(function(result){
																			if(result.value){
																				document.getElementById("form-0").submit(); 
																				
																			}
																			});
															  
															  
															};
															</script>
                                                        </tr>
                                                        
														<?php  $i++;} ?>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


</body>
</html>
<?php 
if (isset($_POST['save'])){
		$idUser = $_POST['idUser'];
		$role = $_POST['role'];
		$apps = $_POST['someaps'];
		$status = $_POST['status'];
		$statusAll = $_POST['statusAll'];
		$receiveEmail = $_POST['receiveEmail'];
		$aps = [];
		
		$allApps = implode(",",$apps);
		
		 if (!mysqli_query($conn,"UPDATE users SET rights='$role',testApp='$allApps',status='$status', receiveEmail='$receiveEmail', testStatusAll='$statusAll' WHERE idUser ='$idUser'")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}else{
			echo "<script type='text/javascript'>success_user();</script>";
		} 
	}
if (isset($_POST['email'])){
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$rights = $_POST['role'];
		$crypted = password_hash($password, PASSWORD_DEFAULT); 
		$crypted = substr($crypted,7);


		if (!mysqli_query($conn,"INSERT INTO users (username, password, email, name, surname, rights, testApp, status, testStatusAll, emailN, receiveEmail,resetToken) VALUES('$username','$crypted','$email','$name','$surname','$rights','1,2','1','0','$email','1','')")){
			$status = mysqli_error($conn);
			$status = str_replace("'","`",$status);
			echo "<script type='text/javascript'>error('".$status."');</script>";
		}else{
			echo "<script type='text/javascript'>success_user();</script>";
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