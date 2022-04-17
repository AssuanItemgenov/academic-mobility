<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $location = 'index.php';
    if(isset($_GET['lang'])){
        setcookie('lang', $_GET['lang'], time() + 3600*24*7*4*12);
        $location = $_SERVER['HTTP_REFERER'];
    }
    header("Location:$location");
}