<?php
$pageTitle = "Web USB";

include 'class/User.class.php';

abstract class LoggedInView
{  
    abstract protected function loadView();
       
    public function handleAuthentication($userID, $sessionID)
    {
        $con=mysqli_connect("127.0.0.1","root","temppwd","Web_USB");
        
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $con->select_db("Web_USB");
            if ($result = mysqli_query($con, "SELECT * FROM user_accounts where userID = '$userID';")) 
            {
                $row = mysqli_fetch_row($result);     
                
                if ($row[7] == $sessionID && $row[7] != "0")
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
                
            }
        }
        
    }
    
 
   
    public function redirectToLoginView($message)
    {
        
    }
    
    public function redirectToErrorView($message)
    {
        echo '<script type="text/javascript">alert("' . $message . '"); </script>';
    }
}

?>