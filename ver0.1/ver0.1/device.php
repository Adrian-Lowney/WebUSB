<?php 
/**
 * @author Adrian
 */
include 'class/DeviceView.class.php';
include 'page/partials/base/header.php';
?>

    <div id ="content">
         
    <br>
    <h4>Devices</h4><hr>
    <br>     

    <div id ="contentBox">
           
<?php

    $usbStatus = explode("Bus", shell_exec('cd scripts; sudo ./listDisks.sh')); 
    
    foreach($usbStatus as $key => $value)
    {          
        if (strpos($value, "Linux") !== false || strpos($value, "HUB") !== false ) {
            unset($usbStatus[$key]);
        }      
    }

    foreach ($usbStatus as $key => $value)
    {
        echo $value.'<br>';
    }
   
    
?>
        
    </div>

    <br><br><hr><br>
    <a href="login.php">Log Out</a>    
    
</div>  

<?php
include 'page/partials/base/footer.php';
?>

