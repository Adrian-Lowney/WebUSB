<?php

/**
 * @author @owner A Lowney, May 2014
 */

$storageDevice = new StorageDevice();

class StorageDevice
{
    private $deviceName = "";
    private $userID = "";
    private $deviceUUID = "";
    private $alias = "";
    private $capacity = "";
    private $freeSpace = "";
    private $usedSpace = "";
    private $connected = "";
    private $format = "";
    private $mountPath = "";
    private $fileArray = "";
      
/**
 * @accessors
 */
 
    public function getDeviceName()
    {
        return $this->deviceName;
    }
    
    public function getDeviceUUID()
    {
        return $this->deviceUUID;
    }
    
    public function getUserID()
    {
        return $this->userID;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    public function getCapacity()
    {
        return $this->capacity;
    }
    
    public function getFreeSpace()
    {
        return $this->freeSpace;
    }
       
    public function getUsedSpace()
    {
        return $this->usedSpace;
    }
    
    public function getFormat()
    {
        return $this->format;
    }        
    
     
    public function getConnected()
    {
        return $this->connected;
    }
    
    public function getMountPath()
    {
        return $this->mountPath;
    }
    
    public function getFileArray()
    {
        return $this->fileArray;    
    }
  
/**
 * @setters
 */ 
      
    public function setDeviceName($deviceName)
    {
        $this->deviceName = $deviceName;
    }
    
    public function setDeviceUUID($deviceUUID)
    {
        $this->deviceUUID = $deviceUUID;
    }
    
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
    
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    
    public function setCapacity($capacity)
    {
         $this->capacity = $capacity;
    }
    
    public function setUsedSpace($usedSpace)
    {
         $this->usedSpace = $usedSpace;
    }
    
    public function setFreeSpace($freeSpace)
    {
        $this->freeSpace = $freeSpace;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }    
    
    public function setConnected($connected)
    {
         $this->connected = $connected;
    }
    
    public function setMountPath($mountPath)
    {
         $this->mountPath = $mountPath;
    }
    
    public function setFileArray($fileArray)
    {
        $this->fileArray = $fileArray;    
    }
}


?>