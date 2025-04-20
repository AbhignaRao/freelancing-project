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

if(isset($_SESSION["job_id"])){
    $job_id=$_SESSION["job_id"];
}
else{
    $job_id="";
    //header("location: index.php");
}

if(isset($_POST["f_user"])){
	$_SESSION["f_user"]=$_POST["f_user"];
	header("location: viewFreelancer.php");
}

if(isset($_POST["c_letter"])){
	$_SESSION["c_letter"]=$_POST["c_letter"];
	header("location: coverLetter.php");
}


if(isset($_POST["f_hire"])){
	$f_hire=$_POST["f_hire"];
	$f_price=$_POST["f_price"];
	$sql = "INSERT INTO selected (f_username, job_id, e_username, price, valid) VALUES ('$f_hire', '$job_id', '$username','$f_price',1)";
    
    $result = $conn->query($sql);
    if($result==true){
    	$sql = "DELETE FROM apply WHERE job_id='$job_id'";
		$result = $conn->query($sql);
		if($result==true){
			$sql = "UPDATE job_offer SET valid=0 WHERE job_id='$job_id'";
			$result = $conn->query($sql);
			if($result==true){
				header("location: jobDetails.php");
			}
		}
    }
}


if(isset($_POST["f_done"])){
	$f_done=$_POST["f_done"];
	$sql = "UPDATE selected SET valid=0 WHERE job_id='$job_id'";
	$result = $conn->query($sql);
    if($result==true){
    	header("location: jobDetails.php");
    }
}


$sql = "SELECT * FROM job_offer WHERE job_id='$job_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$e_username=$row["e_username"];
        $title=$row["title"];
        $type=$row["type"];
        $description=$row["description"];
        $budget=$row["budget"];
        $skills=$row["skills"];
        $special_skill=$row["special_skill"];
        $timestamp=$row["timestamp"];
        
        // Check if status exists in the row, if not set a default value
        $jstatus = isset($row["status"]) ? $row["status"] : "open";
        
        // Check if deadline exists in the row, if not set a default value
        $deadline = isset($row["deadline"]) ? $row["deadline"] : "";
    }
} else {
    echo "0 results";
}

// Fetch employer details right after job details
$employer_name = "";
$employer_company = "";
$employer_email = "";
$employer_contact = "";

$sql = "SELECT * FROM employer WHERE username='$e_username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Add fallbacks for potentially missing fields
    $employer_name = isset($row["name"]) ? $row["name"] : $e_username;
    $employer_company = isset($row["company"]) ? $row["company"] : "";
    $employer_email = isset($row["email"]) ? $row["email"] : "";
    $employer_contact = isset($row["contact_no"]) ? $row["contact_no"] : "";
}

