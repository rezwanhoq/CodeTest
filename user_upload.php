<?php

$db = 'mysql';
$username = 'root';
$password = '';
$file = 'users.csv';
$table = 'usertable';
$host = 'localhost';

$cons = mysqli_connect("$host", "$username", "$password", "$db");
$sql = "CREATE TABLE users(    
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE)";
if (mysqli_query($cons, $sql)) {
    echo "Table created successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($cons);
}
mysqli_close($cons);