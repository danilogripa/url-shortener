<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 10/11/14
 * Time: 14:41
 */
require "../trackear/Database.php";

//$links = parse_ini_file('links.ini');

if(isset($_GET['l'])){
    $db = new Database();
    if($result = $db->getLink($_GET['l'])){
        header('Location: ' . $result["link"]);
    }
}
else{
    header('HTTP/1.0 404 Not Found');
    echo 'Unknown link.';
}
