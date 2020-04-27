<?php

if (!isset($_GET['pid']) || $_GET['pid']=='' )
{
   header("location:papers_awaiting_review.php");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Review Paper";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   

   $messagestatus='';

   $paperid = $_GET['pid'];
   $pageLink = "reviewpaper.php?pid=".$paperid;
   $paper = new Paper();
   $paperinfo = $paper->getPaperById($paperid);

   foreach($paperinfo as $result)
   {
     $paperId = $result['id'];
     $paperTitle = $result['title'];
     $paperProject = $result['name'];
     $paperDescription = $result['description'];
     $paperFile = $result['file'];
     $paperDateSubmitted = $result['datesubmitted'];
     $paperStatus = $result['status'];
   }


   $Id_Project = '';
   $comments = '';
   $title = '';


   if (isset($_POST['submitForm']))
   {
        
        $comments = $_POST['comment'];

        
        if ($comments=='')
        {
           $messagestatus='warning';
           $msg = "Comment is required to submit a review.";
        }else
        {
            $dataArray = array("paperid"=>$paperid,"comment"=>$comments,"file"=>$_SESSION['uploadedFile'],"submitedby"=>$_SESSION['myUserId']);
            $paper = new Paper();            
            $result = $paper->submitReview($dataArray);
            $messagestatus = $result["status"];
            $msg = $result["msg"];

            $comments = '';
            unset($_SESSION['uploadedFile']);
        }
   }


   if (isset($_POST['uploadFile']))
   {
        $userid = $_SESSION['myUserId'];
        $comments = $_POST['comment'];
       
   }

    

?>  
        <br/>
<div style="background-image: url('images/background9.jpeg')">
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
echo "<h4 style='margin-left: 800px; font-size: 40px; color: purple '> Review the Paper</h4>";
?>
        <div class="container" style="border: solid 5px mediumpurple; background: purple;  padding: 10px">
            <div class="col-xs-12 text-right">

                </div>

            <div class="row" style="color: white">
                <div class="col-xs-12">
                    <h3 class="text-center price-headline" style="color:white;">Review Paper </h3>
                </div>

                
            </div>
                  


           

             <form name="uploadpaper" action="<?php echo $pageLink; ?>" method="post" enctype="multipart/form-data" >
              
              <div class="form-group row" style="color: white">
                  
                  <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Title</label>
                  
                  <div class="col-xs-12 col-sm-7">
                        <i class='fa fa-file-o'></i> 
                          <?php 
                              echo "<a  style='color:white' target='_blank' href='submited_paper_info.php?pid=".$paperId."'>".$paperTitle."</a> &nbsp;&nbsp;&nbsp;&nbsp;<small>[<strong>Project Group</strong> &nbsp;&nbsp;<i class='fa fa-folder-o'></i> ".$paperProject."]</small>";
                          ?>
                  </div>
              </div>

              
              <div class="form-group row">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Comment</label>
                  
                  <div class="col-xs-12 col-sm-8">
                      <textarea class="form-control" cols="80" rows="5" name="comment"><?php echo  $comments; ?></textarea>
                  </div>
              </div>

              <div class="row">
                  <div class="col-xs-3"></div>
                  <div class="col-xs-9" style="color: white">
                      <?php
                          if (isset($_POST['uploadFile']))
                          {
                            echo "<strong>";
                              $target_dir = "uploads/";
                              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

                              $uploadOk = 1;
                              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
                              if(isset($_POST["submit"])) {
                                  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                  if($check !== false) {
                                      echo "File is an editable document - " . $check["mime"] . ". ";
                                      $uploadOk = 1;
                                  } else {
                                      echo "File is not an editable document. ";
                                      $uploadOk = 0;
                                  }
                              }
// Check if file already exists
                              if (file_exists($target_file)) {
                                  echo "Sorry, file already exists. ";
                                  $uploadOk = 0;
                              }
// Check file size
                              if ($_FILES["fileToUpload"]["size"] > 50000000) {
                                  echo "Sorry, your file is too large. ";
                                  $uploadOk = 0;
                              }
// Allow certain file formats
                              if($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "txt") {
                                  echo "Sorry, only DOC, DOCX, TXT files are allowed. ";
                                  $uploadOk = 0;
                              }
// Check if $uploadOk is set to 0 by an error
                              if ($uploadOk == 0) {
                                  echo "Sorry, your file was not uploaded. ";
                                  $_SESSION['fileUpload']=0;
// if everything is ok, try to upload file
                              } else {
                                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. ";
                                      $_SESSION['fileUpload']=1;
                                      $_SESSION['uploadedFile'] = basename( $_FILES["fileToUpload"]["name"]);
                                  } else {
                                      echo "Sorry, there was an error uploading your file. ";
                                      $_SESSION['fileUpload']=0;
                                  }
                              }

                              echo "</strong><br/><br/>";

                          }                  
                      ?>
                  </div>
              </div>

              <div class="form-group row">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Review File</label>
                  
                  <div class="col-xs-7 col-sm-5">
                      <input type="file" name="fileToUpload" >
                      <input type="submit" name="uploadFile" value="Upload File" class="btn btn-default btn-sm">
                  </div>
                  
              </div>
                            
              <div class="row" style="margin-top:10px;">
                  
                  <div class="col-xs-2 col-sm-2">&nbsp;</div>
                  <div class="col-xs-10 col-sm-10">
                      <input  style="color: purple; background: white; margin-left: 650px" class="btn btn-primary" type="submit" name="submitForm" value="Submit Review"/>
                  </div>
              </div>

              </form>

              <?php
                $paper = new Paper();
                $list = $paper->ReviewedPapersByMember($_SESSION['myUserId']);
                $totalPapers = $list->num_rows;
              ?>

              <br/><br/>
        </div>
    <hr style=" border-top: 1px solid purple;">
<!-- Reviewed paper   -->
    <div class="container" style="border: solid 5px mediumpurple; background: purple; color: white; padding: 10px">
              <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-center price-headline" style="color:white;font-weight:bold;">My Reviews (<?php echo $totalPapers; ?>)</h4>
                </div>

              </div>
              <div class="row" >
                  <div class="col-xs-4">
                        <strong><big>Project</big></strong>
                  </div>
                  <div class="col-xs-4">
                        <strong><big>Paper Title</big></strong>
                  </div>
                  <div class="col-xs-4">
                      <strong><big>File</big></strong>
                  </div>

              </div>
              <br/>
              <?php
                  
                  foreach($list as $row)
                  {
                    $datesubmitted = new DateTime($row['datesubmitted']);
                    $datesubmitted = $datesubmitted->format('l jS F, Y');
                    
              ?>
              <div class="row" >
                  <div class="col-xs-4">
                        <?php 
                            echo "<i class='fa fa-folder-o'></i> <a style='color: white' href='createAndManageProject.php'>" .$row['name']."</a><br/>";
                            echo "<small>Submitted on ".$datesubmitted."</small>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                        <?php  
                            echo "<i style='color: white' class='fa fa-comment-o'></i> <a style='color: white' href='submited_paper_info.php?pid=".$row['paperid']."'>".$row['title']."</a>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                      <?php
                            echo "<i style='color: white' class='fa fa-file-o'></i> <a style='color: white' target='_blank' href='uploads/".$row['file']."'>".$row['file']."</a>";
                      ?>
                  </div>

              </div>
              <hr>



              <?php
                  }
              ?>
                          
    </div><!-- end of container //-->
</div><!--end of container 2-->
    <br>
    <br>
    <br>
    <br>
</div><!--background ends-->
     
  

    

<?php
   require_once("footer.php");

?>
