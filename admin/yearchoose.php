<?php
    session_start();
    $type = $_GET['type'];
    if(!isset($_SESSION["year"])){  
    //未设置  
        $_SESSION["year"]='2015';     
    }
    if($type=='set'){
        $year = $_GET['year'];
        // store session data
        $_SESSION['year']=$year;
        echo true;
    }
    if($type=='get'){
        $year = $_SESSION['year'];
        echo $year;
    }
     
?>