
<?php
$config->uploadBadExtensions = 'php php3 phtml exe cfm shtml asp pl cgi sh vbs jsp';

$uploaddir = $_POST['directory'];
//echo "Directory: ".$uploaddir; 
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);



if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Upload failed.. <br><br> Returning to directory..";
}

if($uploaddir != "")
{
    $uploaddir = substr($uploaddir, 13);
    ?>
    <meta http-equiv="refresh" 
          content="0; url=../../../device.php?directory=<?php echo $uploaddir;?>" />
    <?php
}
 else {
    ?>
    <meta http-equiv="refresh" 
          content="0; url=../../../device.php" />
    <?php
}
?> 

