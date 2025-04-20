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

if(isset($_SESSION["e_user"])){
	$e_user=$_SESSION["e_user"];
	$_SESSION["msgRcv"]=$e_user;
}

$sql = "SELECT * FROM employer WHERE username='$e_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$name=$row["Name"];
		$email=$row["email"];
		$contactNo=$row["contact_no"];
		$gender=$row["gender"];
		$birthdate=$row["birthdate"];
		$address=$row["address"];
		$company=$row["company"];
		$profile_sum=$row["profile_sum"];
	    }
} else {
    echo "0 results";
}


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Employer profile</title>
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
	}
	.navbar-inverse .navbar-nav > li > a {
		color: #fff;
		font-size: 16px;
		padding: 15px 25px;
		transition: all 0.3s ease;
		border-bottom: 2px solid transparent;
	}
	.navbar-inverse .navbar-nav > li > a:hover {
		color: #fff;
		border-bottom: 2px solid #fff;
	}
	.navbar-inverse .navbar-nav > li > a i {
		margin-right: 10px;
	}

	/* Dropdown styling */
	.dropdown-menu {
		background-color: #000;
		border: none;
		border-radius: 8px;
		box-shadow: 0 4px 20px rgba(0,0,0,0.2);
		padding: 15px 0;
		margin-top: 12px;
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
	}
	.dropdown-menu li a i {
		margin-right: 12px;
		width: 20px;
		text-align: center;
	}

	/* Card styling */
	.card {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		padding: 30px;
		margin-bottom: 30px;
	}
	.panel {
		border: none;
		box-shadow: none;
		margin-bottom: 30px;
	}
	.panel-heading {
		background: linear-gradient(45deg, #000, #333) !important;
		color: #fff !important;
		border: none;
		padding: 20px 25px;
		border-radius: 8px;
		font-size: 20px;
		font-weight: 600;
		margin-bottom: 20px;
	}
	.panel-body {
		padding: 20px 25px;
		background: #f8f9fa;
		border-radius: 8px;
		margin-bottom: 15px;
	}
	.panel-body h4 {
		margin: 0;
		color: #333;
		font-size: 16px;
		line-height: 1.6;
	}

	/* Profile image */
	.profile-img {
		width: 150px;
		height: 150px;
		border-radius: 50%;
		margin: 0 auto 20px;
		display: block;
		object-fit: cover;
		border: 5px solid #fff;
		box-shadow: 0 5px 15px rgba(0,0,0,0.1);
	}

	/* Social links */
	.social-links {
		margin-top: 25px;
	}
	.social-links a {
		display: inline-block;
		width: 40px;
		height: 40px;
		background: #333;
		color: #fff;
		text-align: center;
		line-height: 40px;
		border-radius: 50%;
		margin-right: 10px;
		transition: all 0.3s ease;
	}
	.social-links a:hover {
		background: #000;
		transform: translateY(-3px);
	}

	/* Footer styling */
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
	}

	/* Button styling */
	.btn {
		padding: 12px 25px;
		font-size: 15px;
		font-weight: 600;
		border-radius: 8px;
		transition: all 0.3s ease;
	}
	.btn-primary {
		background: #000;
		border: 2px solid #000;
	}
	.btn-primary:hover {
		background: #333;
		border-color: #333;
		transform: translateY(-2px);
	}
	.btn i {
		margin-right: 8px;
	}

	/* Table styling */
	table {
		width: 100%;
		margin-bottom: 0;
	}
	table td {
		padding: 12px 15px;
		border-bottom: 1px solid #eee;
		font-size: 15px;
		color: #666;
	}
	table tr:last-child td {
		border-bottom: none;
	}
	table tr:hover td {
		background: #f8f9fa;
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
			<a href="index.php" class="navbar-brand">Projectworlds Freelance</a>
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
        <div class="col-lg-4">
            <div class="card text-center">
                <img src="image/img04.jpg" alt="Profile Picture" class="profile-img">
                <h3><?php echo $name; ?></h3>
                <p><i class="fas fa-envelope"></i> <?php echo $email; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $contactNo; ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $address; ?></p>
                <p><i class="fas fa-venus-mars"></i> <?php echo $gender; ?></p>
                <p><i class="fas fa-calendar"></i> <?php echo $birthdate; ?></p>
                
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <!--End Column 1-->

        <!--Column 2-->
        <div class="col-lg-8">
            <div class="card">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3><i class="fas fa-building"></i> Company Profile</h3>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Company Name</div>
                    <div class="panel-body"><h4><?php echo $company; ?></h4></div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Profile Summary</div>
                    <div class="panel-body"><h4><?php echo $profile_sum; ?></h4></div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Current Projects</div>
                    <div class="panel-body">
                        <table>
                            <tr>
                                <td><strong>Job ID</strong></td>
                                <td><strong>Title</strong></td>
                                <td><strong>Freelancer</strong></td>
                            </tr>
                            <?php 
                            $sql = "SELECT * FROM job_offer,selected WHERE job_offer.job_id=selected.job_id AND selected.e_username='$e_user' AND selected.valid=1 ORDER BY job_offer.timestamp DESC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $job_id=$row["job_id"];
                                    $title=$row["title"];
                                    $f_username=$row["f_username"];
                                    $timestamp=$row["timestamp"];
                                    echo '
                                    <tr>
                                    <td>'.$job_id.'</td>
                                    <td>'.$title.'</td>
                                    <td>'.$f_username.'</td>
                                    </tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
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
				<ul class="list-unstyled">
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
