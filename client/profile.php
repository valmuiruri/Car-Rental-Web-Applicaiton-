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
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="css/stylish-portfolio.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!-- Create a user session or resume an existing one -->
		<?php session_start(); ?>
	 
		 <?php
			 
			 if(isset($_POST['updateBtn']) && isset($_SESSION['id'])){
			  // include database connection
				include_once '../connection.php'; 
				
				$query = "UPDATE member SET password=?,email=? WHERE memberID=?";
			 
				$stmt = $dbh->prepare($query);
				$stmt->bind_param('sss', $_POST['password'], $_POST['email'], $_SESSION['id']);
				// Execute the query
					if($stmt->execute()){
						echo "Record was updated. <br/>";
					}else{
						echo 'Unable to update record. Please try again. <br/>';
					}
			 } 
		 ?>
		<?php
			if(isset($_SESSION['id'])){
			   // include database connection
				include_once '../connection.php'; 
				
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
				header("Location: ../worklogin.php");
				die();
			}
		?>
		<!-- Navigation -->
		<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
		<nav id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
				<li class="sidebar-brand">
					<a href="#top" onclick=$("#menu-close").click();>Hello <?php echo $myrow['username']; ?></a>
				</li>
				<li>
					<a href="#top" onclick=$("#menu-close").click();>Home</a>
				</li>
				<li>
					<a href="../car.php" onclick=$("#menu-close").click();>Rent a Car</a>
				</li>
				<li>
					<a href="../carReturn.php" onclick=$("#menu-close").click();>Return a Car</a>
				</li>
				<li>
					<a href="#services" onclick=$("#menu-close").click();>Rental History</a>
				</li>
				<li>
					<a href="#contact" onclick=$("#menu-close").click();>KTCS Locations</a>
				</li>
				<li>
					<a href="#contact" onclick=$("#menu-close").click();>Contact</a>
				</li>
				<li>
					<a href="../worklogin.php?logout=1" onclick=$("#menu-close").click();>Log Out</a>
				</li>
			</ul>
		</nav>

		<!-- Header -->
		<header id="top" class="header">
			<div class="text-vertical-center">
				<h1>Welcome! What Would you Like to do Today?</h1>
				<br>
				<a href="../car.php" class="btn btn-dark btn-lg">Rent A Car</a>
				<a href="#services" class="btn btn-dark btn-lg">Rental History</a>
				<a href="#contact" class="btn btn-dark btn-lg">KTCS Locations</a>
			</div>
		</header>
		
		<!-- Services -->
		<!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
		<section id="services" class="services bg-primary">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-10 col-lg-offset-1">
						<h2>Rental History</h2>
						<hr class="small">
						<div class="row">
							<!-- SQL PART 1 -->
							<?php
								include_once '../connection.php';
								$query = "SELECT date, carID, make_model, rating, comment FROM comments NATURAL JOIN car where memberID ='".$_SESSION['id']."' ORDER BY date ASC";
								$stmt = $dbh->prepare($query);
								//Executeparam
								$stmt->execute();
								$stmt->bind_result($date,$carID,$model,$rating,$comment);
								echo "<div class='table-responsive'>";
								echo "<table class='table table-hover'>";
								echo "<thead>";
								echo "<tr>";
								echo "<th scope='col'>Date</th>";
								echo "<th scope='col'>Access Code</th>";
								echo "<th scope='col'>Model</th>";
								echo "<th scope='col'>Rating</th>";
								echo "<th scope='col'>Comment</th>";
								echo "</tr >";
								echo "</thead>";
								echo "<tbody>";
								while ($stmt ->fetch()){
									echo "<tr>";
									echo "<td>$date</td>";
									echo "<td>$carID</td>";
									echo "<td>$model</td>";
									echo "<td>$rating</td>";
									echo "<td>$comment</td>";
									echo "</tr>";
								}
								echo "</tbody>";
								echo"</table>";
								echo "</div>"
							?>
							<!-- SQL end of part 1 -->
						</div><!-- /.row (nested) -->
					</div><!-- /.col-lg-10 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</section>

		<!-- Map -->
		<section id="contact" class="map">
			<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?q=place_id:Ei03NjMgUHJpbmNlc3MgU3QsIEtpbmdzdG9uLCBPTiBLN0wgNFYxLCBDYW5hZGE&key=AIzaSyCE833HYQYjGSs0esp_ROVGmEWP0zW36TY" allowfullscreen></iframe>
		</section>
		<section id="contact1" class="map">
			<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?q=place_id:EiU4OSBCcm9jayBTdCwgS2luZ3N0b24sIE9OIEs3TCwgQ2FuYWRh&key=AIzaSyCE833HYQYjGSs0esp_ROVGmEWP0zW36TY" allowfullscreen></iframe>
		</section>
		<section id="contact2" class="map">
			<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJc3CVvQer0kwR5P3u9OHtwkE&key=AIzaSyCE833HYQYjGSs0esp_ROVGmEWP0zW36TY" allowfullscreen></iframe>
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
			<a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
		</footer>

		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>

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
