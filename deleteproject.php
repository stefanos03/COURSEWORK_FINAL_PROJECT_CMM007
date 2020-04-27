<?php
require_once("myPhpFunctionalities/Configuration.php");

if (!isset($_GET['id']) || $_GET['id']=='')
{
	header("location:createAndManageProject.php");
}

$projectid = $_GET['id'];

$project = new Project();
$project->deleteProject($projectid);
header("location:createAndManageProject.php");

?>