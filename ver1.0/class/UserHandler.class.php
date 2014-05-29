<?php

/**
 * @author @owner A Lowney, May 2014
 */
$userHandler = new UserHandler;

class UserHandler
{
    public function UserHandler()
    { 
        
    }
    
/**
 * @functions
 */
 
    public function processLogin($username, $password, $time)
    {
        $con=mysqli_connect("127.0.0.1","root","temppwd","Web_USB");
        
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
                
            $con->select_db("Web_USB");
            $username = mysqli_real_escape_string($con, $username);
            
            if ($result = mysqli_query($con, "SELECT * FROM user_accounts where username = '$username';")) 
            {
                $row = mysqli_fetch_row($result);
                $salt = $row[5];    
                $passwordHash = $row[3];  
                                
                if((hash('SHA512', $password.$salt)) == $passwordHash)
                {
                    return $row[0];
                }
                else
                {
                    return 0;
                }       
            }
        } 
        mysqli_free_result($result);
    }
    
    public function processRegistration($newUser)
    {
        $username = $newUser->getUsername(); $firstName = $newUser->getFirstName(); $lastName = $newUser->getLastName(); 
        $passwordHash=$newUser->getEncryptedPassword();
        
        $email = $newUser->getEmail(); $salt = $newUser->getSalt();
        
        $con=mysqli_connect("127.0.0.1","root","temppwd","Web_USB");

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($con,"INSERT INTO user_accounts (firstName, lastName, passwordHash, username, salt, email)
        VALUES ('$firstName', '$lastName', '$passwordHash', '$username', '$salt', '$email')");

        $result = mysqli_query($con, "SELECT userID FROM user_accounts WHERE username = '$username'");

        while($row = mysqli_fetch_array($result))
        {
            $userID = htmlspecialchars($row['userID']);
        }
        mysqli_close($con);
        
        return $userID;   
    }

    public function generateEncryptedPassword($salt, $password)
    {
        $passwordHash = hash("SHA512", $password.$salt);
        return $passwordHash;
    }
    
}

?>