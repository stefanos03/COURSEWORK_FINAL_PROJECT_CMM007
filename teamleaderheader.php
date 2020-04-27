<?php


$ProfilPic = "";
if ($_SESSION["myPhoto"] != "") {
    $ProfilPic = $_SESSION["myPhoto"];
} else {
    $ProfilPic = "photoprofil.png";
}

$ProfilPic = "users photos/" . $ProfilPic;


?>
<!--navbar starts here for team leader-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color:purple;color:white;">
    <div class="navbar-header">
        <a href="infoPage.php"> <img src="images/logop.png" alt="logo" width="70" height="70" ></a>
        <strong>RGU Research paper Project</strong>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu" aria-expanded="false"></button>

      </div>



      <div id="nav-menu" class="collapse navbar-collapse" style="margin-left: 650px; margin-top: 10px">
          <ul class="nav navbar-nav">

              <li><a style='color:#ffffff;' href="infoPage.php"><span class="fa fa-home" ></span><strong> Back To Main</strong></a></li>

              <li><a style='color:#ffffff;' href="SubmitPaperLeader.php"><span class="fa fa-paper-plane" ></span><strong> Sumbit Paper</strong></a></li>

              <li><a style='color:#ffffff;' href="papers_in_review.php"><span class="fa fa-search" ></span><strong> In Review</strong></a></li>
              <li class=" nav navbar-nav"><a class="w3-button w3-hover-yellow" style='color:white; 'href="papers_awaiting_review.php"><span class="fa fa-search" ></span><strong> Review Paper</strong></a></li>

              <li><a  style='color:white; 'href="my_papers_reviewed.php"><span class="fa fa-search-plus" ></span><strong> Papers Reviewed</strong></a></li>


              <!--profile name and picture-->
              <li style="float: right; margin-top: 10px"> <?php  echo "<strong>Welcome ".$_SESSION['myLastname'].' '.$_SESSION['myFirstname']."</strong><br>";
                  ?>  </li>
              <li class="dropdown" style="margin-left: 350px; margin-top: -10px">
                  <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" href="AboutUs.php"  >
                      <img src="<?php echo $ProfilPic; ?>" class="img-rounded" width="40px" height="40px" hspace="1px" align="left" > <b class="caret"></b>
                  </a>


                  <ul class="dropdown-menu">
                      <li role="separator" class="divider"></li>
                      <li><a style="padding-top:8px;padding-bottom:8px;color:purple;" href="Log_out.php">Log out</a></li>

                  </ul>

              </li>


          </ul>
      </div>
    </nav>