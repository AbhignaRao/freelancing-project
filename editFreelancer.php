<?php include('server.php');

if(isset($_SESSION["Username"])){
	$username = $_SESSION["Username"];
	
	// Initialize all variables with empty strings
	$name = $email = $contactNo = $gender = $birthdate = $address = "";
	$prof_title = $skills = $profile_sum = $education = $experience = "";
	
	// Fetch user data from database
	$sql = "SELECT * FROM freelancer WHERE username='$username'";
	$result = $conn->query($sql);
	
	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		// Assign values from database
		$name = $row["Name"] ?? '';
		$email = $row["email"] ?? '';
		$contactNo = $row["contact_no"] ?? '';
		$gender = $row["gender"] ?? '';
		$birthdate = $row["birthdate"] ?? '';
		$address = $row["address"] ?? '';
		$prof_title = $row["prof_title"] ?? '';
		$skills = $row["skills"] ?? '';
		$profile_sum = $row["profile_sum"] ?? '';
		$education = $row["education"] ?? '';
		$experience = $row["experience"] ?? '';
	}
} else {
	header("location: index.php");
	exit();
}

if(isset($_POST['update'])){
	// Sanitize all inputs
	$name = sanitize_input($_POST['name']);
	$email = sanitize_input($_POST['email']);
	$contactNo = sanitize_input($_POST['contactNo']);
	$gender = sanitize_input($_POST['gender']);
	$birthdate = sanitize_input($_POST['birthdate']);
	$address = sanitize_input($_POST['address']);
	$prof_title = sanitize_input($_POST['prof_title']);
	$skills = sanitize_input($_POST['skills']);
	$profile_sum = sanitize_input($_POST['profile_sum']);
	$education = sanitize_input($_POST['education']);
	$experience = sanitize_input($_POST['experience']);
	
	// Update all fields in the database
	$sql = "UPDATE freelancer SET 
			Name='$name',
			email='$email',
			contact_no='$contactNo',
			gender='$gender',
			birthdate='$birthdate',
			address='$address',
			prof_title='$prof_title',
			skills='$skills',
			profile_sum='$profile_sum',
			education='$education',
			experience='$experience'
			WHERE username='$username'";
			
	if(safe_query($sql)){
		$_SESSION['success'] = "Profile updated successfully!";
		header("location: freelancerProfile.php");
		exit();
	} else {
		$_SESSION['error'] = "Error updating profile. Please try again.";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Freelancer Profile</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">

<style>
	body {
		padding-top: 3%;
		margin: 0;
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		background-color: #f5f5f5;
		color: #333;
	}

	/* Navbar styling */
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

	/* Form Section Styling */
	.page-header {
		border: none;
		margin: 40px 0;
		padding-bottom: 20px;
		position: relative;
	}
	.page-header h2 {
		color: #000;
		font-size: 32px;
		font-weight: bold;
		margin: 0;
		padding-bottom: 15px;
		border-bottom: 2px solid #000;
		display: inline-block;
	}
	.page-header h2:after {
		content: '';
		position: absolute;
		bottom: 18px;
		left: 0;
		width: 50px;
		height: 2px;
		background: #000;
		transition: width 0.3s ease;
	}
	.page-header:hover h2:after {
		width: 100px;
	}

	/* Form Styling */
	.form-container {
		background: #fff;
		border-radius: 12px;
		padding: 40px;
		box-shadow: 0 5px 20px rgba(0,0,0,0.05);
		margin-bottom: 40px;
	}
	.form-group {
		margin-bottom: 25px;
		position: relative;
	}
	.control-label {
		color: #333;
		font-weight: 600;
		font-size: 15px;
		margin-bottom: 10px;
	}
	.form-control {
		height: 45px;
		border-radius: 6px;
		border: 1px solid #ddd;
		padding: 10px 15px;
		font-size: 15px;
		transition: all 0.3s ease;
		box-shadow: none;
	}
	.form-control:focus {
		border-color: #000;
		box-shadow: 0 0 5px rgba(0,0,0,0.1);
	}
	textarea.form-control {
		height: 120px;
		resize: vertical;
	}

	/* Radio Button Styling */
	.radio {
		margin: 10px 0;
	}
	.radio label {
		display: flex;
		align-items: center;
		font-size: 15px;
		color: #555;
		cursor: pointer;
		padding: 8px 0;
		transition: all 0.3s ease;
	}
	.radio label:hover {
		color: #000;
	}
	.radio input[type="radio"] {
		margin-right: 10px;
		transform: scale(1.2);
	}

	/* Button Styling */
	.btn {
		padding: 12px 30px;
		font-size: 16px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 1px;
		border-radius: 6px;
		transition: all 0.3s ease;
		margin-top: 20px;
	}
	.btn-primary {
		background: #000;
		border: 2px solid #000;
		color: #fff;
	}
	.btn-primary:hover {
		background: transparent;
		color: #000;
		transform: translateY(-2px);
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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h2>Edit Profile</h2>
            </div>

            <div class="form-container">
                <form id="registrationForm" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Enter your full name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email address</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Enter your email" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Contact no.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="contactNo" value="<?php echo $contactNo; ?>" placeholder="Enter your contact number" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Gender</label>
                        <div class="col-sm-8">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=="male") echo "checked";?> />
                                    <i class="fas fa-male"></i> Male
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=="female") echo "checked";?> />
                                    <i class="fas fa-female"></i> Female
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" value="other" <?php if (isset($gender) && $gender=="other") echo "checked";?> />
                                    <i class="fas fa-user"></i> Other
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Date of birth</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="birthdate" value="<?php echo $birthdate; ?>" placeholder="YYYY/MM/DD" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" placeholder="Enter your address" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Professional Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="prof_title" value="<?php echo htmlspecialchars($prof_title); ?>" placeholder="Enter your professional title" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Skills</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="skills" rows="5"><?php echo htmlspecialchars($skills); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Profile Summary</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="profile_sum" rows="5"><?php echo htmlspecialchars($profile_sum); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Education</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="education" rows="5"><?php echo htmlspecialchars($education); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Experience</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="experience" rows="5"><?php echo htmlspecialchars($experience); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
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
<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

<script>
$(document).ready(function() {
    $('#registrationForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    emailAddress: {
                        message: 'Please enter a valid email address'
                    }
                }
            },
            contactNo: {
                validators: {
                    notEmpty: {
                        message: 'Contact number is required'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Please enter a valid contact number'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Please select your gender'
                    }
                }
            },
            birthdate: {
                validators: {
                    notEmpty: {
                        message: 'Date of birth is required'
                    },
                    date: {
                        format: 'YYYY/MM/DD',
                        message: 'Please enter a valid date in YYYY/MM/DD format'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'Address is required'
                    }
                }
            },
            prof_title: {
                validators: {
                    notEmpty: {
                        message: 'Professional title is required'
                    }
                }
            },
            skills: {
                validators: {
                    notEmpty: {
                        message: 'Please enter at least one skill'
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>