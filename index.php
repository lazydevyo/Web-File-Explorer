<?php 
session_start();

if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?theme=') !== false) {
    SaveTheme($_GET['theme'].".css");
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

</head>
<body>
<div id="SelectStyle">
<a href="?theme=Dark">🌚</a>
<a href="?theme=Light">🌞</a>
</div>
<div id="mainwindow">


<?php 

include "explorer.php" ;

?>  


</div>
<div id="dirwindow">

<?php
    if (strpos($currentPath, '?dir=') !== false) {
        echo getcwd()."\\".$_GET['dir'];
     }else{
           //current directory (default root) with session
       echo getcwd();
     }
?>
</div>
</body>
<HTML>
