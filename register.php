<!DOCTYPE html>
	<html>
	<head>
		<!-- Up to date compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional Theme - Style Login & Admin Buttons -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- All the files that are required -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
		
		<link rel="stylesheet" href="style.css">


		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		
	</head>
	<body>
		<!-- LOGIN FORM -->
		<!-- REGISTRATION FORM -->
		<div class="text-center" style="padding:50px 0">
			<div class="logo">Register Now!</div>
			<?php
				//Create a user session or resume an existing one
				session_start();
			 ?>
			<?php
				if(isset($_POST['register'])){
					//include database connection
					include_once 'connection.php'; 
					
					$query = "INSERT INTO `member` (`memberID`, `name`, `address`, `phone_number`, `email`, `driver_license_num`, `membership_fee`, `username`, `password`, `admin`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["address"]."', '".$_POST["phone_number"]."', '".$_POST["email"]."', '".$_POST["driver_license_num"]."', '5', '".$_POST["username"]."', '".$_POST["password"]."', '0')";
				 
					$stmt = $dbh->prepare($query);
					// Execute the query
					if($stmt->execute()){
						echo "<h2>You have successfully registered! Please click Login to continue</h2>";
					}else{
						echo '<h2>Please try again!</h2>';
					}
				}
			 
			?>
			<div class="login-form-1">
				<form name='register' id='register' action='register.php' method='post'>
					<div class="login-form-main-message"></div>
					<div class="main-login-form">
						<div class="login-group">
							<div class="form-group">
								<label for="reg_name" class="sr-only">fullname</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
							</div>
							<div class="form-group">
								<label for="reg_address" class="sr-only">address</label>
								<input type="text" class="form-control" id="address" name="address"placeholder="Address">
							</div>
							<div class="form-group">
								<label for="reg_phone_number" class="sr-only">phonenum</label>
								<input type="text" class="form-control" id="phone_number" name="phone_number"placeholder="Phone Number">
							</div>
							<div class="form-group">
								<label for="reg_email" class="sr-only">Email</label>
								<input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
							</div>
							<div class="form-group">
								<label for="reg_driver_license_num" class="sr-only">driver license number</label>
								<input type="text" class="form-control" id="driver_license_num" name="driver_license_num"placeholder="Driver License Number">
							</div>
							<div class="form-group">
								<label for="reg_username" class="sr-only">username</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="reg_password" class="sr-only">password</label>
								<input type="password" class="form-control" id="password" name="password"placeholder="Password">
							</div>
							
						</div>
					</div>
					<div class="etc-login-form">
						<input type="submit" id='register' name='register' value='register' class="btn btn-default"/>
					</div>
				</form>
				<a href="worklogin.php" class="btn btn-default">Login</a>
			</div>
			<!-- end:Main Form -->
		</div>
		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1 text-center">
						<h3><strong>Kingston Town Car Sharing</strong>
						</h3>
						<h4>338 brock
							<br>Kingston, ON</h4>
						<ul class="list-unstyled">
							<li><i class="fa fa-phone fa-fw"></i> (226) 339-1853</li>
							<li><i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:valentino.muiruri@example.com">ktcsadmin@gmail.com</a>
							</li>
						</ul>
						<br>
						<hr class="small">
						<p class="text-muted">Copyright &copy; CISC332 2017</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- Up To Date compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
	</body>
	</html>