<?php 
$currentPath ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(!isset($_SESSION["currentdir"])){
    //current directory (default root) without session
    $_SESSION["currentdir"] = getcwd();
}else{
    //if url contains dir set directory to(root + dir value)
    if (strpos($currentPath, '?dir=') !== false) {
		
		// currentdir shows clean directory e.g localhost\folder\ instead localhost?dir=folder\
        $_SESSION["currentdir"] = getcwd()."\\".$_GET['dir'];
     }else{
           //current directory (default root) with session e.g no ?dir= so just show localhost.
        $_SESSION["currentdir"] =getcwd();
     }

}
    //if directorydir is a directory read the directory 
if(is_dir($_SESSION["currentdir"])){


        //read everything as array and set it.
    $currentdir_Cont = scandir($_SESSION["currentdir"]);
    // check the lengh of the array
    $dir_len  = count($currentdir_Cont);



    
}else{

    //if its not a directory read it as file as well remove the \ at the end from dir value
    header("Location: ".substr($_GET['dir'], 0, -1));
   //header("Location: ".$_GET['dir']);
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
        
        
      



//if currentdir_Cont is a directoy or a file. Basicly if the path is a file or a folder

        if(is_dir($currentdir_Cont[$x+2])){
            if($filetype=="folder"){
             
            $filesize = GetDirectorySize(getcwd()."\\".$currentdir_Cont[$x+2]);
            }else{
            $filesize = filesize(getcwd()."\\".$currentdir_Cont[$x+2]);  
            }

            //check folder path if its in root and theres a folder named Explorer
            if($_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2] == "Explorer"){


            }else{

                echo "<tr><td><a href='?dir=".$currentdir_Cont[$x+2]."\\". "'>".
                "<img id=\"filetype\" src=\"Explorer/filetype/png/".$filetype.".png\" onerror=\"this.src='Explorer/filetype/png/folder.png';\"/><text>"
                .$currentdir_Cont[$x+2]."</text></a></td>"."<td>".formatSizeUnits($filesize)."</td>"
                
                ."</tr>";
            }

           
        }else{        


            //check if its in root and its a file called index.php or exporer.php and hide them.
            if($_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="index.php" || $_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="explorer.php" || $_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="\Explorer"){
              //nothing echo-ing 




            }else{
				
				//check if $filetype is folder and check the folder size with GetDirectorySize()
                    if($filetype=="folder"){
						
						//if the whole url contains ?dir=
                        if (strpos($currentPath, '?dir=') !== false) {
							//if its not on root
                        $filesize = GetDirectorySize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);
						}else{
							//if its on root
						$filesize = GetDirectorySize(getcwd()."\\".$currentdir_Cont[$x+2]);
						}

                    }else{
						//if $filetype its not folder check the file size instead
						
						
						if (strpos($currentPath, '?dir=') !== false) {
							//if its not on root
                        $filesize = filesize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);
						}else{
							//if its on root
						$filesize = filesize(getcwd()."\\".$currentdir_Cont[$x+2]);	
						}
                    }
					//
                
         
			
				// if the whole url contains a ?dir= value
				if (strpos($currentPath, '?dir=') !== false) {
				$extrdir = "";
				}else{
					//if not add it
				$extrdir = "?dir=";
				}
				
              	  echo "<tr><td><a href='".$extrdir.$currentPath.$currentdir_Cont[$x+2]."\\"."'>".
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
