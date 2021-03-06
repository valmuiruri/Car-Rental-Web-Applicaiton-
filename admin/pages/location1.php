 <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KTCS Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php
  //Create a user session or resume an existing one
 session_start();
 ?>
 
 <?php
 
if(isset($_POST['updateBtn']) && isset($_SESSION['id'])){
  // include database connection
    include_once '../../connection.php'; 
	
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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">KTCS Admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						<li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Profile</a>
                        <li><a href="../../worklogin.php?logout=1"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="carM.php"><i class="fa fa-wrench fa-fw"></i> Car Maintenance</a>
                        </li>
                        <li>
                            <a href="carHistory.php"><i class="fa fa-bar-chart-o fa-fw"></i> Car Rental History</a>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="date1.php"><i class="fa fa-wrench fa-fw"></i> Reservations</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Car Availability<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="location1.php">89 Brock St.</a>
                                </li>
                                <li>
                                    <a href="location2.php">763 Princess St.</a>
                                </li>
                                <li>
                                    <a href="location3.php">300 University Ave.</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">89 Brock Street</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-road fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Destination</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
<?php
if(isset($_SESSION['id'])){
   // include database connection
    include_once '../../connection.php'; 
	   
        echo "Cars available: <br>";
    
	// SELECT query
        $query = "SELECT carID, vin, make_model, year, rental_fee FROM car WHERE pickup_location = '89 Brock St.' AND available = '0'";
 
        // prepare query for execution
        $stmt = $dbh->prepare($query);
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        //$stmt->bind_Param("i", $_SESSION['id']);

        // Execute the query
		$stmt->execute();
    
        $stmt->bind_result($carID,$vin,$makemodel,$year,$rentalfee);
	echo "<table class='table table-hover table-bordered'>";
	echo "<tr>";
	echo "<th>Member ID</th>";
	echo "<th>Car ID</th>";
	echo "<th>year</th>";
	echo "<th>Model</th>";
	echo "<th>Rental Fee</th>";
	echo "</tr>";
    while ($stmt -> fetch()){
						echo "<tr>";
						echo "<td>$vin</td>";
						echo "<td>$carID</td>";
						echo "<td>$year </td>";
						echo "<td>$makemodel</td>";
						echo "<td>$rentalfee</td>";
						echo "</tr>";
        
    }
		echo "</table>";
} else {
	//User is not logged in. Redirect the browser to the login index.php page and kill this page.
	header("Location: ../../worklogin.php");
	die();
}

?>
<?php
if(isset($_SESSION['id'])){
    include_once '../../connection.php';
    echo "<br>";
    echo "Reservation for cars at 89 Brock Street: <br>";
    
    $query = "SELECT car.carID, vin, make_model, year, rental_fee, memberID AS reserved_by FROM car, reservation WHERE pickup_location = '89 Brock St.' AND available = '1' AND reservation.carID = car.carID";
    
    $stmt = $dbh->prepare($query);
    
    $stmt->execute();
    $stmt->bind_result($carID,$vin,$makemodel,$year,$rentalfee,$memberID);
	echo "<table class='table table-hover table-bordered'>";
	echo "<tr>";
	echo "<th>Member ID</th>";
	echo "<th>Car ID</th>";
	echo "<th>year</th>";
	echo "<th>Model</th>";
	echo "<th>Rental Fee</th>";
	echo "</tr>";
    if ($stmt -> fetch()){
						echo "<tr>";
						echo "<td>$memberID</td>";
						echo "<td>$carID</td>";
						echo "<td>$year </td>";
						echo "<td>$makemodel</td>";
						echo "<td>$rentalfee</td>";
						echo "</tr>";
    }
    else {
        echo "No cars are reserved at 89 Brock St. currently. <br>";
    }
    echo "</table>";
}
?> 
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>








