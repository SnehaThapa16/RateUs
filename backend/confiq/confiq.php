<?php
// Database connection using MySQLi
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'rateus';

// Creating connection
$mysqli = new mysqli($host, $user, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: ".$mysqli->connect_error);
}

function create_unique_id(){
    $characters="1234567890abcdefghijklmnopqrstuvwxyz";
    $str="";
    $characters_length=strlen($characters);
    for($i=0;$i<10;$i++){
        $str.=$characters[mt_rand(0,$characters_length-1)];
    }
    return $str;
}
?>
