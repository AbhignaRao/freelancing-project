<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
	if ($_SESSION["Usertype"]==1) {
		$linkPro="freelancerProfile.php";
		$linkEditPro="editFreelancer.php";
		$linkBtn="applyJob.php";
		$textBtn="Apply for this job";
	}
	else{
		$linkPro="employerProfile.php";
		$linkEditPro="editEmployer.php";
		$linkBtn="editJob.php";
		$textBtn="Edit the job offer";
	}
}
else{
    $username="";
	//header("location: index.php");
}

if(isset($_POST["jid"])){
	$_SESSION["job_id"]=$_POST["jid"];
	header("location: jobDetails.php");
}

$sql = "SELECT * FROM job_offer WHERE valid=1 ORDER BY timestamp DESC";
$result = $conn->query($sql);

if(isset($_POST["s_title"])){
	$t=$_POST["s_title"];
	$sql = "SELECT * FROM job_offer WHERE title='$t' and valid=1";
	$result = $conn->query($sql);
}

if(isset($_POST["s_type"])){
	$t=$_POST["s_type"];
	$sql = "SELECT * FROM job_offer WHERE type='$t' and valid=1";
	$result = $conn->query($sql);
}

if(isset($_POST["s_employer"])){
	$t=$_POST["s_employer"];
	$sql = "SELECT * FROM job_offer WHERE e_username='$t' and valid=1";
	$result = $conn->query($sql);
}

if(isset($_POST["s_id"])){
	$t=$_POST["s_id"];
	$sql = "SELECT * FROM job_offer WHERE job_id='$t' and valid=1";
	$result = $conn->query($sql);
}

if(isset($_POST["recentJob"])){
	$sql = "SELECT * FROM job_offer WHERE valid=1 ORDER BY timestamp DESC";
	$result = $conn->query($sql);
}

if(isset($_POST["oldJob"])){
	$sql = "SELECT * FROM job_offer WHERE valid=1";
	$result = $conn->query($sql);
}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>All Job Offers</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

