<?php

$username = null;
$array = [];
$password = null;
$createtable = null;
$file = null;
$host = null;
$help = false;
$dryrun = false;
$cons = null;
$count = 0;
$db = 'mysql';

$shortopts  = "";
$shortopts .= "u:";  // Required value
$shortopts .= "p:"; // Required value
$shortopts .= "h:"; // Required value

$helpopts = array(
    "  --file [csv file name]     – this is the name of the CSV to be parsed",
    "  --create_table             – this will cause the MySQL users table to be built (and no further action will be taken) ",
    "  --dry_run                  – this will be used with the --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered",
    "  -u                         – MySQL username",
    "  -p                         – MySQL password",
    "  -h                         – MySQL host"
);
$longopts  = array(
    "file:",     // Required value
    "create_table",    // No value
    "dry_run",        // No value
    "help"           // No value
);
$options = getopt($shortopts, $longopts);

foreach ($options as $optionskey => $optionsValue) {
    
    switch ($optionskey) {
        case 'u':
            $username = $optionsValue;
            break;
        case 'p':
            $password = $optionsValue;
            break;
        case 'h':
            $host = $optionsValue;
            break;
        case 'create_table':
            $createtable = true;
            break;
        case 'file':
            $file = $optionsValue;
            break;
        case 'dry_run':
            $dryrun = true;
            break;
        case 'help':
            $help = true;
            break;
        default:
            
            break;
    }
}

if ($help) {
    foreach ($helpopts as $key => $value) {
        print ($value) . PHP_EOL;
    }
    exit;
}
if ($file) {
    $array = array_map('str_getcsv', file($file));
    $header = array_shift($array);
    array_walk($array, '_combine_array', $header);

    function _combine_array(&$row, $key, $header)
    {
        $row = array_combine($header, $row);
    }
}

if ($host && $username && $password){
    $cons = mysqli_connect("$host", "$username", "$password", "$db");    
}

if ($cons && $dryrun == false) {

    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $name = ucfirst($value['name']);
            $surname = ucfirst($value['surname']);
            $email = strtolower($value['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = "INSERT INTO $table (name, surname, email) VALUES ('$name', '$surname', '$email')";
                if (mysqli_query($cons, $sql)) {
                    $count++;
                }
            } else {
                fwrite(STDOUT, $email . PHP_EOL);
            }
        }
        echo "Result: " . $count . " records added.";
    }

    // create table 
    if ($createtable) {
        echo "hello";
        $sql = "CREATE TABLE users(    
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(70) NOT NULL UNIQUE)";

        if (mysqli_query($cons, $sql)) {
            echo "Table created successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($cons);
        }
    }
    mysqli_close($cons);
} else {    
    die("ERROR: Could not connect to DB.");
}
