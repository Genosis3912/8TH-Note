<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "8thnote_db";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
