<?php
session_start();
include_once 'includes/dbconnect.php';
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
<a href="../member.php#top" class="smoothScroll"><img src="images/Logo.png"/></a>
</div>
<div class="container text">
<a href="../member.php#top" class="smoothScroll">Home</a>
<a href="../member.php#about"class="smoothScroll">About Me</a>
<a href="../member.php#uni"class="smoothScroll">University Projects</a>
<a href="../member.php#personal"class="smoothScroll">Personal Projects</a>
<a href="../member.php#contact"class="smoothScroll">Contact</a>
<a href="blog.php">Blog</a>
<a href="includes/cv.php">CV</a>
<?php if($_SESSION["user"] == true) : ?>
<div class="dropdown">
User
<div class="dropdown-content">
<a href="../CMS.php">CMS</a>
<a href="register.php"> Register</a>
<a href="includes/logout.php">Logout</a>
</div>
</div>
<?php else : ?>
<a href="../login.php">Login</a>
<?php endif; ?>
</div>
</div>
</div>

<div id="content">
<div class="Section Blog">
<h1> My Blog <small> A small blog posting about my ongoing adventures!</small></h1>
 <?php
    include "includes/dbconnect.php";
    if (empty($_GET['Page'])) {
      $_GET['Page'] = "1";
    }
    $pageNo = $_GET['Page'];
    $pageBot = $pageNo * 4 - 4;
    $query = "SELECT * FROM BlogCMS Order By timeStamp DESC LIMIT " . $pageBot . ", 4;";
    $result = mysqli_query($mysqli, $query);
    $num_results = mysqli_num_rows($result);

    $query2 = "SELECT COUNT(*) FROM BlogCMS;";
    $result2 = mysqli_query($mysqli, $query2);
    $rawRows = mysqli_fetch_row($result2);

    $pages = ceil($rawRows[0] / 4 );
    $SetActive[] = "";
    $SetActive[$_GET['Page']] = "class=\"active\"";   

    for($i=0; $i<$num_results; $i++) {
      $row = mysqli_fetch_assoc($result);
      echo "<div class=\"blogEntry " . $i . "\"><h4>" .  $row['blogTitle'] . "</h4><h5>" . $row['timeStamp'] . "</h5><p>" . $row['blogEntry'] . "</p></div>";
    }  
    echo "<div class=\"botAlign\"><div class=\"center-page\"><ul class=\"pagination\">  <li " . $SetActive[1] . ">  <a href=\"?Page=1\">1</a></li>";
    
    for($j=1; $j<$pages; $j++){
      echo "<li " . $SetActive[($j + 1)] . "><a href=\"?Page=" . ($j + 1) . "\">" . ($j + 1) ."</a></li>";
    }
    echo "</ul></div>";
    ?>
</div>
</div>
</body>
</html>