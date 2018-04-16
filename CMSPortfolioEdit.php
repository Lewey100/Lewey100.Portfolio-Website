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
if($_POST['Select'] == "Select Portfolio Entry To Edit or Delete"){
  $Titles = $_POST['Titles'];

  $query = "SELECT * FROM PortfolioCMS WHERE Title='" . $Titles . "'";
  $result = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_assoc($result);
  $rowTitle = $row['Title'];
  $rowLink = $row['Link'];
  $rowFilePath = $row['photo'];
  $rowDesc = $row['Description'];
  $rowDownloadable = $row['Downloadable'];
  $rowPlayable = $row['Playable'];
  $entryID = $row['postID'];

  if ($rowDownloadable == 'on') {
    $ismember1 = "checked";
  }
  if ($rowPlayable == 'on') {
    $ismember2 = "checked";
  }
  
  mysqli_close($mysqli);
}
elseif ($_POST['Submit'] == "Update Portfolio Entry"){

  $errorMessage2 = "";
  $rowTitle = $_POST['Title'];
  $rowLink = $_POST['Link'];
  $rowFilePath = $_POST['photo'];
  $rowDesc = $_POST['Description'];
  $rowDownloadable = $_POST['Downloadable'];
  $rowPlayable = $_POST['Playable'];

  if ($rowDownloadable == 'on') {
    $ismember1 = "checked";
  }
  if ($rowPlayable == 'on') {
    $ismember2 = "checked";
  }

  
  $entryID = $_POST['entryKey'];

$formInput = array($_POST['Title'], $_POST['Link'], $_POST['photo'], $_POST['Description'], $_POST['Downloadable'], $_POST['Playable']);
  if($formInput[0] == "Title") 
  {
    $errorMessage2 .= "<li class=\"alert alert-danger\" role=\"alert\">Please enter a valid title. </li>";
  }
 
  if($formInput[3] == "Description") 
  {
    $errorMessage2 .= "<li class=\"alert alert-danger\" role=\"alert\">Please enter a portfolio description. </li>";
  }
 
  if($formInput[4] == "Downloadable"){
    $formInput[4] = 1;
  }
  else{
    $formInput[4] = 0;
  }

  if($formInput[5] == "Playable"){
    $formInput[5] = 1;
  }
  else{
    $formInput[5] = 0;
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
    if (isset($_POST['PrevFilePath'])) {
      $filePathArr = $_POST['PrevFilePath'] . " ";
    }
    else{
      $filePathArr = "";
    }
    foreach ($filePath as $value) {
      $filePathArr .= "$value ";
    }

  }

  if(empty($errorMessage2)){
    for ($i=0; $i < 2; $i++){ 
      $formInput[$i] = trim($formInput[$i]);
      $formInput[$i] = stripslashes($formInput[$i]);
      $formInput[$i] = htmlspecialchars($formInput[$i]);
    }


      $stmt = $mysqli->prepare("UPDATE PortfolioCMS SET Title = ?, Link = ?, photo = ?, Description = ?, Downloadable = ?, Playable = ? WHERE postID = ?");
      $stmt->bind_param('ssssiii', $formInput[0], $formInput[1], $filePathArr, $formInput[3], $formInput[4], $formInput[5], $_POST['entryKey']);
      $stmt->execute(); 
      $stmt->close();  
  
  }
}
elseif ($_POST['Submit'] == "Delete"){
  $stmt2 = $mysqli->prepare("DELETE FROM PortfolioCMS WHERE postID = ?");
    $stmt2->bind_param('i', $_POST['delKey']);
    $stmt2->execute(); 
    $stmt2->close();
}
?>

<div id=content>
<div class="Section">
     
    <div class="h1"> Edit This Portfolio Item </div>

  <div class="CMSBlogEdit">
    <h2>Change item or <a href="javascript:history.back()">Go Back</a> to edit another item.</h2>
    <?php
    if(!empty($errorMessage2)) 
    {
     echo("<p>" . $errorMessage2 . "</p>\n");
   }
   ?>

   <form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <p>
     <input name="Title" class="CMSBlogTitleIn" type="text" value="<?php echo $rowTitle; ?>" onblur="if (this.value == '') {this.value = '<?php echo $rowTitle; ?>';}">
     <input name="Link" class="CMSBlogTitleIn" type="text" value="<?php echo $rowLink; ?>"  onblur="if (this.value == '') {this.value = '<?php echo $rowLink; ?>';}">
     </br>

     <input name="Description" class="CMSBlogEntryIn" type="text" value="<?php echo $rowDesc; ?>" onblur="if (this.value == '') {this.value = '<?php echo $rowDesc; ?>';}">
     </br>
     <input type="file" name="files[]" multiple="" class="fileUpload"/>
   <p>Add additional photos. Image Upload (700x400).</p>
   <br>
    <input name="Downloadable" type="checkbox" value="Downloadable"> Downloadable
     <input name="Playable" type="checkbox" value="Playable"> Playable
     </br>
   </p>
   <input name="Submit" class="subButton" type="submit" value="Update Portfolio Entry"/>
 </p>
 <?php
 if ($stmt) {
  echo "<p>Portfolio Posted Successfully!</p>";
}
?>
</div>

<input type="hidden" name="PrevFilePath" value="<?php echo $rowFilePath; ?>">
<input type="hidden" name="entryKey" value="<?php echo $entryID; ?>">

</form>
<div class="CMSBlogEdit">
<h2> Delete a blog entry</h2>
<form id="CMSBlog" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
<p>
 <input name="Submit" class="" type="submit" value="Delete"/>
  </p>
 
  <input type="hidden" name="delKey" value="<?php echo $entryID; ?>">
</div>
</form>
</div>
</div>
</body>
</html>