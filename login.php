

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Secure Era</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   
<!--===============================================================================================-->
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="util.css">
	<link rel="stylesheet" type="text/css" href="main.css">
	<!--===============================================================================================-->
</head>
<body>
	<?php
	session_start();
	if(isset($_SESSION['uid'])){
		header("location:index.php");
	}
	$conn = new mysqli('localhost', 'root', '','dmce');
	$msg="";
	
if(isset($_POST['signin'])){
	$username=mysqli_real_escape_string($conn,$_POST['email']) ;
	$password=mysqli_real_escape_string($conn,$_POST['pass']);
	$password=sha1($password);
  
	$sql ="SELECT * FROM `users` WHERE `username`=? AND `password`=?";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param("ss",$username,$password);
	$stmt->execute(); 
	$result = $stmt->get_result();
	// $row = $result->fetch_assoc();

	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_assoc($result);
		session_regenerate_id();
		$_SESSION['uid'] =$row['uid'];
		session_write_close();
	  header("location:index.php");
	}
	else{
	  $msg="Username or password is incorrect !";
	}
  }
if(isset($_POST['signup'])){

	$username=$_POST['email1'];
	$password=$_POST['pass1'];
	$password=sha1($password);
	$uid=  uniqid();
	$sql="INSERT INTO users (`username`,`password`,`uid`) VALUES('$username','$password','$uid')";
	if(mysqli_query($conn,$sql)){
		echo "done";
		$_SESSION['uid']=$uid;
		header('location: index.php');
	}

}

  
?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form action="" class="login100-form validate-form" method="post" id="sin">
					<span class="login100-form-title p-b-33">
						Account Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" type="submit" name="signin">
							Sign in
						</button>
					</div>


					<div class="text-center">
						<span class="txt1">
							Create an account?
						</span>

						<span onclick="showsignup()" class="txt2 hov1" style="cursor: pointer;">
							Sign up
	  					</span>
					</div>
				</form>
				<form action="" onsubmit="return validateForm()" class="login100-form validate-form" method="post" id="sout" style="display: none;">
					<span class="login100-form-title p-b-33">
						Account Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" id="email1" name="email1" placeholder="Email">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" id="pass1" name="pass1" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" id="cpass1" name="cpass1" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
					<div class="row">

						<div class="container-login100-form-btn m-t-20 col-6">
							<button class="login100-form-btn" type="submit" name="signup">
								Sign Up
							</button>
						</div>
						<div class="m-t-20 col-6 ">
							<button type="button" onclick="showsignin()" class="login100-form-btn" style="background-color: rgb(58, 121, 189);">
								Sign In
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


	<script>
	function validateForm() {
		var x = $('#pass1').val();
		var y = $('#cpass1').val();
		if (x != y) {
			alert("Passwords do not match");
			return false;
		}else{
			return true;
		}

}
		$(document).ready(function(){
			// console.log('hello');
			// $('#signup').hide();
		})
		function showsignup(){
			$('#sin').hide();
			$('#sout').show();
		}
		function showsignin(){
			$('#sin').show();
			$('#sout').hide();
		}
	</script>

</body>
</html>