<style>
	body {
		padding-top: 120px;
		margin: 0;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-color: #f8f9fa;
		color: #333;
	}

	/* Container spacing */
	.container {
		padding-top: 50px;
		max-width: 1200px;
		margin: 0 auto;
	}

	/* Main content wrapper */
	.row {
		display: flex;
		justify-content: center;
		gap: 30px;
		margin-top: 30px;
	}

	/* Card spacing and alignment */
	.card {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		padding: 0;
		margin-top: 40px;
		margin-bottom: 40px;
		border: none;
		width: 100%;
	}

	/* Panel heading with improved spacing */
	.panel-heading {
		background: linear-gradient(45deg, #000, #333) !important;
		color: #fff !important;
		border: none;
		padding: 25px 30px;
		border-radius: 12px 12px 0 0;
		font-size: 24px;
		font-weight: 600;
		margin-bottom: 0;
		display: flex;
		align-items: center;
		gap: 15px;
	}
	.panel-heading i {
		font-size: 28px;
	}
	.panel-heading h3 {
		margin: 0;
		padding: 0;
	}

	/* Navbar styling */
	.navbar-inverse {
		background-color: #000;
		border-color: #000;
		box-shadow: 0 2px 15px rgba(0,0,0,0.1);
		padding: 20px 0;
		min-height: 80px;
	}
	.navbar-inverse .navbar-brand {
		color: #fff;
		font-size: 26px;
		font-weight: bold;
		transition: all 0.3s ease;
		padding: 15px 20px;
	}
	.navbar-inverse .navbar-brand:hover {
		color: #fff;
		transform: translateY(-2px);
		text-shadow: 0 2px 4px rgba(0,0,0,0.2);
	}
	.navbar-inverse .navbar-nav > li > a {
		color: #fff;
		font-size: 16px;
		padding: 15px 25px;
		transition: all 0.3s ease;
		border-bottom: 2px solid transparent;
		margin: 0 5px;
	}
	.navbar-inverse .navbar-nav > li > a:hover {
		color: #fff;
		border-bottom: 2px solid #fff;
		transform: translateY(-2px);
	}
	.navbar-inverse .navbar-nav > li > a i {
		margin-right: 10px;
		transition: all 0.3s ease;
	}
	.navbar-inverse .navbar-nav > li > a:hover i {
		transform: scale(1.2);
	}

	/* Dropdown styling */
	.dropdown-menu {
		background-color: #000;
		border: none;
		border-radius: 8px;
		box-shadow: 0 4px 20px rgba(0,0,0,0.2);
		padding: 15px 0;
		margin-top: 12px;
		min-width: 200px;
	}
	.dropdown-menu li a {
		color: #fff !important;
		padding: 12px 25px;
		transition: all 0.3s ease;
		display: flex;
		align-items: center;
	}
	.dropdown-menu li a:hover {
		background-color: #333;
		transform: translateX(5px);
		color: #fff !important;
	}
	.dropdown-menu li a i {
		margin-right: 12px;
		width: 20px;
		text-align: center;
		font-size: 16px;
	}

	/* Table container improvements */
	.table-container {
		margin: 25px;
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 15px rgba(0,0,0,0.08);
		overflow: hidden;
	}

	.job-table {
		width: 100%;
		border-collapse: separate;
		border-spacing: 0;
		margin: 0 auto;
	}

	.job-table thead th {
		background: #f8f9fa;
		color: #333;
		font-weight: 600;
		padding: 18px 15px;
		text-transform: uppercase;
		font-size: 14px;
		letter-spacing: 0.5px;
		border-bottom: 2px solid #000;
		text-align: center;
		vertical-align: middle;
	}

	.job-table tbody td {
		padding: 18px 15px;
		vertical-align: middle;
		border-bottom: 1px solid #eee;
		text-align: center;
		font-size: 14px;
		line-height: 1.4;
	}

	.job-table tbody tr:last-child td {
		border-bottom: none;
	}

	.job-table tbody tr:hover {
		background-color: #f8f9fa;
	}

	.job-table .btn {
		padding: 8px 15px;
		font-size: 13px;
		border-radius: 6px;
		margin: 0;
		min-width: 100px;
	}

	/* Column specific widths */
	.job-table .title-column { width: 30%; }
	.job-table .type-column { width: 15%; }
	.job-table .budget-column { width: 15%; }
	.job-table .employer-column { width: 20%; }
	.job-table .date-column { width: 12%; }
	.job-table .action-column { width: 8%; }

	/* Search box improvements */
	.search-box {
		background: #fff;
		border-radius: 12px;
		padding: 25px;
		margin-top: 40px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		position: sticky;
		top: 100px;
	}

	.search-box .form-group {
		margin-bottom: 20px;
	}
	.search-box .form-control {
		height: 50px;
		border-radius: 8px;
		border: 2px solid #eee;
		padding: 10px 20px;
		font-size: 15px;
		transition: all 0.3s ease;
		background: #f8f9fa;
	}
	.search-box .form-control:focus {
		border-color: #000;
		box-shadow: 0 0 10px rgba(0,0,0,0.1);
		background: #fff;
	}
	.search-box .btn {
		width: 100%;
		padding: 12px 20px;
		font-size: 15px;
		font-weight: 600;
		margin-bottom: 0;
		border-radius: 8px;
		transition: all 0.3s ease;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
	}
	.search-box .btn i {
		font-size: 16px;
	}
	.search-box .btn-info {
		background: #000;
		border: 2px solid #000;
		color: #fff;
	}
	.search-box .btn-info:hover {
		background: #333;
		border-color: #333;
	}
	.search-box .btn-warning {
		background: #333;
		border: 2px solid #333;
		color: #fff;
		margin-bottom: 15px;
	}
	.search-box .btn-warning:hover {
		background: #000;
		border-color: #000;
	}

	/* Footer Styling */
	.footer {
		background: #000;
		color: #fff;
		padding: 80px 0 40px;
		margin-top: 60px;
	}
	.footer h3 {
		color: #fff;
		font-size: 22px;
		font-weight: bold;
		margin-bottom: 30px;
		padding-bottom: 15px;
		border-bottom: 2px solid #333;
		position: relative;
	}
	.footer h3:after {
		content: '';
		position: absolute;
		bottom: -2px;
		left: 0;
		width: 50px;
		height: 2px;
		background: #fff;
	}
	.footer p, .footer a {
		color: #999;
		font-size: 15px;
		line-height: 1.8;
		transition: all 0.3s ease;
	}
	.footer a:hover {
		color: #fff;
		text-decoration: none;
		padding-left: 10px;
	}
	.footer .social-links {
		margin-top: 25px;
	}
	.footer .social-links a {
		display: inline-block;
		width: 40px;
		height: 40px;
		background: #333;
		color: #fff;
		text-align: center;
		line-height: 40px;
		border-radius: 50%;
		margin-right: 12px;
		transition: all 0.3s ease;
	}
	.footer .social-links a:hover {
		background: #fff;
		color: #000;
		transform: translateY(-5px);
		box-shadow: 0 5px 15px rgba(255,255,255,0.1);
	}
	.footer .quick-links li {
		margin-bottom: 15px;
	}
	.footer .quick-links a {
		display: block;
		color: #999;
		transition: all 0.3s ease;
		padding: 5px 0;
	}
	.footer .quick-links a i {
		margin-right: 10px;
		transition: all 0.3s ease;
	}
	.footer .quick-links a:hover {
		color: #fff;
		padding-left: 15px;
	}
	.footer .quick-links a:hover i {
		transform: translateX(5px);
	}
	.footer .contact-info p {
		margin-bottom: 15px;
		display: flex;
		align-items: center;
	}
	.footer .contact-info i {
		width: 30px;
		color: #fff;
		margin-right: 15px;
		font-size: 18px;
	}

	/* Fix search functionality */
	<?php
	if(isset($_POST["s_title"])){
		$t = trim($_POST["s_title"]);
		$sql = "SELECT * FROM job_offer WHERE title LIKE '%$t%' AND valid=1";
		$result = $conn->query($sql);
	}

	if(isset($_POST["s_type"])){
		$t = trim($_POST["s_type"]);
		$sql = "SELECT * FROM job_offer WHERE type LIKE '%$t%' AND valid=1";
		$result = $conn->query($sql);
	}

	if(isset($_POST["s_employer"])){
		$t = trim($_POST["s_employer"]);
		$sql = "SELECT * FROM job_offer WHERE e_username LIKE '%$t%' AND valid=1";
		$result = $conn->query($sql);
	}

	if(isset($_POST["s_id"])){
		$t = trim($_POST["s_id"]);
		$sql = "SELECT * FROM job_offer WHERE job_id LIKE '%$t%' AND valid=1";
		$result = $conn->query($sql);
	}
	?>

	/* Empty results message styling */
	.no-results {
		text-align: center;
		padding: 30px;
		color: #666;
		font-size: 16px;
		background: #f8f9fa;
		border-radius: 8px;
		margin: 20px 0;
	}
	.no-results i {
		font-size: 40px;
		color: #999;
		margin-bottom: 15px;
		display: block;
	}

	/* Responsive improvements */
	@media (max-width: 768px) {
		body {
			padding-top: 60px;
		}
		.panel-heading {
			padding: 15px 20px;
			font-size: 18px;
		}
		.job-table th, .job-table td {
			padding: 12px 15px;
			font-size: 14px;
		}
		.search-box {
			padding: 20px;
		}
	}
</style>

</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand">Freelance Hub</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="allJob.php"><i class="fas fa-briefcase"></i> Browse Jobs</a></li>
                <li><a href="allFreelancer.php"><i class="fas fa-users"></i> Browse Freelancers</a></li>
                <li><a href="allEmployer.php"><i class="fas fa-building"></i> Browse Employers</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user-circle"></i> <?php echo $username;?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $linkPro; ?>"><i class="fas fa-user"></i> Profile</a></li>
						<li><a href="<?php echo $linkEditPro; ?>"><i class="fas fa-edit"></i> Edit Profile</a></li>
						<li><a href="message.php"><i class="fas fa-envelope"></i> Messages</a></li>
						<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
			        </ul>
			    </li>
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->

<div class="container">
<div class="row">
<!--Column 1-->
	<div class="col-lg-9">
            <div class="card">
			<div class="panel panel-success">
                    <div class="panel-heading">
                        <h3><i class="fas fa-briefcase"></i> All Job Offers</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <table class="job-table">
                                <thead>
                                    <tr>
                                        <th class="title-column">Title</th>
                                        <th class="type-column">Type</th>
                                        <th class="budget-column">Budget</th>
                                        <th class="employer-column">Employer</th>
                                        <th class="date-column">Posted on</th>
                                        <th class="action-column">Action</th>
                      </tr>
                                </thead>
                                <tbody>
                      <?php 
                      if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $job_id=$row["job_id"];
                                $title=$row["title"];
                                $type=$row["type"];
                                $budget=$row["budget"];
                                $e_username=$row["e_username"];
                                $timestamp=$row["timestamp"];
                                    ?>
                                    <tr>
                                        <td class="title-column"><?php echo $title; ?></td>
                                        <td class="type-column"><?php echo $type; ?></td>
                                        <td class="budget-column">₹<?php echo $budget; ?></td>
                                        <td class="employer-column"><?php echo $e_username; ?></td>
                                        <td class="date-column"><?php echo date("d M Y", strtotime($timestamp)); ?></td>
                                        <td class="action-column">
                                            <form action="allJob.php" method="post">
                                                <input type="hidden" name="jid" value="<?php echo $job_id; ?>">
                                                <input type="submit" class="btn btn-primary btn-sm" value="View Details">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                        } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No jobs found</td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                     </table>
                        </div>
                    </div>
			</div>
		</div>
	</div>
