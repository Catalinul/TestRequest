<?php  
session_start();

$manifest = parse_ini_file("src/manifest.ini");

if(isset($_SESSION['url'])) 
   $url = $_SESSION['url']; 
else 
   $url = "index.php";   

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Test Request platform</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <meta name="author" content="Catalin Pirvu"/>

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">

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
					<form class="form-login" method="post">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">Login</h3>
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="email address">
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" name="password" class="form-control" placeholder="password">
                    </div>
                    <div class="form-group text-left">
                        <div class="checkbox checkbox-fill d-inline">
                            <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                            <label for="checkbox-fill-a1" class="cr"> Save Details</label>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4" name="login" type="submit">Login</button>
                    <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.php">Reset</a></p>
                    <p id="error" class="mb-2 text-danger" hidden></p>
					</form>
                </div>
                <span class="m-2 text-right">V<?php echo $manifest["version"];?></span>
            </div>
			
        </div>
    </div>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<?php  
include("database/db_conection.php");  //conexiunea la DB
  
if(isset($_POST['login']))  //verific daca a fost apasat butonul de login
{  
    $email=$_POST['email'];  
    $user_pass=$_POST['password'];  
	$month = date('m') - 1;

	if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //sanitizez email-ul
        $check_user="select * from users WHERE email='$email'";  
    
        $run=mysqli_query($conn,$check_user);  //interoghez tabela users
        
        while ($row = $run->fetch_assoc()) { //parsez datele user-ului
        
            $userType= $row['rights'];
            $testApp = $row['testApp'];
            $username = $row['username'];
            $name = $row['name'];
            $surname = $row['surname'];
            $testApp = $row['testApp'];
            $password = $row['password'];
            $status = $row['status'];
            $testStatus = $row['testStatusAll']; //daca userul are sau nu dreptul la e vedea toate statusurile
            $icon = $row['icon'];
            $receiveEmail = $row['receiveEmail'];
            $userID = $row['idUser'];
            $emailN = $row['emailN'];
            $team = $row['team'];
            
        }
        
            if(mysqli_num_rows($run))  
            {  
                if ($status == '1'){
                    
                    if (password_verify($user_pass, '$2y$10$'.$password)){ //decriptez si compar parola
                        if (in_array($userType, array('0','1','2'))){
                            header("Location: $url"); 
                        } else {
                            header("Location: src/403.html"); // This line triggers for invalid user_types
                        }	
                        
                        //echo "<script>window.open('$url','_self')</script>";  
                        $_SESSION['app']="TestRequest";
                        $_SESSION['user']=$username;
                        $_SESSION['name']=$name;
                        $_SESSION['surname']=$surname;
                        $_SESSION['user_type']=$userType;
                        $_SESSION['testApp']=$testApp;
                        $_SESSION['testStatus']=$testStatus;
                        $_SESSION['icon']=$icon;
                        $_SESSION['email']=$email;
                        $_SESSION['emailN']=$emailN;
                        $_SESSION['notification']=$receiveEmail;
                        $_SESSION['userID']=$userID;
                        $_SESSION['team']=$team;
                        $_SESSION['emailTester']="pirvu.catalin15@gmail.com";
                        //$_SESSION['emailTester']=$emailN;
                        setcookie("month",$month);
                    }else{
                        echo "<script>$('#error').html('Password is incorect');$('#error').removeAttr('hidden');</script>";
                    }
                }else{
                    echo "<script>$('#error').html('User is deactivated');$('#error').removeAttr('hidden');</script>";
                }
            }else{
                
                echo "<script>$('#error').html('User does not exist');$('#error').removeAttr('hidden');</script>";
            }  
    }else{
        $check_user="select * from users WHERE username='$email'";  
    
        $run=mysqli_query($conn,$check_user);  
        
        while ($row = $run->fetch_assoc()) {
        
            $userType= $row['rights'];
            $testApp = $row['testApp'];
            $username = $row['username'];
            $name = $row['name'];
            $surname = $row['surname'];
            $testApp = $row['testApp'];
            $password = $row['password'];
            $status = $row['status'];
            $testStatus = $row['testStatusAll'];
            $icon = $row['icon'];
            $receiveEmail = $row['receiveEmail'];
            $userID = $row['idUser'];
            $emailN = $row['emailN'];
            $team = $row['team'];
            
        }
    
    }
	
} 
?>  