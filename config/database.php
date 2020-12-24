<?php
/**
 * @author Robin Beck
 */

$dbName     = 'maskyourface';
$dns        = 'mysql:dbname=' . $dbName . ';host=localhost';
$user       = 'root';
$password   = ''; 
$options    = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$database = null;

try
{
    $database = new PDO($dns, $user, $password, $options);
}
catch (PDOException $e)
{
    die ('Unable to establish database connection: ' . $e->getMessage());
}