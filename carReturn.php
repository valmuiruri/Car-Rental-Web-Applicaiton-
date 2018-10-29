<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>User</title>
		<!-- Bootstrap Core CSS -->
		<!--<link href="client/css/bootstrap.min.css" rel="stylesheet"> -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Custom CSS -->
		<link href="client/css/stylish-portfolio.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="client/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>
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
			if(isset($_SESSION['id'])){
			   // include database connection
				include_once 'connection.php'; 
				
				// SELECT query
					$query = "SELECT username, password from member where username=? and password=?";
			 
					// prepare query for execution
					$stmt = $dbh->prepare($query);
					
					// bind the parameters. This is the best way to prevent SQL injection hacks.
					$stmt->bind_Param("ss", $_SESSION['username'], $_SESSION['password']);

					// Execute the query
					$stmt->execute();
			 
					// results 
					$result = $stmt->get_result();
					
					// Row data
					$myrow = $result->fetch_assoc();
					
			} else {
				//User is not logged in. Redirect the browser to the login index.php page and kill this page.
				header("Location: worklogin.php");
				die();
			}
		?>
		
		<?php
			if(isset($_POST['finished'])){
				include_once 'connection.php';
				$query2 = "UPDATE car SET available = '0' WHERE carID = '".$_POST['carID']."'";
				$query = "UPDATE member_history SET dropoff_odometer ='".$_POST['dropO']."', return_stat ='".$_POST['status']."' WHERE  memberID ='".$_SESSION['id']."'";
				$stmt = $dbh->prepare($query);
				$stmt2 = $dbh->prepare($query2);
				$stmt2->execute();
				//$stmt->bind_result('sii',$_POST['status'],$_POST['carID'],$_SESSION['id']);
				if($stmt->execute()){
				}else{
					echo 'Unable to update record. Please try again. <br/>';
				}
				
				$query = "UPDATE member_history  SET dropoff_odometer = '".$_POST['dropO']."', return_stat = '".$_POST['status']."' WHERE carID = '".$_POST['carID']."' AND memberID = '".$_SESSION['id']."'";
				$stmt = $dbh->prepare($query);
				$stmt->execute();
				$query = "INSERT INTO `comments` (`memberID`, `carID`, `date`, `rating`, `comment`) VALUES ('".$_SESSION['id']."', '".$_POST['carID']."', '".$_POST['day']."', '".$_POST['checkbox1']."', '".$_POST['dropD']."')";
				$stmt = $dbh->prepare($query);
				$stmt->execute();
				
				}
		?>
		
		<!-- Navigation   -->
		<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
		<nav id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
				<li class="sidebar-brand">
					<a href="#top" onclick=$("#menu-close").click();>Hello <?php echo $myrow['username']; ?></a>
				</li>
				<li>
					<a href="client/profile.php" onclick=$("#menu-close").click();>Home</a>
				</li>
				<li>
					<a href="car.php" onclick=$("#menu-close").click();>Rent a Car</a>
				</li>
				<li>
					<a href="carReturn.php" onclick=$("#menu-close").click();>Return a Car</a>
				</li>
				<li>
					<a href="client/profile.php#services" onclick=$("#menu-close").click();>Rental History</a>
				</li>

				<li>
					<a href="client/profile.php#contact" onclick=$("#menu-close").click();>Contact</a>
				</li>
				<li>
					<a href="worklogin.php?logout=1" onclick=$("#menu-close").click();>Log Out</a>
				</li>
			</ul>
		</nav>
		<!-- Header -->
		<header id="top" class="header">
			<div class="text-vertical-center">
				<br>
				<?php 
					if(isset($_POST['finished'])){
						echo "<h1>Thank you for completing the form! Hope you have a nice day!</h1>";
						echo "<a href='client/profile.php' class='btn btn-dark btn-lg'>Profile</a>";
					}else{
						echo "<h1>Please complete form below to return your vechile</h1>";
						echo "<a href='#about' class='btn btn-dark btn-lg'>Begin</a>";
					}
				?>
			</div>
		</header>

		<!-- About -->
		<section id="about" class="about">
			<!-- Main Form -->
			<form name='carReturn' id='carReturn' action='carReturn.php' method='post'>
				<center>
				<h2>Please Complete Form</h2></center>
				<hr class="small">
				<!-- LOGIN FORM -->
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-5 col-md-6">
							<h3>Car</h3>
							<?php
								include_once 'connection.php';
								$query= "SELECT carID, make_model, year, pickup_location, rental_fee FROM car WHERE available = '1' ORDER BY pickup_location";
								$stmt = $dbh->prepare($query);
								$stmt->execute();
								$stmt->bind_result($carID, $make_model, $year, $pickup_location, $rental_fee);
								$select = '<select class="form-control" name="carID">';
								while($stmt ->fetch()){
									$select.='<option value="'.$carID.'">'.$make_model. ' | '.$year. ' | '.$pickup_location. ' | '.$rental_fee.'</option>';
								}		
								$select.='</select><br>';
								echo $select;
							?>
						</div>
						<div class="col-sm-5 col-md-6">
							<h3>Return Date</h3>
							<label for="day" class="sr-only">day</label>
							<input type="date" class="form-control" id="day" name="day" placeholder="Enter a sepcific day">
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-sm-5 col-md-6">
							<h3>Drop Off Odometer Reading</h3>
							<label for="dropO" class="sr-only">drop off odometer reading</label>
							<input type="text" class="form-control" id="dropO" name="dropO" >
						</div>
						<div class="col-sm-5 col-md-6">
							<h3>Car Status</h3>
							<select class="form-control" name="status">
								<option value="normal">Normal</option>
								<option value="damage">Damage</option>
								<option value="notR">Not Running</option>
							</select>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-sm-5 col-md-6">
							<h3>Rate Car</h3>
							<select class="form-control" name="checkbox1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
						<div class="col-sm-5 col-md-6">
							<h3>Comment</h3>
							<label for="dropD" class="sr-only">Drop Details</label>
							<input type="text" class="form-control" id="dropD" name="dropD" >
						</div>
					</div>
					<center>
						<h3>Send Feedback</h3>
						<input type="submit" id='finished' name='finished' value='finished' class="btn btn-default"/>
					</center>
				</div>
			</form>
		</section>
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
		<a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
		<!-- jQuery <script src="client/js/jquery.js"></script>-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Bootstrap Core JavaScript <script src="client/js/bootstrap.min.js"></script>-->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<!-- Custom Theme JavaScript -->
		<script>
			// Closes the sidebar menu
			$("#menu-close").click(function(e) {
				e.preventDefault();
				$("#sidebar-wrapper").toggleClass("active");
			});
			// Opens the sidebar menu
			$("#menu-toggle").click(function(e) {
				e.preventDefault();
				$("#sidebar-wrapper").toggleClass("active");
			});
			// Scrolls to the selected menu item on the page
			$(function() {
				$('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
					if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
						var target = $(this.hash);
						target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
						if (target.length) {
							$('html,body').animate({
								scrollTop: target.offset().top
							}, 1000);
							return false;
						}
					}
				});
			});
			//#to-top button appears after scrolling
			var fixed = false;
			$(document).scroll(function() {
				if ($(this).scrollTop() > 250) {
					if (!fixed) {
						fixed = true;
						// $('#to-top').css({position:'fixed', display:'block'});
						$('#to-top').show("slow", function() {
							$('#to-top').css({
								position: 'fixed',
								display: 'block'
							});
						});
					}
				} else {
					if (fixed) {
						fixed = false;
						$('#to-top').hide("slow", function() {
							$('#to-top').css({
								display: 'none'
							});
						});
					}
				}
			});
			// Disable Google Maps scrolling
			// See http://stackoverflow.com/a/25904582/1607849
			// Disable scroll zooming and bind back the click event
			var onMapMouseleaveHandler = function(event) {
				var that = $(this);
				that.on('click', onMapClickHandler);
				that.off('mouseleave', onMapMouseleaveHandler);
				that.find('iframe').css("pointer-events", "none");
			}
			var onMapClickHandler = function(event) {
					var that = $(this);
					// Disable the click handler until the user leaves the map area
					that.off('click', onMapClickHandler);
					// Enable scrolling zoom
					that.find('iframe').css("pointer-events", "auto");
					// Handle the mouse leave event
					that.on('mouseleave', onMapMouseleaveHandler);
				}
				// Enable map zooming with mouse scroll when the user clicks the map
			$('.map').on('click', onMapClickHandler);
		</script>
	</body>
</html>
