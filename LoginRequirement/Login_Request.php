<?php
//Login_request
if (session_start()!=1)
{
	session_start(); 

}
else
{

}

if (!isset($_SESSION['memberLogin']) && ($_SESSION['memberLogin']!='stefanos2021'))
{
	header("location:index.php");	
}





?>