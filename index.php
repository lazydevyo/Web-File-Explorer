<?php 
session_start();
$currentPath ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($currentPath, '?theme=') !== false) {
    SaveTheme($_GET['theme'].".css");
    Header("Location:".dirname($_SERVER['PHP_SELF']));
}

//get current dir and split
if (strpos($currentPath, '?dir=') !== false) {
    //split the ?dir of each \ 
    $dirary = $_GET['dir'];
$diraryCut =explode ("\\", $_GET['dir']);

}else{
    $dirary = "";
    $diraryCut = array("/");
}
//Load the theme
$fp = fopen('Explorer/theme.select', 'r');
$theme = fread($fp,filesize("Explorer/theme.select"));



function SaveTheme($text){
        $fp = fopen('Explorer/theme.select', 'w');
        fwrite($fp, $text);
        fclose($fp);
}

?>

<HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="Explorer/themes/<?php echo $theme; ?>">

<script src="Explorer/jquery-ui/external/jquery/jquery.js"></script>
<script src="Explorer/jquery-ui/jquery-ui.js"></script>

<link rel="stylesheet" href="Explorer/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="Explorer/jquery-ui/jquery-ui.theme.css">

<style>
#selectstyle{

    position: absolute;
    top: 2px;
    right: 2px;
    font-size: 28px;
    border: 0px;
}

#selectstyle a{
    text-decoration: none;
}
</style>
<script>
  $(function() {
    $( "#slider" ).slider({min:20, max: 200,  slide: function() {

         $(".filetype").css("width",$( "#slider" ).slider( "value" ));
         $(".filetype").css("height",$( "#slider" ).slider( "value" ));

         if($( "#slider" ).slider("value")>25){
            $.post( "index.php", { submit: ""} );
         }
      }});

  });

</script>
</head>
<body>
<div id="loading"></div>
<div id="popout">
<div id="createfolderform">

<h2>Create a folder</h2>
<form style="display: inline" action="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" method="post">
<input type="text" name="filenamevalue" value="">
<input type="submit" name="mdr" value="Create">
</form>
</div>

<div id="uploadfileform">

<h2>Create a folder</h2>
<form style="display: inline" action="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"  method="post" enctype="multipart/form-data">
<input type="file" name="uploadfilevalue" value="">
<input id="uploadbuttonsubmit" type="submit" name="upfile" value="Upload">
</form>
</div>


</div>

<div id="SelectStyle">
<a href="?theme=Dark">🌚</a>
<a href="?theme=Light">🌞</a>
</div>

<div id="mainwindow">
<div id="menubar">

<span id="sortbutton">
    
<form style="display: inline" action="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" method="post">

<input id="sortb" type="submit" name="swap" value="">
</form>

</span>

<div id="slider"></div>
<span id="createfolder_button"></span>
<span id="uploadfile_button"></span>
<div id="navigationfolders">
<?php
echo "<a href='".dirname($_SERVER['PHP_SELF'])."'>"."<span class='dirary'>"."Home"."</span></a>";


$dirloop ="";

for($x = 0; $x < count($diraryCut)-1; $x++) {

    if($dirloop==""){
        //since dirloop is empty just at the first folder
        $dirloop = $diraryCut[$x]; 
    }else{
        //for each loop add the previus value of the dirarycut to dirloop so if its was folder1 should be folder1 + folder2
        $dirloop = $dirloop . "\\".$diraryCut[$x];
    }
   
    if (strpos($currentPath, '?dir=') !== false) {
        $extrdir = "?dir=";
        }else{
            //if not add it
        $extrdir = "";
        }

//loop throuth all the dirarycut
 echo "<a href='".$extrdir.$dirloop."\'>"."<span class='dirary'>".$diraryCut[$x]."</span></a>";


}

?>
</div>
</div>
<?php 

include "explorer.php" ;

?>  


</div>
<div id="dirwindow">

<?php
    if (strpos($currentPath, '?dir=') !== false) {
       // echo getcwd()."\\".$_GET['dir'];
     }else{
           //current directory (default root) with session
    //   echo getcwd();
     }
?>
</div>
<script>
$("#createfolder_button").click(function() {
$("#popout").fadeIn();
$("#createfolderform").css("display","block");
});

$("#uploadfile_button").click(function() {
$("#popout").fadeIn();
$("#uploadfileform").css("display","block");
});
uploadbuttonsubmit
$("#uploadbuttonsubmit").click(function() {
$("#loading").fadeIn();

});
$("#popout").click(function() {
//$("#popout").fadeOut();

});
</script>
</body>
<HTML>

