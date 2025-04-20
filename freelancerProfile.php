<?php 
include('server.php');

// Check if user is logged in
if(!isset($_SESSION["Username"])){
	header("location: index.php");
	exit();
}

$username = $_SESSION["Username"];

// Initialize variables with default values
$name = $email = $contactNo = $gender = $birthdate = $address = "";
$prof_title = $skills = $profile_sum = $education = $experience = "";

// Fetch user data from database
$sql = "SELECT * FROM freelancer WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	// Assign values from database with null coalescing
	$name = $row["Name"] ?? 'Not specified';
	$email = $row["email"] ?? 'Not specified';
	$contactNo = $row["contact_no"] ?? 'Not specified';
	$gender = $row["gender"] ?? 'Not specified';
	$birthdate = $row["birthdate"] ?? 'Not specified';
	$address = $row["address"] ?? 'Not specified';
	$prof_title = $row["prof_title"] ?? 'Not specified';
	$skills = $row["skills"] ?? 'Not specified';
	$profile_sum = $row["profile_sum"] ?? 'Not specified';
	$education = $row["education"] ?? 'Not specified';
	$experience = $row["experience"] ?? 'Not specified';
}

// Handle job details redirect
if(isset($_POST["jid"])){
	$_SESSION["job_id"] = $_POST["jid"];
	header("location: jobDetails.php");
	exit();
}

// Handle employer view redirect
if(isset($_POST["e_user"])){
	$_SESSION["e_user"] = $_POST["e_user"];
	header("location: viewEmployer.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Freelancer profile</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

<style>
	body {
		padding-top: 3%;
		margin: 0;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-color: #f5f5f5;
		color: #333;
	}

	/* Enhanced Navbar styling */
	.navbar-inverse {
		background-color: #000;
		border-color: #000;
		box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		padding: 10px 0;
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
	
	/* Enhanced Dropdown styling */
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

	/* Enhanced Profile Section */
	.profile-section {
		padding: 60px 0;
		background: linear-gradient(135deg, #000 0%, #333 100%);
		margin-bottom: 50px;
		border-bottom: 3px solid #fff;
	}
	.profile-card {
		background: rgba(255, 255, 255, 0.1);
		border: 1px solid rgba(255, 255, 255, 0.2);
		border-radius: 12px;
		padding: 40px;
		color: #fff;
		box-shadow: 0 10px 30px rgba(0,0,0,0.2);
		transition: all 0.3s ease;
	}
	.profile-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 15px 40px rgba(0,0,0,0.3);
	}
	.profile-card h2 {
		color: #fff;
		font-size: 36px;
		font-weight: bold;
		margin-bottom: 20px;
	}
	.profile-card .lead {
		font-size: 20px;
		color: rgba(255,255,255,0.9);
		margin-bottom: 15px;
	}
	.profile-card p i {
		margin-right: 10px;
		color: rgba(255,255,255,0.8);
	}

	/* Enhanced Content Cards */
	.card {
		background: #fff;
		border-radius: 12px;
		border: none;
		overflow: hidden;
		box-shadow: 0 5px 15px rgba(0,0,0,0.05);
		margin-bottom: 30px;
		padding: 30px;
		transition: all 0.3s ease;
	}
	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 25px rgba(0,0,0,0.1);
	}
	.card h3 {
		color: #000;
		font-size: 24px;
		font-weight: 600;
		margin-bottom: 25px;
		padding-bottom: 15px;
		border-bottom: 2px solid #000;
		position: relative;
	}
	.card h3:after {
		content: '';
		position: absolute;
		bottom: -2px;
		left: 0;
		width: 50px;
		height: 2px;
		background: #000;
		transition: all 0.3s ease;
	}
	.card:hover h3:after {
		width: 100%;
	}
	.card p {
		color: #555;
		font-size: 16px;
		line-height: 1.8;
		margin-bottom: 20px;
	}
	.card p strong {
		color: #333;
		margin-right: 10px;
	}
	.card p i {
		width: 25px;
		color: #000;
		margin-right: 10px;
	}

	/* Enhanced Button Styling */
	.btn {
		padding: 12px 30px;
		border-radius: 8px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 1px;
		transition: all 0.3s ease;
		border: 2px solid transparent;
		position: relative;
		overflow: hidden;
	}
	.btn:before {
		content: '';
		position: absolute;
		top: 50%;
		left: 50%;
		width: 0;
		height: 0;
		background: rgba(255,255,255,0.1);
		border-radius: 50%;
		transform: translate(-50%, -50%);
		transition: all 0.5s ease;
	}
	.btn:hover:before {
		width: 200%;
		height: 200%;
	}
	.btn-primary {
		background: #000;
		color: #fff;
		border-color: #000;
	}
	.btn-primary:hover {
		background: transparent;
		color: #000;
		border-color: #000;
		transform: translateY(-2px);
	}

	/* Enhanced Footer */
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
						<li><a href="freelancerProfile.php"><i class="fas fa-user"></i> Profile</a></li>
						<li><a href="editFreelancer.php"><i class="fas fa-edit"></i> Edit Profile</a></li>
						<li><a href="message.php"><i class="fas fa-envelope"></i> Messages</a></li>
						<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->

<!--main body-->
<div class="profile-section">
    <div class="container">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php echo $name; ?></h2>
                    <p class="lead"><?php echo $prof_title; ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $address; ?></p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="editfreelancer.php" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h3><i class="fas fa-user-circle"></i> Professional Title</h3>
                <p><?php echo !empty($prof_title) ? htmlspecialchars($prof_title) : 'Not specified'; ?></p>
            </div>

            <div class="card">
                <h3><i class="fas fa-info-circle"></i> Personal Info</h3>
                <p><strong>Email:</strong> <?php echo !empty($email) ? htmlspecialchars($email) : 'Not specified'; ?></p>
                <p><strong>Contact:</strong> <?php echo !empty($contactNo) ? htmlspecialchars($contactNo) : 'Not specified'; ?></p>
                <p><strong>Gender:</strong> <?php echo !empty($gender) ? htmlspecialchars($gender) : 'Not specified'; ?></p>
                <p><strong>Birth Date:</strong> <?php echo !empty($birthdate) ? htmlspecialchars($birthdate) : 'Not specified'; ?></p>
            </div>

            <div class="card">
                <h3><i class="fas fa-cogs"></i> Skills</h3>
                <p><?php echo !empty($skills) ? htmlspecialchars($skills) : 'No skills listed'; ?></p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <h3><i class="fas fa-user"></i> Profile Summary</h3>
                <p><?php echo !empty($profile_sum) ? htmlspecialchars($profile_sum) : 'No profile summary available'; ?></p>
            </div>

            <div class="card">
                <h3><i class="fas fa-graduation-cap"></i> Education</h3>
                <p><?php echo !empty($education) ? htmlspecialchars($education) : 'No education details provided'; ?></p>
            </div>

            <div class="card">
                <h3><i class="fas fa-briefcase"></i> Work Experience</h3>
                <p><?php echo !empty($experience) ? htmlspecialchars($experience) : 'No work experience listed'; ?></p>
            </div>
        </div>
    </div>
</div>
<!--End main body-->

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
					<p><i class="fas fa-phone"></i> +91 8374029227	</p>
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