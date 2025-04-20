<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
}
else{
    $username="";
	//header("location: index.php");
}


if(isset($_POST["postJob"])){
    $title=test_input($_POST["title"]);
    $type=test_input($_POST["type"]);
    $description=test_input($_POST["description"]);
    $budget=test_input($_POST["budget"]);
    $skills=test_input($_POST["skills"]);
    $special_skill=test_input($_POST["special_skill"]);
    $deadline=test_input($_POST["deadline"]);

    $sql = "INSERT INTO job_offer (title, type, description, budget, skills, special_skill, e_username, valid, deadline) VALUES ('$title', '$type', '$description','$budget','$skills','$special_skill','$username',1, '$deadline')";
    
    $result = $conn->query($sql);
    if($result==true){
        $_SESSION["job_id"] = $conn->insert_id;
        header("location: jobDetails.php");
    }
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Post a job</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">

<style>
	body{padding-top: 3%;margin: 0;}
	.card{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background:#fff}
	
	/* Navbar styling */
	.navbar-inverse {
		background-color: #2c3e50;
		border-color: #2c3e50;
		box-shadow: 0 2px 5px rgba(0,0,0,0.1);
	}
	.navbar-inverse .navbar-brand {
		color: #ecf0f1;
		font-size: 24px;
		font-weight: bold;
	}
	.navbar-inverse .navbar-nav > li > a {
		color: #ecf0f1;
		font-size: 16px;
		transition: all 0.3s ease;
	}
	.navbar-inverse .navbar-nav > li > a:hover {
		color: #3498db;
		background-color: transparent;
	}
	.dropdown-menu {
		background-color: #2c3e50;
		border: none;
		box-shadow: 0 2px 5px rgba(0,0,0,0.2);
	}
	.dropdown-menu .list-group-item {
		background-color: transparent;
		color: #ecf0f1;
		border: none;
		padding: 10px 20px;
		transition: all 0.3s ease;
	}
	.dropdown-menu .list-group-item:hover {
		background-color: #34495e;
		color: #3498db;
	}

	/* Form styling */
	.page-header {
		border-bottom: 2px solid #3498db;
		margin: 40px 0 20px;
	}
	.page-header h2 {
		color: #2c3e50;
		font-weight: bold;
	}
	.form-control {
		height: 40px;
		border-radius: 4px;
		box-shadow: none;
		border: 1px solid #ddd;
	}
	textarea.form-control {
		height: auto;
	}
	.btn-info {
		background-color: #3498db;
		border-color: #3498db;
		padding: 10px 20px;
		font-size: 16px;
		transition: all 0.3s ease;
	}
	.btn-info:hover {
		background-color: #2980b9;
		border-color: #2980b9;
	}
	.control-label {
		font-weight: 600;
		color: #2c3e50;
	}

	/* Footer styling */
	.footer {
		background: #2c3e50;
		color: #ecf0f1;
		padding: 50px 0;
		margin-top: 50px;
	}
	.footer h3 {
		color: #3498db;
		font-size: 20px;
		margin-bottom: 20px;
		font-weight: bold;
	}
	.footer p {
		margin: 10px 0;
		font-size: 15px;
	}
	.footer a {
		color: #ecf0f1;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	.footer a:hover {
		color: #3498db;
		text-decoration: none;
	}
	.social-links i {
		margin-right: 10px;
		font-size: 20px;
	}
	.footer .social-contact a {
		display: block;
		padding: 8px 0;
		font-size: 16px;
	}
	.footer .social-contact i {
		width: 30px;
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
				<li><a href="allJob.php"><i class="fas fa-briefcase"></i> Browse all jobs</a></li>
                <li><a href="allFreelancer.php"><i class="fas fa-users"></i> Browse Freelancers</a></li>
                <li><a href="allEmployer.php"><i class="fas fa-building"></i> Browse Employers</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fas fa-user"></i> <?php echo $username; ?>
					</a>
					<ul class="dropdown-menu">
						<a href="employerProfile.php" class="list-group-item">
							<i class="fas fa-home"></i> View profile
						</a>
						<a href="editEmployer.php" class="list-group-item">
							<i class="fas fa-edit"></i> Edit Profile
						</a>
						<a href="message.php" class="list-group-item">
							<i class="fas fa-envelope"></i> Messages
						</a>
						<a href="logout.php" class="list-group-item">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
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
                    <h2>Post A Job Offer</h2>
                </div>

                <form id="registrationForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Title</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="title" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Type</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="type" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Job Description</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="description" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Budget</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="budget" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Required Skills</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="skills" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Special Requirement</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="special_skill" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Deadline</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="deadline" value="" placeholder="YYYY-MM-DD" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <!-- Do NOT use name="submit" or id="submit" for the Submit button -->
                        <button type="submit" name="postJob" class="btn btn-info btn-lg">Post</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>


<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h3>Quick Links</h3>
                <p><a href="index.php"><i class="fas fa-home"></i> Home</a></p>
                <p><a href="allJob.php"><i class="fas fa-briefcase"></i> Browse all jobs</a></p>
                <p><a href="allFreelancer.php"><i class="fas fa-users"></i> Browse Freelancers</a></p>
                <p><a href="allEmployer.php"><i class="fas fa-building"></i> Browse Employers</a></p>
            </div>
            <div class="col-lg-3">
                <h3>About Us</h3>
                <p><i class="fas fa-globe"></i> Freelancing Platform</p>
                <p><i class="fas fa-map-marker-alt"></i> Guntur</p>
                <p><i class="fas fa-map"></i> Andhra Pradesh</p>
                <p><i class="far fa-copyright"></i> 2025</p>
            </div>
            <div class="col-lg-3">
                <h3>Contact Us</h3>
                <p><i class="fas fa-phone"></i> Abhigna Rao +918374029227</p>
                <p><i class="fas fa-map-marked-alt"></i> Andhra Pradesh, India</p>
                <p><i class="far fa-copyright"></i> 2025</p>
            </div>
            <div class="col-lg-3">
                <h3>Social Contact</h3>
                <div class="social-contact">
                    <a href="#" class="facebook"><i class="fab fa-facebook-square"></i> Facebook</a>
                    <a href="#" class="google"><i class="fab fa-google-plus-square"></i> Google</a>
                    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i> Twitter</a>
                    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i> Linkedin</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer-->


<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

<script>
$(document).ready(function() {
    $('#registrationForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'The title is required and cannot be empty'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: 'The type is required and cannot be empty'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'The description is required and cannot be empty'
                    }
                }
            },
            deadline: {
                validators: {
                    notEmpty: {
                        message: 'The deadline is required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The deadline is not valid'
                    }
                }
            },
            budget: {
                validators: {
                    notEmpty: {
                        message: 'The budget is required and cannot be empty'
                    },
                    stringLength: {
                        max: 11,
                        message: 'The number is too big'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The number is not valid'
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>