<?php
session_start();
include_once 'includes/dbconnect.php';

if(isset($_SESSION['user'])!="")
{
 header("Location: member.php?u=$email");
}
if(isset($_POST['btn-login']))
{
	$email=$_POST['email'];
	$upass=$_POST['pass'];
	$email = stripslashes($email);
	$upass = stripslashes($upass);
 $email = mysqli_real_escape_string($mysqli, $email);
 $upass = mysqli_real_escape_string($mysqli, $upass);
 $upass = md5($upass);
 $sql="SELECT user_id FROM users WHERE email='$email' and password='$upass'";
 $result=$mysqli->query($sql);
 $row=mysqli_fetch_array($result);
 
 if($result->num_rows == 1)
  {
  $_SESSION['user'] = $row['user_id'];
  header("Location: member.php?u=$email");
 }
 else
 {
  ?>
        <script>alert('Your Username/Password is incorrect!');</script>
        <?php
 }
 
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lewis-Seddon.com</title>
<link rel="stylesheet" href="main.css" type="text/css" />

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
<a href="login.php">Login</a>
</div>
</div>
</div>

<div id="content">


<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Login</button></td>
</tr>
</table>
</form>


</div>

</div>
<footer>
<div id="Copyright">
Copyright &copy; Lewis Seddon 2016
</div>
</footer>
</body>

</html>
