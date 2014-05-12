<?php

/**
 * @author A Lowney
 */
$user = new User();

class User
{

    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $encryptedPassword;
    private $salt;
    private $userID;
 
 
 /**
 * @accessors
 */   
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
    
    public function getUsername()
    {
    	return $this->username;
    }
    
    public function getEncryptedPassword()
    {
    	return $this->encryptedPassword;
    }
    
    public function getSalt()
    {
    	return $this->salt;
    }
    
    public function getUserID()
    {
    	return $this->userID;
    }

/**
 * @setters
 */
    public function setFirstName($firstName)
    {
    	$this->firstName = $firstName;
    }
    
    public function setLastName($lastName)
    {
    	$this->lastName = $lastName;
    }
    
    public function setEmail($email)
    {
    	$this->email = $email;
    }
    
    public function setUsername($username)
    {
    	$this->username = $username;
    }
    
    public function setEncryptedPassword($encryptedPassword)
    {
        $this->encryptedPassword = $encryptedPassword;	
    }
    
    public function setSalt($salt)
    {
    	$this->salt = $salt;
    }
    
    public function setUserID($userID)
    {
    	$this->userID = $userID;
    }
}
?>