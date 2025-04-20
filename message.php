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
	header("location: index.php");
	exit();
}

// Initialize flag for inbox/sent messages view
$f = isset($_POST["sm"]) ? 1 : 0;

// Default query for inbox messages
if($f == 0) {
$sql = "SELECT * FROM message WHERE receiver='$username' ORDER BY timestamp DESC";
} 
// Query for sent messages
else {
	$sql = "SELECT * FROM message WHERE sender='$username' ORDER BY timestamp DESC";
}
$result = $conn->query($sql);

// Handle search in inbox
if(isset($_POST["s_inbox"]) && !empty($_POST["s_inbox"])){
	$t = $conn->real_escape_string($_POST["s_inbox"]);
	$sql = "SELECT * FROM message WHERE receiver='$username' AND 
		   (sender LIKE '%$t%' OR msg LIKE '%$t%') 
		   ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f = 0;
}

// Handle search in sent messages
if(isset($_POST["s_sm"]) && !empty($_POST["s_sm"])){
	$t = $conn->real_escape_string($_POST["s_sm"]);
	$sql = "SELECT * FROM message WHERE sender='$username' AND 
		   (receiver LIKE '%$t%' OR msg LIKE '%$t%') 
		   ORDER BY timestamp DESC";
	$result = $conn->query($sql);
	$f = 1;
}

// Handle view profile
if(isset($_POST["sr"])){
	$t = $conn->real_escape_string($_POST["sr"]);
	// Check if user is a freelancer
	$sql = "SELECT * FROM freelancer WHERE username='$t'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$_SESSION["f_user"] = $t;
		header("location: viewFreelancer.php");
		exit();
	} else {
	    // Check if user is an employer
	    $sql = "SELECT * FROM employer WHERE username='$t'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$_SESSION["e_user"] = $t;
			header("location: viewEmployer.php");
			exit();
		}
	}
}

// Handle reply to message
if(isset($_POST["rep"])){
	$_SESSION["msgRcv"] = $_POST["rep"];
	header("location: sendMessage.php");
	exit();
}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Messages</title>
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

	/* Header image */
	.header-image {
		background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('image/message-header.jpg');
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

	/* Message interface styling */
	.message-container {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		margin-bottom: 30px;
		overflow: hidden;
	}

	.message-sidebar {
		background: #f8f9fa;
		padding: 20px;
		border-right: 1px solid #eee;
	}

	.message-search {
		margin-bottom: 20px;
	}

	.message-search .form-control {
		height: 45px;
		border-radius: 8px;
		border: 2px solid #eee;
		padding: 10px 15px;
		font-size: 15px;
		transition: all 0.3s ease;
	}

	.message-search .form-control:focus {
		border-color: #000;
		box-shadow: none;
	}

	.message-tabs {
		margin-bottom: 20px;
		display: flex;
		gap: 10px;
	}

	.tab-btn {
		background: #fff;
		border: 2px solid #eee;
		padding: 10px 20px;
		border-radius: 8px;
		color: #666;
		font-weight: 600;
		transition: all 0.3s ease;
		flex: 1;
		text-align: center;
	}

	.tab-btn:hover, .tab-btn.active {
		background: #000;
		border-color: #000;
		color: #fff;
	}

	.message-list {
		max-height: 600px;
		overflow-y: auto;
	}

	.message-item {
		padding: 20px;
		border-bottom: 1px solid #eee;
		transition: all 0.3s ease;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 15px;
	}

	.message-item:hover {
		background: #f8f9fa;
		transform: translateX(5px);
	}

	.message-avatar {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		background: #000;
		color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
		font-weight: bold;
	}

	.message-content {
		flex: 1;
	}

	.message-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 5px;
	}

	.message-sender {
		font-weight: bold;
		color: #000;
	}

	.message-time {
		font-size: 12px;
		color: #666;
	}

	.message-preview {
		color: #666;
		font-size: 14px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.message-actions {
		display: flex;
		gap: 10px;
	}

	.action-btn {
		background: none;
		border: none;
		color: #666;
		transition: all 0.3s ease;
		padding: 5px;
	}

	.action-btn:hover {
		color: #000;
		transform: scale(1.1);
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
    <div class="header-image">
        <h1><i class="fas fa-envelope"></i> Messages</h1>
    </div>

    <div class="message-container">
<div class="row">
            <!-- Sidebar with tabs -->
            <div class="col-md-3 message-sidebar">
                <div class="message-search">
                    <input type="text" class="form-control" id="messageSearch" placeholder="Search messages...">
                </div>
                
                <div class="message-tabs">
                    <form action="message.php" method="post" style="width: 100%;">
                        <button type="submit" name="inbox" class="tab-btn <?php echo ($f==0) ? 'active' : ''; ?>">
                            <i class="fas fa-inbox"></i> Inbox
                        </button>
                    </form>
                    <form action="message.php" method="post" style="width: 100%;">
                        <button type="submit" name="sm" class="tab-btn <?php echo ($f==1) ? 'active' : ''; ?>">
                            <i class="fas fa-paper-plane"></i> Sent
                        </button>
                    </form>
                </div>

                <a href="sendMessage.php" class="btn btn-primary btn-block compose-btn">
                    <i class="fas fa-pen"></i> Compose Message
                </a>
            </div>

            <!-- Message list -->
            <div class="col-md-9">
                <div class="message-list">
                      <?php
                      	if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
                            $sender = $row["sender"];
                            $receiver = $row["receiver"];
                            $msg = $row["msg"];
                            $timestamp = $row["timestamp"];
                            
                            // Format the date
                            $date = date("M d, Y h:i A", strtotime($timestamp));
                            
                            // Determine if this is a sent or received message
                            $isSent = ($f == 1);
                            $otherUser = $isSent ? $receiver : $sender;
                    ?>
                    <div class="message-item">
                        <div class="message-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <h4><?php echo $otherUser; ?></h4>
                                <span class="message-time"><?php echo $date; ?></span>
                            </div>
                            <div class="message-preview"><?php echo substr($msg, 0, 100) . (strlen($msg) > 100 ? '...' : ''); ?></div>
                            <div class="message-actions">
                                <?php if(!$isSent) { ?>
                                <form action="message.php" method="post" style="display: inline;">
                                    <input type="hidden" name="rep" value="<?php echo $sender; ?>">
                                    <button type="submit" class="btn btn-link">
                                        <i class="fas fa-reply"></i> Reply
                                    </button>
                                    </form>
                                <?php } ?>
                                <form action="message.php" method="post" style="display: inline;">
                                    <input type="hidden" name="sr" value="<?php echo $otherUser; ?>">
                                    <button type="submit" class="btn btn-link">
                                        <i class="fas fa-user"></i> View Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                    ?>
                    <div class="no-messages">
                        <i class="fas fa-inbox"></i>
                        <p><?php echo ($f == 1) ? 'No sent messages' : 'No messages in inbox'; ?></p>
			</div>
                    <?php
                    }
                    ?>
				</div>
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

<script>
// Add this JavaScript for the search functionality
document.getElementById('messageSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const messageItems = document.querySelectorAll('.message-item');
    
    messageItems.forEach(item => {
        const content = item.textContent.toLowerCase();
        item.style.display = content.includes(searchText) ? 'flex' : 'none';
    });
});
</script>

</body>
</html>