<!--End Column 1-->

<!--Column 2-->
	<div class="col-lg-3">
            <div class="search-box">
			<form action="allJob.php" method="post">
				<div class="form-group">
                        <input type="text" class="form-control" name="s_title" placeholder="Enter job title">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Job Title
                        </button>
				</div>
	        </form>

	        <form action="allJob.php" method="post">
				<div class="form-group">
                        <input type="text" class="form-control" name="s_type" placeholder="Enter job type">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Job Type
                        </button>
				</div>
	        </form>

	        <form action="allJob.php" method="post">
				<div class="form-group">
                        <input type="text" class="form-control" name="s_employer" placeholder="Enter employer name">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Employer
                        </button>
				</div>
	        </form>

	        <form action="allJob.php" method="post">
				<div class="form-group">
                        <input type="text" class="form-control" name="s_id" placeholder="Enter job ID">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Job ID
                        </button>
				</div>
	        </form>

	        <form action="allJob.php" method="post">
				<div class="form-group">
                        <button type="submit" name="recentJob" class="btn btn-warning">
                            <i class="fas fa-clock"></i> Recent Jobs First
                        </button>
				</div>
	        </form>

	        <form action="allJob.php" method="post">
				<div class="form-group">
                        <button type="submit" name="oldJob" class="btn btn-warning">
                            <i class="fas fa-history"></i> Older Jobs First
                        </button>
				</div>
	        </form>
	    </div>
	</div>