$_SESSION["msgRcv"]=$e_username;



 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Job Details</title>
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

	/* Skills styling */
	.skills-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.skills-list li {
		display: inline-block;
		margin: 5px;
		padding: 8px 15px;
		background: #f0f2f5;
		border-radius: 20px;
		font-size: 14px;
		color: #333;
		transition: all 0.3s ease;
	}
	.skills-list li:hover {
		background: #000;
		color: #fff;
		transform: translateY(-2px);
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

	/* Job status badge */
	.status-badge {
		display: inline-block;
		padding: 8px 15px;
		border-radius: 20px;
		font-size: 14px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
	.status-open {
		background: #28a745;
		color: #fff;
	}
	.status-closed {
		background: #dc3545;
		color: #fff;
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
	.rating {
		text-align: center;
	}
	.stars {
		color: #ffc107;
		font-size: 20px;
		margin-right: 10px;
	}
	.rating-text {
		font-size: 18px;
		font-weight: bold;
		color: #333;
	}
	.review-item {
		margin-bottom: 15px;
		padding-bottom: 15px;
		border-bottom: 1px solid #eee;
	}
	.review-item:last-child {
		margin-bottom: 0;
		padding-bottom: 0;
		border-bottom: none;
	}
	.review-rating {
		color: #ffc107;
		font-size: 16px;
		margin-bottom: 5px;
	}
	.review-text {
		color: #666;
		font-style: italic;
		margin: 0;
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


<!--main body-->
<div style="padding:1% 3% 1% 3%;">
<div class="row">

<!--Column 1-->
	<div class="col-lg-8">

<!--Freelancer Profile Details-->	
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-primary">
			  <div class="panel-heading"><h3><i class="fas fa-briefcase"></i> Job Details</h3></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Job Title</div>
			  <div class="panel-body"><h4><?php echo $title; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Job Type</div>
			  <div class="panel-body"><h4><?php echo $type; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Job Description</div>
			  <div class="panel-body"><h4><?php echo $description; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Required Skills</div>
			  <div class="panel-body">
				<ul class="skills-list">
					<?php 
					$skills_array = explode(',', $skills);
					foreach($skills_array as $skill) {
						echo '<li>'.trim($skill).'</li>';
					}
					?>
				</ul>
			  </div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Special Requirements</div>
			  <div class="panel-body"><h4><?php echo $special_skill; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Budget</div>
			  <div class="panel-body"><h4>$<?php echo $budget; ?></h4></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">Posted On</div>
			  <div class="panel-body"><h4><?php echo date('F j, Y', strtotime($timestamp)); ?></h4></div>
			</div>
			<?php if($deadline != "") { ?>
			<div class="panel panel-primary">
			    <div class="panel-heading">Deadline</div>
			    <div class="panel-body"><h4><?php echo date('F j, Y', strtotime($deadline)); ?></h4></div>
			</div>
			<?php } ?>
			<?php if($username != ''){ ?>
			<div style="text-align: center; margin-top: 30px;">
				<a href="<?php echo $linkBtn; ?>" class="btn btn-primary">
					<i class="fas <?php echo $_SESSION['Usertype']==1 ? 'fa-paper-plane' : 'fa-edit'; ?>"></i>
					<?php echo $textBtn; ?>
				</a>
			</div>
			<?php } ?>
			<p></p>
		</div>
<!--End Freelancer Profile Details-->

<!--Freelancer Profile Details-->	
		<div id="applicant" class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-success">
			  <div class="panel-heading"><h3>Applicants for this job</h3></div>
			  <div class="panel-body"><h4>
                  <table style="width:100%">
                  <tr>
                      <td>Applicant's username</td>
                      <td>Bid</td>
                  </tr>
                    <?php 
                    $sql = "SELECT * FROM apply WHERE job_id='$job_id' ORDER BY bid";
					$result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                        $f_username=$row["f_username"];
                        $bid=$row["bid"];
                        $cover_letter=$row["cover_letter"];

                        echo '
                        <form action="jobDetails.php" method="post">
                        <input type="hidden" name="f_user" value="'.$f_username.'">
                            <tr>
                            <td><input type="submit" class="btn btn-link btn-lg" value="'.$f_username.'"></td>
                            <td>'.$bid.'</td>
                            </form>
                            <form action="jobDetails.php" method="post">
                            <input type="hidden" name="c_letter" value="'.$cover_letter.'">
                            <td><input type="submit" class="btn btn-link btn-lg" value="cover letter"></td>
                            </form>
                            <form action="jobDetails.php" method="post">
                            <input type="hidden" name="f_hire" value="'.$f_username.'">
                            <input type="hidden" name="f_price" value="'.$bid.'">
                            <td><input type="submit" class="btn btn-link btn-lg" value="Hire"></td>
                            </tr>
                        </form>';

                        }
                    } else {
                      $sql = "SELECT * FROM selected WHERE job_id='$job_id'";
					  $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $f_username=$row["f_username"];
                                $bid=$row["price"];
                                $v=$row["valid"];

                                if ($v==0) {
                                	$tc="Job ended";
                                	$tv="";
                                }else{
                                	$tc="End Job";
                                	$tv="f_done";
                                }

                                echo '
                                <form action="jobDetails.php" method="post">
                                <input type="hidden" name="f_user" value="'.$f_username.'">
                                    <tr>
                                    <td><input type="submit" class="btn btn-link btn-lg" value="'.$f_username.'"></td>
                                    <td>'.$bid.'</td>
                                    </form>
                                    <form action="jobDetails.php" method="post">
                                    <input type="hidden" name="'.$tv.'" value="'.$f_username.'">
                                    <td><input type="submit" class="btn btn-link btn-lg" value="'.$tc.'"></td>
                                    </tr>
                                </form>

                                                             
                                ';

                                }
                        } else {
                            echo "<tr></tr><tr><td></td><td>Nothing to show</td></tr>";
                        }
                        }

                       ?>
                     </table>
              </h4></div>
			</div>
			<p></p>
		</div>
<!--End Freelancer Profile Details-->



	</div>
<!--End Column 1-->

<?php 

?>

<!--Column 2-->
	<div class="col-lg-4">

<!--Main profile card-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<p></p>
			<img src="image/img04.jpg">
			<h2><?php echo $employer_name; ?></h2>
			<p><span class="glyphicon glyphicon-user"></span> <?php echo $e_username; ?></p>
	        <center><a href="sendMessage.php" class="btn btn-info"><span class="glyphicon glyphicon-envelope"></span>  Send Message</a></center>
	        <p></p>
	    </div>
<!--End Main profile card-->


<!--Contact Information-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-success">
			  <div class="panel-heading"><h4>Contact Information</h4></div>
			</div>
			<div class="panel panel-success">
			  <div class="panel-heading">Email</div>
			  <div class="panel-body"><?php echo $employer_email; ?></div>
			</div>
			<div class="panel panel-success">
			  <div class="panel-heading">Mobile</div>
			  <div class="panel-body"><?php echo $employer_contact; ?></div>
			</div>
		</div>
<!--End Contact Information-->

	</div>
<!--End Column 2-->


<!--Column 3-->
	<div class="col-lg-2">
	</div>
<!--End Column 3-->

</div>
</div>
<!--End main body-->


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

<?php 

if($e_username!=$username && $_SESSION["Usertype"]!=1){
	echo "<script>
		        $('#applybtn').hide();
		</script>";
} 

if($_SESSION["Usertype"]==1 && $jstatus=='closed'){
	echo "<script>
		        $('#applybtn').hide();
		</script>";
} 

if($e_username!=$username){
	echo "<script>
		        $('#applicant').hide();
		</script>";
}


?>


</body>
</html>