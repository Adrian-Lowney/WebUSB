<?php 
/**
 * @author Adrian
 */

if ( isset( $_GET['directory'] ) && !empty( $_GET['directory'] ))
{
    $directory = $_GET['directory'];
    
    ?>
    <body onload="exploreDevice('<?php echo $directory;?>')"/></body>
    <?php
}


    $pageTitle = "Home - Web USB";

    include 'page/partials/base/header.php';

    ?>

    </body>
        <div id ="content">

        <div id='cssmenu'>
            <ul>
                <li><a href='device.php'><span><i><b>Home</b></i></span></a></li>
               <li><a href='aboutUs.php'><span>About Us</span></a></li>
               <li ><a href='login.php?command=logOut'><span>Log Out</span></a></li>
               
                <div id ="loader" style="visibility: hidden; float:right; padding: 13px 20px;display: inline;text-decoration: none; color:white;" >
                    Uploading
                   <img src='page/partials/images/loader.gif'>   
                </div>
               
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

