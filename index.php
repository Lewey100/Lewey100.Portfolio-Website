<?php
session_start();
include_once 'includes/dbconnect.php';


if(isset($_SESSION['user']))
{ 
 header("Location: member.php");
}
$res=mysqli_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);

$query = "SELECT * FROM PortfolioCMS Order By Title ASC";
$ismember1 = "";
$ismember2 = "";
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lewis-Seddon.com</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<link rel="stylesheet" href="flexslider.css" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="Scripts/smoothscroll.js"></script>
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
<a href="#top" class="smoothScroll"><img src="images/Logo.png"/></a>
</div>
<div class="container text">
<a href="#top" class="smoothScroll">Home</a>
<a href="#about"class="smoothScroll">About Me</a>
<a href="#uni"class="smoothScroll">University Projects</a>
<a href="#personal"class="smoothScroll">Personal Projects</a> 
<a href="#contact"class="smoothScroll">Contact</a>
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
<div class="flex-container">
  <div class="flexslider">
    <ul class="slides">
      <li>
        <a href="#"><img src="images/ZombieIntro.jpg"/></a>
                <p> C++ Zombies Intro Screen </p>
      </li>
      <li>
        <img src="images/ZombieGame.jpg"/>
                <p> C++ Zombies Game </p>
      </li>
            <li>
              <img src="images/Sunrise.jpg"/>
                <p> Infection Inc. Sunrise </p>
            </li>
            <li>
              <img src="images/Moon.jpg"/>
                <p> Infection Inc. Day/Night Cycle </p>
            </li>
            <li>
              <img src="images/Zombie.jpg"/>
                <p> Infection Inc. Zombie Model </p>
            </li>
    </ul>
  </div>
</div>

<a name="about"></a>
<div id="space">
</div>

<div class="Section">
<div class="h1">
About Me
</div>
</p>
<div class="AboutMeText">
My name is Lewis Seddon, and this is my game development portfolio.</p>
I am currently a second year <a href="http://www.shu.ac.uk/prospectus/course/800/">MComp Games Software Development</a> student at Sheffield Hallam University, expected to graduate in June 2018. I have always had a passion for gaming which has led me into the path of creating my own. Some games which have inspired me are <a href= "http://survivethenights.net/about-stn-2/">Survive The Nights</a>, <a href="https://www.dayzgame.com/"> DayZ</a> and <a href="http://playrust.com/">Rust</a>.</p>
Some of my current favorite games are <a href="http://euw.leagueoflegends.com/">League of Legends</a>, <a href="http://blog.counter-strike.net/">Counter-Strike: Global Offensive</a> and <a href="http://rocketleague.psyonix.com/"> Rocket League</a>.</p>
My other hobbies and interests are learning to play guitar, golf and travelling.
</div>
<div id="photo">
</div>
</div>

<a name="uni"></a>
<div id="space">
</div>
<div class="Section Uni">
<div class="h1">
University Projects
</div>
</p>
<div class="OpeningContent">
<p>Since arriving at Sheffield Hallam University in September 2014 I have learnt a lot of new skills that are all essential to Game Development and have worked on numerous projects, individually and within a team. These projects are listed below with some information about them! Some will be available to download and test yourselves:
</p>

<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
      {
        $critera = "";
        $CD = $_POST["Downloadable"];
        $CP = $_POST['Playable'];
        

        if ($CD == 'on') {
          $critera .= "WHERE Downloadable='1' ";
          $ismember1 = "checked";
        }
        if ($CP == 'on') {
          if ($CD == 'on') {
            $critera .= "OR Playable='1' ";
          }
          else{
            $critera .= "WHERE Playable='1' ";
          }
          $ismember2 = "checked";
        }
        
        if($_POST["Search"] == "Search") 
        {
          unset($_POST["Search"]);
        }

        if (isset($_POST["Search"])) {
          $SearchInput = $_POST["Search"];
          $SearchInput = trim($SearchInput);
          $SearchInput = stripslashes($SearchInput);
          $SearchInput = htmlspecialchars($SearchInput);
          if ($CD == 'on' || $CP == 'on') {
            $critera .= " AND Title LIKE '%" . $SearchInput . "%' OR Description LIKE '%" . $SearchInput . "%'";
          }
          else{
            $critera = "WHERE Title LIKE '%" . $SearchInput . "%' OR Description LIKE '%" . $SearchInput . "%'";
          }
        }
        $query = "SELECT * FROM PortfolioCMS " . $critera . " Order By Title ASC";
      }
     
?>
<div class="SearchArea">
<form id="SearchBar" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
<p>
<input type="checkbox" name="Downloadable" <?php echo $ismember1 ?>>
<data-toggle="tooltip" data-placement="top" title="Downloadable">Downloadable
<input type="checkbox" name="Playable" <?php echo $ismember2 ?>>
<data-toggle="tooltip" data-placement="top" title="Playable">Playable
<input name="Search" class="CMSBlogEntryIn" type="text" value="Search" onfocus="if (this.value == 'Search'){this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}">
          </p>
 <input name="submit" class="subButton" type="submit" value="Search Portfolio"/>
          </p>
        </form>
        </div>

        </div>
