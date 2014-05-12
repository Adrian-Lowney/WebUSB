<?php
/**
 * @author Adrian
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
                echo "<b>Welcome ".$_COOKIE["username"]."</b><hr><br>";

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