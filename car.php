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
			<!-- Custom Fonts--> 
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
						$query = "SELECT username, password FROM member WHERE username=? AND password=?";
				 
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
			<!-- main body START-->
			<!-- this will show what the user wants to rent on a given day Start -->
			<!-- Header -->
			<header id="top" class="header">
				<div class="text-vertical-center">
					<h1>Pick A Car To Rent</h1>
					<br>
					<a href="#about" class="btn btn-dark btn-lg">Choose below</a>
				</div>
			</header>
			<!-- this will show what the user wants to rent on a given day END-->
			<!-- Start on Rental Options to Rent Car -->
		    <div class="container">
				<section id="about" class="about ">
					<div class="row justify-content-center">
						<form name='car' id='car' action='car.php' method='post'>
							<div class="col-md-3">
								<h3>KTCS Location</h3>
								<?php
									include_once 'connection.php';
									$query="SELECT DISTINCT pickup_location FROM car";
									$stmt = $dbh->prepare($query);
									//Executeparam
									$stmt->execute();
									$stmt->bind_result($locations);
									$select = '<select class="form-control" name="location">';
									while($stmt ->fetch()){
										$select.='<option value="'.$locations.'">'.$locations.'</option>';
									}		
									$select.='</select>';
									echo $select;
								?>
							</div>
							<!-- Part 2 of search bar -->
							<div class="col-md-3">
								<h3>Rent on a Specific day</h3>
								<input class="form-control" type="date" name="day" id="day">
							</div>
							<div class="col-md-6">
								<h3>Search Your Car Now</h3>
								<input type="submit" id='car' name='car' value='refresh search' class="btn btn-default"/>
							</div>
						</form>
					</div>
					<!-- Part 2  of search bar END -->
					<div class="row justify-content-start">
						<form name='reserve' id='reserve' action='carReserve.php' method='post'>
							<div class="col-md-6">
								<h3>All Available Cars to Reserve</h3>
								<?php
									include_once 'connection.php';
									$query= "SELECT carID, make_model, year, pickup_location, rental_fee FROM car WHERE available = '0' ORDER BY pickup_location";
									$stmt = $dbh->prepare($query);
									$stmt->execute();
									$stmt->bind_result($carID, $make_model, $year, $pickup_location, $rental_fee);
									$select = '<select class="form-control" name="carID">';
									while($stmt ->fetch()){
										$select.='<option value="'.$carID.'">Model: '.$make_model. ' | Year: '.$year. ' | Pick Up Location: '.$pickup_location. ' | Fee: $'.$rental_fee.'</option>';
									}		
									$select.='</select><br>';
									echo $select;
									
								?>
							</div>
							<div class="col-md-6">
								<h3>Select My Car</h3>
								<input type="submit" id='reserve' name='reserve' value='Reserve' class="btn btn-default"/>
							</div>
						</form>
					</div>
				</section>
				<section id="section2" class="about">
					<div class="row justify-content-center">
						<div class="col-xs-6 col-md-6">
							<?php
							if (isset($_SESSION['id'])){
								include_once 'connection.php';
								if(isset($_POST['car'])){
									echo "<h2>Available</h2>";
									echo "<hr class='small'>";
									
									
									$query="SELECT carID, make_model, year, rental_fee, pickup_location FROM car WHERE pickup_location = '".$_POST["location"]."'";
									
									$stmt = $dbh->prepare($query);
									$stmt->execute();
									echo "<h2>By Location: </h2>";
									$stmt->bind_result($carID, $makemodel,$year,$rental_fee,$location);
									
									while($stmt ->fetch()){
										echo "<div class='thumbnail'>";
											echo "<div class='caption'>";
											echo "<center>";
												echo "<h3> Model: $make_model $year (Car ID: $carID) </h3>";
												echo "<div class='btn-group'>";
													echo "<p>";
														echo "<span class='btn btn-default' type='button'>Pickup Location: $location</span>";
														echo "<span class='btn btn-default' type='button'>Rental fee:  $$rental_fee</span>";
													echo"</p>";
													
												echo"</div>";
											echo "</center>";
											echo"</div>";
										echo"</div>";

									}
									$query = "SELECT  carID, make_model, year, pickup_location, rental_fee FROM car NATURAL JOIN reservation WHERE available = '0' AND date != '".$_POST['day']."' ORDER BY pickup_location";
									$stmt = $dbh->prepare($query);
									$stmt->execute();
									$stmt->bind_result($carID, $make_model, $year, $pickup_location, $rental_fee);
									echo "<h2>All Available Today:</h2>";
									while($stmt ->fetch()){
										echo "<div class='thumbnail'>";
											echo "<div class='caption'>";
											echo "<center>";
												echo "<h3> Model: $make_model $year (Car ID: $carID) </h3>";
												echo "<div class='btn-group'>";
													echo "<p>";
														echo "<span class='btn btn-default' type='button'>Pickup Location: $location</span>";
														echo "<span class='btn btn-default' type='button'>Rental fee:  $$rental_fee</span>";
													echo"</p>";
													
												echo"</div>";
											echo "</center>";
											echo"</div>";
										echo"</div>";

									}
								}
							}
							?>
						</div>
						<div class="col-xs-6 col-md-6">
							<?php
								if(isset($_POST['car'])) {
									echo "<h2>Please Pick a Car to Reserve</h2>";
									echo "<hr class='small'>";
									include_once 'connection.php';
									$query = "SELECT carID, make_model, year, pickup_location, rental_fee FROM car NATURAL JOIN reservation WHERE available = '0' AND date != NOW() ORDER BY pickup_location";
									$stmt = $dbh->prepare($query);
									$stmt->execute();
									$stmt->bind_result($carID, $make_model, $year, $pickup_location, $rental_fee);
									$select = '<select class="form-control" name="select">';
										while($stmt ->fetch()){
											$select.='<option value="'.$carID.'">'.$make_model.'</option>';
										}		
								$select.='</select><br>';
								echo $select;
								echo "<a href='#reserve' class='btn btn-default'>Complete</a>";
								}
							?>
						</div>
					</div>
				</section>
		    </div>
			<!-- Footer -->
			<footer>
				<div class="container">
					<div class="row justify-content-center">
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
			
			<!-- Navigation Arrow -->
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
