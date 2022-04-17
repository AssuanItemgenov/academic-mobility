<?php
try{
    $connection = new PDO ("mysql:host=localhost; dbname=academ_m", "root", "");
}catch(PDOException $e){
    echo $e -> getMessage ();
}