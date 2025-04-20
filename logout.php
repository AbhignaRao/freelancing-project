<?php 
session_start();
session_destroy();
header("Location: index.php");
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout - Projectworlds Freelance</title>
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

    /* Header image */
    .header-image {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('image/logout-banner.jpg');
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

    /* Logout content styling */
    .logout-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.08);
        padding: 40px;
        text-align: center;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .logout-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 40px rgba(0,0,0,0.12);
    }

    .logout-icon {
        font-size: 64px;
        color: #000;
        margin-bottom: 30px;
        animation: fadeInDown 1s ease;
    }

    .logout-container h2 {
        color: #000;
        font-size: 32px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .logout-container p {
        color: #666;
        font-size: 18px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .countdown {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        background: #f8f9fa;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-block;
        margin: 10px 0;
    }

    .btn-login {
        background: #000;
        color: #fff;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        border: 2px solid #000;
    }
    .btn-login:hover {
        background: #333;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .btn-login i {
        margin-right: 10px;
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

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">Projectworlds Freelance</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="allJob.php"><i class="fas fa-briefcase"></i> Browse Jobs</a></li>
                <li><a href="allFreelancer.php"><i class="fas fa-users"></i> Browse Freelancers</a></li>
                <li><a href="allEmployer.php"><i class="fas fa-building"></i> Browse Employers</a></li>
            </ul>
        </div>      
    </div>  
</nav>
<!--End Navbar menu-->

<div class="container">
    <!-- Header Image -->
    <div class="header-image">
        <h1>Logged Out Successfully</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="logout-container">
                <i class="fas fa-sign-out-alt logout-icon"></i>
                <h2>Thank You for Using Our Platform!</h2>
                <p>You have been successfully logged out of your account. We hope you had a great experience with Projectworlds Freelance.</p>
                <div class="countdown">
                    Redirecting in <span id="countdown">5</span> seconds...
                </div>
                <a href="loginReg.php" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login Again
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Tips Section -->
            <div class="tips-section">
                <h3><i class="fas fa-lightbulb"></i> Quick Tips</h3>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check"></i> Clear your browser cache for better security</li>
                    <li><i class="fas fa-check"></i> Always log out on shared devices</li>
                    <li><i class="fas fa-check"></i> Keep your password secure</li>
                    <li><i class="fas fa-check"></i> Enable two-factor authentication</li>
                    <li><i class="fas fa-check"></i> Update your profile regularly</li>
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

<script>
// Countdown timer and redirect with smooth animation
var seconds = 5;
function countdown() {
    var countdownElement = document.getElementById('countdown');
    countdownElement.innerHTML = seconds;
    
    if (seconds > 0) {
        seconds--;
        // Add fade effect
        countdownElement.style.opacity = 0;
        setTimeout(function() {
            countdownElement.style.opacity = 1;
        }, 200);
        setTimeout(countdown, 1000);
    } else {
        window.location.href = 'index.php';
    }
}
countdown();
</script>

</body>
</html>