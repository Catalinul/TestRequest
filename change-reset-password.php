<?php  

if(empty($_GET['token']))  
{  
	header("Location: src/403.html");  
}else{ 
	include("database/db_conection.php");  
	$token = $_GET['token'];
	$check_email="select * from users WHERE resetToken='$token'";  
  
    $run=mysqli_query($conn,$check_email);  
    
	$row = $run->fetch_assoc();
   
		if(!mysqli_num_rows($run))  
		{
			
		header("Location: src/403.html");  		
			
		}else{ 

include("database/db_conection.php");  
date_default_timezone_set('Europe/Bucharest');
$timestamp = date('Y-m-d G:i:s');
?> 

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
	function change_password(){
		if ($('#form')[0].checkValidity()){
			//mai sus se verifica daca parola respecta regulile impuse
			var userID = $('#userID').val();
			var password = $('#password').val();

			$.ajax({ //functie asincrona
				type: "GET",
				url: 'src/changePassword.php?userId='+userID+'&password=' + password,
				//type: "POST",
				//url: "src/changePassword.php",
				//data: {userId: userID, password: password}
				cache: false,
				success: function(response) {
					Swal.fire({
					 title: 'Success!',
					 text: 'Your password was changed.',
					 icon: 'success',
					}).then(function(){
						window.location.href = "auth-signin.php";
					})
				},
				failure: function (response) {
					Swal.fire(
					"Internal Error",
					"Oops, your password was not changed.", 
					"error"
					)
				}
			});
		}else{
			$('#form')[0].reportValidity();
		}
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
					<div class="mb-4">
                        <i class="feather icon-mail auth-icon"></i>
                    </div>
                    <h3 class="mb-4">Set Password</h3>
					<form id="form" onsubmit="return false;">
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Should contain at least one lower case, one digit and minimum length:8" required>
                        <input type="hidden" name="userID" id="userID" value="<?php echo $row['idUser'];?>">
						
                    </div>
                    <input type="button" class="btn btn-primary mb-4 shadow-2" name="reset" onclick="change_password()" value="Reset Password">
					</form>
                     <p id="error" class="mb-2 text-danger" hidden></p>
					
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
  

}}

?>