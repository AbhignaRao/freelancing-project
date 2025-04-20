<?php include('server.php');
if(!isset($_SESSION["Username"])){
    header("location: index.php");
    exit();
}

$username = $_SESSION["Username"];

// Initialize variables with default values
$name = $email = $contactNo = $gender = $birthdate = $address = $profile_sum = $company = "";

// Add sample data if no records exist
$sql = "SELECT COUNT(*) as count FROM selected WHERE e_username='$username'";
$result = safe_query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Get current timestamp for recent jobs
    $current_time = date('Y-m-d H:i:s');
    $two_days_ago = date('Y-m-d H:i:s', strtotime('-2 days'));
    $five_days_ago = date('Y-m-d H:i:s', strtotime('-5 days'));
    $week_ago = date('Y-m-d H:i:s', strtotime('-1 week'));
    $two_weeks_ago = date('Y-m-d H:i:s', strtotime('-2 weeks'));
    $month_ago = date('Y-m-d H:i:s', strtotime('-1 month'));

    // Insert sample current job offerings with real-time timestamps
    $sample_jobs = array(
        array('Full Stack Developer', 'Full-time', 'Looking for an experienced full stack developer for our e-commerce platform...', 6000, 'PHP,React,Node.js', 'E-commerce experience', $two_days_ago),
        array('Mobile App Developer', 'Contract', 'Need a skilled mobile app developer for iOS and Android development...', 4500, 'React Native,iOS,Android', 'Published apps', $five_days_ago),
        array('UI/UX Designer', 'Part-time', 'Seeking creative UI/UX designer for our product redesign...', 3500, 'Figma,Adobe XD', 'Portfolio required', $week_ago)
    );

    foreach ($sample_jobs as $job) {
        $sql = "INSERT INTO job_offer (e_username, title, type, description, budget, skills, special_skill, timestamp, valid) 
                VALUES ('$username', '$job[0]', '$job[1]', '$job[2]', $job[3], '$job[4]', '$job[5]', '$job[6]', 1)";
        safe_query($sql);

        // Store the last inserted job id
        $last_job_id = mysqli_insert_id($conn);
        
        // For the first two jobs, add currently hired freelancers
        if ($job[0] == 'Full Stack Developer' || $job[0] == 'Mobile App Developer') {
            $f_username = ($job[0] == 'Full Stack Developer') ? 'dev_master' : 'app_expert';
            $sql = "INSERT INTO selected (f_username, job_id, e_username, price, valid, timestamp) 
                    VALUES ('$f_username', $last_job_id, '$username', $job[3], 1, '$job[6]')";
            safe_query($sql);
        }
    }

    // Insert sample previous job offerings
    $sample_past_jobs = array(
        array('Content Writer', 'Freelance', 'Content writing for our company blog...', 2000, 'Writing,SEO', 'SEO knowledge', $two_weeks_ago),
        array('Digital Marketing Expert', 'Project', 'Social media campaign management...', 3000, 'Social Media,Marketing', 'Campaign experience', $month_ago),
        array('Backend Developer', 'Contract', 'API development and database optimization...', 5000, 'Python,Django,PostgreSQL', 'API experience', date('Y-m-d H:i:s', strtotime('-6 weeks')))
    );

    foreach ($sample_past_jobs as $job) {
        $sql = "INSERT INTO job_offer (e_username, title, type, description, budget, skills, special_skill, timestamp, valid) 
                VALUES ('$username', '$job[0]', '$job[1]', '$job[2]', $job[3], '$job[4]', '$job[5]', '$job[6]', 0)";
        safe_query($sql);

        // Store the last inserted job id
        $last_job_id = mysqli_insert_id($conn);
        
        // Add previously hired freelancers for completed jobs
        $f_username = str_replace(' ', '_', strtolower($job[0])) . '_pro';
        $sql = "INSERT INTO selected (f_username, job_id, e_username, price, valid, timestamp) 
                VALUES ('$f_username', $last_job_id, '$username', $job[3], 0, '$job[6]')";
        safe_query($sql);
    }
}