<?php
include "includes/dbconnect.php";

 $result = mysqli_query($mysqli, $query);
      $num_results = mysqli_num_rows($result);
      for($i=0; $i<$num_results; $i++) {
        $Link1 = "";
        $Link2 = "";
        
        $row = mysqli_fetch_assoc($result);
        if ($i % 2 == 0){
          echo "<div class=\"row " . $i . "\">";
        }

        if (!empty($row['Link'])) {
          $Link1 = "<a href=\"" . $row['Link'] . "\">";
          $Link2 = "</a>";
        }

     echo "<div class=\"Portfolio-Items\">" .
        $Link1 . "<img class=\"imgcol\" src=\"" . $row['photo'] . "\">" . $Link2  . "<h2>" . $row['Title'] .
          "</h2>" . "<p>" . $row['Description'] . "</p>" . "</div>";
      
      if ($i % 2 != 0){
          echo "</div>";
        }
    }

?>
</div>
</div>
<a name="personal"></a>
<div id="space">
</div>
<div class="Section Personal">
<div class="h1">
Personal Projects
</div>
</p>
<div class="OpeningContent">
Now that I have developed some skill in the art of Game Development I have took it upon myself to work on my projects in my free time, take a look below to see some of my blossoming ideas:
</div>

<?php

$query= "SELECT * FROM PersonalPortfolioCMS";
 $result = mysqli_query($mysqli, $query);
      $num_results = mysqli_num_rows($result);
      for($i=0; $i<$num_results; $i++) {
        $Link1 = "";
        $Link2 = "";
        
        $row = mysqli_fetch_assoc($result);
        if ($i % 2 == 0){
        	echo "<div class=\"row " . $i . "\">";
        }
        
        if (!empty($row['Link'])) {
          $Link1 = "<a href=\"" . $row['Link'] . "\">";
          $Link2 = "</a>";
        }

       echo "<div class=\"Portfolio-Items\">" .
        $Link1 . "<img class=\"imgcol\" src=\"" . $row['photo'] . "\">" . $Link2  . "<h2>" . $row['Title'] .
          "</h2>" . "<p>" . $row['Description'] . "</p>" . "</div>";

            if ($i % 2 != 0){
          echo "</div>";
        }
      }

?>
</div>
<!--
<div class="Portfolio-Personal">
<a href="InfectionGame/Infection Inc.html"> <img class="imgcol" src="images/Sunrise.jpg"> </a>
<h2> Infection Inc. </h2>
<p> Infection Inc. is my current pride and joy. It is a first person shooter zombie survival game inspired by the likes of DayZ and Survive The Nights. Although in very early development, due to my studies being my #1 priority, I have big plans for this video game and have a feature list longer than the Great Wall of China! I will keep updating the version on this website as I develop it for you to download/play. Click the photo to test the latest version! <br> (Requires Unity Web Player | Chrome not supported)
</div>
</div>
-->
<a name="contact"></a>
<div id="space">
</div>
<div class="Section Contact">
<div class="h1">
Contact Me!
</div>

</p>
<div class="ContactContent">

<div class="Portfolio-Personal">
E-mail me at Lewis.Seddon@student.shu.ac.uk or use the contact form below:
</br></br>


<form name="contactform" method="post">
 <?php 
//email

if(isset($_POST['sendEmail'])) {
include_once "includes/dbconnect.php";

  $stmt= $mysqli->prepare("INSERT INTO contact (subject, name, email, comments) VALUES (?,?,?,?)");
  $stmt->bind_param('ssss', $_POST['subject'], $_POST['name'], $_POST['email'], $_POST['comments']);

  $stmt->execute();
  


    // EDIT THE 2 LINES BELOW AS REQUIRED
    $to = "Lewis.Seddon@student.shu.ac.uk";


    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }


    // validation expected data exists
    if(!isset($_POST['subject']) ||
       !isset($_POST['name']) ||
       !isset($_POST['email']) ||
       !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }

$subject = $_POST['subject']; // required
$name = $_POST['name'];// required
$email = $_POST['email'];// required
$comments = $_POST['comments'];// required


    $error_message = "";

      $string_exp = "^[a-z .'-]+$";
  if(!eregi($string_exp,$subject)) {
    $error_message .= 'The subject you entered does not appear to be valid.<br />';
  }
  $string_exp = "^[a-z .'-]+$";
  if(!eregi($string_exp,$name)) {
    $error_message .= 'The name you entered does not appear to be valid.<br />';
  }
    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){ 
   $error_message .= 'The email you entered does not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }

    $message = "Form details below.\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $message .= "Name: ".clean_string($name)."\n";
    $message .= "email: ".clean_string($email)."\n";
    $message .= "comments: ".clean_string($comments)."\n";



mail($to, $subject, $message);  

//send
header("Location: index.php");

$stmt->close;

}

 ?>
<table width="450px">
 <tr>
  <td valign="top">
    <label for = "subject">Subject *</label>
  </td>
  <td valign="top">
  <input  type="text" name="subject" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="name">Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
 <td valign="top">
  <label for="comments">Comments *</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input name="sendEmail" type="submit" value="Submit">   
 </td>
</tr>
</table>
</form>

<br></p>
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:440px;width:910px;'><div id='gmap_canvas' style='height:440px;width:910px;'></div><div><small><a href="http://embedgooglemaps.com">                 embed google map              </a></small></div><div><small><a href="https://www.googlemapsgenerator.com/">generate Google Maps</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(53.37704056759799,-1.466027077246057),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(53.37704056759799,-1.466027077246057)});infowindow = new google.maps.InfoWindow({content:'<strong>Sheffield Hallam University</strong><br>Howard Street, S1 4WB<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
</div>

</div>

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
<div id="Copyright">
Copyright &copy; Lewis Seddon 2016
</div>
</div>
</body>
</html>
