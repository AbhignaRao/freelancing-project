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

if(isset($_SESSION["msgRcv"])){
    $msgRcv=$_SESSION["msgRcv"];
}

if(isset($_POST["send"])){
    $msgTo=$_POST["msgTo"];
    $msgBody=$_POST["msgBody"];
    $sql = "INSERT INTO message (sender, receiver, msg) VALUES ('$username', '$msgTo', '$msgBody')";
    $result = $conn->query($sql);
    if($result==true){
        header("location: message.php");
    }
}




 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Send Message</title>
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

	/* Header image */
	.header-image {
		background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('image/compose-message.jpg');
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

	/* Message compose styling */
	.compose-container {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(0,0,0,0.08);
		margin-bottom: 30px;
		overflow: hidden;
	}

	.compose-header {
		background: #000;
		color: #fff;
		padding: 25px;
		border-radius: 12px 12px 0 0;
	}

	.compose-header h2 {
		margin: 0;
		font-size: 24px;
		font-weight: bold;
	}

	.compose-body {
		padding: 30px;
	}

	.form-group {
		margin-bottom: 25px;
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

	/* Search suggestions */
	.search-suggestions {
		position: absolute;
		top: 100%;
		left: 0;
		right: 0;
		background: #fff;
		border-radius: 0 0 8px 8px;
		box-shadow: 0 5px 15px rgba(0,0,0,0.1);
		z-index: 1000;
		display: none;
	}

	.suggestion-item {
		padding: 12px 15px;
		border-bottom: 1px solid #eee;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.suggestion-item:hover {
		background: #f8f9fa;
	}

	.suggestion-item:last-child {
		border-bottom: none;
	}

	/* Tips section */
	.tips-section {
		background: #f8f9fa;
		border-radius: 12px;
		padding: 25px;
		margin-bottom: 30px;
	}

	.tips-section h3 {
		color: #000;
		font-size: 20px;
		font-weight: bold;
		margin-bottom: 20px;
	}

	.tips-section ul {
		padding-left: 20px;
	}

	.tips-section li {
		margin-bottom: 15px;
		color: #666;
		font-size: 15px;
		line-height: 1.6;
	}

	.tips-section li i {
		color: #000;
		margin-right: 10px;
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
    <!-- Header Image -->
    <div class="header-image">
        <h1>Compose Message</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Message Compose Form -->
            <div class="compose-container">
                <div class="compose-header">
                    <h2><i class="fas fa-paper-plane"></i> New Message</h2>
                </div>
                <div class="compose-body">
                    <form id="messageForm" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label">To:</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" name="msgTo" id="msgTo" placeholder="Enter recipient's username" value="<?php echo isset($msgRcv) ? $msgRcv : ''; ?>" required>
                                <div class="search-suggestions" id="searchSuggestions"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Message:</label>
                            <div id="editor" class="editor-container"></div>
                            <textarea name="msgBody" id="messageContent" style="display:none"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="send" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                            <a href="message.php" class="btn btn-default">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Tips Section -->
            <div class="tips-section">
                <h3><i class="fas fa-lightbulb"></i> Messaging Tips</h3>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check"></i> Be clear and concise</li>
                    <li><i class="fas fa-check"></i> Introduce yourself properly</li>
                    <li><i class="fas fa-check"></i> State your purpose clearly</li>
                    <li><i class="fas fa-check"></i> Be professional and courteous</li>
                    <li><i class="fas fa-check"></i> Proofread before sending</li>
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
        placeholder: 'Write your message here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    // Update hidden form field before submit
    document.getElementById('messageForm').onsubmit = function() {
        document.getElementById('messageContent').value = quill.root.innerHTML;
    };

    // Username search suggestions
    $(document).ready(function() {
        var searchTimeout;
        var $searchInput = $('#msgTo');
        var $suggestions = $('#searchSuggestions');

        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            var query = $(this).val();

            if (query.length >= 2) {
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: 'search_users.php',
                        method: 'POST',
                        data: { query: query },
                        success: function(response) {
                            if (response.length > 0) {
                                var html = '';
                                response.forEach(function(user) {
                                    html += '<div class="suggestion-item" data-username="' + user.username + '">' +
                                           '<i class="fas fa-user"></i> ' + user.username +
                                           '</div>';
                                });
                                $suggestions.html(html).show();
                            } else {
                                $suggestions.hide();
                            }
                        }
                    });
                }, 300);
            } else {
                $suggestions.hide();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            $searchInput.val($(this).data('username'));
            $suggestions.hide();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.position-relative').length) {
                $suggestions.hide();
            }
        });
    });
</script>

</body>
</html>