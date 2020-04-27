<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("LoginRequirement/Login_Request.php");
   $pageTitle = "Create User";  
   require_once("myPhpFunctionalities/Configuration.php");
   require_once("header.php");    
   
   
   $messagestatus='';

   if (isset($_POST['submitForm']))
   {
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        

        if ($lastname=='' || $firstname=='' || $email=='' || $password=='' || $role=='')
        {
           $messagestatus='warning';
           $message = "All fields are required to be filled before continuing.";
        }else
        {
            $user = new User();
            $result = $user->createuser($lastname,$firstname,$email,$password,$role);
            $messagestatus = $result["status"];
            $message = $result["msg"];
        }
   }

    

?>
<!--    admin can create and manage a user-->
        <br/>
   <div style="background-image: url('images/background9.jpeg')">
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
                  echo "<h4 style='margin-right: 350px; font-size: 40px; color: purple '>Create & Manage Users</h4>";

                    ?>
                </div>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>


           

             <form name="create_user" action="createAndManageUser.php" method="post" style="border: solid 3px purple;padding: 10px; background: purple; margin-left: -15px; margin-right: -15px">
                 <h3 class="text-left price-headline" style="color:white; margin-left: 500px; margin-bottom: 40px">Create User</h3>
              <div class="form-group row" style="margin-left: 200px">
            
                   <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Last Name</label>
                      
                    <div class="col-xs-12 col-sm-5">
                        
                            <input class="form-control" type="text" name="lastname"/>                     
                    </div> 

              </div>
              <div class="form-group row" style="margin-left: 200px">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">First Name</label>
                  
                  <div class="col-xs-12 col-sm-5">
                      <input class="form-control" type="text" name="firstname"/>
                  </div>
              </div>
              <div class="form-group row"  style="margin-left: 200px">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Email</label>
                  
                  <div class="col-xs-12 col-sm-5">
                      <input class="form-control" type="text" name="email"/>
                  </div>
              </div>
              <div class="form-group row"  style="margin-left: 200px">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Password</label>
                  
                  <div class="col-xs-12 col-sm-5">
                      <input class="form-control" type="text" name="password"/>
                  </div>
              </div>

              <div class="form-group row"  style="margin-left: 200px">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color: white">Role</label>
                  
                  <div class="form-group col-xs-12 col-sm-5">
                      <select class="form-control" name="role"/>
                            <option></option>
                            <option>teamleader</option>
                            <option value='member'>Student</option>    
                      </div>
                  </div>
              </div>

              
              <div class="form-group row">
                  <div class="col-xs-12 col-sm-2"></div>

                  <div class="col-xs-12 col-sm-10" >
                      <input  class="btn btn-primary" type="submit" name="submitForm" value="Create" style="background: white; color: purple"/>
                  </div>
              </div>
              </form>
                          
    </div><!-- end of container //-->

<!--Start of Manage-->
<br>
    <br/>
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

            ?>
        </div>
        <hr style=" border-top: 1px dashed purple;" >
        <div class="row">
            <div class="col-xs-12">

            </div>


        </div>



        <div class="row" style="border: solid 3px purple; padding: 30px; background: purple; margin-bottom: 30px">
            <h3 class="text-left price-headline container-fixed-top" style="color:white; margin-left: 500px;">Manage User</h3>
            <br>
            <?php
            $user = new User();
            $allUsers = $user->getAllUsers();
            foreach($allUsers as $row)
            {
                $id = $row['id'];
                $name = $row['lastname'].' '.$row['firstname'];
                $email = $row['email'];
                $location = $row['location'];
                $address = $row['address'];
                $country = $row['country'];
                $pwd = $row['password'];
                $role = $row['role'];
                $datecreated = new DateTime($row['datecreated']);
                $datecreated = $datecreated->format('l jS F, Y');


                $deleteUrl = "<a href='deleteUsers.php?id=".$id."' style='color: white'>Delete</a>";
                if ($role=='')
                {
                    $role = 'member';
                }

                $memberLink = "<a href='#?mp=aHR0cHM6Ly9haXJ2aWV3c3RvcmFnZS5ibG9iLmNvcmUud2luZG93cy5uZX-".$id."-QvYXZhdGFycy9hYzE4ZWNiNjZkN2ZiYTE4YzY3MTUxYzM3MDhiMmMzZQ'>".$name."</a>"

                ?>
                <div class="row">
                    <div class="col-xs-3" style="color: white">
                        <?php
                        echo "<strong ><i class='fa fa-user-o' style='color: white'></i> ".$memberLink."</strong><br/><small ><i class='fa fa-trash'></i> ".$deleteUrl."</small>";
                        ?>
                    </div>
                    <div class="col-xs-3" style="color: white">
                        <?php
                        echo "<i class='fa fa-envelope-o'></i> <a  style='color: white' href='mailto:.$email'>".$email."</a>";
                        ?>
                    </div>
                    <div class='col-xs-2' style="color: white">
                        <?php
                        echo "<i style='color: white' class='fa fa-tasks'></i> ".$role;
                        ?>
                    </div>
                    <div class="col-xs-4">
                        <?php
                        echo "<small style='color: white'><i class='fa fa-calendar-o'></i> ".$datecreated."</small>";
                        ?>
                    </div>

                </div>
                <hr  style=" border-top: 1px dashed white;">

                <?php

            }
            ?>

        </div>
    </div><!-- end of container //-->
    </div>
    </div><!--end of background-->
    <br>
    <br>
    <br>



<?php
require_once("footer.php");

?>