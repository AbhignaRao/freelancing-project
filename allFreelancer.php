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

if(isset($_POST["f_user"])){
	$_SESSION["f_user"]=$_POST["f_user"];
	header("location: viewFreelancer.php");
}

$sql = "SELECT * FROM freelancer";
$result = $conn->query($sql);

if(isset($_POST["s_username"])){
	$t = trim($_POST["s_username"]);
	$sql = "SELECT * FROM freelancer WHERE username LIKE '%$t%'";
	$result = $conn->query($sql);
}

if(isset($_POST["s_name"])){
	$t = trim($_POST["s_name"]);
	$sql = "SELECT * FROM freelancer WHERE Name LIKE '%$t%'";
	$result = $conn->query($sql);
}

if(isset($_POST["s_email"])){
	$t = trim($_POST["s_email"]);
	$sql = "SELECT * FROM freelancer WHERE email LIKE '%$t%'";
	$result = $conn->query($sql);
}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>All Freelancers</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

<style>
	body {
		padding-top: 100px;
		margin: 0;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-color: #f8f9fa;
		color: #333;
	}

	/* Container spacing */
	.container {
		padding-top: 30px;
	}

	/* Navbar styling */
	.navbar-inverse {
		background-color: #000;
		border-color: #000;
		box-shadow: 0 2px 15px rgba(0,0,0,0.1);
		padding: 15px 0;
		min-height: 70px;
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

	/* Card and Table Styling */
	.card {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		padding: 0;
		margin-top: 20px;
		margin-bottom: 40px;
		border: none;
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
	.panel-body {
		padding: 30px;
	}

	/* Freelancer Table Styling */
	.freelancer-table {
		width: 100%;
		margin-top: 0;
		border-collapse: separate;
		border-spacing: 0 15px;
	}
	.freelancer-table th {
		background: #f8f9fa;
		padding: 18px 20px;
		font-size: 15px;
		font-weight: 600;
		color: #333;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		border-bottom: 2px solid #000;
	}
	.freelancer-table td {
		padding: 20px;
		vertical-align: middle;
		background: #fff;
		border: 1px solid #eee;
		transition: all 0.3s ease;
	}
	.freelancer-table tr:hover td {
		background: #f8f9fa;
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(0,0,0,0.05);
	}
	.freelancer-table .btn-link {
		color: #000;
		font-weight: 600;
		padding: 0;
		font-size: 15px;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	.freelancer-table .btn-link:hover {
		color: #333;
		text-decoration: none;
		transform: translateX(5px);
	}

	/* Search Box Styling */
	.search-box {
		background: #fff;
		border-radius: 12px;
		padding: 30px;
		margin-bottom: 30px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		border: none;
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
		.freelancer-table th, .freelancer-table td {
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
                        <h3><i class="fas fa-users"></i> All Freelancers</h3>
                    </div>
                    <div class="panel-body">
                        <table class="freelancer-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Skills</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $f_username=$row["username"];
                                        $name=$row["Name"];
                                        $email=$row["email"];
                                        $skills=$row["skills"];

                                        echo '
                                        <form action="allFreelancer.php" method="post">
                                        <input type="hidden" name="f_user" value="'.$f_username.'">
                                            <tr>
                                            <td><input type="submit" class="btn btn-link" value="'.$f_username.'"></td>
                                            <td>'.$name.'</td>
                                            <td>'.$email.'</td>
                                            <td>'.$skills.'</td>
                                            </tr>
                                        </form>
                                        ';
                                    }
                                } else {
                                    echo '<tr><td colspan="4" class="no-results"><i class="fas fa-search"></i>No freelancers found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--End Column 1-->

        <!--Column 2-->
        <div class="col-lg-3">
            <div class="search-box">
                <form action="allFreelancer.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="s_username" placeholder="Enter username">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Username
                        </button>
                    </div>
                </form>

                <form action="allFreelancer.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="s_name" placeholder="Enter name">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Name
                        </button>
                    </div>
                </form>

                <form action="allFreelancer.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="s_email" placeholder="Enter email">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Search by Email
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
				<p>Projectworlds Freelance is a global freelancing platform where businesses and independent professionals connect and collaborate remotely.</p>
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