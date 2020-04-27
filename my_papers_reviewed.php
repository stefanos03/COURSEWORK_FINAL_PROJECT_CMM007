<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Assign User to Project";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   
   $messagestatus='';


   

                $paper = new Paper();
                $list = $paper->ReviewedPapersByMember($_SESSION['myUserId']);
                $totalPapers = $list->num_rows;
    

?>

        <br/>
  <div style="background-image: url('images/background2.jpeg')">
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
      echo "<h4 style='margin-left: 800px; font-size: 40px; color: purple '>My Papers Reviewed</h4>";
      ?>
        <div class="container" style="border: solid 5px mediumpurple; background: purple">
            <div class="col-xs-12 text-right">

                </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center price-headline" style="color:white;">My Reviews (<?php echo $totalPapers; ?>)</h3>
                </div>

                
            </div>
                  

           
                           
<!--              the time that was submitted-->
             
              <?php
                  
                  foreach($list as $row)
                  {
                    $datesubmitted = new DateTime($row['datesubmitted']);
                    $datesubmitted = $datesubmitted->format('l jS F, Y');

                    $assign = '';
                    if ($row['status']=='c' || $row['status']=='r')
                    {
                       $assign="<a href='assign_reviewer1.php?pid=".$row['paperid']."'><strong>Assign reviewer</strong></a>";
                    }
                    
              ?>
              <div class="row" style="color: white">
                  <div class="col-xs-4" style='background-color: mediumpurple;border-radius:5px;padding-top:10px;padding-bottom:15px;'>
                        <?php 
                            echo "<strong><big>Project</big></strong><br/><i class='fa fa-folder-o'></i> <a style='color: white' href='createAndManageProject.php'>" .$row['name']."</a><br/>";
                            echo "<small>Submitted on ".$datesubmitted."</small><br/>";
                        ?>
                        <br/>
                        <?php  
                            echo "<strong><big>Paper Title</big></strong><br/><i class='fa fa-comment-o'></i> <a style='color: white' href='submited_paper_info.php?pid=".$row['paperid']."'><strong>".$row['title']."</strong></a><br/>";
                        ?>
                       <br/>
                       <?php
                            echo "<strong><big>File</big></strong><br/><i class='fa fa-file-o'></i> <a style='color: white' target='_blank' href='uploads/".$row['file']."'>".$row['file']."</a><br/><br/>";

                            echo "<div style='text-align:right;'><a href='reviewpaper.php?pid=".$row['paperid']."'><strong style='color: white'>Review this Paper</strong></a></div>";

                       ?>
                  </div>
                  <div class="col-xs-8">
                        <?php
                            $reviews= $paper->paperReviewByMember($row['paperid'],$_SESSION['myUserId']);

                            foreach($reviews as $rec)
                            {
                              $comment = $rec['comment'];
                              $datecreated= new DateTime($rec['datecreated']);
                              $datecreated = $datecreated->format('l jS F, Y');

                          ?>
                            <div class='row' >
                                <div class='col-xs-12'>
                                    <strong>Review</strong><br/>
                                    <?php 
                                      echo "<small>".$datecreated."</small>";


                                        echo "<div style='margin-top:10px;margin-bottom:10px;'>".nl2br($comment)."<br><i class='fa fa-paperclip'></i> <a href='uploads/".$rec['file']."'>".$rec['file']."</a></div>";

                                    ?>
                                </div>
                            </div>

                          <?php

                            }
                          ?>



                  </div>
                  

              </div>
              <hr style=" border-top: 1px dashed mediumpurple;">



              <?php
                  }
              ?>
                          
    </div><!-- end of container //-->
<!--fixing the background picture-->
<br>
<br>
<br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>

  </div><!--Background ends-->

<?php
   require_once("footer.php");

?>