// Fetch user data from database using safe query
$sql = "SELECT * FROM employer WHERE username='$username'";
$result = safe_query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Assign values from database with null coalescing
    $name = $row["Name"] ?? 'Not specified';
    $email = $row["email"] ?? 'Not specified';
    $contactNo = $row["contact_no"] ?? 'Not specified';
    $gender = $row["gender"] ?? 'Not specified';
    $birthdate = $row["birthdate"] ?? 'Not specified';
    $address = $row["address"] ?? 'Not specified';
    $profile_sum = $row["profile_sum"] ?? 'Not specified';
    $company = $row["company"] ?? 'Not specified';
} else {
    $_SESSION['error'] = "Could not retrieve profile data. Please try again.";
}

// Get job offers
$sql = "SELECT * FROM job_offer WHERE e_username='$username' and valid=1 ORDER BY timestamp DESC";
$job_result = safe_query($sql);

if(isset($_POST["jid"])){
	$_SESSION["job_id"]=$_POST["jid"];
	header("location: jobDetails.php");
}

if(isset($_POST["f_user"])){
	$_SESSION["f_user"]=$_POST["f_user"];
	header("location: viewFreelancer.php");
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Employer Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
		.profile-header {
			background: linear-gradient(135deg, #000 0%, #333 100%);
			padding: 60px 30px;
			border-radius: 12px;
			margin-bottom: 30px;
			color: #fff;
			text-align: center;
			box-shadow: 0 10px 30px rgba(0,0,0,0.2);
			transition: all 0.3s ease;
		}
		.profile-header:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 40px rgba(0,0,0,0.3);
		}
		.profile-img {
			width: 150px;
			height: 150px;
			border-radius: 50%;
			border: 4px solid #fff;
			margin-bottom: 20px;
			box-shadow: 0 5px 15px rgba(0,0,0,0.2);
			transition: all 0.3s ease;
		}
		.profile-img:hover {
			transform: scale(1.05);
			border-color: #00c6ff;
		}

		/* Enhanced Card Styling */
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

		/* Enhanced Panel Styling */
		.panel {
			background: #fff;
			border: none;
			border-radius: 12px;
			box-shadow: 0 5px 15px rgba(0,0,0,0.05);
			margin-bottom: 30px;
			transition: all 0.3s ease;
		}
		.panel:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 25px rgba(0,0,0,0.1);
		}
		.panel-heading {
			border-radius: 12px 12px 0 0;
			padding: 20px 25px;
		}
		.panel-primary > .panel-heading {
			background: linear-gradient(135deg, #000 0%, #333 100%);
			border: none;
		}
		.panel-info > .panel-heading {
			background: linear-gradient(135deg, #000 0%, #333 100%);
			border: none;
		}
		.panel-title {
			font-size: 20px;
			font-weight: 600;
			color: #fff;
		}
		.panel-body {
			padding: 25px;
		}

		/* Enhanced Table Styling */
		.table {
			margin-bottom: 0;
		}
		.table > thead > tr > th {
			border-bottom: 2px solid #000;
			font-weight: 600;
			padding: 15px;
			color: #000;
		}
		.table > tbody > tr > td {
			padding: 15px;
			vertical-align: middle;
			border-top: 1px solid #eee;
			color: #555;
		}
		.table > tbody > tr:hover {
			background-color: #f9f9f9;
		}
		.btn-link {
			color: #000;
			font-weight: 500;
			transition: all 0.3s ease;
		}
		.btn-link:hover {
			color: #00c6ff;
			text-decoration: none;
			transform: translateX(5px);
		}

		/* Enhanced Wallet Card */
		.wallet-card {
			background: linear-gradient(135deg, #000 0%, #333 100%);
			border-radius: 12px;
			padding: 30px;
			color: #fff;
			box-shadow: 0 10px 30px rgba(0,0,0,0.2);
			transition: all 0.3s ease;
		}
		.wallet-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 40px rgba(0,0,0,0.3);
		}
		.wallet-balance {
			font-size: 32px;
			font-weight: bold;
			color: #fff;
			margin-bottom: 10px;
			text-shadow: 0 2px 4px rgba(0,0,0,0.2);
		}

		/* Enhanced Social Links */
		.social-links .list-group-item {
			background: transparent;
			border: none;
			padding: 15px 20px;
			transition: all 0.3s ease;
		}
		.social-links .list-group-item:hover {
			transform: translateX(5px);
			background: rgba(255,255,255,0.1);
		}
		.social-links .list-group-item a {
			color: #fff;
			font-size: 16px;
			text-decoration: none;
			display: flex;
			align-items: center;
		}
		.social-links .list-group-item i {
			font-size: 24px;
			margin-right: 15px;
			transition: all 0.3s ease;
		}
		.social-links .list-group-item:hover i {
			transform: scale(1.2);
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

		.rating-summary {
			padding: 15px 0;
		}
		.overall-rating {
			text-align: center;
			margin-bottom: 20px;
		}
		.stars {
			color: #ffc107;
			font-size: 24px;
			margin-bottom: 10px;
		}
		.rating-text {
			font-size: 18px;
			font-weight: bold;
			color: #333;
		}
		.rating-stats {
			margin: 20px 0;
		}
		.stat-item {
			display: flex;
			align-items: center;
			margin-bottom: 8px;
		}
		.stat-item .label {
			width: 60px;
			text-align: right;
			margin-right: 10px;
			color: #666;
		}
		.stat-item .progress {
			flex: 1;
			height: 8px;
			margin: 0 10px;
			background-color: #eee;
		}
		.stat-item .count {
			width: 30px;
			color: #666;
		}
		.recent-reviews {
			margin-top: 20px;
		}
		.review-item {
			margin-bottom: 20px;
			padding-bottom: 20px;
			border-bottom: 1px solid #eee;
		}
		.review-item:last-child {
			margin-bottom: 0;
			padding-bottom: 0;
			border-bottom: none;
		}
		.review-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 10px;
		}
		.review-date {
			color: #999;
			font-size: 14px;
		}
		.review-text {
			color: #666;
			font-style: italic;
			margin: 0;
			line-height: 1.5;
		}
</style>
</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
	<div class="container">
		<div class="navber-header">
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
				<li><a href="allJob.php">Browse all jobs</a></li>
				<li><a href="allFreelancer.php">Browse Freelancers</a></li>
				<li><a href="allEmployer.php">Browse Employers</a></li>
				<li class="dropdown" style="background:#000;padding:0 20px 0 20px;">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?>
			        </a>
			        <ul class="dropdown-menu list-group list-group-item-info">
			        	<a href="employerProfile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span>  View profile</a>
			          	<a href="editEmployer.php" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span>  Edit Profile</a>
					  	<a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span>  Messages</a> 
					  	<a href="logout.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Logout</a>
			        </ul>
			    </li>
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->


<!--main body-->
<div class="container-fluid" style="margin-top:20px">
<div class="row">
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

<!--Column 1-->
	<div class="col-lg-3">

<!--Main profile card-->
		<div class="profile-header text-center">
			<img src="image/img04.jpg" alt="Profile Photo" class="profile-img">
			<h2><?php echo $name; ?></h2>
			<p><i class="fas fa-map-marker-alt"></i> <?php echo $address; ?></p>
	    </div>
<!--End Main profile card-->

<!--Contact Information-->
		<div class="card">
			<h3><i class="fas fa-info-circle"></i> Contact Information</h3>
			<hr>
			<p><i class="fas fa-envelope"></i> <?php echo $email; ?></p>
			<p><i class="fas fa-phone"></i> <?php echo $contactNo; ?></p>
			<p><i class="fas fa-building"></i> <?php echo $company; ?></p>
		</div>
<!--End Contact Information-->

<!--Reputation-->
		<div class="card">
			<h3><i class="fas fa-star"></i> Reputation</h3>
			<hr>
			<div class="rating-summary">
				<div class="overall-rating">
					<div class="stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star-half-alt"></i>
					</div>
					<div class="rating-text">4.5 out of 5</div>
				</div>
				<div class="rating-stats">
					<div class="stat-item">
						<span class="label">5 stars</span>
						<div class="progress">
							<div class="progress-bar bg-success" style="width: 75%"></div>
						</div>
						<span class="count">15</span>
					</div>
					<div class="stat-item">
						<span class="label">4 stars</span>
						<div class="progress">
							<div class="progress-bar bg-success" style="width: 20%"></div>
						</div>
						<span class="count">4</span>
					</div>
					<div class="stat-item">
						<span class="label">3 stars</span>
						<div class="progress">
							<div class="progress-bar bg-warning" style="width: 5%"></div>
						</div>
						<span class="count">1</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="recent-reviews">
				<h4>Recent Reviews</h4>
				<div class="review-item">
					<div class="review-header">
						<div class="stars">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
						</div>
						<span class="review-date">January 15, 2024</span>
					</div>
					<p class="review-text">"Outstanding employer! Clear communication and timely payments."</p>
				</div>
				<div class="review-item">
					<div class="review-header">
						<div class="stars">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="far fa-star"></i>
						</div>
						<span class="review-date">January 10, 2024</span>
					</div>
					<p class="review-text">"Great experience working with this employer. Well-defined project requirements."</p>
				</div>
			</div>
		</div>
<!--End Reputation-->

	</div>
<!--End Column 1-->

<!--Column 2-->
	<div class="col-lg-7">

<!--Employer Profile Details-->	
			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-briefcase"></i> Current Job Offerings</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Job ID</th>
								<th>Title</th>
								<th>Posted on</th>
                      </tr>
						</thead>
						<tbody>
                      <?php 
						if ($job_result->num_rows > 0) {
							while($row = $job_result->fetch_assoc()) {
                                echo '
								<tr>
                                <form action="employerProfile.php" method="post">
									<input type="hidden" name="jid" value="'.$row["job_id"].'">
									<td>'.$row["job_id"].'</td>
									<td><button type="submit" class="btn btn-link">'.$row["title"].'</button></td>
									<td>'.$row["timestamp"].'</td>
                                </form>
								</tr>';
                                }
                        } else {
							echo '<tr><td colspan="3" class="text-center">No current job offerings</td></tr>';
                        }
                       ?>
						</tbody>
                  </table>
				</div>
			</div>
		</div>

			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-history"></i> Previous Job Offerings</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Job ID</th>
								<th>Title</th>
								<th>Posted on</th>
                      </tr>
						</thead>
						<tbody>
                      <?php 
                      	$sql = "SELECT * FROM job_offer WHERE e_username='$username' and valid=0 ORDER BY timestamp DESC";
						$result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '
								<tr>
                                <form action="employerProfile.php" method="post">
									<input type="hidden" name="jid" value="'.$row["job_id"].'">
									<td>'.$row["job_id"].'</td>
									<td><button type="submit" class="btn btn-link">'.$row["title"].'</button></td>
									<td>'.$row["timestamp"].'</td>
                                </form>
								</tr>';
                                }
                        } else {
							echo '<tr><td colspan="3" class="text-center">No previous job offerings</td></tr>';
                        }
                       ?>
						</tbody>
                  </table>
				</div>
			</div>
		</div>

			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-users"></i> Currently Hired Freelancers</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Job ID</th>
								<th>Title</th>
								<th>Freelancer</th>
								<th>Date</th>
                      </tr>
						</thead>
						<tbody>
                      <?php 
                      	$sql = "SELECT * FROM job_offer,selected WHERE job_offer.job_id=selected.job_id AND selected.e_username='$username' AND selected.valid=1 ORDER BY job_offer.timestamp DESC";
						$result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '
								<tr>
									<td>'.$row["job_id"].'</td>
									<td>
                                <form action="employerProfile.php" method="post">
										<input type="hidden" name="jid" value="'.$row["job_id"].'">
										<button type="submit" class="btn btn-link">'.$row["title"].'</button>
                                    </form>
									</td>
									<td>
                                    <form action="employerProfile.php" method="post">
										<input type="hidden" name="f_user" value="'.$row["f_username"].'">
										<button type="submit" class="btn btn-link">'.$row["f_username"].'</button>
                                </form>
									</td>
									<td>'.$row["timestamp"].'</td>
								</tr>';
                                }
                        } else {
							echo '<tr><td colspan="4" class="text-center">No currently hired freelancers</td></tr>';
                        }
                       ?>
						</tbody>
                  </table>
				</div>
			</div>
		</div>

			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-users"></i> Previously Hired Freelancers</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Job ID</th>
								<th>Title</th>
								<th>Freelancer</th>
                      </tr>
						</thead>
						<tbody>
                      <?php 
                      	$sql = "SELECT * FROM job_offer,selected WHERE job_offer.job_id=selected.job_id AND selected.e_username='$username' AND selected.valid=0 ORDER BY job_offer.timestamp DESC";
						$result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '
                                    <tr>
									<td>'.$row["job_id"].'</td>
									<td><input type="submit" class="btn btn-link btn-lg" value="'.$row["title"].'"></td>
                                    </form>
                                    <form action="employerProfile.php" method="post">
									<input type="hidden" name="f_user" value="'.$row["f_username"].'">
									<td><input type="submit" class="btn btn-link btn-lg" value="'.$row["f_username"].'"></td>
									<td>'.$row["timestamp"].'</td>
								</tr>';
                                }
                        } else {
							echo '<tr><td colspan="3" class="text-center">No previously hired freelancers</td></tr>';
                        }
                       ?>
						</tbody>
                  </table>
				</div>
			</div>
		</div>
	</div>
