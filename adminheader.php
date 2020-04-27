<?php


$Picture_Profile = "";
if ($_SESSION["myPhoto"] != "") {
    $Picture_Profile = $_SESSION["myPhoto"];
} else {
    $Picture_Profile = "photoprofil.png";
}

$Picture_Profile = "users photos/" . $Picture_Profile;


//Admin Navigation menu
?>
<!--Nav starts for admin here-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color:purple;color:white;">
      <div class="navbar-header">
          <a href="infoPage.php"> <img src="images/logop.png" alt="logo" width="70" height="70" ></a>
        <strong> RGU Research paper Project</strong></div>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>

        </button>

      </div>



      <div id="nav-menu" class="collapse navbar-collapse" style="margin-left: 510px; margin-top: 10px">
          <ul class="nav navbar-nav">

            <li class=" nav navbar-nav"><a class="w3-button w3-hover-yellow" style='color:#ffffff; 'href="infoPage.php"><span class="fa fa-home" ></span><strong> Back To Main</strong></a></li>

                <li class="nav navbar-nav"><a style="color:#ffffff;" href="createAndManageUser.php"><span class="fa fa-users"></span><strong> Create & Manage Users  </strong></a></li>

              <li class="nav navbar-nav"><a style="color:#ffffff;" href="createAndManageProject.php"><span class="fa fa-tasks"></span><strong>  Create & Manage Project </strong></a> </li>

              <li class="nav navbar-nav"><a style="color:#ffffff;" href="assignUsertoProject.php"><span class="fa fa-user"></span><strong> Assign User to Project </strong></a> </li>




              </li>

            </li>


              <li style="float: right; margin-top: 10px"> <?php  echo "<strong>Welcome ".$_SESSION['myLastname'].' '.$_SESSION['myFirstname']."</strong><br>";
                      ?>  </li>
            <li class="dropdown" style="margin-left: 350px; margin-top: -10px">
              <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="AboutUs.php"  >
                  <img src="<?php echo $Picture_Profile; ?>" class="img-rounded" width="40px" height="40px" hspace="1px" align="left" > <b class="caret"></b>
              </a>


                <ul class="dropdown-menu">
                  <li role="separator" class="divider"></li>
                  <li><a style="padding-top:8px;padding-bottom:8px;color:purple;" href="Log_out.php">Log out</a></li>
                 
                </ul>

            </li>
<!--    Menu of admin ends-->


          </ul>
      </div>
    </nav>