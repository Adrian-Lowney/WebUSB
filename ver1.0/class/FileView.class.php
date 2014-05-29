<?php
/**
 * @author @owner A Lowney, May 2014
 */

include 'LoggedInView.class.php';

class FileView extends LoggedInView
{
    protected function loadView() 
    {
        include 'device/FileHandler.class.php';
        
        $fileHandler = new FileHandler($_POST["deviceUUID"]);
    }
     
    public function FileView() 
    {     
        if(isset($_COOKIE["userID"]) && isset($_COOKIE["session_ID"]) && isset($_COOKIE["username"]))
        {
            
            $authStatus = self::handleAuthentication($_COOKIE['userID'], $_COOKIE['session_ID']);

            if($authStatus == 1)
            {
                echo "<b>Welcome ".$_COOKIE["username"]."</b>&nbsp;&nbsp;<img src='page/partials/images/userIcon.png'/><hr><br>";

            }
            else
            {
                self::redirectToErrorView("Please login...");
                echo'<script>window.location="login.php";</script> ';
            }
        }
        else if(!isset($_COOKIE["userID"]) && !isset($_COOKIE["session_ID"]) && !isset($_COOKIE["username"]))
        {
            self::redirectToErrorView("Please login...");
            echo'<script>window.location="login.php";</script> ';
        }
        
        self::loadView(); 
    }
    
}

$fileView = new FileView();


?>