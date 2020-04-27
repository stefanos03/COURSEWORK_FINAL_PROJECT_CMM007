<?php

if (!isset($_GET['pid']) || $_GET['pid']=='')
{
  header("location: SubmitPaperLeader.php");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Assign User to Project";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   
   $status='';

   $paperid = $_GET['pid'];
   $pageLink = "assign_reviewer1.php?pid=".$paperid;
   $paper = new Paper();
   $paperInfo  = $paper->getPaperById($paperid);

   
   foreach($paperInfo as $result)
   {
      $paperTitle = $result["title"];
      $paperProject = $result['name'];
      $paperDesc = $result['description'];
      $paperFile = $result['file'];
      $paperUserId = $result['userid'];
      $paperSubmitedby = $result['lastname'].' '.$result['firstname'];
      $paperDate = new DateTime($result['datesubmitted']);
      $paperDate = $paperDate->format('l jS F, Y');
   }


   

  //Submit button to assign  paper to user
   if (isset($_POST['submitForm']))
   {
        $userid = $_POST['user'];
        $duration = $_POST['duration'];


        if ($paperid=='' || $userid=='' || $duration=='' )
        {
           $status='warning';
           $msg = "All fields are required to be filled before continuing.";
        }else
        {
            $dataArray = array("paperid"=>$paperid,"userid"=>$userid,"duration"=>$duration);
            $paper = new Paper();            
            $result = $paper->AssignReviewer($dataArray);
            $status = $result["status"];
            $msg = $result["msg"];
        }
   }

    

?>
<!--team leader can assing a user to a project-->
        <br/>

  <div style="background-image: url('images/background7.jpeg')">
      <br>
        <div class="container" style="border: solid 5px mediumpurple;  background: purple;">
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

                    ?>
                </div>

            <div class="row" >
                <div class="col-xs-12">
                    <h3 class="text-center price-headline" style="color:white;">Assign Reviewer </h3>
                </div>

                
            </div>
            <br>


             <form name="uploadpaper" action="<?php echo $pageLink; ?>" method="post" enctype="multipart/form-data">     
              
              <div class="form-group row" style="color: white; margin-left:250px" >
                  
                  <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Select Reviewer</label>
                  
                  <div class="form-group col-xs-12 col-sm-4">
                      <select class="form-control" name="user">
                            <option></option>

                            <?php
                              $project = new User();
                              $result = $project->getAllUsers();
                              foreach ($result as $row)
                              {
                                $id = $row['id'];
                                $name =  $row['lastname'].' '.$row['firstname'];

                                

                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                             

                            <?php

                              }

                            ?>   
                      </select>
                  </div>
              </div>

              <div class="form-group row" style="color: white; margin-left: 250px" >
            
                   <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right">Duration (in days)</label>
                      
                    <div class="col-xs-12 col-sm-4">
                        
                            <input class="form-control" type="text" name="duration" value="15"/>                      
                    </div> 

              </div>
             
                            
              <div class="row" style="margin-top:10px;">
                  
                  <div class="col-xs-2 col-sm-2">&nbsp;</div>
                  <div class="col-xs-10 col-sm-10">
                      <input  class="btn btn-primary" type="submit" name="submitForm" value="Assign Reviewer" style="background: white; color: purple; margin-left: 450px"/>
                  </div>
              </div>

              </form>

              <br/>


        </div><!-- end of container //-->
      <hr  style="border-top: 1px solid mediumpurple;">

              <div class="container" style="border: solid 5px mediumpurple; background: purple">
              <div class="row" style="color: white">
                  <div class="col-xs-12">
                    <h4 class="text-left price-headline" style="color:white;font-weight:bold;">Assigned Reviewers</h4>
                </div>
                  <ol>
                <?php
                    $selReviewers = $paper->getReviewersToPaper($paperid);

                    foreach($selReviewers as $row)
                    {
                        $dateassigned = new DateTime($row['dateassigned']);
                        $dateassigned = $dateassigned->format('l jS F, Y');
                        $deleteUrl = "<a href='deletePaper.php?id=".$id."' style='color: white'>Delete</a>";
                        echo "<li>".$row['lastname'].' '.$row['firstname']."  - <small>assigned on ".$dateassigned." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='' style='color: white'>Remove</a></small></li>";


                    }

                ?>
                  </ol>
              </div>
              <br/>
              <hr  style="border-top: 1px solid mediumpurple;">


              <div class="row" style="color: white">
                  <div class="col-xs-12">
                    <h4 class="text-left price-headline" style="color:white;font-weight:bold;">Paper Details</h4>
                </div>

              </div>
              <br/>
              <div class="row" style="color: white" >
                  <div class="col-xs-12">
                      <strong style="color: white">Project Group</strong>
                        <?php 
                            echo "<br/><i class='fa fa-folder-o'></i> <a href='createAndManageProject.php' style='color: white'>" .$paperProject."</a><br/></br>";
                           
                        ?>
                  </div>

                  <div class="col-xs-12">
                      <strong style="color: white">Paper Title</strong>
                        <?php 
                            echo "<br/><i class='fa fa-file-o'></i> <a href='SubmitPaperLeader.php' style='color: white'>" .$paperTitle."</a><br/><br/>";
                           
                        ?>
                  </div>
                  <div class="col-xs-12">
                        <strong style="color: white">Description</strong>
                        <?php  
                            echo "<br/><i class='fa fa-comment-o' style='color: white'></i>  ".$paperDesc."<br/><br/>";
                        ?>
                  </div>
                  <div class="col-xs-12">
                      <Strong style="color: white">File</Strong>
                      <?php
                            echo "<br/><i class='fa fa-file-o'></i> <a style='color: white' target='_blank' href='uploads/".$paperFile."'>".$paperFile."</a><br/><br/>";
                      ?>
                  </div>

                  <div class="col-xs-12">
                      <strong style="color: white">Submitted By</strong>
                      <?php
                            echo "<br/><i class='fa fa-user-o'></i> <a style='color: white'  href='#'".$paperUserId."'>".$paperSubmitedby."</a><br/><br/>";
                      ?>
                  </div>

                  <div class="col-xs-12" style="color: white">
                      <Strong>Date Submitted</Strong>
                      <?php
                            echo "<br/><i class='fa fa-calendar-o'></i> ".$paperDate."</a>";              
                      ?>
                  </div>


              </div>





              </div><!--end of container-->

      <br>
      <br>
      <br>
      <br>
      <br>
  </div><!--Background ends-->




    

<?php
   require_once("footer.php");

?>
