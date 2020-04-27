<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   include("LoginRequirement/Login_Request.php");
   $pageTitle = "Manage Users";
  include("myPhpFunctionalities/Configuration.php");
  include("header.php");


   
   

   $paper = new Paper();
   $submissions = '' ;
   $reviews = '';
   $archive = '';

   if ($_SESSION['myRole']=='admin' || $_SESSION['myRole']=='teamleader' )
   {
      $submissions = @$paper->getAllSubmitedPapers();
      $reviews = $paper->getAllPapersInReview();
      

   }
   if ($_SESSION['myRole']=='member' || $_SESSION['myRole']=='')
   {
      
      $submissions = $paper->SubmitedPapersByMember($_SESSION['myUserId']);
      $reviews = $paper->MemberAssignedPapersInReview($_SESSION['myUserId']);
      
      
   }

   $archive = $paper->ReviewedPapers();

   
   $totalSubmissions = @$submissions->num_rows;
   $totalPapersInReview = @$reviews->num_rows;
   $totalInArchive = $archive->num_rows;

    

?>
    

   

    


        <br/>
<div style="background-image: url('images/background8.jpeg')">
        <div class="container">

            <div class="row">
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
                  echo "<strong style='margin-right: 400px;font-size: 40px;color: purple'>".$_SESSION['myLastname'].' '.$_SESSION['myFirstname']."</strong>,<br>";
                    ?>
                </div>

<!--                Start the container-->
                <div class="col-xs-12" style="border: 5px solid mediumpurple;background: purple;">
                    <h2 class="text-center price-headline" style="color:white; ">Browse Papers</h2>
                </div>

                
            </div>

            <hr style=" border: 1px solid purple;">

            <div class="column">
               <div class='col-xs-12'>
                    <div id="color">

                            <!-- Nav tabs -->
                            <ul id="color" class="nav nav-tabs" role="tablist" style="border: 5px solid mediumpurple; padding: 10px; color: purple; background: purple">
                              <li id="color" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><strong>Submissions (<?php echo $totalSubmissions; ?>)</strong></a></li>
                              <li id="color" role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><strong>Reviews (<?php echo $totalPapersInReview; ?>)</strong></a></li>
                              <li id="color" role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><strong>Archives (<?php echo $totalInArchive; ?>)</strong></a></li>
                              
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" style="border: 5px solid  mediumpurple; background:purple;padding: 10px">
                              <div role="tabpanel" class="tab-pane active" id="home">
                              <br/>
                                  <div class='row'>
                                      <div class='col-xs-4'>
                                          <strong style="color: white"><big>Project Group</big></strong>
                                      </div>
                                      <div class='col-xs-4'>
                                          <strong style="color: white"><big>Title</big></strong>
                                      </div>
                                      <div class='col-xs-4'>
                                          <strong style="color: white"><big>File</big></strong>
                                      </div>
                                  </div>
                                  <hr style="border: 1px solid mediumpurple;">
                                  <?php

                                       
                                        foreach($submissions as $row)
                                        {
                                          $datesubmitted = new DateTime($row['datesubmitted']);
                                          $datesubmitted = $datesubmitted->format('l jS F, Y');
                                  ?>
                                      <div class='row'>
                                          <div class='col-xs-4'>
                                              <?php 
                                                  echo "<i class='fa fa-folder-open-o' style='color: white'></i> <a href='#' style='color: white'>".$row['name']."</a><br/>";
                                                  echo "<small style='color: white;  '>Submitted on ".$datesubmitted."</small>"
                                              ?>
                                          </div>
                                          <div class='col-xs-4'>
                                                <?php
                                                    echo "<i class='fa fa-file-pdf-o' style='color: white'></i> <a style='color: white' href='submited_paper_info.php?pid=".$row['id']."'>".$row['title']."</a>";

                                                ?>
                                          </div>
                                          <div class='col-xs-4'>
                                                <?php
                                                    echo "<i style='color: white' class='fa fa-upload'></i> <a style='color: white' href='uploads/".$row['file']."'>".$row['title']."</a>";

                                                  ?>
                                          </div>
                                      </div>
                                      <hr style="border-top: 1px dashed mediumpurple;">
                                  <?php

                                        }

                                  ?>



                              </div>
                              <div role="tabpanel" class="tab-pane" id="profile" style="color: white">
                              <!--Reviews starts //-->
                              <br/>
                                  <div class="row">
                                      <div class="col-xs-4">
                                          <strong style="color: white"><big>Project Group</big></strong>
                                      </div>
                                      <div class="col-xs-5">
                                              <strong style="color: white"><big>Paper</big></strong>
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
                                                <?php echo "<a style='color: white' href='submited_paper_info.php'>".$res['name']."</a>";  ?>

                                          </div>
                                          <div class="col-xs-5">
                                                  <i class='fa fa-file-pdf-o'></i>
                                                  <?php echo "<a style='color:white' href='submited_paper_info.php?pid=".$res['id']."'>".$res['title']."</a>";
                                                  ?>
                                          </div>
                                          <div class="col-xs-3">
                                                
                                                  <?php
                                                     echo "<strong><big>
                                                              <a style='color: white' href='reviewpaper.php?pid=".$res['id']."'>Review this Paper</a>
                                                           </big></strong>";
                                                  ?>
                                          </div>
                                          <div class="col-xs-12">
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
                                      <hr style="border-top: 1px dashed mediumpurple;">
                                <?php 

                                      }

                                ?>



                              <!-- end reviews //-->
                              </div>
<!-- Archives-->
                              <div role="tabpanel" class="tab-pane" id="messages" style="color: white">
                                <br/>
                                <?php
                                      foreach($archive as $row)
                                      {
                                        $photo = "";


                                        if ($row['photo']!='')
                                        {
                                          $photo = 'users photos/'.$row['photo'];
                                        }
                                        else{
                                          $photo = "users photos/photoprofil.png";
                                        }
                                        $code1 = 'oDdpnVaWwgdsjhMFiyIeLjJjSUCThpJUxfUVwTGnNSGeMLToTq';
                                        $code2 = 'FoltjKlLKnBdPvQfPQi!oLU!lStPXzTyZomFgktMQluhRbCDHe';

                                ?>
                                    <div class='row'>
                                        <div class='col-xs-12'>
                                            <?php
                                                echo "<div ><strong><i class='fa fa-file-pdf-o'></i> <a style='color: white' href='submited_paper_info.php?pid=".$row['paperid']."'>".$row['title']."</a></strong><div style='padding-top:10px;'>".nl2br($row['comment'])."</div></div>";
                                                echo "<div><i class='fa fa-upload'></i> <a style='color: white' href='uploads/".$row['reviewedfile']."'>".$row['reviewedfile']."</a></div>";
                                                echo "<div style='text-align:right;'><a style='color: white' href='#".$code1.'-'.$row['memberid'].'-'.$code2."'>".$row['lastname'].' '.$row['firstname']."</a> <img class='img-rounded' style='width:50px;height:50px;' src='".$photo."'><br/></div>"
                                             ?>


                                        </div>

                                    </div>
                                    <hr style="border-top: 1px dashed mediumpurple;">

                                <?php
                                      }


                                ?>





                              </div>
                              
                            </div>

                          </div>
               </div><!-- end of col //-->
            </div><!-- end of row //-->
             
            
                          
    </div><!-- end of container //-->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div><!--end of the background-->



    

<?php
   require_once("footer.php");

?>
