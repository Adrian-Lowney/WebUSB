<script type="text/javascript" src='../../javascript/main.js'></script>





<?php
echo shell_exec("pwd");
$uploaddir = $_POST['directory'];
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo "<p>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "File is valid, and was successfully uploaded.\n";
} else {
   echo "Upload failed";
}

echo "</p>";
echo '<pre>';
echo 'Here is some more debugging info:';
print_r($_FILES);
echo $uploaddir;

print "</pre>";


$GLOBALS['directory'] = "testststasatast"; 
?> 

<script>

window.location.replace("../../device.php");

</script>
