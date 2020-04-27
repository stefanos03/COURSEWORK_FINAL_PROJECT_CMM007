<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Papers assigned awaiting review";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   
   $status='';   

   $paper = new Paper();
   $reviews = $paper->MemberAssignedPapersInReview($_SESSION['myUserId']);
   $numInReview = $reviews->num_rows;


   

    

?>
<br/>

<!--This for the team leader paper reviewed-->

<div  id="bg" style="background-image: url('images/background8.jpeg')">
<div >
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

      echo "<strong style='margin-left: 800px; font-size: 40px; color: purple '>Welcome ".$User_roles."</strong>";
      echo "<h4 style='margin-left: 800px; font-size: 40px; color: purple '>Awaiting to Review</h4>";
      ?>
        <div class="container" style="border: solid 5px mediumpurple; background: purple">
            <div class="col-xs-12 text-right">

                </div>

            
           
              <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center price-headline" style="color:white;">Assigned Papers Awaiting Review (<?php echo $numInReview;  ?>)</h3>
                </div>                
              </div>
              
              <hr>     


              
              <div class="row" style="color: white">
                        <div class="col-xs-4">
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
                    <div class="row">
                        <div class="col-xs-4">
                              <i class='fa fa-folder-o'></i>
                              <?php echo "<a style='color: white' href='#'>".$res['name']."</a>";  ?>

                        </div>
                        <div class="col-xs-5">
                                <i class='fa fa-file-o'></i>
                                <?php echo "<a style='color:white' href='submited_paper_info.php?pid=".$res['id']."'>".$res['title']."</a>";
                                ?>
                        </div>
                        <div class="col-xs-3" style="color: white">
                              
                                <?php
                                   echo "<strong><big>
                                            <a style='color: white' href='reviewpaper.php?pid=".$res['id']."'>Review this Paper</a>
                                         </big></strong>";
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


              <?php 

                    }

              ?>



    </div><!-- end of container //-->

  </div><!--Background ends-->


    
<br/>
<?php
   require_once("footer.php");

?>

    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>