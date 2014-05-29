<!DOCTYPE html>
<div id ="page">
<html>
   
    <head>
        <link rel="stylesheet" type="text/css" href='page/partials/style/main.css'>
        <link rel="shortcut icon" href="page/partials/base/favicon.ico">
        <script type="text/javascript" src='javascript/jquery.js'></script>
        <script type="text/javascript" src='javascript/main.js'></script>
          
        <title><?echo $pageTitle;?></title>
    </head>
      
    <script>
        $("#myform :input").tooltip({
        position: "center right",
        offset: [-2, 10]
        effect: "fade",
        });
        
    </script>  
    <body>
            
            
                <div id="header">
                    
                    <h1>&nbsp;&nbsp;&nbsp;<i><b>Web USB</i></b> &nbsp;<img src="page/partials/images/usb.png"></h1>
                   
                    <div id = "videoPlayZone">
                    </div>
                    <div id ="audioPlayZone">
                    </div>
                    
                </div>
                