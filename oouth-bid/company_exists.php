<?php
error_reporting(-1);
ini_set('display_errors', 'On');

$name = $_POST["company_name"];

$dbserver = 'localhost';
$dbuser = 'root';
$dbpasswd =  'oluwaseyi';
$dbname = "oouth_bid";
$tablename = 'tbl_company';

if(!mysql_connect($dbserver,$dbuser, $dbpasswd))
{
    echo "error: ".mysql_error();
    exit;
}
if(!mysql_select_db($dbname))
{
    echo "error: ".mysql_error();
    exit;
}

$name = mysql_real_escape_string( $name );

$result = mysql_query("SELECT tbl_company.company_name FROM tbl_company WHERE company_name = '$name' ");

if(!$result)
{
    echo "error: ".mysql_error();
    exit;
}

if(mysql_num_rows($result) == 0)
{
    echo 'true';//email is unique. not signed up before
}
else
{
    echo 'false';
}

?>