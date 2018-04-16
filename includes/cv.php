<?php
session_start();
include_once 'includes/dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lewis-Seddon.com</title>
<link rel="stylesheet" href="../main.css" type="text/css" />
</head>

<body bgcolor="8AD8FF">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73816236-1', 'auto');
  ga('send', 'pageview');

</script>
<a name="top"></a>
<div id="navigation">

<div class="container">
<div id="logo">
<a href="../member.php#top" class="smoothScroll"><img src="../images/Logo.png"/></a>
</div>
<div class="container text">
<a href="../member.php#top" class="smoothScroll">Home</a>
<a href="../member.php#about"class="smoothScroll">About Me</a>
<a href="../member.php#uni"class="smoothScroll">University Projects</a>
<a href="../member.php#personal"class="smoothScroll">Personal Projects</a>
<a href="../member.php#contact"class="smoothScroll">Contact</a>
<a href="../blog.php">Blog</a>
<a href="cv.php">CV</a>
<?php if($_SESSION["user"] == true) : ?>
<div class="dropdown">
User
<div class="dropdown-content">
<a href="../CMS.php">CMS</a>
<a href="register.php"> Register</a>
<a href="logout.php">Logout</a>
</div>
</div>
<?php else : ?>
<a href="../login.php">Login</a>
<?php endif; ?>
</div>
</div>
</div>

<div id="content">
<div id="space">
</div>
<div class="Section CV">
<div class="h1">
Curriculum Vitae
</div>
<div id="CV">
<iframe src="https://docs.google.com/document/d/1lbketTLfAGp5723zZpXE18pZYo4WlvoGtr7U9W-J36M/pub?embedded=true"></iframe>
</div>
</div>

</div>
<div id="Copyright">
Copyright &copy; Lewis Seddon 2016
</div>

</body>

</html>
