<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("LoginRequirement/Login_Request.php");
$pageTitle = "Assign User to Project";
require_once("myPhpFunctionalities/Configuration.php");
require_once("header.php");


$messagestatus='';
$title = '';
$descr = '';
$Id_Project = '';




if (isset($_POST['submitForm']))
{
    $Id_Project = $_POST['project'];
    $title = $_POST['title'];
    $descr = $_POST['description'];


    if ($Id_Project=='' || $title=='' || $descr=='' || $_SESSION['fileUpload']=='')
    {
        $messagestatus='warning';
        $msg = "All fields are required to be filled before continuing.";
    }else
    {
        $dataArray = array("projectid"=>$Id_Project,"title"=>$title,"description"=>$descr,"file"=>$_SESSION['uploadedFile'],"submitedby"=>$_SESSION['myUserId']);
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
    $descr = $_POST['description'];

}




?>
<br/>
<br>
<!--Sumbit Paer for leader-->
<div style="background-image: url('images/background.jpeg')">
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

        echo "<strong style='margin-right: 350px; font-size: 40px; color: purple '>Welcome ".$User_roles."</strong>";
        echo "<h4 style='margin-right: 400px; font-size: 40px; color: purple '>Sumbit & Assign</h4>";
        ?>
    </div>

    <div class="row">



    </div>







    <form name="uploadpaper" action="SubmitPaperLeader.php" method="post" enctype="multipart/form-data" style="border: solid 5px mediumpurple;background: purple; padding: 10px; margin-right:-15px; margin-left:-15px;">
        <h3 class="text-left price-headline" style="color:white; margin-left: 400px">Paper Submission</h3>
        <div class="form-group row" style="margin-left: 150px">

            <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Project</label>

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
                        if ($Id_Project==$id)
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

        <div class="form-group row" style="margin-left: 150px">

            <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Title</label>

            <div class="col-xs-12 col-sm-5">

                <input class="form-control" type="text" name="title" value="<?php echo $title; ?>"/>
            </div>

        </div>
        <div class="form-group row" style="margin-left: 150px">

            <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Description</label>

            <div class="col-xs-12 col-sm-5">
                <textarea class="form-control" cols="80" rows="5" name="description"><?php echo $descr; ?></textarea>
            </div>
        </div>

        <div class="row" >
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
<!--file upload-->
        <div class="form-group row" style="margin-left: 150px">

            <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">File</label>

            <div class="col-xs-7 col-sm-5">
                <input type="file" name="fileToUpload" style="color: purple" >
                <input type="submit" name="uploadFile" value="Upload File" class="btn btn-default btn-sm" style="color: purple">
            </div>

        </div>

<!--Submit button-->
        <div class="row" style="margin-top:10px; ">

            <div class="col-xs-2 col-sm-2">&nbsp;</div>
            <div class="col-xs-10 col-sm-10" >
                <input  class="btn btn-primary" type="submit" name="submitForm" value="Submit Paper" style="background: white; color: purple; margin-left: 500px "/>
            </div>
        </div>

    </form>

    <?php
    $paper = new Paper();
    $list = $paper->getAllSubmitedPapers();
    $totalPapers = $list->num_rows;
    ?>

    <br/><br/>






    <br/>
    <?php

    foreach($list as $row)
    {
        $datesubmitted = new DateTime($row['datesubmitted']);
        $datesubmitted = $datesubmitted->format('l jS F, Y');

        ?>




        <?php
    }
    ?>

</div><!-- end of container //-->

<!--submissions test-->

<br>

<div class="container" style="border: solid 3px mediumpurple; padding: 10px; background: purple">


    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-left price-headline" style="color:white; margin-left: 450px">Paper Submissions (<?php echo $totalPapers; ?>)</h3>
        </div>


    </div>

    <!-- row 1 //-->
    <hr style=" border-top: 1px solid mediumpurple;">


    <div class="row"  style="border: 5px solid mediumpurple;">
        <div class="col-xs-4" >
            <strong style="color: white"><big>Project</big></strong>
        </div>
        <div class="col-xs-4">
            <strong style="color: white"><big>Paper Title</big></strong>
        </div>
        <div class="col-xs-4">
            <strong style="color: white"><big>File</big></strong>
        </div>

    </div>
    <br/>
    <?php

    foreach($list as $row)
    {
        $datesubmitted = new DateTime($row['datesubmitted']);
        $datesubmitted = $datesubmitted->format('l jS F, Y');

        $assign = '';
        if ($row['status']=='s' || $row['status']=='r')
        {
            $assign="<a href='assign_reviewer1.php?pid=".$row['id']."'><strong>Assign reviewer</strong></a>";
        }

        ?>
    <div class="container">
        <div class="row" >
            <div class="col-xs-4" style="color: white">
                <?php
                echo "<i class='fa fa-folder-o'></i> <a style='color: white' href='createAndManageProject.php'>" .$row['name']."</a><br/>";
                echo "<small>Submitted on ".$datesubmitted."</small>";
                ?>
            </div>
            <div class="col-xs-4" style="color: white">
                <?php
                echo "<i class='fa fa-commenting'></i> <a href='#' style='color: white'>".$row['title']."</a><br/> <a style='color: white'>$assign</a>";
                ?>
            </div>
            <div class="col-xs-4" style="color: white">
                <?php
                echo "<i class='fa fa-file-o'></i> <a style='color: white' target='_blank' href='uploads/ ".$row['file']."'>".$row['file']."</a>";
                ?>
            </div>
        </div>
    </div>
        <hr style="border-top: 1px solid mediumpurple;">



        <?php
    }
    ?>

</div><!-- end of container //-->

    <br>
    <br>
    <br>
    <br>
    <br>

</div><!--background-->


<?php
require_once("footer.php");

?>
