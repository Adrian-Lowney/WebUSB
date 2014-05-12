<?php
/**
 * @author A Lowney
 */ 
$pageTitle = "Login";

if( isset($_GET['command']))
{
   setcookie("userID", "", time()-3600);
   setcookie("session_ID", "", time()-3600);
   setcookie("username", "", time()-3600);
}

include 'class/UserHandler.class.php';
include 'class/User.class.php';

$loginView = new LoginView();

class LoginView
{
    private $username = "";
    private $password = "";
    private $con = "";
   
 /**
 * @constructor
 */
    public function LoginView()
    {   
    $this->con=mysqli_connect("127.0.0.1","root","temppwd","Web_USB");
    
    if(isset($_POST['username']) || isset($_POST['password']) )
        {
            $this->processLoginRequest();
        }        
    }
        
 /**
 * @functions
 */
    public function processLoginRequest()
    {   
        if((((filter_input(INPUT_POST, 'username')) && (filter_input(INPUT_POST, 'password'))) != "") 
                || !isset($_POST['username']) )
        {
            $this->setUsername(filter_input(INPUT_POST, 'username'));
            $this->setPassword(filter_input(INPUT_POST, 'password'));       
            $time = date("g:i:s A D, F jS Y");

            $userHandler = new UserHandler();
            $userID = $userHandler->processLogin($this->getUsername(), $this->getPassword(), $time);
            
            if( $userID != 0 )
            {   
                $sessionID = hash('sha512', rand(10000000, 10000000000000));
               
                
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $result = mysqli_query($this->con,"UPDATE user_accounts SET session_id ='$sessionID' where userID='$userID'");

                setcookie("userID", $userID, time()+3600);
                setcookie("session_ID", $sessionID, time()+3600);  
                setcookie("username", $_POST['username'], time()+3600);  
                
                echo'<script>window.location="device.php";</script> '; 
            }
            elseif( $userID == 0 )
            {
                $this->redirectToErrorView("Incorrect username or password, please try again.");
            }
        }
        else
        {
            $this->redirectToErrorView("Enter missing information!");
        }
    }
    
    public function redirectToErrorView($message)
    {
        echo '<script type="text/javascript">alert("' . $message . '"); </script>';
    }
    
    public function redirectToDeviceView($userID)
    {
        
    }
    
 /**
 * @accessors
 */   
    public function getUsername()
    {
    	return $this->username;
    }
   
    public function getPassword()
    {
    	return $this->password;
    }
    
 
/**
 * @setters
 */
    public function setUsername($username)
    {
    	$this->username = mysqli_real_escape_string($this->con,$username);
    }
  
    public function setPassword($password)
    {
    	$this->password = mysqli_real_escape_string($this->con,$password);
    }
  
}
?>