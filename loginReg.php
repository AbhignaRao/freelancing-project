<?php
session_start();

// Initialize form variables
$errorMsg = "";
$errorMsg2 = "";
$name = "";
$username = "";
$email = "";
$password = "";
$contactNo = "";
$birthdate = "";
$address = "";
$usertype = "";

// Initialize validation flags
$validation_complete = false;
$form_submitted = false;

include('server.php');

// Add error handling for include
if (!file_exists('server.php')) {
    die("Error: Required configuration file 'server.php' is missing.");
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login/Register - Freelancing Platform</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #f8f9fa;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			padding-top: 70px;
		}

		/* Navbar Styling */
		.navbar {
			background-color: #000;
			border: none;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			min-height: 70px;
		}
		.navbar-brand {
			color: #fff !important;
			font-size: 24px;
			font-weight: 600;
			height: 70px;
			line-height: 40px;
		}
		.navbar-toggle {
			margin-top: 18px;
		}

		/* Header Section */
		.header-section {
			background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('images/header-bg.jpg');
			background-size: cover;
			background-position: center;
			color: white;
			padding: 100px 0 80px;
			text-align: center;
			margin-bottom: 60px;
		}
		.header-section h1 {
			font-size: 3.5em;
			margin-bottom: 20px;
			font-weight: 700;
			text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
		}
		.header-section p {
			font-size: 1.3em;
			max-width: 700px;
			margin: 0 auto;
			line-height: 1.6;
		}

		/* Form Container */
		.auth-container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 0 20px;
		}
		.auth-card {
			background: white;
			padding: 40px;
			border-radius: 15px;
			box-shadow: 0 5px 30px rgba(0,0,0,0.1);
			margin-bottom: 30px;
		}
		.page-header {
			text-align: center;
			border-bottom: none;
			margin: 0 0 30px;
		}
		.page-header h2 {
			color: #000;
			font-weight: 600;
			font-size: 2.2em;
			margin-bottom: 10px;
		}

		/* Form Elements */
		.form-group {
			margin-bottom: 25px;
			position: relative;
		}
		.form-group label {
			font-weight: 500;
			color: #333;
			margin-bottom: 8px;
			display: block;
		}
		.input-group {
			width: 100%;
		}
		.input-group-addon {
			background: #f8f9fa;
			border-color: #ddd;
			color: #666;
		}
		.form-control {
			height: 48px;
			border-radius: 8px;
			border: 2px solid #ddd;
			padding: 10px 15px;
			font-size: 15px;
			transition: all 0.3s ease;
		}
		.form-control:focus {
			border-color: #000;
			box-shadow: none;
		}

		/* Radio Buttons */
		.gender-section {
			margin: 25px 0;
		}
		.radio-group {
			display: flex;
			gap: 30px;
			margin-top: 10px;
		}
		.radio-group label {
			display: flex;
			align-items: center;
			cursor: pointer;
			font-weight: normal;
		}
		.radio-group input[type="radio"] {
			margin-right: 8px;
		}

		/* Buttons */
		.btn-custom {
			background: #000;
			color: white;
			padding: 12px 30px;
			border-radius: 8px;
			font-size: 16px;
			font-weight: 500;
			letter-spacing: 0.5px;
			transition: all 0.3s ease;
			width: 100%;
			margin-top: 20px;
		}
		.btn-custom:hover {
			background: #333;
			color: white;
			transform: translateY(-2px);
		}

		/* Error Messages */
		.error-msg {
			color: #dc3545;
			background: #ffe6e6;
			padding: 15px;
			border-radius: 8px;
			margin-bottom: 20px;
			display: none;
		}
		.error-msg:not(:empty) {
			display: block;
		}

		/* Responsive Design */
		@media (max-width: 768px) {
			.header-section {
				padding: 60px 0;
			}
			.header-section h1 {
				font-size: 2.5em;
			}
			.auth-card {
				padding: 25px;
			}
			.radio-group {
				flex-direction: column;
				gap: 15px;
			}
		}

		/* Additional Enhancements */
		.form-divider {
			text-align: center;
			margin: 30px 0;
			position: relative;
		}
		.form-divider:before {
			content: '';
			position: absolute;
			top: 50%;
			left: 0;
			right: 0;
			height: 1px;
			background: #ddd;
		}
		.form-divider span {
			background: white;
			padding: 0 15px;
			color: #666;
			position: relative;
		}
		
		/* Password Toggle */
		.password-toggle {
			position: absolute;
			right: 15px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #666;
			z-index: 10;
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
			</button>
			<a href="index.php" class="navbar-brand">Freelance Hub</a>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->

<!-- Header Section -->
<section class="header-section">
	<div class="container">
		<h1>Welcome to Freelance Hub</h1>
		<p>Join our community of talented freelancers and businesses. Find the perfect match for your next project.</p>
	</div>
</section>

<div class="container">
	<div class="row">
		<!-- Login Form -->
		<div class="col-md-6">
			<div class="auth-card">
				<div class="page-header">
					<h2>Login</h2>
					<p>Welcome back! Please login to your account</p>
				</div>
				
				<form id="loginForm" method="post">
					<div class="error-msg">
						<?php echo $errorMsg; ?>
					</div>
					
					<div class="form-group">
						<label>Username</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-user"></i></span>
							<input type="text" class="form-control" name="username" placeholder="Enter your username" required>
						</div>
					</div>

					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-lock"></i></span>
							<input type="password" class="form-control" name="password" placeholder="Enter your password" required>
							<span class="password-toggle"><i class="fas fa-eye"></i></span>
						</div>
					</div>

					<div class="form-group gender-section">
						<label>User Type</label>
						<div class="radio-group">
							<label><input type="radio" name="usertype" value="freelancer" required> Freelancer</label>
							<label><input type="radio" name="usertype" value="employer" required> Employer</label>
						</div>
					</div>

					<button type="submit" name="login" class="btn btn-custom">Login</button>
				</form>
			</div>
		</div>

		<!-- Registration Form -->
		<div class="col-md-6">
			<div class="auth-card">
				<div class="page-header">
					<h2>Register</h2>
					<p>Create a new account to get started</p>
				</div>
				
				<form id="registerForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<div class="error-msg">
						<?php 
						if(isset($_SESSION["error"])) {
							echo $_SESSION["error"];
							unset($_SESSION["error"]);
						}
						?>
					</div>
					
					<div class="form-group">
						<label>Full Name</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-user"></i></span>
							<input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" placeholder="Enter your full name" required>
						</div>
					</div>

					<div class="form-group">
						<label>Username</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-user-circle"></i></span>
							<input type="text" class="form-control" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" placeholder="Choose a username" required>
						</div>
					</div>

					<div class="form-group">
						<label>Email</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-envelope"></i></span>
							<input type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="Enter your email" required>
						</div>
					</div>

					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-lock"></i></span>
							<input type="password" class="form-control" name="password" placeholder="Choose a password" required>
							<span class="password-toggle"><i class="fas fa-eye"></i></span>
						</div>
					</div>

					<div class="form-group">
						<label>Confirm Password</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-lock"></i></span>
							<input type="password" class="form-control" name="repassword" placeholder="Confirm your password" required>
							<span class="password-toggle"><i class="fas fa-eye"></i></span>
						</div>
					</div>

					<div class="form-group">
						<label>Contact Number</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-phone"></i></span>
							<input type="tel" class="form-control" name="contactNo" value="<?php echo isset($_POST['contactNo']) ? htmlspecialchars($_POST['contactNo']) : ''; ?>" placeholder="Enter your contact number" required>
						</div>
					</div>

					<div class="form-group gender-section">
						<label>Gender</label>
						<div class="radio-group">
							<label><input type="radio" name="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?> required> <i class="fas fa-male"></i> Male</label>
							<label><input type="radio" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?> required> <i class="fas fa-female"></i> Female</label>
							<label><input type="radio" name="gender" value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'checked' : ''; ?> required> <i class="fas fa-user"></i> Other</label>
						</div>
					</div>

					<div class="form-group">
						<label>Date of Birth</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-calendar"></i></span>
							<input type="date" class="form-control" name="birthdate" value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label>Address</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span>
							<textarea class="form-control" name="address" placeholder="Enter your address" rows="3" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
						</div>
					</div>

					<div class="form-group gender-section">
						<label>User Type</label>
						<div class="radio-group">
							<label><input type="radio" name="usertype" value="freelancer" <?php echo (isset($_POST['usertype']) && $_POST['usertype'] == 'freelancer') ? 'checked' : ''; ?> required> Freelancer</label>
							<label><input type="radio" name="usertype" value="employer" <?php echo (isset($_POST['usertype']) && $_POST['usertype'] == 'employer') ? 'checked' : ''; ?> required> Employer</label>
						</div>
					</div>

					<button type="submit" name="register" class="btn btn-custom">Register</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
	// Password toggle functionality
	$('.password-toggle').click(function() {
		const input = $(this).siblings('input');
		const icon = $(this).find('i');
		
		if (input.attr('type') === 'password') {
			input.attr('type', 'text');
			icon.removeClass('fa-eye').addClass('fa-eye-slash');
		} else {
			input.attr('type', 'password');
			icon.removeClass('fa-eye-slash').addClass('fa-eye');
		}
	});

	// Form validation
	function validateForm(formId) {
		const form = $(formId);
		let isValid = true;
		
		form.find('[required]').each(function() {
			if (!$(this).val()) {
				$(this).addClass('is-invalid');
				isValid = false;
			} else {
				$(this).removeClass('is-invalid');
			}
		});
		
		return isValid;
	}

	$('#loginForm').on('submit', function(e) {
		if (!validateForm('#loginForm')) {
			e.preventDefault();
		}
	});

	$('#registerForm').on('submit', function(e) {
		if (!validateForm('#registerForm')) {
			e.preventDefault();
		}
	});

	// Remove validation styling on input
	$('input, textarea').on('input', function() {
		$(this).removeClass('is-invalid');
	});
});
</script>

</body>
</html>