<?php

/**
 * @author A Lowney
 * @copyright 2013
 */

class StorageDevice
{
    private $deviceName;
    private $userID;
    private $alias;
    private $capacity;
    private $freeSpace;
    private $connected;
    private $mountPath;
    private $fileArray;
   
/**
 * @accessors
 */
 
    public function getDeviceName()
    {
        return $deviceName;
    }
    
    public function getUserID()
    {
        return $userID;
    }
    
    public function getAlias()
    {
        return $alias;
    }
    
    public function getCapacity()
    {
        return $capacity;
    }
    
    public function getFreeSpace()
    {
        return $freeSpace;
    }
    
    public function getConnected()
    {
        return $connected;
    }
    
    public function getMountPath()
    {
        return $mountPath;
    }
    
    public function getFileArray()
    {
        return $fileArray;    
    }
  
/**
 * @setters
 */ 
    
}


?>