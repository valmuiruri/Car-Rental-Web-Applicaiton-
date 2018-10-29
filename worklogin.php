<!DOCTYPE html>
	<html lang="en">
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional Theme - Style Login & Admin Buttons  -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="style.css">
		
		<!-- All the files that are required -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>

	</head>
	<!-- Where all the magic happens -->
	<?php
		error_reporting(E_ALL);
		//Create a user session or resume an existing one
		session_start();
	?>
	<?php
		//check if the user clicked the logout link and set the logout GET parameter
		if(isset($_GET['logout'])){
			//Destroy the user's session.
			$_SESSION['id']=null;
			session_destroy();
		}
	?>
	<?php
		//check if the user is already logged in and has an active session
		if(isset($_SESSION['id'])&&isset($_POST['loginBtn'])){
			//Redirect the browser to the profile editing page and kill this page.
			header("Location: clients/profile.php");
			die();
		}elseif (isset($_SESSION['id'])&&isset($_POST['admin'])){
				header("Location: admin/pages/index.php");
			die();
		}
	?>
	<?php
		//check if the login form has been submitted
		if(isset($_POST['loginBtn'])){
			// include database connection
			include_once 'connection.php'; 
			
			// SELECT query
				$query = "SELECT memberID,username, password, email FROM member WHERE username=? AND password=? AND admin='0'";
		 
				// prepare query for execution
				if($stmt = $dbh->prepare($query)){
				
				// bind the parameters. This is the best way to prevent SQL injection hacks. ss means the two parameters are strings.
				$stmt->bind_Param("ss", $_POST['username'], $_POST['password']);
				 
				// Execute the query
				$stmt->execute();
		 
				// Get Results
				$result = $stmt->get_result();

				// Get the number of rows returned
				$num = $result->num_rows;
				
				if($num>0){
					//If the username/password matches a user in our database
					//Read the user details
					$myrow = $result->fetch_assoc();
					//Create a session variable that holds the user's id
					$_SESSION['id'] = $myrow['memberID'];
					//Redirect the browser to the profile editing page and kill this page.
					header("Location: client/profile.php");
					die();
				} else {
					//If the username/password doesn't matche a user in our database
					// Display an error message and the login form
					echo "<h2>Failed to login, Please Try again or fill out your email below!</h2> ";
				}
				} else {
					echo "Failed to prepare the SQL";
				}
		 }
	?>
	<?php
		//check if the login form has been submitted
		if(isset($_POST['admin'])){
			// include database connection
			include_once 'connection.php'; 
			// SELECT query
			$query = "SELECT memberID,username, password, email FROM member WHERE username=? AND password=? AND admin='1'";
			// prepare query for execution
			if($stmt = $dbh->prepare($query)){
			// bind the parameters. This is the best way to prevent SQL injection hacks. ss means the two parameters are strings.
			$stmt->bind_Param("ss", $_POST['username'], $_POST['password']);
			// Execute the query
			$stmt->execute();
			// Get Results
			$result = $stmt->get_result();
			// Get the number of rows returned
			$num = $result->num_rows;
			if($num>0){
				//If the username/password matches a user in our database
				//Read the user details
				$myrow = $result->fetch_assoc();
				//Create a session variable that holds the user's id
				$_SESSION['id'] = $myrow['memberID'];
				//Redirect the browser to the profile editing page and kill this page.
				header("Location: admin/pages/index.php");
				die();
			} else {
				//If the username/password doesn't matche a user in our database
				// Display an error message and the login form
				echo "<h2>Failed to login, Please Try again!</h2> ";
			}
			} else {
				echo "Failed to prepare the SQL";
			}
		}
	?>
	<body>
		<!-- LOGIN FORM -->
		<div class="text-center" style="padding:25px 0">
			<div class="logo">Login</div>
			<!-- Main Form -->
			<div class="login-form-1">
				<form name='login' id='worklogin' action='worklogin.php' method='post'>
					<div class="login-form-main-message"></div>
					<div class="main-login-form">
						<div class="login-group">
							<div class="form-group">
								<label for="lg_username" class="sr-only">Username</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="lg_password" class="sr-only">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							</div>
						</div>
					</div>
					<div class="etc-login-form">
					<input type="submit" id='loginBtn' name='loginBtn' value='Log In' class="btn btn-default"/>
					<input type="submit" id='admin' name='admin' value='Admin' class="btn btn-default"/>
					</div>
				</form>
			</div>
			<!-- end:Main Form -->
		</div>
		<!-- FORGOT PASSWORD FORM -->
		<div class="text-center" style="padding:50px 0">
			<div class="logo">Forgot Password?</div>
			<!-- Main Form -->
			<div class="login-form-1">
				<form id="forgot-password-form" class="text-left">
					<div class="etc-login-form">
						<p>When you fill in your registered email address, you will be sent instructions on how to reset your password.</p>
					</div>
					<div class="login-form-main-message"></div>
					<div class="main-login-form">
						<div class="login-group">
							<div class="form-group">
								<label for="fp_email" class="sr-only">Email address</label>
								<input type="text" class="form-control" id="fp_email" name="fp_email" placeholder="Email Address">
							</div>
						</div>
						<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
					</div>
					<div class="etc-login-form">
						<p>New user? <a href="register.php">Create new account today!</a></p>
					</div>
				</form>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
		<!-- Compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
	</html>
