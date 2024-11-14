<?php
 $username = "root";
 $password = "";
 $hostname = "localhost";
 $database = "notesapp";

$connect = mysqli_connect($hostname,$username,$password,$database);

if (!$connect){
    die("connection failed" . mysqli_connect_error());
}


?>