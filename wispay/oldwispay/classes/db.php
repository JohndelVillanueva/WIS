<?php
$db_host="localhost"; //localhost server 
$db_user="attuser";	//database username
$db_password="9qRs6Hx8T!lXcz1w";	//database password
$db_name="attendance";	//database name

try
{
	$db=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e)
{
	$e->getMessage();
}




