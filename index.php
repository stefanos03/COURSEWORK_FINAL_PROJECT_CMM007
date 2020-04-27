<?php
  error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
session_destroy();
$pageTitle = "Home_Page";
require_once("myPhpFunctionalities/Configuration.php");

$message = "";
$status = "";
$content = "";

//check if cookie is set
if (isset($_COOKIE['username']) && $_COOKIE['password'])
{
    
    loginFunction($_COOKIE['username'],$_COOKIE['password']);
}



//Login form functionality start
if (isset($_POST['submitForm']))
{
    $usrname = SanitizeField::clean($_POST['username']);
    $password = SanitizeField::clean($_POST['epassword']);
    
    if ($usrname!="" && $password!="")
    {
          if (!empty($_POST['remember_me']))
            {
               setcookie("username",$usrname,time()+3600);
               setcookie("password",$password, time()+3600);
               //echo "Cookie set successfully";
            }
            else{
              //echo "Remember  Cookie is not set ";
              setcookie("username",'');
              setcookie("password",'');
            }
          loginFunction($usrname,$password);
    }else
    {
       $status = "error your something went wrong";
       $message = "Username and password is required to login!!!";
    }
}


//Login function
function loginFunction($username,$password)
{
        $Members = new Member();
        $dataArray = array("username"=>$username,"password"=>$password);
        $Results =  $Members->login($dataArray);

        if ($Results['status']=="success")
        {
            session_start();
            $_SESSION['memberLogin'] = 'stefanos2020';
            $_SESSION['myUserId'] = $Results["id"];
            $_SESSION['myLastname'] = $Results["lastname"];
            $_SESSION['myFirstname'] = $Results["firstname"];
            $_SESSION["myLocation"] = $Results["location"];
            $_SESSION["myAddress"] = $Results["address"];
            $_SESSION["myEmail"] = $Results["email"];
            $_SESSION["myCountry"] = $Results["country"];
            $_SESSION["myPhoto"] = $Results["photo"];
//            $_SESSION['myAboutme'] = $Results['aboutme'];
            $_SESSION['myRole'] = $Results['role'];

            header("location:infoPage.php");
        }
        else
        {
            $status = $Results["status"];
            $message = $Results["message"];
            echo "Username and password is required to login!!!";
        }

}//end of loginFunction

include("header.php");
include("indexheader.php");







?>
<!DOCTYPE html>
<html>

<head>
    <title>W3.CSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=iso-8859-2" http-equiv="Content-Type">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .mySlides {display:none;}
    </style>
</head>

<div class="w3-container w3-padding-16 w3-purple" style="margin-top: 5px">
    <h2 style="margin-left: 700px">Welcome to RGU Research Paper Project </h2>
    <p style="margin-left: 200px">This project will be designing to implement a web application that will help group project to upload, identification, review, monitoring and following of research papers between the group members.
        <br> The research activities will be report writing, review, editing and other similar tasks can be to monitor and track the editorial progress of a number of papers within a limited time.
        <br>Furthermore, this project will give the opportunity for the user to create platform that will support group project teams.</p>
</div>
<body style="background: orchid">

<div class="w3-content w3-display-container " style="margin-top: 90px; width: 1050px; height: 650px;">

    <div class="w3-display-container mySlides">
        <img src="images/nice.png" style="width:100%">
        <div class="w3-display-bottomleft w3-large w3-container w3-padding-16 w3-black">
            Welcome to our webpage
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="images/how-to-write-a-research-paper.jpg" style="width:100%">
        <div class="w3-display-bottomleft w3-large w3-container w3-padding-16 w3-black">
              You can now upload your documents here
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="images/research_essay.jpg" style="width:100%">
        <div class="w3-display-bottomleft w3-large w3-container w3-padding-16 w3-black">
        Review all your documents anytime
        </div>
    </div>

    </div>
</div>
</body>

<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}
        x[myIndex-1].style.display = "block";
        setTimeout(carousel, 5000); // Change image every 2 seconds
    }
</script>

</body>
</html>




            </div>



  <!-- container //-->
    </section>

<br>
<br>
<br>
<?php
   require_once("indexFooter.php");
?>
<script type="text/javascript" src="JavaScript/datetimelibrary.js"></script>
<script type="text/javascript" src="JavaScript/newsletter.js"></script>