<!DOCTYPE html>
<html lang="en">

<head>
    <title>Test Request - Reset password</title>

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
					 title: 'We have sent you a reset link on your email!',
					 text: 'The link is valid 12 hours!',
					 icon: 'success',
					}).then(function(){
							window.location.href = "auth-signin.php";
					});
		}
	function error(ev){
		console.log(ev);
				Swal.fire({
					 title: 'Error!',
					 text: 'Error:'+ev,
					 icon: 'error',
					}).then(function(){
							window.location.href = "auth-signin.php";
					});
		}
	</script>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
					<form method="post">
						<div class="mb-4">
							<i class="feather icon-mail auth-icon"></i>
						</div>
						<h3 class="mb-4">Reset Password</h3>
						<div class="input-group mb-3">
							<input type="email" name="email" class="form-control" placeholder="Email">
						</div>
						<input type="submit" class="btn btn-primary mb-4 shadow-2" name="reset" value="Reset Password">
						<p id="error" class="mb-2 text-danger" hidden></p>
					 </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
	<script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

</body>
</html>
<?php
include("database/db_conection.php");  
if(isset($_POST['reset']))  
{  
	include('src/emailService.php'); //configurare PHPMailer
    $email=$_POST['email'];
	$token = bin2hex(openssl_random_pseudo_bytes(16)); //generare token
	//verificare existenta email in tabela
    $check_email="select * from users WHERE email='$email'";  
  
    $run=mysqli_query($conn,$check_email);  
	$row = $run->fetch_assoc();
   
		if(mysqli_num_rows($run))  
		{  
			if ($row['status'] == '1'){ //verificare user activ
				$userID = $row['idUser'];
				if (!mysqli_query($conn,"UPDATE users SET resetToken='$token' WHERE  idUser='$userID'")){
					$status = mysqli_error($conn);
					$status = str_replace("'","`",$status); //actualizare status in caz de esec conectare
					echo "<script type='text/javascript'>error('".$status."');</script>";
				}else{
					sendEmail($email, 'Test Request Platform Password Reset', 'You can reset your password here http://'.$_SERVER['HTTP_HOST'].'/change-reset-password.php?token='.$token);
					echo "<script type='text/javascript'>success();</script>";
				}
				
				
				
			}else{
				echo "<script>$('#error').html('User is deactivated');$('#error').removeAttr('hidden');</script>";
			}
		}else{
			
			echo "<script>$('#error').html('Email does not exist');$('#error').removeAttr('hidden');</script>";
		}  
	
	
}  



?>