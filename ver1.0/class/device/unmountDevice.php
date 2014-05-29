<?php

/**
 * @author @owner A Lowney, May 2014
 */

if(isset($_POST["deviceUUID"]) && isset($_POST["action"]))
{
    unmountDevice($_POST["deviceUUID"]);
}

function unmountDevice($deviceUUID)
{
    $con=new mysqli("127.0.0.1","root","temppwd","Web_USB");
    mysqli_query($con, "update devices set connected = 0 where deviceUUID = '".$deviceUUID."'");  
    unmount($deviceUUID);
}

function unmount($deviceUUID)
{
    $deviceUUID = "/var/www/disk".$deviceUUID.'/';
    $unmountCommand = "sudo scripts/./listDisks.sh unmount ".$deviceUUID;
    $unmountExec = shell_exec($unmountCommand);
}

?>