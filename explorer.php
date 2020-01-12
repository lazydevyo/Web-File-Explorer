<?php 

$currentPath ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$sort = 2; //sort by name

if (strpos($currentPath, '?dir=') !== false) {
$root = false;
 } else{
$root = true;
}


if(!isset($_SESSION["show_thumbnails"])){
    
    $_SESSION["show_thumbnails"] = false;
}

if(isset($_POST['swap'])){
    $_SESSION["show_thumbnails"] = !$_SESSION["show_thumbnails"];
   
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['mdr'])){
 if($root){
    CreateFolder($_POST['filenamevalue'],"");
 }else{
    CreateFolder($_POST['filenamevalue'],$_GET['dir']."/");
 }


}
if(isset($_POST['upfile'])){
    if($root){
    UploadFile("");
    }else{
    UploadFile($_GET['dir']."/");
    }
}
if($_SESSION["show_thumbnails"]==true){
    $titleLenght = 3;
    $htmltype_tr = "div";
    $htmltype_td = "span";
    $classname = "grid-item";
}else{
    $titleLenght = 20;
    $htmltype_tr = "tr";
    $htmltype_td = "td";
    $classname = "list-item";
}

if(!isset($_SESSION["currentdir"])){
    //current directory (default root) without session
    $_SESSION["currentdir"] = getcwd();
}else{
    //if url contains dir set directory to(root + dir value)
    if ($root== false) {
		
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
    $currentdir_Cont = scandir($_SESSION["currentdir"],$sort);
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
if($_SESSION["show_thumbnails"]==false){
echo"<table><tr><th>Name</th><th>Size</th></tr>";
}else{
echo"<div class='grid-container'>";

}
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

                echo "<".$htmltype_tr." class='".$classname."'><".$htmltype_td."><a href='?dir=".$currentdir_Cont[$x+2]."\\". "'>".
                "<img class=\"filetype\" src=\"Explorer/filetype/svg/".$filetype.".svg\" onerror=\"this.src='Explorer/filetype/svg/blank.svg';\"/><text>"
                .limit_text($currentdir_Cont[$x+2],$titleLenght)."</text></a></".$htmltype_td.">"."<".$htmltype_td." class='filesize'>".formatSizeUnits($filesize)."</".$htmltype_td.">"
                
                ."</".$htmltype_tr.">";
            }

           
        }else{        


            //check if its in root and its a file called index.php or exporer.php and hide them.
            if($_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="index.php" ||
               $_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="explorer.php" ||
               $_SESSION["currentdir"] ==  getcwd() && $currentdir_Cont[$x+2]=="\Explorer"){
              //nothing echo-ing 




            }else{
				
				//check if $filetype is folder and check the folder size with GetDirectorySize()
                    if($filetype=="folder"){
						
						//if the whole url contains ?dir=
                        if ($root== false) {
                            
							//if its not on root
                        $filesize = GetDirectorySize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);
						}else{
							//if its on root
						$filesize = GetDirectorySize(getcwd()."\\".$currentdir_Cont[$x+2]);
						}

                    }else{
						//if $filetype its not folder check the file size instead
						
						
						if ($root== false) {
							//if its not on root
                        $filesize = filesize(getcwd()."\\".substr($_GET['dir'], 0, -1)."\\".$currentdir_Cont[$x+2]);
						}else{
							//if its on root
						$filesize = filesize(getcwd()."\\".$currentdir_Cont[$x+2]);	
						}
                    }
					//
                
         
			
				// if the whole url contains a ?dir= value
				if ($root== false) {
				$extrdir = "";
				}else{
					//if not add it
				$extrdir = "?dir=";
				}
                //if file type is one of these replace the icon with the actual image from the file
                if($filetype=="jpg" || $filetype=="png" || $filetype=="gif" || $filetype=="bmp" || $filetype=="JPG" || $filetype=="PNG" || $filetype=="GIF" || $filetype=="BMP"){

                    if($_SESSION["show_thumbnails"]==true){
                        if($root== true){
                            $filetype =dirname($_SERVER['PHP_SELF'])."/".$currentdir_Cont[$x+2];
                        }else{
                            $filetype =dirname($_SERVER['PHP_SELF'])."/".str_replace('\\','/',substr($_GET['dir'], 0, -1))."/".$currentdir_Cont[$x+2];
                        }
                        
                    }else{
                        $filetype = "Explorer/filetype/svg/".$filetype.".svg";
                    }
                    
                   
                }else{

                    //else just show an icon coresponding to the file type
                    $filetype = "Explorer/filetype/svg/".$filetype.".svg";
                }
                
               
                echo "<".$htmltype_tr." class='".$classname."'><".$htmltype_td."><a href='".$extrdir.$currentPath.$currentdir_Cont[$x+2]."\\"."'>".
                    "<img class=\"filetype\" src=\"".$filetype."\" onerror=\"this.src='Explorer/filetype/svg/blank.svg';\"/><text>"
                    .limit_text($currentdir_Cont[$x+2],$titleLenght)."</text></a></".$htmltype_td.">"."<".$htmltype_td." class='filesize'>".formatSizeUnits($filesize)."</".$htmltype_td.">"
                    
                    ."</".$htmltype_tr.">";
              
              
            }
            
        }
        
       
    }
    if($_SESSION["show_thumbnails"]==false){
    echo"</table>";
    }else{
        echo"</div>";
    }
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
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

function CreateFolder($name,$dir){
    mkdir($dir.$name);
}
function UploadFile($path){
    $tmp_name = $_FILES["uploadfilevalue"]["tmp_name"];
    $filename = basename($_FILES["uploadfilevalue"]["name"]);
    move_uploaded_file($tmp_name,$path.$filename);
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
