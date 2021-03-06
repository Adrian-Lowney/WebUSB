<?php
/**
 * @author Adrian
 */

include 'LoggedInView.class.php';
include 'device/DeviceHandler.class.php';

class DeviceView extends LoggedInView
{
    protected function loadView() 
    {

        $deviceHandler = new DeviceHandler();
        
        $storageDevices = $deviceHandler->fetchDevices($_COOKIE['userID']);
        
        ?>
            <div class="myDeviceTable" > 
                <table >
                    <tr> 
                        <td id="myDevices">My Devices</td> 
                    </tr>
                    
        <?php
        
        foreach ($storageDevices as $key => $storageDevice)  
        { 
            if($storageDevice->getUserID() != 0)
            {
                if($storageDevice->getConnected() == 1)
                {
                    ?><tr><td><?php
                }   
                else
                {
                    ?><tr><td id ="myDeviceNotConn"><?php
                }
      
            ?>
            <div id = "name">
            <div id="<?php echo $storageDevice->getDeviceUUID(); ?>" style="display:inline;">
            <?php
            echo "<b>Name</b>: ".$storageDevice->getAlias()."&nbsp;&nbsp;";?></div><?php
            ?><img src="page/partials/images/edit.png" onclick="rename('<?php echo $storageDevice->getAlias(); ?>' , '<?php echo $storageDevice->getDeviceUUID(); ?>')"/><?php
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            ?></div><?php
            if($storageDevice->getConnected() == 1)
            { 
            echo "<div id = 'info'><b>Capacity</b>: ".$storageDevice->getCapacity()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br><b>Free Space</b>: ".$storageDevice->getFreeSpace()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br><b>Used Space</b>: ".$storageDevice->getUsedSpace()."</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            ?>
             
            <div id ="deviceOptions">
                <a href="#"  class="exploreButton" onclick="exploreDevice('<?php echo $storageDevice->getDeviceUUID(); ?>')">Explore</a><br> <hr color="grey">
                <a href="#"   class="unmountButton" onclick="unmountDevice('<?php echo $storageDevice->getDeviceUUID(); ?>')">Unmount</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"   class="disassociateButton" onclick="disassociateDevice('<?php echo $storageDevice->getDeviceUUID(); ?>')">Forget</a></div><?php
            
                
            }
            else
            {
                ?><div id = "info"><?php
                echo "Not connected";
                ?></div>
                
                <div id ="deviceOptions">
                <a href="#"   class="disassociateButton" onclick="disassociateDevice('<?php echo $storageDevice->getDeviceUUID(); ?>')">Forget</a></div><?php
                
            }
            
            }?> </td></tr><?php
        } 
        ?>
                            
                   
                         
                </table>
    
                </div><br><br>
                
                
                <div class="connectedDeviceTable" >
                <table >

                    <tr>      
                        <td id="connectedDevices">Available Devices</td>                 
                    </tr>
                    
                    <?php
        
        foreach ($storageDevices as $key => $storageDevice)  
        { 
            if($storageDevice->getUserID() == 0)
            { 
            ?><tr><td><div id = "name"><?php   
            
            echo "<b>Name</b>: ".$storageDevice->getAlias()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></div><?php
            
            echo "<div id = 'info'><b>Capacity</b>: ".$storageDevice->getCapacity()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br><b>Free Space</b>: ".$storageDevice->getFreeSpace()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br><b>Used Space</b>: ".$storageDevice->getUsedSpace()."</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            ?>
            <div id ="deviceOptions">       
            <a href="#"   class="associateButton"  onclick="associateDevice('<?php echo $_COOKIE['userID']; ?>','<?php echo $storageDevice->getDeviceUUID(); ?>')">Claim</a><?php
            }?></div></td></tr><?php
        } 
        ?>
                    
                </table>
                </div>
        <?php   
        
    }
     
    public function DeviceView() 
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

$deviceView = new DeviceView();

?>