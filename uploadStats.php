<?php
//echo 'debug:startUpload<br>' . "\n";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//echo 'debug:errorSet<br>' . "\n";

require_once 'const.php';
//echo 'debug:required<br>' . "\n";

$name = $_GET['name'];
$score = $_GET['score'];
//echo 'debug:get<br>' . "\n";

$score = (int) decrypt($score);
//echo 'debug:decrypt<br>' . "\n";

$name = mysql_escape_string($name);
$score = mysql_escape_string($score);
//echo 'debug:escaped<br>' . "\n";

//connect to db
$link = mysql_connect($dbHost, $dbUser, $dbPwd) or die('Error: no connection');
//echo 'debug:linked<br>' . "\n";
mysql_select_db($databaseName) or die('Error: Database not found');
//echo 'debug:selected<br>' . "\n";

//maybe create table
$createQuery = 'CREATE TABLE IF NOT EXISTS Stats (name varchar(255), score int);';
mysql_query($createQuery) or die('Error: Could not create table');
//echo 'debug:createQuery<br>' . "\n";

//get old score from db
$query = 'SELECT score FROM Stats WHERE name="' . $name . '" ORDER BY score DESC';
$result = mysql_query($query) or die('Error: unknow user');
//echo 'debug:selectQuery<br>' . "\n";

$oldScore = 0;
while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
    $oldScore = (int) $line[0];
}
//echo 'debug:oldScore' . $oldScore . '<br>' . "\n";

//check if better
if ($score > $oldScore) {
    //insert better score
    //echo 'debug:better!<br>' . "\n";
    $query = "INSERT INTO `$databaseName`.`Stats` (`name`, `score`) VALUES ('$name', '$score')";
    $result = mysql_query($query) or die('Error: not able to insert new score');
    echo 'better';
} else {
    echo 'notBetter';
}


exit;

function decrypt($rawScore) {
    return $rawScore;
}

?>