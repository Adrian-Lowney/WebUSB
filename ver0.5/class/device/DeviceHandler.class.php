<?php
/**
 * @author A Lowney
 */
include 'StorageDevice.class.php';

function changeDeviceName($newName, $deviceUUID)
{
    $con=new mysqli("127.0.0.1","root","temppwd","Web_USB");
    mysqli_query($con, "update devices set alias = '".$newName."' where deviceUUID = '".$deviceUUID."'");
}

function disassociateDevice($deviceUUID)
{
    $con=new mysqli("127.0.0.1","root","temppwd","Web_USB");
    mysqli_query($con, "update devices set userID = 0 where deviceUUID = '".$deviceUUID."'");
    
}

function associateDevice($userID, $deviceUUID)
{
    $con=new mysqli("127.0.0.1","root","temppwd","Web_USB");
    mysqli_query($con, "update devices set userID = ".$userID." where deviceUUID = '".$deviceUUID."'");
   
}

if(isset($_POST["newName"]) && isset($_POST["deviceUUID"])&& (isset($_POST["userID"]) == FALSE ))
{
    changeDeviceName($_POST["newName"], $_POST["deviceUUID"]);
}
else if(isset($_POST["deviceUUID"]) && (isset($_POST["newName"]) == FALSE )&& (isset($_POST["userID"]) == FALSE ))
{
    disassociateDevice($_POST["deviceUUID"]);
}
else if(isset($_POST["userID"]) && isset($_POST["deviceUUID"]) && (isset($_POST["newName"]) == FALSE))
{
    associateDevice($_POST["userID"], $_POST["deviceUUID"]);
}
else if(isset($_POST["deviceUUID"]) && isset($_POST["action"]) && (isset($_POST["newName"]) == FALSE )&& (isset($_POST["userID"]) == FALSE ))
{
    unmountDevice($_POST["deviceUUID"]);
}
else
{

    class DeviceHandler {

        private $con = "";

        public function DeviceHandler()
        { 
            $this->con=new mysqli("127.0.0.1","root","temppwd","Web_USB");
            
        }
        
        public function fetchDevices($userID)
        {
            $storageDevices = array();
            $storageDevice = new StorageDevice();

            $currentDevices = explode("/dev", shell_exec('sudo scripts/./listDisks.sh blkid')); 
            $usbStatus = explode("Bus", shell_exec('sudo scripts/./listDisks.sh listUSBs')); 

            foreach($usbStatus as $key => $value)
            {     
                $usbStatus[$key] = substr($value, 29);
                if (strpos($value, "Linux") !== false || strpos($value, "HUB") !== false || strpos($value, "Virtual") !== false || $value == "") 
                {
                    unset($usbStatus[$key]);
                }              
            }

            foreach($currentDevices as $key => $value)
            {   
                /////Filter out any non USB devices by LENGTH UUID/////
                $arr = explode('UUID=', $value);
                $getUUIDEnd = stripos($arr[1], ' TYPE');                
                $UUID = substr($arr[1], 0, $getUUIDEnd);           
                /////////////////////////////////////////////////////////
                $currentDevices[$key] = "/dev".$value;

                if (strpos($value, "swap") !== false || strpos($value, "HUB") !== false || $value == "" || strpos($value, "rootfs") !== false || strpos($value, "mmcblk") !== false) 
                {
                    unset($currentDevices[$key]);
                } 
                else if(strlen($UUID) > 11)
                {
                    ////Unset non USB devices//////
                    unset($currentDevices[$key]);
                    ///////////////////////////////          
                }
            }


            $usbStatus = array_values($usbStatus);
            $currentDevices = array_values($currentDevices);
            $allUUIDs = array();

            foreach ($currentDevices as $key => $value)  
            {       

                    //Get path
                    $devicePathEnd = stripos($value, ':');                
                    $devicePath = substr($value, 0, $devicePathEnd);   

                    //Get UUID
                    $startUUID = strpos($value, 'UUID="')+6;           
                    $deviceUUID = substr ($value , $startUUID, 9 ); 

                    //Get Format
                    $startFormat = strpos($value, ' TYPE="')+7;
                    $deviceFormat = str_replace('"', "", substr ($value , $startFormat, 4 ));


                    //Set mount path
                    $mountPath = "/var/www/disk".$deviceUUID;
                    $connected = 1;

                    ////Create storage device object 
                    $storageDevice = new StorageDevice();
                    ///////////////////////

                    //Search for devices UUID in DB
                    $wasConnected = mysqli_query($this->con, "SELECT deviceUUID FROM devices where deviceUUID = '".$deviceUUID."'");

                    $row = mysqli_fetch_array($wasConnected);
                   
                    if($row[0] == "")//never attached USB device prior to now
                    {                   
                        mysqli_query($this->con,"INSERT INTO devices (deviceUUID, userID, alias, mountPath, connected)
                        VALUES ('$deviceUUID', 0, 'New Device', '$mountPath', '$connected')");

                        $storageDevice->setUserID(0);// Device is not associated yet as it is new..
                        $storageDevice->setAlias("New Device");//Device is new so it won't have an alias yet..

                        $this->fstabAppend($deviceUUID, $deviceFormat);
                        $this->mountDevice($deviceUUID, $deviceFormat);
                    }
                    else if($row[0] == $deviceUUID)//USB has been attached previously
                    {
                       $this->mountDevice($deviceUUID, $deviceFormat);

                       $result = mysqli_query($this->con, "SELECT * FROM devices where deviceUUID = '".$deviceUUID."'");
                       $row = mysqli_fetch_array($result);
                      
                       $storageDevice->setUserID($row[1]);// Device is not new to the system so we get its userID from the DB as it might be associated with a user .. 
                       $storageDevice->setAlias($row[2]);

                       mysqli_query($this->con, "update devices set connected = 1 where deviceUUID = '".$deviceUUID."'");
                    }
                    ///////////////////////////////////////////

                    /////////////////Get Device Info/////////////
                    $deviceInfo = explode(" ", shell_exec('sudo scripts/./listDisks.sh info '.$devicePath));

                    $deviceCapacity = $deviceInfo[8];
                    $deviceUsedSpace = $deviceInfo[9];
                    $deviceFreeSpace = $deviceInfo[10];

                    //////////////////////////////////////////
                    //Finish new storageDevice object attributes
                    ////////////////////

                    $storageDevice->setDeviceUUID($deviceUUID);
                    $storageDevice->setCapacity($deviceCapacity);
                    $storageDevice->setFreeSpace($deviceFreeSpace);
                    $storageDevice->setUsedSpace($deviceUsedSpace);
                    $storageDevice->setFormat($deviceFormat);
                    $storageDevice->setConnected($connected);
                    $storageDevice->setMountPath($mountPath);

                    if($storageDevice->getUserID() == $userID || $storageDevice->getUserID() == 0)
                    {
                        array_push($storageDevices, $storageDevice);          
                    }

                    //add UUID to allUUID array so we can later set connected column of non attached devices to 0!
                    array_push($allUUIDs, $deviceUUID); 


            }

            /////////////////////////////////////////////////////////
            //this section gets the set difference of connected and historically connected devices so the connected field can be toggled when an historically connected device is not currently connected!
            /////////////////////////////////////////////////////////
            $allDBDevices = array();

            $result = mysqli_query($this->con, "SELECT deviceUUID FROM devices");

            while($row = mysqli_fetch_array($result))
            {
                array_push($allDBDevices, $row[0]);
            }

            $unconnectedDevices = array_diff($allDBDevices, array_filter($allUUIDs));

            foreach($unconnectedDevices as $key => $value)
            {           
                mysqli_query($this->con, "update devices set connected = 0 where deviceUUID = '".$value."'");  
            } 

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Get the Database entries for the devies this user has associated with previously but are not attached
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $result = mysqli_query($this->con, "SELECT * FROM devices where userID = ".$userID." and connected = 0");

            while($row = mysqli_fetch_array($result))
            {
                $storageDevice = new StorageDevice();
                $storageDevice->setDeviceUUID($row[0]);
                $storageDevice->setUserID($row[1]);
                $storageDevice->setAlias($row[2]);
                $storageDevice->setMountPath($row[3]);
                $storageDevice->setConnected($row[4]);

                array_push($storageDevices, $storageDevice);
            }


            return $storageDevices;
            } 

        public function fstabAppend($deviceUUID, $deviceFormat)        
        {
            $fstabCommand = "sudo scripts/./listDisks.sh fstabAppend ".$deviceUUID." ".$deviceFormat;
            $fstabExec = shell_exec($fstabCommand);     
        } 

        public function mountDevice($deviceUUID)        
        {
            $chownDirectory = "sudo scripts/./listDisks.sh chownDevice "."/var/www/disk".$deviceUUID;
            $chownExec = shell_exec($mountCommand);  
             
            $mountCommand = "sudo scripts/./listDisks.sh mount ".$deviceUUID;
            $mountExec = shell_exec($mountCommand);     
        }    


        public function fillDevice($mountPath)
        {

        }    
    }
    

    
}