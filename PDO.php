<?php

    $dbhost = 'mysql-siteweb.alwaysdata.net';
    $dbname = 'siteweb_bd_cherifauto';
    $dbuser = 'siteweb';
    $dbpswd = 'Cherif@06';
    try{
        $connect = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            )
        );
    }catch (PDOException $e){
        die("Une erreur est survenue lors de la connexion à la Base de données !");
    }
