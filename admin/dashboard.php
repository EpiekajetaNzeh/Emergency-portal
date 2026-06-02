<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');



if (strlen($_SESSION['eahpaid']==0)) {
  header('location:logout.php');
  } 
     ?>
<!DOCTYPE html>
<head>
<title>Dashboard | Administrative Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="css/style.css?v=<?=time()?>" rel='stylesheet' type='text/css' />
<link href="css/style-responsive.css?v=<?=time()?>" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="css/monthly.css">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="js/jquery2.0.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/raphael-min.js"></script>
<script src="js/morris.js"></script>
<style>
    /* Subtle Watermark Background for Dashboard */
    body {
        background-color: #f1f5f9; /* Clean base color */
    }
    #main-content {
        position: relative;
        z-index: 1;
    }
    #main-content::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('../assets/img/gallery/Ambulance2.jpg') center center;
        background-size: cover;
        opacity: 0.05; /* Barely visible, highly professional watermark */
        z-index: -1;
        pointer-events: none;
        filter: grayscale(30%); /* Softens the image colors so they don't pop through the data blocks */
    }
    /* Add a slight premium glass lift to the data blocks if applicable */
    .market-update-block {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .market-update-block:hover {
        transform: translateY(-4px);
    }
</style>
</head>
<body>
<section id="container">
<!--header start-->

<!--header end-->
<?php include_once('includes/header.php');?>
<!--sidebar start-->

<!--sidebar end-->
<?php include_once('includes/sidebar.php');?>
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!-- //market-->
		<div class="market-updates">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd">
					<div class="market-update-block clr-block-2">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-ambulance fa-3x"> </i>
							</div>
							<?php $query1=mysqli_query($con,"Select * from  tblambulance");
	$ambcnt=mysqli_num_rows($query1);
	?>
							 <div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
								
							 <h4><a href="manage-ambulance.php" style="color: white">Total Ambulance</a></h4>
							<h3><?php echo $ambcnt;?></h3>
								<a href="manage-ambulance.php" style="color:black">View Details</a>
							
						  </div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd">
					<div class="market-update-block clr-block-1">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" ></i>
							</div>
							<?php $query2=mysqli_query($con,"Select * from  tblambulancehiring");
	$totalreq=mysqli_num_rows($query2);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<h4><a href="all-amublance-request.php" style="color: white">All Ambulance Request</a></h4>
								<h3><?php echo $totalreq;?></h3>
								<a href="all-amublance-request.php" style="color:black">View Details</a>
								
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd">
					<div class="market-update-block clr-block-3">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x"></i>
							</div>
							<?php $query3=mysqli_query($con,"Select * from  tblambulancehiring where (Status is null or Status='')");
	$newreq=mysqli_num_rows($query3);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<h4><a href="new-ambulance-request.php" style="color: white">New  Request</a></h4>
								<h3><?php echo $newreq;?></h3>
								<a href="new-ambulance-request.php" style="color:black">View Details</a>
								
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd">
					<div class="market-update-block clr-block-4">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" style="color:#fff"></i>
							</div>
							<?php $query4=mysqli_query($con,"Select * from  tblambulancehiring where Status='Assigned'");
	$assignedreq=mysqli_num_rows($query4);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="assign-ambulance-request.php"><h4>Assigned Request</h4></a>
								<h3><?php echo $assignedreq;?></h3>
								<a href="assign-ambulance-request.php" style="color:#fff">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>	
			</div>
		</div>

		<div class="market-updates">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-5">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" ></i>
							</div>
							<?php $query5=mysqli_query($con,"Select * from  tblambulancehiring where Status ='On the way'");
	$otwreq=mysqli_num_rows($query5);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="ontheway-ambulance-request.php"><h4>On The Way </h4></a>
								<h3><?php echo $otwreq;?></h3>
									<a href="ontheway-ambulance-request.php" style="color:black">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>	

				
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-8">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" ></i>
							</div>
							<?php $query6=mysqli_query($con,"Select * from  tblambulancehiring where Status ='Pickup'");
	$pickupreq=mysqli_num_rows($query6);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="pickup-ambulance-request.php"><h4>Patient Picked </h4></a>
								<h3><?php echo $pickupreq;?></h3>
								<a href="pickup-ambulance-request.php" style="color:black">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>	

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-1">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" ></i>
							</div>
							<?php $query7=mysqli_query($con,"Select * from  tblambulancehiring where Status ='Reached'");
	$reachedreq=mysqli_num_rows($query7);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="reached-ambulance-request.php"><h4>Patient Reached </h4></a>
								<h3><?php echo $reachedreq;?></h3>
									<a href="reached-ambulance-request.php" style="color:black">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-2">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-file fa-3x" ></i>
							</div>
							<?php $query8=mysqli_query($con,"Select * from  tblambulancehiring where Status ='Rejected'");
	$rejectedreq=mysqli_num_rows($query8);
	?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="rejected-ambulance-request.php"><h4>Rejected Request</h4></a>
								<h3><?php echo $rejectedreq;?></h3>
								<a href="rejected-ambulance-request.php" style="color:black">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>

		<div class="market-updates">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-4">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-clock-o fa-3x" style="color:#fff"></i>
							</div>
							<?php $query_pending=mysqli_query($con,"Select * from tblambulance_pending");
							$pending_regs=mysqli_num_rows($query_pending);
							?>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="pending-ambulance-registrations.php" style="color: white"><h4>Pending Registrations</h4></a>
								<h3><?php echo $pending_regs;?></h3>
								<a href="pending-ambulance-registrations.php" style="color:#fff">View Details</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 market-update-gd" style="margin-top:1%;">
					<div class="market-update-block clr-block-2">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 market-update-right">
								<i class="fa fa-map-marker fa-3x" style="color:#fff"></i>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-8 market-update-left">
							<a href="simulate-tracking.php" style="color: white"><h4>Simulate Tracking</h4></a>
								<h3 style="color:white">Live</h3>
								<a href="simulate-tracking.php" style="color:#fff">Open Tool</a>
							</div>
						</div>
					  <div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>
           
		<div class="row">
			<div class="panel-body">
				<div class="col-md-12 w3ls-graph">
					<!--agileinfo-grap-->
						<div class="agile_graph_box">
							<div class="panel-heading">Analytics Overview</div>
							<div id="hero-area" style="height: 280px;"></div>
						</div>
	<!--//agileinfo-grap-->

				</div>
			</div>
		</div>
		<div class="agil-info-calendar">
			<div class="row">
				<!-- calendar -->
				<div class="col-md-6 agile-calendar">
					
				</div>
				<!-- //calendar -->
				<div class="col-md-6 w3agile-notifications">
					
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
			<!-- tasks -->
			<div class="agile-last-grids">
				<div class="row">
					<div class="col-md-4 agile-last-left">
						
					</div>
					<div class="col-md-4 agile-last-left agile-last-middle">
						
					</div>
					<div class="col-md-4 agile-last-left agile-last-right">
						
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		<!-- //tasks -->
		<div class="agileits-w3layouts-stats">
					<div class="row">
						<div class="col-md-4 stats-info widget">
							
						</div>
						<div class="col-md-8 stats-info stats-last widget-shadow">
							
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
</section>
 <!-- footer -->
	<?php include_once('includes/footer.php');?>	  
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/jquery.scrollTo.js"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="js/monthly.js"></script>
	

	
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->



</body>
</html>
