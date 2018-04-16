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
<div id=content>
<div class="Section CMS">
<div class="h1"> Content Management System </div>

 <?php
  include "includes/dbconnect.php";
  if($_POST['Submit'] == "Add Blog Post")
  {
    $errorMessage = "";


    $formInput = array($_POST['blogTitle'], $_POST['blogEntry']);

    if($formInput[0] == "Blog Title *") 
    {
      $errorMessage .= "Please enter a blog title.";
    }
    if($formInput[1] == "Blog Entry *") 
    {
      $errorMessage .= "Please enter a blog entry.";
    }

    if(empty($errorMessage)){
      for ($i=0; $i < 3; $i++){ 
        $formInput[$i] = trim($formInput[$i]);
        $formInput[$i] = stripslashes($formInput[$i]);
        $formInput[$i] = htmlspecialchars($formInput[$i]);
      }

      $stmt = $mysqli->prepare("INSERT INTO BlogCMS(blogTitle, blogEntry) VALUES (?, ?)");
      $stmt->bind_param('ss', $formInput[0], $formInput[1]);

      $stmt->execute(); 
      $stmt->close();    
    }
  }
  

  ?>
  <div class ="CMSBlogEdit">
  <h2>Create a blog post!</h2>
    <form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
    <p>
     <input name="blogTitle" class="CMSBlogTitleIn" type="text" value="Blog Title" onfocus="if (this.value == 'Blog Title'){this.value = '';}" onblur="if (this.value == '') {this.value = 'Blog Title';}">
     <input name="blogEntry" class="CMSBlogEntryIn" type="text" value="Blog Entry" onfocus="if (this.value == 'Blog Entry') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Blog Entry';}">
     </br>
     </p>
     <input name="Submit" class="blogButtonIn" type="submit" value="Add Blog Post"/>
   <?php
   if ($stmt) {
    echo "<p>Blog Posted Added!</p>";
  }

  ?>
  </div>
</form>

<div id="space"></div>
  <div class="CMSBlogEdit">
  <h2>Edit/Delete a blog entry</h2>
  <form action="CMSBlogEdit.php" method="POST">
    <p>
      <select name="blogTitles">
        <?php
        $query = "SELECT blogTitle FROM BlogCMS Order By timeStamp Desc";
        $result = mysqli_query($mysqli, $query);
        $num_result = mysqli_num_rows($result);
        for($i=0; $i<$num_result; $i++) {
          $row = mysqli_fetch_assoc($result);
          echo "<option value=\"" . $row['blogTitle'] . "\">" . $row['blogTitle'] . "</option>";
        }
        ?>
      </select>
    </br>
  </p>
  <input name="Select" class="blogButtonIn" type="submit" value="Select Blog Entry To Edit or Delete"/>
</form>
</div>

<div id="space"></div>
<?php
if($_POST['Submit'] == "Add Portfolio Post")
{

  $errorMessage2 = "";

  $formInput = array($_POST['Title'], $_POST['Link'], $_POST['Description'], $_POST['Downloadable'], $_POST['Playable']);
  if($formInput[3] == "Downloadable"){
    $formInput[3] = 1;
  }
  else{
    $formInput[3] = 0;
  }
  if($formInput[4] == "Playable"){
    $formInput[4] = 1;
  }
  else{
    $formInput[4] = 0; 
  }

 if(isset($_FILES['files'])){
    $errors= array();
    for($i=0;$i<count($_FILES['files']['tmp_name']); $i++){
      $file_name = $_FILES['files']['name'][$i];
      $file_size =$_FILES['files']['size'][$i];
      $file_tmp =$_FILES['files']['tmp_name'][$i];
      $file_type=$_FILES['files']['type'][$i];  
      if($file_size > 2097152){
        $errorMessage2.="File size must be less than 2 MB";
      }   
      $img_dir="images";
      if(is_dir($img_dir)==false){
        mkdir("$img_dir", 0700);    // Create directory if it does not exist
      }
      if(is_dir("$img_dir/".$file_name)==false){
        move_uploaded_file($file_tmp,"$img_dir/".$file_name);
        $filePath[$i] = "$img_dir/" . $file_name;   
      }else{                  // rename the file if another one exist
        $new_dir="$img_dir/".$file_name.time();
        rename($file_tmp,$new_dir) ; 
        $filePath[$i] = "$img_dir/" . $file_name.time();      
      }
    }
  }

if(empty($errorMessage2)){
    for ($i=0; $i < 2; $i++){ 
      $formInput[$i] = trim($formInput[$i]);
      $formInput[$i] = stripslashes($formInput[$i]);
      $formInput[$i] = htmlspecialchars($formInput[$i]);
    }

    $filePathArr = "";
    foreach ($filePath as $value) {
      $filePathArr .= "$value ";
    }

    
$stmt2 = $mysqli->prepare("INSERT INTO PortfolioCMS(Title, Link, photo, Description, Downloadable, Playable) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt2->bind_param('ssssii', $formInput[0], $formInput[1], $filePathArr, $formInput[2], $formInput[3], $formInput[4]);
    $stmt2->execute(); 
    $stmt2->close();  

  }
}

    ?>

     <div class ="CMSBlogEdit">
  <h2>Create a portfolio post!</h2>
    <form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <p>
     <input name="Title" class="CMSBlogTitleIn" type="text" value="Title" onfocus="if (this.value == 'Title'){this.value = '';}" onblur="if (this.value == '') {this.value = 'Title';}">
     <input name="Link" class="CMSBlogTitleIn" type="text" value="Link" onfocus="if (this.value == 'Link') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Link';}">
     </br>
     <input name="Description" class="CMSBlogEntryIn" type="text" value="Description" onfocus="if (this.value == 'Description') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Description';}">
     </p>
     </br>
     <input type="file" name="files[]" multiple="" class="fileUpload"/>
   <p>Image Upload (700x400).</p>
   </br>
    <input name="Downloadable" type="checkbox" value="Downloadable"> Downloadable
     <input name="Playable" type="checkbox" value="Playable"> Playable
     </br>
     <input name="Submit" class="blogButtonIn" type="submit" value="Add Portfolio Post"/>
   <?php
   if ($stmt2) {
    echo "<p>Portfolio Posted Added!</p>";
  }

  ?>
  </div>
</form>

<div id="space"></div>
  
  <div class="CMSBlogEdit">
  <h2>Edit/Delete a Portfolio entry</h2>
  <form action="CMSPortfolioEdit.php" method="POST">
    <p>
      <select name="Titles">
        <?php
        $query2 = "SELECT Title FROM PortfolioCMS Order By Title ASC";
        $result2 = mysqli_query($mysqli, $query2);
        $num_result2 = mysqli_num_rows($result2);
        for($x=0; $x<$num_result2; $x++) {
          $row2 = mysqli_fetch_assoc($result2);
          echo "<option value=\"" . $row2['Title'] . "\">" . $row2['Title'] . "</option>";
        }
        ?>
      </select>
    </br>
  </p>
  <input name="Select" class="blogButtonIn" type="submit" value="Select Portfolio Entry To Edit or Delete"/>
</form>
</div>


</div>
</div>


</body>
</html>