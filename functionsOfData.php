<?php

function findCountries ($lang = 'en'){
    global $connection;
    $countries = null;
    try {
        $query = $connection->prepare('SELECT country_id, country_name_'.$lang.', status FROM countries');
        $query -> execute();
        $countries = $query->fetchAll();
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $countries;
}

function findNationality ($lang = 'en'){
    global $connection;
    $nationalities = null;
    try {
        $query = $connection->prepare('SELECT nationality_id, nationality_name_'.$lang.', status FROM nationality');
        $query -> execute();
        $nationalities = $query->fetchAll();
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $nationalities;
}

function findFaculties ($lang = 'en'){
    global $connection;
    $faculties = null;
    try {
        $query = $connection->prepare('SELECT faculty_id, faculty_name_'.$lang.', status FROM faculties');
        $query -> execute();
        $nationalities = $query->fetchAll();
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $nationalities;
}