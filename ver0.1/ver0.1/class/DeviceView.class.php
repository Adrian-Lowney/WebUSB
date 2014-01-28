<?php
/**
 * @author Adrian
 */

  
session_start();

include 'LoggedInView.class.php';

class DeviceView extends LoggedInView
{
    protected function loadView() 
    {
        
    }
     
    public function DeviceView() 
    {
        self::loadView();
        
        if(isset($_SESSION['userID']) && isset($_SESSION['session_ID']))
        {
            $authStatus = self::handleAuthentication($_SESSION['userID'], $_SESSION['session_ID']);

            if($authStatus == 1)
            {
                //Display Username etc..
            }
            else
            {
                self::redirectToErrorView("Please login...");
                echo'<script>window.location="login.php";</script> ';
            }
        }
        else
        {
            self::redirectToErrorView("Please login...");
            echo'<script>window.location="login.php";</script> ';
        }
        
        
    }
    
}

$deviceView = new DeviceView();

?>