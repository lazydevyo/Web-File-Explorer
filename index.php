<?php session_start(); ?>
<HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

Body,html {
margin:0px;

}
#dirwindow {
    color: #797979;
   
    width: calc(100% - 50px);
}
#mainwindow{
margin:40px;
}
#mainwindow , #dirwindow{
    font-size :1em;
    padding: 24px;
    border: 1px solid #eaeaea;
    box-shadow: #0000002e 3px 8px 18px;
    font-family: arial;
}


#filetype{
margin-left: -10px;
width:20px;
height:20px;

}
text {
    margin-left:5px;
}

#mainwindow a{

padding-left:24px;
padding-right:10px;
padding-top:6px;
padding-bottom:6px;
display: block;

color:#000;
text-decoration: none;
}

#mainwindow a:hover{
color:#fff;
background-color: #ffcc7e;
}

table{
width:100%;

}
tr:nth-child(even){background-color: #f2f2f2;}

td:nth-child(2){
    color:#808080;
}

td {
    width: 88%;
    text-align: left;

}
th{
    font-weight:normal;
    height: 54px;
    padding-top: 24px;
    border-bottom: 1px solid #ccc;
    width: 50%;
    text-align:left;
}
@media only screen and (max-width: 600px) {
    #mainwindow{
        padding:0px;
        margin:0px;
    }
    td:nth-child(2),th:nth-child(2){
display:none;

    }
}

</style>

</head>
<body>

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