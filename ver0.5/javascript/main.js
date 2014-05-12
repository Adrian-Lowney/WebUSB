function rename(currentName, deviceUUID)
{
var x;

var newName=prompt("Please enter the desired name for this device:", currentName);

if (newName!=null)
{
    newName = newName.replace(/[^a-zA-Z 0-9]+/g,'');
    x="<b>Name</b>: " + newName+"&nbsp;&nbsp;";
    document.getElementById(deviceUUID).innerHTML=x;

  
    $.ajax({     
        url: "class/device/DeviceHandler.class.php", 
        type: "POST",
        data: "newName=" + newName + "&deviceUUID=" + deviceUUID,
        dataType: "text",

            success: function()
            {
                //alert("Test: " + response);
            }
         });
 }
}

function associateDevice(userID, deviceUUID)
{

var query=alert("Are you sure you want to associate with this device?");

if (deviceUUID!=null)
{
 
    $.ajax({     
        url: "class/device/DeviceHandler.class.php", 
        type: "POST",
        data: "userID=" + userID + "&deviceUUID=" + deviceUUID,
        dataType: "text",

            success: function()
            {
                location.reload();
            }
         });
}        
}

function disassociateDevice(deviceUUID)
{

var query=alert("Are you sure you want to disassociate with this device?");

if (deviceUUID!=null)
{
 
    $.ajax({     
        url: "class/device/DeviceHandler.class.php", 
        type: "POST",
        data: "deviceUUID=" + deviceUUID,
        dataType: "text",

            success: function()
            {
                location.reload();
            }
         });
}        
}



function exploreDevice(deviceUUID){
    alert(deviceUUID);
    document.getElementById('contentBox').innerHTML = "";
    $("#contentBox").load("file.php", { 
         'deviceUUID': deviceUUID
        });
};

function unmountDevice(deviceUUID){
     
var query=alert("Are you sure you want to unmount this device?");

if (deviceUUID!=null)
    {

        $.ajax({     
            url: "class/device/unmountDevice.php", 
            type: "POST",
            data: "deviceUUID=" + deviceUUID + "&action=" + "unmount", 
            dataType: "text",

                success: function()
                {
                    alert("done "+deviceUUID);
                }
             });
    }        
}

function homeReturn(){
    window.location = "device.php" ;
}
