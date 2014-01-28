<?php
/**
 * @author A Lowney
 */ 
$pageTitle = "Register";

include 'class/UserHandler.class.php';
include 'class/User.class.php';

$registerView = new RegisterView(); 

class RegisterView
{
    private $username = "";
    private $firstName = "";
    private $lastName = "";
    private $email = "";
    private $password = "";
    private $confirmPassword = "";
    private $passwordHash = "";
    private $salt = "";
   
 /**
 * @constructor
 */
    public function RegisterView()
    {
        if($_POST != "")
        {
            $this->processRegistrationRequest();
        }          
    }
        
 /**
 * @functions
 */
 
    public function processRegistrationRequest()
    {
        $username = filter_input(INPUT_POST, 'username'); 
        $link=new mysqli("127.0.0.1","root","temppwd","Web_USB");    
        if (mysqli_connect_errno($link))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $link->select_db("Web_USB");
            if ($result = mysqli_query($link, "SELECT username FROM user_accounts where username = '$username';")) 
            {
                $row = mysqli_fetch_row($result);
                
                if(sizeof($row) > 0)
                {
                    $message = "Username already in use!";
                    $this->redirectToErrorView($message);
                }
                elseif((filter_input(INPUT_POST, 'lastName') && filter_input(INPUT_POST, 'firstName') && filter_input(INPUT_POST, 'username') && filter_input(INPUT_POST, 'email') && filter_input(INPUT_POST, 'password') && filter_input(INPUT_POST, 'confirmPassword')) != "")
                {
                    $this->setLastName(filter_input(INPUT_POST, 'lastName'));$this->setFirstName(filter_input(INPUT_POST, 'firstName'));$this->setUsername(filter_input(INPUT_POST, 'username'));
                    $this->setEmail(filter_input(INPUT_POST, 'email'));$this->setPassword(filter_input(INPUT_POST, 'password'));$this->setConfirmPassword(filter_input(INPUT_POST, 'confirmPassword'));
                    
                    if($this->getPassword() != $this->getConfirmPassword())
                    {
                        $this->redirectToErrorView("Passwords do not match!");
                    }
                    else
                    {
                        $userHandler = new UserHandler();
                        
                        $this->setSalt(rand(10000000, 10000000000000));
                        $this->setEncryptedPassword($userHandler->generateEncryptedPassword($this->getSalt(), $this->getPassword()));  
                        
                        $newUser = new User();
                        
                        $newUser->setFirstName($this->getFirstName());$newUser->setLastName($this->getLastName());$newUser->setEmail($this->getEmail());$newUser->setUsername($this->getUsername());
                        $newUser->setEncryptedPassword($this->getEncryptedPassword());$newUser->setSalt($this->getSalt());
                      
                        $userHandler->processRegistration($newUser); 
                        
                        $userID = 0;
                        $this->redirectToDeviceView($userID);
                    }
                }
                elseif(isset($_POST['username']))
                {
                        $this->redirectToErrorView("Enter missing information!");
                }  
            }
        }      
    }
    
    public function redirectToErrorView($message)
    {
        echo '<script type="text/javascript">alert("' . $message . '"); </script>';
    }
    
    public function redirectToDeviceView($userID)
    {       
        header( 'Location: /ver0.1/login.php' ); 
    }
    
 /**
 * @accessors
 */   
    public function getUsername()
    {
    	return $this->username;
    }

    public function getFirstName()
    {
    	return $this->firstName;
    }
    
    public function getLastName()
    {
    	return $this->lastName;
    }
   
    public function getEmail()
    {
    	return $this->email;
    }
    
    public function getPassword()
    {
    	return $this->password;
    }
    
    public function getConfirmPassword()
    {
    	return $this->confirmPassword;
    }
    
    public function getEncryptedPassword()
    {
    	return $this->passwordHash;
    }
    
    public function getSalt()
    {
    	return $this->salt;
    }

/**
 * @setters
 */
    public function setUsername($username)
    {
    	$this->username = mysql_real_escape_string($username);
    }
 
    public function setFirstName($firstName)
    {
    	$this->firstName = mysql_real_escape_string($firstName);
    }
    
    public function setLastName($lastName)
    {
    	$this->lastName = mysql_real_escape_string($lastName);
    }
    
    public function setEmail($email)
    {
    	$this->email = mysql_real_escape_string($email);
    }
    
    public function setPassword($password)
    {
    	$this->password = mysql_real_escape_string($password);
    }
    
    public function setConfirmPassword($confirmPassword)
    {
    	$this->confirmPassword = mysql_real_escape_string($confirmPassword);
    }
    
    public function setSalt($salt)
    {
    	$this->salt = $salt;
    }
        
    public function setEncryptedPassword($passwordHash)
    {
        $this->passwordHash = mysql_real_escape_string($passwordHash);	
    }

}
?>