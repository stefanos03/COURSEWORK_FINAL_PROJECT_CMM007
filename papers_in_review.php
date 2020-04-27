<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Assign User to Project";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   
   $messagestatus='';

   $paper = new Paper();
   $reviews = $paper->getAllPapersInReview();
   $numInReview = $reviews->num_rows;






?>  
        <br/>
  <div  style="background-image: url('images/background9.jpeg')"  >
        <div class="container">
            <div class="col-xs-12 text-right">
                  <?php
                           $User_roles = '';
                           if ($_SESSION['myRole']=='admin')
                           {
                              $User_roles = 'Administrator';
                           }
                           else if ($_SESSION['myRole']=='teamleader')
                           {
                              $User_roles = 'Team Leader';

                           }else if ($_SESSION['myRole']=='member' || $_SESSION['myRole']=='')
                           {
                              $User_roles = 'Member';
                           }

                  echo "<strong style='margin-right: 350px; font-size: 40px; color: purple '>Welcome ".$User_roles."</strong>,<br>";
                  echo "<h4 style='margin-right: 350px; font-size: 40px; color: purple '>Manage Papers in Review</h4>";
                    ?>
                </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="container" style="border: solid 3px mediumpurple;background: purple ; padding: 10px">
           
              <div class="row" style="color: white">
                <div class="col-xs-12" style="color: white">
                    <h3 class="text-center price-headline" style="color:white;">Papers in Review (<?php echo $numInReview;  ?>)</h3>
                </div>                
              </div>
              
              <hr>     


              
              <div class="row" style="color: white">
                        <div class="col-xs-4" style="color: white">
                              <strong><big>Project Group</big></strong>
                        </div>
                        <div class="col-xs-5">
                                <strong><big>Paper</big></strong>
                        </div>
              </div>
              
              <br/>   
              

              <?php
                    foreach($reviews as $res)
                    {

                        $paperid = $res['id'];

              ?>
                    <div class="row" style="color: white">
                        <div class="col-xs-4" style="color: white">
                              <i class='fa fa-folder'></i>
                              <?php echo "<a style='color: white' href='projects.php'>".$res['name']."</a>";  ?>

                        </div>
                        <div class="col-xs-5" style="color: white">
                                <i class='fa fa-file-o'></i>
                                <?php echo "<a style='color:white' href='submited_paper_info.php?pid=".$res['id']."'>".$res['title']."</a>";
                                ?>
                        </div>
                        <div class="col-xs-12" style="color: white">
                                  <h5><strong>Assigned Reviewers</strong></h5>
                                  <ol>
                                      <?php
                                          $selReviewers = $paper->getReviewersToPaper($paperid);

                                          foreach($selReviewers as $row)
                                          {
                                              $dateassigned = new DateTime($row['dateassigned']);
                                              $dateassigned = $dateassigned->format('l jS F, Y');
                                              echo "<li>".$row['lastname'].' '.$row['firstname']."  - <small>assigned on ".$dateassigned." &nbsp;&nbsp;&nbsp;<strong>(Duration: ".$row['duration']." days)</strong></small></li>";

                                          }

                                    ?>
                                  </ol>

                        </div>
                    </div>
                    <hr>
<!-- Closed brackets-->
              <?php 

                    }

              ?>
              
              


              
             



              

    </div><!-- end of container //-->
        </div>
      <br>
      <br>
      <br>
      <br>
      <br>
  </div><!--Background ends-->
     
  

    

<?php
   require_once("footer.php");

?>
