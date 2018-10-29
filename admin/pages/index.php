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
<?php
if(isset($_SESSION['id'])){
   // include database connection
    include_once '../../connection.php'; 
	
	// SELECT query
        $query = "SELECT memberID,username, password FROM member WHERE memberID='".$_SESSION['id']."'";
 
        // prepare query for execution
        $stmt = $dbh->prepare($query);
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        //$stmt->bind_Param("i", $_SESSION['id']);

        // Execute the query
		$stmt->execute();
 
		// results 
		$result = $stmt->get_result();
		
		// Row data
		$myrow = $result->fetch_assoc();
		
} else {
	//User is not logged in. Redirect the browser to the login index.php page and kill this page.
	header("Location: ../../worklogin.php");
	die();
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
                    <h1 class="page-header">Administrator Dashboard | Welcome: <?php echo $myrow['username']; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-credit-card fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Invoice</div>
                                </div>
                            </div>
                        </div>
                        <a href="Invoice.php">
                            <div class="panel-footer">
                                <span class="pull-left">Monthly Invoice</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car   fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Car Fleet</div>
                                </div>
                            </div>
                        </div>
                        <a href="addcar.php">
                            <div class="panel-footer">
                                <span class="pull-left">Add new car</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>New Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comment.php">
                            <div class="panel-footer">
                                <span class="pull-left">Respond to Comments</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div><br>
<?php
if(isset($_SESSION['id'])){
    include_once '../../connection.php';
    
    echo "<h2>ATTENTION!!! These cars have travelled 5000kms or more since their last maintenance:</h2>";
    
    $query = "SELECT member_history.carID, make_model, year, vin FROM member_history NATURAL JOIN history, car WHERE (dropoff_odometer-odo_reading) > 5000 and member_history.carID = car.carID";
    
    $stmt = $dbh->prepare($query);
    
    $stmt->execute();
    $stmt->bind_result($carID,$makemodel,$year,$vin);
	echo "<table class='table table-hover table-bordered'>";
	echo "<tr>";
	echo "<th>CarID</th>";
	echo "<th>VIN</th>";
	echo "<th>Model</th>";
	echo "<th>year</th>";

	echo "</tr>";
	
    while ($stmt -> fetch()){
		echo "<tr>";
		echo "<td>$carID</td>";
		echo "<td>$vin</td>";
        echo "<td>$makemodel</td>";
		echo "<td>$year </td>";
		echo "</tr>";
    }
	
	echo "</table>";
}
?>
<?php
if(isset($_SESSION['id'])){
    include_once '../../connection.php';
    
    echo "<h2>Cars ranked by highest number of rentals to lowest: </h2>";
    
    $query = "select count(carID) as num_of_rentals, reservation.carID, make_model, year, vin FROM reservation NATURAL JOIN car GROUP BY carID ORDER BY num_of_rentals DESC";
    
    $stmt = $dbh->prepare($query);
    
    $stmt->execute();
    $stmt->bind_result($rentals,$carID,$makemodel,$year,$vin);
	echo "<table class='table table-hover table-bordered'>";
	echo "<tr>";
	echo "<th>CarID</th>";
	echo "<th>Model</th>";
	echo "<th>year</th>";
	echo "<th>Number of Rentals</th>";
	echo "</tr>";
    while ($stmt -> fetch()){
		echo "<tr>";
		echo "<td>$carID</td>";
        echo "<td>$makemodel</td>";
		echo "<td>$year </td>";
		echo "<td>$rentals</td>";
		echo "</tr>";
        
    }
	echo "</table>";
}
?>    
            </div>
            <!-- /.row -->
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
