

function rename(currentName, deviceUUID)
{
var x;

var newName=prompt("Please enter the desired name for this device:", currentName);

if (newName!=null)
{
    newName = newName.replace(/[^a-zA-Z 0-9]+/g,'');
    x="<b>Name</b>: " + newName+"&nbsp;&nbsp;";
    
    
    document.getElementById('name'+deviceUUID).innerHTML=x;
    
    
    
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

function reloadPage()
{
    location.reload('device.php');
}

function associateDevice(userID, deviceUUID)
{
    if (deviceUUID!=="")
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
    var r=confirm("Disassociate with this device?\n");

    if (r==true) 
    {
        if (deviceUUID!=="")
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
}

function exploreDevice(deviceUUID){
    
    
    document.getElementById('contentBox').innerHTML = "";
    $("#contentBox").load("file.php", { 
         'deviceUUID': deviceUUID
        });
};

function loader(){ 
   $("#loader").css('visibility', 'visible');
   $(window).scrollTop(0);
 
};

function unmountDevice(deviceUUID){
     
var r=confirm("Unmount device?\n");

if (r==true) 
{
    if (deviceUUID!=="")
        {

            $.ajax({     
                url: "class/device/utility/unmountDevice.php", 
                type: "POST",
                data: "deviceUUID=" + deviceUUID + "&action=" + "unmount", 
                dataType: "text",

                    success: function()
                    {
                        $('#'+deviceUUID).remove();
                        alert("          --ALERT--\n\n    Please remove your device now!\n\n");
                    }
                 });
        }        
    }
}

function homeReturn(){
    window.location = "device.php" ;
}

function videoPlayFunction(content, format){
    //alert(content);
    document.getElementById('videoPlayZone').innerHTML = "";
    document.getElementById('audioPlayZone').innerHTML = "";
    
    $("#videoPlayZone").css("visibility","visible");
    $("#audioPlayZone").css("visibility","hidden");
    
    $("#videoPlayZone").load("class/device/utility/media.php", { 
         'content': content,
         'format': format
        });
     
};

function audioPlayFunction(content, format){
    //alert(content);
    document.getElementById('audioPlayZone').innerHTML = "";
    document.getElementById('videoPlayZone').innerHTML = "";
    
    $("#audioPlayZone").css("visibility","visible");
    $("#videoPlayZone").css("visibility","hidden");
    
    $("#audioPlayZone").load("class/device/utility/media.php", { 
         'content': content,
         'format': format
        });
     
};

function closeMedia(){
    document.getElementById('audioPlayZone').innerHTML = "";
    document.getElementById('videoPlayZone').innerHTML = "";
    
    $("#audioPlayZone").css("visibility","hidden");
    $("#videoPlayZone").css("visibility","hidden");
   
}


function deleteFile(file, directory){
     alert(file);
var r=confirm("Delete file?\n");
if (r==true) 
    {
        
        $.ajax({     
            url: "class/device/utility/fileActions.php", 
            type: "POST",
            data: "file=" + file + "&action=" + "deleteFile", 
            dataType: "text",

                success: function()
                {
                    exploreDevice(directory);
                }
             });
    }
    else
    {
      
    }

}

function renameFile(file, format, directory)
{
    var newName=prompt("Enter the file's new name:");

    if (newName!=="")
    {
        newName = newName.replace(/[^a-zA-Z 0-9]+/g,'');   
        
        if (file!==null)
        {
                $.ajax({     
                    url: "class/device/utility/fileActions.php", 
                    type: "POST",
                    data: "file=" + file + "&action=" + "renameFile" + "&newName=" + newName + "&format=" + format , 
                    dataType: "text",

                        success: function()
                        {
                            exploreDevice(directory);
                        }
                     });
          } 
    }
    else
    {
        alert("No new filename entered, cancelling action.");
    }

           
}
 