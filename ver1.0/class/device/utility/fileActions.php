<?php

if($_POST["action"] == "deleteFile")
{
    deleteFile($_POST["file"]);
}
else if($_POST["action"] == "renameFile")
{
    renameFile($_POST["file"], $_POST["newName"], $_POST["format"]);
}

function deleteFile($file)
{
    
    unlink('../../../'.$file); 
    
}

function renameFile($file, $newName, $format)
{
    $file = "../../../".$file;
    $newFile = substr($file, 0, strrpos($file, "/")+1).$newName.".".$format;
    
    rename($file,$newFile);
}

function deleteFolder($folder) // Later development
{
    
}

function createFolder($folder) // Later development
{
    
}

function renameFolder($folder) // Later development
{
    
}


?>
