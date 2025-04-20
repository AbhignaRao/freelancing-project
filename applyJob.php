<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
}
else{
    $username="";
	//header("location: index.php");
}

if(isset($_SESSION["job_id"])){
    $job_id=$_SESSION["job_id"];
}
else{
    $job_id="";
    //header("location: index.php");
}

$sql = "SELECT * FROM apply WHERE job_id='$job_id' and f_username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $msg="You have already applied for this job. You cannot apply again.";
} else {
    $msg="";
}


if(isset($_POST["apply"]) && $msg==""){
    $cover=test_input($_POST["cover"]);
    $bid=test_input($_POST["bid"]);


    $sql = "INSERT INTO apply (f_username, job_id, bid, cover_letter) VALUES ('$username', '$job_id', '$bid','$cover')";

    
    $result = $conn->query($sql);
    if($result==true){
        header("location: allJob.php");
    }
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Apply for Job</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

	/* Header image */
	.header-image {
		background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('image/apply-job-header.jpg');
		background-size: cover;
		background-position: center;
		height: 200px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		margin-bottom: 30px;
	}
	.header-image h1 {
		font-size: 36px;
		font-weight: bold;
		text-align: center;
		text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
	}

	/* Form styling */
	.form-section {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		padding: 30px;
		margin-bottom: 30px;
	}
	.form-section h2 {
		color: #000;
		font-size: 24px;
		font-weight: bold;
		margin-bottom: 25px;
		padding-bottom: 15px;
		border-bottom: 2px solid #eee;
	}
	.form-control {
		height: 45px;
		border-radius: 8px;
		border: 2px solid #eee;
		padding: 10px 15px;
		font-size: 15px;
		transition: all 0.3s ease;
	}
	.form-control:focus {
		border-color: #000;
		box-shadow: none;
	}
	.editor-container {
		height: 300px;
		margin-bottom: 20px;
		border-radius: 8px;
		border: 2px solid #eee;
	}
	.bid-input {
		position: relative;
	}
	.bid-input:before {
		content: '$';
		position: absolute;
		left: 15px;
		top: 12px;
		font-size: 15px;
		color: #666;
	}
	.bid-input input {
		padding-left: 30px;
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

	/* Job preview */
	.job-preview {
		background: #f8f9fa;
		border-radius: 8px;
		padding: 20px;
		margin-bottom: 20px;
	}
	.job-preview h3 {
		color: #000;
		font-size: 18px;
		font-weight: bold;
		margin-bottom: 15px;
	}
	.job-preview p {
		color: #666;
		font-size: 14px;
		line-height: 1.6;
		margin-bottom: 10px;
	}
	.job-preview .label {
		display: inline-block;
		padding: 5px 10px;
		border-radius: 15px;
		font-size: 12px;
		font-weight: 600;
		margin-right: 5px;
	}

	/* Error message */
	.error-msg {
		color: #dc3545;
		background: #ffe6e6;
		padding: 15px;
		border-radius: 8px;
		margin-bottom: 20px;
		font-size: 14px;
		display: flex;
		align-items: center;
	}
	.error-msg i {
		margin-right: 10px;
		font-size: 18px;
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

<div class="container">
    <!-- Header Image -->
    <div class="header-image">
        <h1>Apply for Job</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Job Preview -->
            <div class="form-section">
                <h2><i class="fas fa-info-circle"></i> Job Overview</h2>
                <div class="job-preview">
                    <?php
                    $sql = "SELECT * FROM job_offer WHERE job_id='$job_id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<h3>'.$row["title"].'</h3>';
                        echo '<p>'.$row["description"].'</p>';
                        echo '<p><strong>Budget:</strong> $'.$row["budget"].'</p>';
                        echo '<p><strong>Required Skills:</strong></p>';
                        $skills = explode(',', $row["skills"]);
                        foreach($skills as $skill) {
                            echo '<span class="label label-primary">'.trim($skill).'</span> ';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Application Form -->
            <div class="form-section">
                <h2><i class="fas fa-paper-plane"></i> Submit Your Application</h2>
                <?php if($msg != "") { ?>
                    <div class="error-msg">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $msg; ?>
                    </div>
                <?php } ?>
                <form id="applicationForm" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label">Cover Letter</label>
                        <div id="editor" class="editor-container"></div>
                        <textarea name="cover" id="coverLetter" style="display:none"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Your Bid Amount</label>
                        <div class="bid-input">
                            <input type="number" class="form-control" name="bid" placeholder="Enter your bid amount" required min="1" step="0.01">
                        </div>
                        <small class="text-muted">Enter the amount you would like to bid for this project</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="apply" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Tips Section -->
            <div class="form-section">
                <h2><i class="fas fa-lightbulb"></i> Application Tips</h2>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Carefully review the job requirements</li>
                    <li><i class="fas fa-check text-success"></i> Highlight relevant experience</li>
                    <li><i class="fas fa-check text-success"></i> Be clear about your delivery timeline</li>
                    <li><i class="fas fa-check text-success"></i> Explain why you're the best fit</li>
                    <li><i class="fas fa-check text-success"></i> Proofread your application</li>
                </ul>
            </div>
        </div>
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your cover letter here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    // Update hidden form field before submit
    document.getElementById('applicationForm').onsubmit = function() {
        document.getElementById('coverLetter').value = quill.root.innerHTML;
    };
</script>

</body>
</html>