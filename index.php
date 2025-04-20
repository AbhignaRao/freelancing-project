<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
	if ($_SESSION["Usertype"]==1) {
		header("location: freelancerProfile.php");
	}
	else{
		header("location: employerProfile.php");
	}
}
else{
    $username="";
	//header("location: index.php");
}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Freelance Hub</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

<style>
	body {
		padding-top: 80px;
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
		margin-bottom: 30px;
	}
	.navbar-inverse .navbar-brand {
		color: #fff;
		font-size: 28px;
		font-weight: bold;
		transition: color 0.3s ease;
	}
	.navbar-inverse .navbar-brand:hover {
		color: #e0e0e0;
	}
	.navbar-inverse .navbar-nav > li > a {
		color: #fff;
		font-size: 18px;
		padding: 15px 20px;
		transition: all 0.3s ease;
		border-bottom: 2px solid transparent;
	}
	.navbar-inverse .navbar-nav > li > a:hover {
		color: #e0e0e0;
		border-bottom: 2px solid #fff;
	}
	.navbar-inverse .navbar-nav > li > a i {
		margin-right: 8px;
	}
	.dropdown-menu {
		background-color: #000;
		border: 1px solid #333;
		border-radius: 4px;
		box-shadow: 0 4px 20px rgba(0,0,0,0.2);
		padding: 10px 0;
		margin-top: 10px;
	}
	.dropdown-menu .list-group-item {
		background-color: transparent;
		color: #fff;
		border: none;
		padding: 12px 25px;
		transition: all 0.3s ease;
		border-left: 2px solid transparent;
	}
	.dropdown-menu .list-group-item:hover {
		background-color: #333;
		color: #fff;
		border-left: 2px solid #fff;
	}
	.dropdown-menu .list-group-item i {
		margin-right: 10px;
		width: 20px;
		text-align: center;
	}

	/* Header and Hero Section */
	.header1 {
		margin-top: 20px;
		background: linear-gradient(135deg, #000 0%, #333 100%);
		padding: 80px 0;
		margin-bottom: 50px;
		border-bottom: 3px solid #fff;
	}
	.jumbotron {
		background: rgba(0, 0, 0, 0.7);
		border: 1px solid rgba(255, 255, 255, 0.2);
		border-radius: 8px;
		padding: 40px;
		margin-bottom: 0;
		box-shadow: 0 10px 30px rgba(0,0,0,0.1);
	}
	.jumbotron h1 {
		color: #fff;
		font-size: 56px;
		font-weight: bold;
		margin-bottom: 20px;
		text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
	}
	.jumbotron p {
		color: #fff;
		font-size: 20px;
		line-height: 1.6;
		margin-bottom: 30px;
		text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
	}
	.btn {
		padding: 12px 30px;
		border-radius: 4px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 1px;
		transition: all 0.3s ease;
		border: 2px solid transparent;
	}
	.btn-warning {
		background: #fff;
		color: #000;
		border-color: #fff;
	}
	.btn-warning:hover {
		background: #000;
		color: #fff;
		border-color: #fff;
	}
	.btn-info {
		background: transparent;
		color: #fff;
		border-color: #fff;
	}
	.btn-info:hover {
		background: #fff;
		color: #000;
	}
	.btn-default {
		background: #fff;
		color: #000;
		border-color: #fff;
	}
	.btn-default:hover {
		background: transparent;
		color: #fff;
	}
	.btn-group {
		margin-top: 20px;
	}
	.btn-group .btn {
		margin: 0 5px;
	}

	/* Carousel Styling */
	.carousel {
		border-radius: 8px;
		overflow: hidden;
		border: 1px solid #ddd;
	}
	.carousel-inner > .item > img {
		width: 100%;
		height: 500px;
		object-fit: cover;
	}
	.carousel-indicators li {
		width: 12px;
		height: 12px;
		border-radius: 50%;
		margin: 0 5px;
		border: 2px solid #fff;
		background: transparent;
	}
	.carousel-indicators .active {
		background: #fff;
		width: 14px;
		height: 14px;
	}
	.carousel-caption {
		background: rgba(0,0,0,0.7);
		padding: 20px;
		border-radius: 4px;
	}

	/* Card Styling */
	.card {
		border-radius: 8px;
		border: 1px solid #ddd;
		overflow: hidden;
		box-shadow: 0 5px 15px rgba(0,0,0,0.05);
		transition: all 0.3s ease;
		margin-bottom: 30px;
		background: #fff;
		padding: 30px;
	}
	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 25px rgba(0,0,0,0.1);
		border-color: #000;
	}
	.card h3 {
		color: #000;
		margin-top: 20px;
		margin-bottom: 15px;
	}
	.card a {
		color: #333;
		text-decoration: none;
		transition: color 0.3s ease;
	}
	.card a:hover {
		color: #000;
	}

	/* Popular Categories */
	.header2 {
		background: #000 !important;
		color: #fff;
		padding: 20px;
		margin-bottom: 30px;
		border-radius: 8px;
	}
	
	/* How it works section */
	.how-it-works {
		background: #fff;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 40px;
		margin-bottom: 30px;
	}
	.how-it-works img {
		max-width: 100%;
		border-radius: 8px;
		border: 1px solid #ddd;
	}

	/* FAQ Section Styles */
	.faq-section {
		padding: 120px 0;
		background-color: #f8f9fa;
	}

	.faq-container {
		max-width: 1400px;
		margin: 0 auto;
		padding: 0 40px;
	}

	.faq-header {
		text-align: center;
		margin-bottom: 80px;
		background: #000;
		padding: 50px 30px;
		border-radius: 15px;
	}

	.faq-header h2 {
		font-size: 3.5rem;
		color: #fff;
		margin-bottom: 20px;
		font-weight: 700;
		text-shadow: 0 2px 4px rgba(0,0,0,0.2);
	}

	.faq-header p {
		color: #fff;
		font-size: 1.4rem;
		opacity: 0.9;
	}

	.faq-list {
		display: flex;
		flex-direction: column;
		gap: 40px;
	}

	.faq-item {
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 4px 25px rgba(0, 0, 0, 0.12);
		overflow: hidden;
		border: 1px solid #eee;
		transition: all 0.3s ease;
		min-height: 100px;
	}

	.faq-item:hover {
		transform: translateY(-2px);
		box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
	}

	.faq-question {
		padding: 45px 50px;
		cursor: pointer;
		display: flex;
		justify-content: space-between;
		align-items: center;
		transition: all 0.3s ease;
		background: #fff;
		border-bottom: 1px solid #eee;
	}

	.faq-question:hover {
		background-color: #f8f9fa;
	}

	.faq-question span {
		font-size: 1.8rem;
		font-weight: 600;
		color: #333;
		flex: 1;
		padding-right: 30px;
		line-height: 1.5;
	}

	.faq-icon {
		transition: transform 0.3s ease;
		color: #666;
		font-size: 1.6rem;
	}

	.faq-question.active .faq-icon {
		transform: rotate(180deg);
	}

	.faq-answer {
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.3s ease-out;
		padding: 0 50px;
		background: #fff;
	}

	.faq-answer.active {
		max-height: 1000px;
		padding: 40px 50px;
	}

	.faq-answer p {
		color: #555;
		line-height: 1.8;
		margin: 0;
		font-size: 1.5rem;
	}

	@media (max-width: 768px) {
		.faq-container {
			padding: 0 20px;
		}
		
		.faq-header h2 {
			font-size: 2.8rem;
		}
		
		.faq-question span {
			font-size: 1.5rem;
		}
		
		.faq-answer p {
			font-size: 1.3rem;
		}
		
		.faq-question {
			padding: 30px 25px;
		}
		
		.faq-answer.active {
			padding: 25px;
		}
	}

	/* Footer styling */
	.footer {
		background: #000;
		color: #fff;
		padding: 80px 0 50px;
		margin-top: 100px;
		border-top: 3px solid #333;
	}
	.footer h3 {
		color: #fff;
		font-size: 22px;
		margin-bottom: 25px;
		font-weight: bold;
		position: relative;
		padding-bottom: 15px;
		border-bottom: 2px solid #333;
	}
	.footer p {
		margin: 15px 0;
		font-size: 16px;
		line-height: 1.6;
		color: #e0e0e0;
	}
	.footer a {
		color: #e0e0e0;
		text-decoration: none;
		transition: all 0.3s ease;
		display: inline-block;
		padding: 5px 0;
		border-bottom: 1px solid transparent;
	}
	.footer a:hover {
		color: #fff;
		border-bottom: 1px solid #fff;
		padding-left: 5px;
	}
	.footer .social-contact a {
		display: block;
		padding: 10px 0;
		border-bottom: 1px solid #333;
	}
	.footer .social-contact a:hover {
		background: #333;
		padding-left: 15px;
	}
	.footer .social-contact i {
		width: 35px;
		height: 35px;
		line-height: 35px;
		text-align: center;
		background: #333;
		border-radius: 50%;
		margin-right: 15px;
		transition: all 0.3s ease;
	}
	.footer .social-contact a:hover i {
		background: #fff;
		color: #000;
	}

	/* Container width control */
	.container {
		max-width: 1200px;
		margin: 0 auto;
		padding: 0 15px;
	}

	/* Equal height cards */
	.equal-height {
		display: flex;
		margin: 0 -15px;
	}
	
	.equal-height .col-lg-6 {
		padding: 0 15px;
		flex: 1;
	}
	
	.equal-height .card {
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		padding: 40px;
		margin: 0;
	}

	.card h1 {
		font-size: 36px;
		margin-bottom: 25px;
		color: #000;
		font-weight: bold;
	}

	.card p {
		font-size: 16px;
		line-height: 1.8;
		color: #333;
		margin-bottom: 30px;
		flex-grow: 1;
	}

	.card .btn {
		align-self: center;
		min-width: 200px;
	}

	/* Section spacing */
	.section {
		padding: 80px 0;
	}

	/* Popular categories grid */
	.categories-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 30px;
		margin-top: 40px;
	}

	.categories-grid .card {
		margin: 0;
		text-align: center;
		padding: 30px;
	}

	.categories-grid .card span {
		font-size: 48px;
		color: #000;
		margin-bottom: 20px;
		display: block;
	}

	/* How it works section */
	.how-it-works .row {
		margin-bottom: 40px;
	}

	.how-it-works .row:last-child {
		margin-bottom: 0;
	}

	.how-it-works img {
		max-width: 100%;
		height: auto;
	}

	/* FAQ section */
	.faq-section {
		max-width: 800px;
		margin: 50px auto;
		padding: 0 20px;
	}

	.faq-container {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 5px 30px rgba(12, 10, 10, 0.08);
		overflow: hidden;
	}
	.faq-header {
		background: #000;
		color:white;
		padding: 25px;
		text-align: center;
	}
	.faq-header h2 {
		margin: 0;
		font-size: 28px;
		font-weight: bold;
	}
	.faq-body {
		padding: 30px;
	}
	.btn-faq {
		width: 100%;
		text-align: left;
		padding: 15px 20px;
		margin-bottom: 10px;
		background: #f8f9fa;
		border: none;
		border-radius: 8px;
		font-size: 16px;
		font-weight: 600;
		color: #333;
		transition: all 0.3s ease;
	}
	.btn-faq:hover {
		background: #000;
		color: #fff;
	}
	.faq-content {
		padding: 20px;
		background: #fff;
		border-radius: 0 0 8px 8px;
		color: #666;
		line-height: 1.6;
	}

	/* Navbar buttons */
	.nav-buttons {
		display: inline-flex !important;
		align-items: center;
		gap: 15px;
		margin: 0;
		padding: 0;
	}

	.nav-buttons li {
		display: inline-block;
		padding: 0;
		margin: 0;
	}

	.btn-login, .btn-register {
		padding: 6px 15px;
		font-weight: 500;
		font-size: 15px;
		text-decoration: none !important;
		display: inline-block;
		color: #fff !important;
		transition: all 0.2s ease;
		border: none;
		background: transparent;
	}

	.btn-login:hover, .btn-register:hover {
		color: #e0e0e0 !important;
		background: transparent;
	}

	/* Fix navbar collapse */
	@media (max-width: 768px) {
		.nav-buttons {
			display: inline-flex !important;
			justify-content: center;
			width: auto;
			margin: 5px 0;
		}
		.btn-login, .btn-register {
			padding: 5px 12px;
			font-size: 14px;
		}
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
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php if($username == ""): ?>
				<li class="nav-buttons">
					<a href="loginReg.php" class="btn btn-login">Login</a>
					<a href="loginReg.php?tab=register" class="btn btn-register">Register</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->



<!--Header and slider-->
<div class="header1">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
		<div class="jumbotron">
				<h1>Welcome to Freelance Hub</h1>
				<p>Freelance Hub is a global freelancing platform where businesses and independent professionals connect and collaborate remotely.</p>
					<a href="loginReg.php" class="btn btn-warning btn-lg">
						<i class="fas fa-rocket"></i> It's Free!! Join Now!!!
					</a>
				<div class="btn-group">
						<a href="#how-it-works" class="btn btn-info">
							<i class="fas fa-info-circle"></i> How it works
						</a>
						<a href="#faq-section" class="btn btn-info">
							<i class="fas fa-question-circle"></i> FAQ
						</a>
						<a href="#categories-section" class="btn btn-info">
							<i class="fas fa-th-list"></i> Categories
						</a>
				</div>
			</div>
		</div>	
			<div class="col-lg-7">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="image/computer.jpg" alt="Chania">
		      <div class="carousel-caption">
		        <h3>Work</h3>
		        <p>Work hard to be successful.</p>
		      </div>
		    </div>

		    <div class="item">
		      <img src="image/mug.jpg" alt="Chania">
		      <div class="carousel-caption">
		        <h3>Time</h3>
		        <p>Do not waste your time.</p>
		      </div>
		    </div>

		    <div class="item">
		      <img src="image/coat.jpg" alt="Flower">
		      <div class="carousel-caption">
		        <h3>Believe</h3>
		        <p>Always believe in yourself.</p>
		      </div>
		    </div>
		  </div>

		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>
	</div>
</div>
<!--End Header and slider-->


<!--Individual register tip-->
<section class="section" style="background:#f5f5f5">
	<div class="container text-center">
		<div class="equal-height">
			<div class="col-lg-6">
				<div class="card">
			<h1>Need works done?</h1>
			<p>It's easy. Simply post a job you need completed and receive competitive bids from freelancers within minutes. Whatever your needs, there will be a freelancer to get it done: from web design, mobile app development, virtual assistants, product manufacturing, and graphic design (and a whole lot more). It is the simplest and safest way to get work done online.</p>
					<a href="loginReg.php" class="btn btn-lg" style="background:#000;color:#fff;">Get Started</a>
				</div>
		</div>
			<div class="col-lg-6">
				<div class="card">
			<h1>Looking for work?</h1>
			<p>If you are an expert in any kind of computer related or online work, then do not hesitate to join our platform. It is easy to use and payment is secured. It is a great platform to those people who are skillful. So do not miss the chance to explore the job posts and make some money.</p>
					<a href="loginReg.php" class="btn btn-lg" style="background:#000;color:#fff;">Get Started</a>
		</div>
	</div>
</div>
</div>
</section>

<!--Popular Categories-->
<section id="categories-section" class="section">
	<div class="container text-center">
		<h1 class="card header2">Popular Categories</h1>
		<div class="categories-grid">
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-credit-card"></span>
				<h3>Web Developer</h3>
					<p>Please login and browse our web developers</p>
				</a>
			</div>
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-phone"></span>
				<h3>Mobile Developer</h3>
					<p>Please login and Browse our Mobile Developer</p>
				</a>
			</div>
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-picture"></span>
				<h3>Graphics Designer</h3>
					<p>Please login and browse our Graphics Designer</p>
				</a>
			</div>
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-pencil"></span>
				<h3>Creative writer</h3>
					<p>Please login and browse our Creative writer</p>
				</a>
			</div>
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-signal"></span>
				<h3>Marketing Expert</h3>
					<p>Please login and browse our Marketing Expert</p>
				</a>
			</div>
			<div class="card">
				<a href="loginReg.php">
					<span class="glyphicon glyphicon-headphones"></span>
				<h3>Virtual Assistant</h3>
					<p>Please login and browse our web Virtual Assistant</p>
				</a>
			</div>
		</div>
	</div>
</section>

<!--How it works-->
<section id="how-it-works" class="section how-it-works" style="background:#f5f5f5">
	<div class="container text-center">
		<h1 class="card header2">How it works</h1>
		<div class="card">
			<div class="row">
		<div class="col-lg-6">
			<h3>Post Projects For Free</h3>
					<p>It's always free to post your project. You'll automatically begin to receive bids from our freelancers. Also, you can browse through the talent available on our site, and contact them by the contact information.</p>
		</div>
		<div class="col-lg-6">
					<img src="image/img01.jpg" alt="Post Projects">
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row">
		<div class="col-lg-6">
			<h3>Deposit Money Safely</h3>
			<p>We have a complete security to your valuable money. You have the rights to pay the deposited money after the project completed. We have a good refund policy to make sure of satisfaction of the project completed.</p>
		</div>
		<div class="col-lg-6">
					<img src="image/img02.jpg" alt="Safe Deposit">
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row">
		<div class="col-lg-6">
			<h3>Feel Free To Talk</h3>
			<p>It is easier to talk with the freelancers here. So before you hire any freelancer feel free to talk with them. Tell them what you need and get the project done in the shortest possible time.</p>
		</div>
		<div class="col-lg-6">
					<img src="image/img03.jpg" alt="Communication">
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row">
		<div class="col-lg-6">
			<h3>Build An Employer Profile</h3>
			<p>If you have a lot of works to be done or run a small business that needs some freelancers in a daily basis, this is the perfect place for you. Build your employer profile today and start hiring.</p>
		</div>
		<div class="col-lg-6">
					<img src="image/img04.jpg" alt="Employer Profile">
		</div>
	</div>
</div>
</div>
</section>

<!--FAQ-->
<section id="faq-section" class="section">
	<div class="faq-section">
		<div class="faq-container">
			<div class="faq-header">
				<h2>Frequently Asked Questions</h2>
				<p>Find answers to common questions about our freelancing platform</p>
			</div>
			
			<div class="faq-list">
				<div class="faq-item">
					<div class="faq-question">
						<span>How do I get started as a freelancer?</span>
						<i class="fas fa-chevron-down faq-icon"></i>
					</div>
					<div class="faq-answer">
						<p>To get started, simply register an account as a freelancer, complete your profile with skills and experience, and start browsing available jobs that match your expertise.</p>
  	</div>
  </div>

				<div class="faq-item">
					<div class="faq-question">
						<span>How does payment work?</span>
						<i class="fas fa-chevron-down faq-icon"></i>
					</div>
					<div class="faq-answer">
						<p>We use a secure payment system. Clients deposit funds into escrow before work begins, and payment is released to freelancers once the work is completed and approved.</p>
  	</div>
  </div>

				<div class="faq-item">
					<div class="faq-question">
						<span>What fees do you charge?</span>
						<i class="fas fa-chevron-down faq-icon"></i>
					</div>
					<div class="faq-answer">
						<p>We charge a small percentage fee on completed projects. The exact fee depends on your membership level and the project size. Check our pricing page for detailed information.</p>
  	</div>
  </div>

				<div class="faq-item">
					<div class="faq-question">
						<span>How do I find the right freelancer?</span>
						<i class="fas fa-chevron-down faq-icon"></i>
					</div>
					<div class="faq-answer">
						<p>You can browse freelancer profiles, review their portfolios, ratings, and reviews. You can also post a job and receive proposals from interested freelancers.</p>
					</div>
  	</div>
  </div>
  </div>
</div>
</section>


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
				<p><i class="fas fa-globe"></i> Freelance Hub</p>
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
<script>
// Smooth scrolling for navigation
$(document).ready(function() {
    // Add smooth scrolling to all links
    $("a[href^='#']").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 100 // Offset for fixed navbar
            }, 800);
        }
    });

    // Add active class and rotate icon for FAQ buttons
    $('.btn-faq').click(function() {
        $(this).find('i').toggleClass('fa-rotate-90');
    });
});

// Add this JavaScript for FAQ functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            const isActive = question.classList.contains('active');
            
            // Close all other answers
            document.querySelectorAll('.faq-answer').forEach(ans => {
                ans.classList.remove('active');
            });
            document.querySelectorAll('.faq-question').forEach(q => {
                q.classList.remove('active');
            });
            
            // Toggle current answer
            if (!isActive) {
                answer.classList.add('active');
                question.classList.add('active');
            }
        });
    });
});
</script>
</body>
</html>