<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Assign User to Project";
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");


   $messagestatus='';


   $Id_Project = '';
   $descrip = '';
   $title = '';


   if (isset($_POST['submitForm']))
   {
        $Id_Project = $_POST['project'];
        $title = $_POST['title'];
        $descrip = $_POST['description'];


        if ($Id_Project=='' || $title=='' || $descrip=='' || $_SESSION['fileUpload']==0)
        {
           $messagestatus='warning';
           $msg = "All fields are required to be filled before continuing.";
        }else
        {
            $dataArray = array("projectid"=>$Id_Project,"title"=>$title,"description"=>$descrip,"file"=>$_SESSION['uploadedFile'],"submitedby"=>$_SESSION['myUserId']);
            $paper = new Paper();
            $result = $paper->submitPaper($dataArray);
            $messagestatus = $result["status"];
            $msg = $result["msg"];
        }
   }


   if (isset($_POST['uploadFile']))
   {
        $Id_Project = $_POST['project'];
        $title = $_POST['title'];
        $descrip = $_POST['description'];
   }



?>
        <br/>
<div style="background-image: url('images/background1.jpeg')">
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
                              $User_roles = 'Student';
                           }

                  echo "<strong style='margin-right: 350px; font-size: 40px; color: purple '>Welcome ".$User_roles."</strong>";
                  echo "<h4 style='margin-right: 350px; font-size: 40px; color: purple '>Submit Your Paper</h4>";
                    ?>
                </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="container" style="border: solid 5px mediumpurple; background: purple">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center price-headline" style="color:white;">Paper Submission </h3>
                </div>


            </div>

                <br>




             <form name="uploadpaper" action="SubmitPaperMember.php" method="post" enctype="multipart/form-data">

              <div class="form-group row" style="margin-left: 200px; color: white">

                  <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Project</label>

                  <div class="form-group col-xs-12 col-sm-5">
                      <select class="form-control" name="project">
                            <option></option>

                            <?php
                              $project = new Project();
                              $result = $project->getAllProject();
                              foreach ($result as $row)
                              {
                                $id = $row['id'];
                                $name =  $row['name'];
                                $selected = '';

                                if ($row['id']==$Id_Project)
                                {
                                  $selected = 'selected';
                                }

                            ?>
                            <option <?php echo $selected; ?> value="<?php echo $id; ?>"><?php echo $name; ?></option>


                            <?php

                              }

                            ?>
                      </select>
                  </div>
              </div>

              <div class="form-group row" style="margin-left: 200px; color: white">

                   <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right">Title</label>

                    <div class="col-xs-12 col-sm-5">

                            <input class="form-control" type="text" name="title" value="<?php echo $title; ?>"/>
                    </div>

              </div>
              <div class="form-group row" style="margin-left: 200px; color: white">

                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Description</label>

                  <div class="col-xs-12 col-sm-5">
                      <textarea class="form-control" cols="80" rows="5" name="description"><?php echo  $descrip; ?></textarea>
                  </div>
              </div>

              <div class="row" style="margin-left: 200px; color: white">
                  <div class="col-xs-3"></div>
                  <div class="col-xs-9">
                      <?php
                          if (isset($_POST['uploadFile']))
                          {
                            echo "<strong>";
                              $target_dir = "uploads/";
                              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

                              $uploadOk = 1;
                              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// if image file is a actual image
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
//  if file already exists
                              if (file_exists($target_file)) {
                                  echo "Sorry, file already exists. ";
                                  $uploadOk = 0;
                              }
//  file size
                              if ($_FILES["fileToUpload"]["size"] > 50000000) {
                                  echo "Sorry, your file is too large. ";
                                  $uploadOk = 0;
                              }
// Allow certain file formats
                              if($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "txt") {
                                  echo "Sorry, only DOC, DOCX, TXT files are allowed. ";
                                  $uploadOk = 0;
                              }
//  if $uploadOk is set to 0 by an error
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

              <div class="form-group row" style="margin-left: 200px; ">

                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">File</label>

                  <div class="col-xs-7 col-sm-5">
                      <input type="file" name="fileToUpload" >
                      <input type="submit" name="uploadFile" value="Upload File" class="btn btn-default btn-sm">
                  </div>

              </div>

              <div class="row" style="margin-top:10px; margin-left: 500px; ">

                  <div class="col-xs-2 col-sm-2">&nbsp;</div>
                  <div class="col-xs-10 col-sm-5">
                      <input  class="btn btn-primary" type="submit" name="submitForm" value="Submit Paper" style="background: white; color: purple"/>
                  </div>
              </div>

              </form>

              <?php
                $paper = new Paper();
                $list = $paper->SubmitedPapersByMember($_SESSION['myUserId']);
                $totalPapers = $list->num_rows;
              ?>

              <br/><br/>
            </div>

<!--Sumbissions starts-->
            <hr style=" border-top: 1px solid purple;">
            <div class="container" style="border: solid 5px mediumpurple; background: purple">
              <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-center price-headline" style="color:white;font-weight:bold;">My Submissions (<?php echo $totalPapers; ?>)</h4>
                </div>

              </div>
              <div class="row" >
                  <div class="col-xs-4" style="color: white">
                        <strong><big>Project</big></strong>
                  </div>
                  <div class="col-xs-4" style="color: white">
                        <strong><big>Paper Title</big></strong>
                  </div>
                  <div class="col-xs-4" style="color: white">
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
              <div class="row" style="color: white" >
                  <div class="col-xs-4">
                        <?php
                            echo "<i class='fa fa-folder-open-o'></i> <a style='color: white' href='createAndManageProject.php'>" .$row['name']."</a><br/>";
                            echo "<small>Submitted on ".$datesubmitted."</small>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                        <?php
                            echo "<i class='fa fa-comments-o'></i> <a style='color: white' href='submited_paper_info.php?pid=".$row['id']."'>".$row['title']."</a>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                      <?php
                            echo "<i class='fa fa-file-pdf-o'></i> <a style='color: white' target='_blank' href='uploads/".$row['file']."'>".$row['file']."</a>";
                      ?>
                  </div>

              </div>
              <hr style=" border-top: 1px dashed mediumpurple;">



              <?php
                  }
              ?>

    </div><!-- end of container //-->
        </div><!--end of container 2-->
<br>
<br>
<br>
    <br>
    <br>

</div><!--background ends-->


<?php
   require_once("footer.php");

?>
