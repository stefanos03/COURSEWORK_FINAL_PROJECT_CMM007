<?php
 
 //activate account when the admin is create a new userr
 if (!isset($_GET['activationcode']))
 {
   header("location:index.php");
 }

 $activationcode  = trim(stripslashes(htmlspecialchars($_GET['activationcode'])));
 
  require_once("myPhpFunctionalities/Configuration.php");

 $member = new Member();
 $result = $member->activateMembershipAccount($activationcode);

 $statusfinal = $result["status"];
 $nextPage = $result["nextPage"];

 if ($statusfinal=="failed")
 {
 	//echo "<br>Inside failed block";
 	header("location:".$nextPage);
 }
 else if ($statusfinal=="expired")
 {

 	session_start();
 	$_SESSION['505msg'] = " <br/><br/><br/><br/>";
 	header("location:".$nextPage); 

 }
 else if ($statusfinal=="success")
 {
 	$_SESSION['memberLogin'] = 'stefanos2021';
 	header("location:".$nextPage);

 }







?>