<?php
/**
 * @author @owner A Lowney, May 2014
 */

class FileHandler {

    public function FileHandler($directory)
    { 
        $this->exploreDevice($directory);
    }
    
    
    public function formatSizeUnits($bytes)//quick method for converting filesizes to something more human readable
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    
    

    public function exploreDevice($directory)//method creates a file/directory array object for a given a directory
    {
       
        $directory = stripslashes($directory);
              
        $dir = '/var/www/disk'.$directory;
        
        $files = array_diff(scandir($dir), array('..', '.'));
        $dirRel ="../disk".$directory;


        foreach($files as $key => $file)//getting rid of hidden or system folders or directories
        { 
            if(strpos($file,".Spotlight" )!==FALSE || strpos($file,".Trashes" )!==FALSE || strpos($file,"._.Temp" )!==FALSE 
                    || strpos($file,".Temp" )!==FALSE || strpos($file,"._" )!==FALSE || strpos($file,"System Volume Information" )!==FALSE)
            {
                unset($files[$key]);
            }
        }

        foreach($files as $key => $file) //just moving folders to the top of the array, for presentation
        { 
            if(is_dir($dir."/".$file) == True)
            {
                unset($files[$key]); 
                array_push($files, $file);
            }
        }
        
        $upDirectory = str_replace("'", "\'", substr($directory, 0, strrpos($directory, "/")));
        
        if($upDirectory !== "") //up a directory arrow on the file explorer 
        {
            echo "&nbsp;&nbsp;&nbsp;".$directory;
            ?>
            <img class="upDirectory" src ='/ver1.0/page/partials/images/back.png' title="Up Directory Tree" alt="Up Directory Tree" onclick = "<?php  echo "exploreDevice('$upDirectory')" ;  ?>"/>
            <br>
            <?php
        }
        else
        {
            echo "&nbsp;&nbsp;&nbsp;".$directory;
            ?>
            <img class="upDirectory" src ='/ver1.0/page/partials/images/back.png' title="Up Directory Tree" alt="Up Directory Tree" onclick = "<?php  echo "homeReturn('$upDirectory')" ;  ?>"/>
            <br>
                     
                <?php
        }
        ?>
            
         <br><hr >    
          
        <?php
        
        
        $files = array_reverse($files);
        ?>
        <div class = "nameColumn"><u>Name</u>
        <div class ="sizeColumn" ><u>Size</u></div>
        <div class ="dateColumn" ><u>Date &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; Time</u></div> 
        <div class ="typeColumn" ><u>Type</u></div> 
        </div><hr>
          
        <?php 
        foreach($files as $key => $file)
        {
            
            $currentDir = $dir."/".$file;            
            $navigationTo = $directory."/".$file."";
            $navigationTo = str_replace("'", "&#39;", $navigationTo); 
            $fileDownload = $dirRel."/".$file;
            
            if(is_dir($currentDir) == True)
            { 
                
                ?><div class = "nameColumn"><?php
                echo "<img src ='/ver1.0/page/partials/images/folder.png' />";
                
                ?>
                  
            <a href= '#'style="text-decoration:none; color: black;" title="Open folder" onclick = "<?php  echo "exploreDevice(&quot;$navigationTo&quot;)" ;  ?>"><i> <?php if(strlen($file) < 15){echo $file;}else{echo substr($file,0,10)."...";} ?></i></a>  
                </div>
                    <?php
                
            }
            else
            {
                ?><div class = "nameColumn"><?php
                
                
                $fileFormat = substr( $file, strrpos( $file, '.' )+1 );
                
                $audioFormats = array("mp3", "wma", "wav", "mid", "ogg", "m4a");
                $videoFormats = array("m4v", "mp4", "avi", "3gp", "flv", "mov", "mkv", "swf", "vob", "wmv");
                
                if(in_array($fileFormat, $audioFormats))
                {
                    ?>
                                   
                        <button class="play-button" title="Play music" 
                             onclick="audioPlayFunction(<?php echo "&quot;".$fileDownload."&quot;";?>, <?php echo "&quot;".$fileFormat."&quot;";?>)" > </button>
                    
                    <?php
                }
                else if(in_array($fileFormat, $videoFormats))
                {
                    ?>
              
                        <button class="play-button"  title="Play video" 
                            onclick="videoPlayFunction(<?php echo "&quot;".$fileDownload."&quot;";?>, <?php echo "&quot;".$fileFormat."&quot;";?>)" > </button>
     
                    <?php
                }
                else 
                {
                    echo "<img style='margin-bottom:1px;' src ='/ver1.0/page/partials/images/file.png'/>&nbsp;";
                }
                $currentDirectory = substr($dir, 13); 
                ?>
                        
                <a style="text-decoration:none; color:black;" title="Download" target="_blank" href= "<?php echo $fileDownload;?>"><?php if(strlen($file) < 55){echo $file;}else{echo substr($file,0,55)."...";} ?></a>
                  
                
                
                
                <div class ="sizeColumn" >  
                    <?php
                    echo $this->formatSizeUnits(filesize($fileDownload)); 
                    ?>
                </div> 
                
                <div class ="dateColumn" >  
                    <?php
                    echo date ("d.m.y H:i:s", filemtime($fileDownload));
                    ?>
                </div>
                
                <div class ="typeColumn" >  
                    <?php
                    echo strtoupper($fileFormat);
                    ?>
                </div>
                <img class="deleteFile" title="Delete file" src="page/partials/images/deleteFile.png" onclick ="deleteFile(<?php echo "&quot;".$fileDownload."&quot;";?>, <?php echo "&quot;".$currentDirectory."&quot;";?> )"/>
                
                <img class="renameFile" title="Rename file" src="page/partials/images/edit.png" onclick ="renameFile(<?php echo "&quot;".$fileDownload."&quot;";?>, <?php echo "&quot;".$fileFormat."&quot;";?>, <?php echo "&quot;".$currentDirectory."&quot;";?> )"/>
           </div>
                             
                <?php
                
                
            }
        }
        
        ?>
                <br><br><hr >
                <form enctype="multipart/form-data" action="class/device/utility/upload.php" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="51200000000000000000000000000000000"/> 
                <input name="userfile" type="file" />
                <input type="hidden" name="directory" value="<?php echo "/var/www/disk".$directory."/"; ?>"/>
              
                <input type="submit" value="Upload" onclick="loader()" />
            </form>
                
                

            
            <?php


        }

        

}
    

    