<!--End Column 2-->


<!--Column 3-->
	<div class="col-lg-2">
		<!-- Removed wallet and social networks sections -->
	</div>
<!--End Column 3-->

</div>
</div>
<!--End main body-->


<!--Footer-->
<div class="footer" style="background-color: #000; padding: 50px 0; color: #fff;">
    <div class="container">
	<div class="row">
            <div class="col-md-3">
                <h3 style="color: #fff; font-size: 24px; margin-bottom: 20px;">About Us</h3>
                <p style="color: #999; line-height: 1.8;">We are a leading freelance platform connecting talented professionals with businesses worldwide. Our mission is to empower freelancers and help businesses find the perfect talent for their projects.</p>
            </div>
            <div class="col-md-3">
                <h3 style="color: #fff; font-size: 24px; margin-bottom: 20px;">Quick Links</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="index.php" style="color: #999; text-decoration: none; transition: all 0.3s;">Home</a></li>
                    <li style="margin-bottom: 10px;"><a href="allJob.php" style="color: #999; text-decoration: none; transition: all 0.3s;">Browse Jobs</a></li>
                    <li style="margin-bottom: 10px;"><a href="allFreelancer.php" style="color: #999; text-decoration: none; transition: all 0.3s;">Browse Freelancers</a></li>
                    <li style="margin-bottom: 10px;"><a href="allEmployer.php" style="color: #999; text-decoration: none; transition: all 0.3s;">Browse Employers</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3 style="color: #fff; font-size: 24px; margin-bottom: 20px;">Contact Us</h3>
                <p style="color: #999; line-height: 1.8;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i> abhignarao<br>
                    <i class="fas fa-phone" style="margin-right: 10px;"></i> +91 8374029227<br>
                    <i class="fas fa-envelope" style="margin-right: 10px;"></i> abhignarao@gmail.com
                </p>
            </div>
            <div class="col-md-3">
                <h3 style="color: #fff; font-size: 24px; margin-bottom: 20px;">Follow Us</h3>
                <div class="social-icons">
                    <a href="#" style="color: #fff; font-size: 24px; margin-right: 15px; transition: all 0.3s;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: #fff; font-size: 24px; margin-right: 15px; transition: all 0.3s;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: #fff; font-size: 24px; margin-right: 15px; transition: all 0.3s;"><i class="fab fa-linkedin"></i></a>
                    <a href="#" style="color: #fff; font-size: 24px; margin-right: 15px; transition: all 0.3s;"><i class="fab fa-instagram"></i></a>
                </div>
                <div style="margin-top: 20px;">
                    <form>
                        <div class="input-group">
                            <span class="input-group-btn">
                            </span>
                        </div>
                    </form>
                </div>
		</div>
		</div>
        <div class="row" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="col-md-12 text-center">
                <p style="color: #999; margin: 0;">© 2024 Freelancing Platform. All rights reserved.</p>
		</div>
		</div>
	</div>
</div>
<!--End Footer-->

<style>
/* Footer specific styles */
.footer a:hover {
    color: #fff !important;
    text-decoration: none;
}
.footer .social-icons a:hover {
    color: #007bff !important;
    transform: translateY(-3px);
}
.footer .form-control::placeholder {
    color: #999;
}
.footer .form-control:focus {
    background: rgba(255,255,255,0.2);
    box-shadow: none;
}
.footer .btn-primary:hover {
    background: #0056b3;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>