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
		<?php
			if(isset($_POST['reserve'])){
				include_once 'connection.php'; 
				//Set the reserved car as unavailable so it stops showing up in all the available cars
				$query = "UPDATE car SET available = '1' WHERE carID =?";
				$stmt = $dbh->prepare($query);
				//Executeparam
				
				$stmt->bind_param('s', $_POST['carID']);
				if($stmt->execute()){	
				} else {
					echo 'Unable to update record. Please try again. <br/>';
				}
			}
		?>
		<?php
			if(isset($_POST['reserve'])){
				include_once 'connection.php'; 
				$query = "INSERT INTO `member_history` (`carID`, `memberID`, `pickup_odometer`) VALUES ('".$_POST["carID"]."','".$_SESSION["id"]."', '5000')";
				$stmt = $dbh->prepare($query);
				if($stmt->execute()){
				}else{
				echo 'Unable to update record. Please try again. <br/>';
				}
			}
		?>
		<!-- Header -->
		<header id="top" class="header">
			<div class="text-vertical-center">
				<h1>Enjoy your car and remember to drive safe!</h1>
				<br>
				<a href="worklogin.php?logout=1" class="btn btn-dark btn-lg">Log Out</a>
				<a href="client/profile.php" class="btn btn-dark btn-lg">Profile</a>
				<a href="carReturn.php" class="btn btn-dark btn-lg">Return Car</a>
			</div>
		</header>
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
