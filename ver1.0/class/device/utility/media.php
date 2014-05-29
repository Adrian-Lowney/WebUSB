<center>
<?php
$file = "../../".$_POST['content']; 
$fileFormat = $_POST['format']; 

$audioFormats = array("mp3", "wma", "wav", "mid", "ogg", "m4a" );
$videoFormats = array("m4v", "mp4", "avi", "3gp", "flv", "mov", "swf", "vob", "wmv");

$nowPlaying = substr($file, strrpos($file, "/") + 1); 

echo "<b>".$nowPlaying."<b>";
echo "<button class='close' onclick ='closeMedia()'>&times;</button><br>";


if(in_array($fileFormat, $videoFormats))
{
    ?>     
    
        <video  width="320" height="240" controls autoplay>
        <source src="<?php   echo $file; ?>" type="video/mp4">
        <source src="<?php   echo $file; ?>" type="video/ogg">
              Your browser does not support the video tag.
        </video>
    
        
    <?php
}
else if(in_array($fileFormat, $audioFormats))
{
    ?>   
        
    
        <audio controls autoplay>
          <source src="<?php   echo $file; ?>" type="audio/ogg">
          <source src="<?php   echo $file; ?>" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
    
<?php
}
?>
</center>