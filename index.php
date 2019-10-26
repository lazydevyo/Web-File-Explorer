<?php 
session_start();
$currentPath ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($currentPath, '?theme=') !== false) {
    SaveTheme($_GET['theme'].".css");
 //   Header("Location:http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
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

<div id="SelectStyle">
<a href="?theme=Dark">🌚</a>
<a href="?theme=Light">🌞</a>
</div>
<div id="mainwindow">
<div id="menubar">

<span id="sortbutton">
    
<form style="display: inline" action="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" method="post">

<input type="submit" name="swap" value="">
</form>
</span>
<div id="slider"></div>
<?php
echo "<span class='dirary'>"."<a href='/'>"."Home"."</a></span>";


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
 echo "<span class='dirary'>"."<a href='".$extrdir.$dirloop."\'>".$diraryCut[$x]."</a></span>";


}

?>

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
</body>
<HTML>
