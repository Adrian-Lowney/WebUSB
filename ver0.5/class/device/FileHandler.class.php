
<?php
/**
 * @author A Lowney
 */

class FileHandler {

    public function FileHandler($directory)
    { 
        $this->exploreDevice($directory);
    }

    public function exploreDevice($directory)
    {
        //$directory = str_replace("'", "&rsquo;", $directory);
        $dir    = '/var/www/disk'.$directory;
        $files = array_diff(scandir($dir), array('..', '.'));
        $dirRel ="../disk".$directory;


        foreach($files as $key => $file)
        { 
            if(strpos($file,".Spotlight" )!==FALSE || strpos($file,".Trashes" )!==FALSE || strpos($file,"._.Temp" )!==FALSE 
                    || strpos($file,".Temp" )!==FALSE || strpos($file,"._" )!==FALSE || strpos($file,"System Volume Information" )!==FALSE)
            {
                unset($files[$key]);
            }
        }

        foreach($files as $key => $file)
        { 
            if(is_dir($dir."/".$file) == True)
            {
                unset($files[$key]); 
                array_push($files, $file);
            }
        }
        
        $upDirectory = substr($directory, 0, strrpos($directory, "/"));
        
        if($upDirectory !== "")
        {
            echo "&nbsp;&nbsp;&nbsp;".$directory;
            ?>
            <img src ='/ver0.1/page/partials/images/back.png' style = "float:left; padding-left:1%;" onclick = "<?php  echo "exploreDevice('$upDirectory')" ;  ?>"/><br>         
            <?php
        }
        else
        {
            echo "&nbsp;&nbsp;&nbsp;".$directory;
            ?>
            <img src ='/ver0.1/page/partials/images/back.png' style = "float:left; padding-left:1%;" onclick = "<?php  echo "homeReturn('$upDirectory')" ;  ?>"/>  <br>         
                <?php
        }
        ?>
            
         <br><hr>    
            
        <?php
        
        
        $files = array_reverse($files);
        
        foreach($files as $key => $file)
        {
            $currentDir = $dir."/".$file;
            $navigationTo = $directory."/".$file."";
            $navigationTo = str_replace("'", "\u0027", $navigationTo);
            $fileDownload = $dirRel."/".$file;
            if(is_dir($currentDir) == True)
            { 

                echo "<img src ='/ver0.1/page/partials/images/folder.png'/>";
                ?>

                <a href= '#'style="text-decoration:none; color: black;" onclick = "<?php  echo "exploreDevice(&quot;$navigationTo&quot;)" ;  ?>"><i> <?php  echo $file; ?></i></a><br>
                
                <?php
               

            }
            else
            {
                echo "<img src ='/ver0.1/page/partials/images/file.png'/>&nbsp;";
                ?>
                
                <a style="text-decoration:none; color:black;" href= '<?php echo $fileDownload;?>'><?php echo $file;?></a><br>
                
                <?php
            }
        }
        
        ?>
                <br><br><hr>
                <form enctype="multipart/form-data" action="class/device/upload.php" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="512000"/>
                Upload: <input name="userfile" type="file" />
                <input type="hidden" name="directory" value="<?php echo "/var/www/disk".$directory."/"; ?>"> 
                <input type="submit" value="Upload" />
            </form>

            
            <?php


        }



}
    

    
