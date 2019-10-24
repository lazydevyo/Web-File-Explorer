<?php 
$currentPath ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(!isset($_SESSION["currentdir"])){
    //current directory (default root) without session
    $_SESSION["currentdir"] = getcwd();
}else{
    //if url contains dir set directory to root + dir
    if (strpos($currentPath, '?dir=') !== false) {
        $_SESSION["currentdir"] = getcwd()."\\".$_GET['dir'];
     }else{
           //current directory (default root) with session
        $_SESSION["currentdir"] =getcwd();
     }

}
    //if its directory change the current directory
if(is_dir($_SESSION["currentdir"])){


        //read everything as array and set it.
    $currentdir_Cont = scandir($_SESSION["currentdir"]);
    // check the lengh of the array
    $dir_len  = count($currentdir_Cont);



    
}else{

    //if its not directory go to the file as well remove the \ at the end
    header("Location: ".substr($_GET['dir'], 0, -1));
    die();
}



//show dirrectory
//echo "Current folder: <b>".$_SESSION["currentdir"] ."</b>" ."\n";
//echo $currentPath;

?>


<?php


//if its directory 
if(is_dir($_SESSION["currentdir"])){

 //if empty
 if($dir_len-2==0){

//echo "Folder is empty";

 }

//echo the array with hrefs.
echo"<table><tr><th>Name</th><th>Size</th></tr>";
    for($x = 0; $x < $dir_len-2; $x++) {

      //  $filetype = "046-file-45";
      $filetypeExt = pathinfo($currentdir_Cont[$x+2]);
      if(substr(strrchr($currentdir_Cont[$x+2], "."), 1)!=null){
       
        $filetype= substr(strrchr($currentdir_Cont[$x+2], "."), 1);
      }else{
        $filetype = "folder";
        
      }
        
        
      



//if its directory set ?dir= Basicaly if its on Root

        if(is_dir($currentdir_Cont[$x+2])){
            if($filetype=="folder"){
            
            $filesize = GetDirectorySize(getcwd()."\\".$currentdir_Cont[$x+2]);
            }else{
            $filesize = filesize(getcwd()."\\".$currentdir_Cont[$x+2]);  
            }
            echo "<tr><td><a href='?dir=".$currentdir_Cont[$x+2]."\\". "'>".
            "<img id=\"filetype\" src=\"Explorer/filetype/png/".$filetype.".png\" onerror=\"this.src='Explorer/filetype/png/folder.png';\"/><text>"
            .$currentdir_Cont[$x+2]."</text></a></td>"."<td>".formatSizeUnits($filesize)."</td>"
            
            ."</tr>";
           
        }else{
            //if its not on Root just add to the directory the file folder name
            //check if its in the root and its index.php or exporer.php and hide them.
            if($_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="index.php" || $_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="exporer.php"){
              //nothing echo-ing 




            }else{
                    if($filetype=="folder"){
                        
                        $filesize = GetDirectorySize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);

                    }else{
                        $filesize = filesize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);
                    }
                
                //if its not either of them show the normaly with direct path
                echo "<tr><td><a href='".$currentPath.$currentdir_Cont[$x+2]."\\"."'>".
                "<img id=\"filetype\" src=\"Explorer/filetype/png/".$filetype.".png\" onerror=\"this.src='Explorer/filetype/png/folder.png';\"/><text>"
                .$currentdir_Cont[$x+2]."</text></a></td>"."<td>".formatSizeUnits($filesize)."</td>"
                
                ."</tr>";
              
            }
            
        }
        
       
    }
    echo"</table>";
    
}
function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}
function formatSizeUnits($bytes)
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

?>

