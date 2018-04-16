<?php
session_start();
include_once 'includes/dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res = mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lewis-Seddon.com</title>
<link rel="stylesheet" href="main.css" type="text/css" />
</head>

<body bgcolor="8AD8FF">
<a name="top"></a>
<div id="navigation">

<div class="container">
<div id="logo">
<a href="#top" class="smoothScroll"><img src="images/Logo.png"/></a>
</div>
<div class="container text">
<a href="member.php#top" class="smoothScroll">Home</a>
<a href="member.php#about"class="smoothScroll">About Me</a>
<a href="member.php#uni"class="smoothScroll">University Projects</a>
<a href="member.php#personal"class="smoothScroll">Personal Projects</a>
<a href="member.php#contact"class="smoothScroll">Contact</a>
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

<?php
include "includes/dbconnect.php";
if($_POST['Select'] == "Select Blog Entry To Edit or Delete"){
  $blogTitles = $_POST['blogTitles'];

  $query = "SELECT * FROM BlogCMS WHERE blogTitle='" . $blogTitles . "'";
  $result = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_assoc($result);
  $rowTitle = $row['blogTitle'];
  $rowEntry = $row['blogEntry'];
  $entryID = $row['blogID'];
  
  mysqli_close($mysqli);
}
elseif ($_POST['Submit'] == "Update Blog Post") {

  $errorMessage = "";
  $rowTitle = $_POST['blogTitle'];
  $rowEntry = $_POST['blogEntry'];
  $entryID = $_POST['entryKey'];
  $formInput = array($_POST['blogTitle'], $_POST['blogEntry']);

  if($formInput[0] == "Blog Title") 
  {
    $errorMessage .= "Please enter a blog title.";
  }
  if($formInput[1] == "Blog Entry") 
  {
    $errorMessage .= "Please enter a blog entry.";
  }

  if(empty($errorMessage)){
    for ($i=0; $i < 2; $i++){ 
      $formInput[$i] = trim($formInput[$i]);
      $formInput[$i] = stripslashes($formInput[$i]);
      $formInput[$i] = htmlspecialchars($formInput[$i]);
    }
    $stmt = $mysqli->prepare("UPDATE BlogCMS SET blogTitle = ?, blogEntry = ? WHERE blogID = ?");
    $stmt->bind_param('ssi', $formInput[0], $formInput[1], $_POST['entryKey']);
    $stmt->execute(); 
    $stmt->close();  
  }
}
elseif ($_POST['Submit'] == "Delete"){
	$stmt2 = $mysqli->prepare("DELETE FROM BlogCMS WHERE blogID = ?");
    $stmt2->bind_param('i', $_POST['delKey']);
    $stmt2->execute(); 
    $stmt2->close();
}

?>
<div id=content>
<div class="Section">
     
    <div class="h1"> Edit This Entry </div>

  <div class="CMSBlogEdit">
    <h2>Change entry or <a href="javascript:history.back()">Go Back</a> to edit another entry.</h2>
    <?php
    if(!empty($errorMessage)) 
    {
     echo("<p>" . $errorMessage . "</p>\n");
   }
   ?>

   <form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
    <p>
     <input name="blogTitle" class="CMSBlogTitleIn" type="text" value="<?php echo $rowTitle; ?>" onblur="if (this.value == '') {this.value = '<?php echo $rowTitle; ?>';}">
     <input name="blogEntry" class="CMSBlogEntryIn" type="text" value="<?php echo $rowEntry; ?>"  onblur="if (this.value == '') {this.value = '<?php echo $rowEntry; ?>';}">
   </p>
   <input name="Submit" class="blogButtonIn" type="submit" value="Update Blog Post"/>
 </p>
 <?php
 if ($stmt) {
  echo "<p>Blog Posted Successfully!</p>";
}
?>
</div>

<input type="hidden" name="entryKey" value="<?php echo $entryID; ?>">

</form>
<div class="CMSBlogEdit">
<h2> Delete a blog entry</h2>
<form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
<p>
 <input name="Submit" class="blogButtonIn" type="submit" value="Delete"/>
  </p>
 
  <input type="hidden" name="delKey" value="<?php echo $entryID; ?>">
</div>
</form>
</div>
</div>
</body>
</html>