<?php
$shortopts  = "";
$shortopts .= "u::";  // Required value
$shortopts .= "p::"; // Optional value
$shortopts .= "h:"; // These options do not accept values

$ss = array(
    "  --file [csv file name]     – this is the name of the CSV to be parsed",
    "  --create_table             – this will cause the MySQL users table to be built (and no further action will be taken) ",
    "  --dry_run                  – this will be used with the --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered",
    "  -u                         – MySQL username",
    "  -p                         – MySQL password",
    "  -h                         – MySQL host"
);
$longopts  = array(
    "file:",     // Required value
    "create_table:",    // Optional value
    "dry_run",        // No value
    "help"           // No value
);
$options = getopt($shortopts, $longopts);
var_dump($options);
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
        case 'help':
            $host = $optionsValue;
            foreach ($ss as $key => $value) {
                print ($value) . PHP_EOL;
            }
            break;
        default:
            # code...
            break;
    }
}


// $db = 'mysql';
// $username = 'root';
// $password = '';
// $file = 'users.csv';
// $table = 'usertable';
// $host = 'localhost';

// $cons = mysqli_connect("$host", "$username", "$password", "$db");
// $sql = "CREATE TABLE users(    
//     name VARCHAR(30) NOT NULL,
//     surname VARCHAR(30) NOT NULL,
//     email VARCHAR(70) NOT NULL UNIQUE)";
// if (mysqli_query($cons, $sql)) {
//     echo "Table created successfully.";
// } else {
//     echo "ERROR: Could not able to execute $sql. " . mysqli_error($cons);
// }
// mysqli_close($cons);