<!--End Column 2-->
</div>
</div>

<!--Footer-->
<div class="footer">
	<div class="container">
	<div class="row">
			<div class="col-md-4">
				<h3>About Us</h3>
				<p>Freelance Hub is a global freelancing platform where businesses and independent professionals connect and collaborate remotely.</p>
				<div class="social-links">
					<a href="#"><i class="fab fa-facebook-f"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-linkedin-in"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
				</div>
			</div>
			<div class="col-md-4">
			<h3>Quick Links</h3>
				<ul class="list-unstyled quick-links">
					<li><a href="index.php"><i class="fas fa-angle-right"></i> Home</a></li>
					<li><a href="allJob.php"><i class="fas fa-angle-right"></i> Browse Jobs</a></li>
					<li><a href="allFreelancer.php"><i class="fas fa-angle-right"></i> Freelancers</a></li>
					<li><a href="allEmployer.php"><i class="fas fa-angle-right"></i> Employers</a></li>
					<li><a href="#"><i class="fas fa-angle-right"></i> Contact Us</a></li>
				</ul>
		</div>
			<div class="col-md-4">
				<h3>Contact Info</h3>
				<div class="contact-info">
					<p><i class="fas fa-map-marker-alt"></i> Guntur, Andhra Pradesh, India</p>
					<p><i class="fas fa-phone"></i> +91 8374029227</p>
					<p><i class="fas fa-envelope"></i> abhignarao@gmail.com</p>
					<p><i class="fas fa-clock"></i> Monday - Friday: 9:00 AM to 6:00 PM</p>
		</div>
		</div>
		</div>
	</div>
</div>
<!--End Footer-->

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>