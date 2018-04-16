<?php
session_start();
if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
include_once 'includes/dbconnect.php';

if(isset($_POST["btn-signup"]))
{
 $fname = $_POST['fname'];
 $sname = $_POST['sname'];
 $email = $_POST['email'];
 $upass = $_POST['pass'];

 $fname = mysqli_real_escape_string($mysqli, $fname);
 $sname = mysqli_real_escape_string($mysqli, $sname);
 $email = mysqli_real_escape_string($mysqli, $email);
 $upass = mysqli_real_escape_string($mysqli, $upass);
 $upass = md5($upass);
 
$sql = "SELECT email FROM users WHERE email='$email'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
 
if(mysqli_num_rows($result) == 1)
{
  echo "Sorry...This email already exist..";
}
else
{
    $query = mysqli_query($mysqli, "INSERT INTO users (email, password, firstname, surname)VALUES ('$email', '$upass', '$fname', '$sname')");
 
if($query)
{
  echo "Thank You! you are now registered.";
}
}

 
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lewis-Seddon.com</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<link rel="stylesheet" href="flexslider.css" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="Scripts/jquery.flexslider.js"></script>
<script>
    $(document).ready(function () {
        $('.flexslider').flexslider({
            animation: 'fade',
            controlsContainer: '.flexslider'
        });
    });
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73816236-1', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body bgcolor="8AD8FF">
<a name="top"></a>
<div id="navigation">

<div class="container">
<div id="logo">
<a href="index.php#top" class="smoothScroll"><img src="images/Logo.png"/></a>
</div>
<div class="container text">
<a href="index.php#top" class="smoothScroll">Home</a>
<a href="index.php#about"class="smoothScroll">About Me</a>
<a href="index.php#uni"class="smoothScroll">University Projects</a>
<a href="index.php#personal"class="smoothScroll">Personal Projects</a>
<a href="index.php#contact"class="smoothScroll">Contact</a>
<a href="blog.php">Blog</a>
<a href="includes/cv.php">CV</a>
<?php if($_SESSION["user"] == true) : ?>
<div class="dropdown">
User
<div class="dropdown-content">
<a href="CMS.php">CMS</a>
<a href="register.php"> Register</a>
<a href="includes/logout.php">Logout</a>
</div>
</div>
<?php else : ?>
<a href="login.php">Login</a>
<?php endif; ?>
</div>
</div>
</div>

<div id="content">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="fname" placeholder="First Name" required /></td>
</tr>
<tr>
<td><input type="text" name="sname" placeholder="Surname" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>

<tr>
<td><button type="submit" name="btn-signup">Register</button></td>
</tr>
</table>
</form>

</div>

</div>
<script>
$(document).ready(function () {
	$('.flexslider').flexslider({
		animation: 'fade',
		controlsContainer: '.flexslider'
	});
});

</script>
<footer>
<div id="Copyright">
Copyright © Lewis Seddon 2016
</div>
</footer>
</body>

</html>
