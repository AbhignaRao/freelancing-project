<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username = $_SESSION["Username"];
	
	// Initialize all variables
	$name = $email = $contactNo = $gender = $birthdate = $address = $profile_sum = $company = "";
	
	$sql = "SELECT * FROM employer WHERE username='$username'";
	$result = safe_query($sql);
	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		// Assign values from database
		$name = $row["Name"] ?? '';
		$email = $row["email"] ?? '';
		$contactNo = $row["contact_no"] ?? '';
		$gender = $row["gender"] ?? '';
		$birthdate = $row["birthdate"] ?? '';
		$address = $row["address"] ?? '';
		$profile_sum = $row["profile_sum"] ?? '';
		$company = $row["company"] ?? '';
	}
} else {
	header("location: index.php");
	exit();
}

if(isset($_POST["editEmployer"])){
    // Sanitize all inputs
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $contactNo = sanitize_input($_POST["contactNo"]);
    $gender = sanitize_input($_POST["gender"]);
    $birthdate = sanitize_input($_POST["birthdate"]);
    $address = sanitize_input($_POST["address"]);
    $profile_sum = sanitize_input($_POST["profile_sum"]);
    $company = sanitize_input($_POST["company"]);

    $sql = "UPDATE employer SET 
            Name='$name',
            email='$email',
            contact_no='$contactNo', 
            address='$address', 
            gender='$gender', 
            profile_sum='$profile_sum', 
            birthdate='$birthdate', 
            company='$company' 
            WHERE username='$username'";

    if(safe_query($sql)){
        $_SESSION['success'] = "Profile updated successfully!";
        header("location: employerProfile.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating profile. Please try again.";
    }
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Employer Profile</title>
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
		border-radius: 6px;
		text-transform: uppercase;
		transition: all 0.3s ease;
		position: relative;
		overflow: hidden;
	}
	.btn:after {
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
	.btn:hover:after {
		width: 200%;
		height: 200%;
	}
	.btn-primary {
		background: #000;
		border-color: #000;
		color: #fff;
	}
	.btn-primary:hover {
		background: #333;
		border-color: #333;
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(0,0,0,0.2);
	}
	.btn-danger {
		background: #dc3545;
		border-color: #dc3545;
	}
	.btn-danger:hover {
		background: #c82333;
		border-color: #bd2130;
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(220,53,69,0.2);
	}

	/* Alert Styling */
	.alert {
		border-radius: 6px;
		padding: 15px 20px;
		margin-bottom: 20px;
		border: none;
		font-size: 15px;
	}
	.alert-success {
		background: #d4edda;
		color: #155724;
	}
	.alert-danger {
		background: #f8d7da;
		color: #721c24;
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
				<li><a href="allJob.php"><i class="fas fa-briefcase"></i> Browse all jobs</a></li>
				<li><a href="allFreelancer.php"><i class="fas fa-users"></i> Browse Freelancers</a></li>
				<li><a href="allEmployer.php"><i class="fas fa-building"></i> Browse Employers</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fas fa-user"></i> <?php echo $username; ?>
					</a>
					<ul class="dropdown-menu">
						<li><a href="employerProfile.php"><i class="fas fa-home"></i> View profile</a></li>
						<li><a href="editEmployer.php"><i class="fas fa-edit"></i> Edit Profile</a></li>
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
                <h2><i class="fas fa-edit"></i> Edit Profile</h2>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form id="editForm" method="post" class="form-horizontal" action="editEmployer.php">
                    <div class="form-group">
                        <label class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Contact Number</label>
                        <input type="text" class="form-control" name="contactNo" value="<?php echo $contactNo; ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>> Male
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Date of Birth</label>
                        <input type="date" class="form-control" name="birthdate" value="<?php echo $birthdate; ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <textarea class="form-control" name="address" rows="3"><?php echo $address; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Company Name</label>
                        <input type="text" class="form-control" name="company" value="<?php echo $company; ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Profile Summary</label>
                        <textarea class="form-control" name="profile_sum" rows="5"><?php echo $profile_sum; ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" name="editEmployer" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="employerProfile.php" class="btn btn-danger">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

<script>
$(document).ready(function() {
    $('#editForm').bootstrapValidator({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The full name is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            contactNo: {
                validators: {
                    notEmpty: {
                        message: 'The contact number is required'
                    },
                    regexp: {
                        regexp: /^[0-9+\-\(\)\s]{8,20}$/,
                        message: 'Please enter a valid phone number'
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>