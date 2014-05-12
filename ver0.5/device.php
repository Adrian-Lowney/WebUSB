<?php 
/**
 * @author Adrian
 */

if(isset($GLOBALS['directory']))
{
    ?>
    <body onload ="exploreDevice('<?php echo $GLOBALS['directory']; ?>')">  
    <?php
    echo $GLOBALS['directory']; 
}
else
{
    echo $GLOBALS['directory']; 
    echo "test";
}


$pageTitle = "Home - Web USB";

include 'page/partials/base/header.php';
 
?>
  
</body>
    <div id ="content">

    <div id='cssmenu'>
        <ul>
            <li><a href='device.php'><span><i><b>Home</b></i></span></a></li>
           <li><a href='settings.php'><span>Settings</span></a></li>
           <li><a href='aboutUs.php'><span>About Us</span></a></li>
           <li><a href='login.php?command=logOut'><span>Log Out</span></a></li>
           
        </ul>
    </div>
    
        <br> <br>    

    
    <div id ="contentBox">          
        <?php
            include 'class/DeviceView.class.php';     
        ?>     
    </div>

    
    <br><br><hr><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.php?command=logOut">Log Out</a>
    
    
</div>  
</body>
<?php
include 'page/partials/base/footer.php';
?>

