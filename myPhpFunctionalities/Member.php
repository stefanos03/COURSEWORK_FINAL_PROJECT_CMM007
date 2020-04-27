<?php
  
  class Member
  {

      private $_email;
      private $_lastname;
      private $_firstname;
      private $_photo;
      private $_aboutme;
      private $_country;
      private $_address;
      private $_activated;
      private $_errmsg;
      private $_response;
      private $_status;
      private $_msg;
      private $_password;
      private $_encrypt_password;
      private $_username;
      private $_emailmessage;
      private $_activationcode;
      private $_subject;
      private $_mailbody;
     



  	  public function registerMember($fields)
  	  {
          $result = "";
          $this->_email = $fields['email'];
          $this->_lastname = $fields['lastname'];
          $this->_firstname = $fields['firstname'];

          $isAlreadyRegistered = $this->checkEmailRegistered($this->_email);
          
          if ($isAlreadyRegistered==0)
          {
              $result = $this->executeNewMemberFunc();
                    if ($result>0)
                    {
                        $this->_errmsg = "";
                        $this->_status = "";
                        $this->_subject = "";
                        $this->createActivation();

                        $this->_mailbody = " <br><br/><br/>

                              <strong>Username: </strong>&nbsp;&nbsp;&nbsp; ".$this->_email."<br/>
                              <strong>Password: </strong>&nbsp;&nbsp;&nbsp; ".$this->_password."

                              <br/><br/>
                          ";



                        $dataArray = array("email"=>$this->_email,"lastname"=>$this->_lastname,"firstname"=>$this->_firstname,"password"=>$this->_password,"message"=>$this->_mailbody,"subject"=>$this->_subject);

                        $email = new Email($dataArray);
                        $mailcontent = $email->createMessage();
                       
                        $email->sendMail($mailcontent);      
                       
                        
                    }
                    else
                    {
                        $this->_errmsg = "";
                        $this->_status = "";
                    }
          }
          else
          {
              $this->_errmsg = "";
              $this->_status = "";
          }
      

          $this->_response = array("msg"=>$this->_errmsg,"status"=>$this->_status);

          return $this->_response;
  	  }


      private function createActivation()
      {

            //check if activation account has been created already

            $sqlQuery = "Delete from activate_account where email='".$this->_email."'";
            $QueryExecutor = new ExecuteQuery();
            $result = $QueryExecutor::customQuery($sqlQuery);


            $codeAlpha = array('A','z','B','y','!','C','x','@','w','D','v','E','u','F','t','G','s','H','r','I','q','J','p','K','o','L','n','M','m','N','l','O','k','P','j','Q','i','R','h','S','g','T','f','U','e','V','d','W','c','X','b','Y','a','Z');
            $code = '';
            for($i=0;$i<100;$i++)
            {
                $num = rand(1,53);
                $this->_activationcode .= $codeAlpha[$num];
            }
        
                    

            $sqlQuery = "Insert into activate_account(email,code)values('".$this->_email."','".$this->_activationcode."')";
            $QueryExecutor = new ExecuteQuery();
            $result = $QueryExecutor::customQuery($sqlQuery);    
                      
      }

  	  private function checkEmailRegistered()
  	  {
          $recfound = 0;
          $sqlQuery = "Select count(*) as recFound from members where email='".$this->_email."'";
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery);  
          foreach ($result as $row)
          {
             $recfound = $row['recFound'];
          }
          
          return $recfound;
  	  }

      private function executeNewMemberFunc()
      {
         $this->_password = $this->generatePassword();
         $this->_encrypt_password = md5(sha1($this->_password));

         $sqlQuery = "Insert into members(email,lastname,firstname,username,password)values('".$this->_email."','".$this->_lastname."','".$this->_firstname."','".$this->_email."','".$this->_password."')";
         $QueryExecutor = new ExecuteQuery();
         $result = $QueryExecutor::customQuery($sqlQuery);  
         return $result;        
      }

      private function generatePassword()
      {
        $codeAlpha = array('A','z','B','y','!','C','x','@','w','D','v','E','u','F','t','G','s','H','r','I','q','J','p','K','o','L','n','M','m','N','l','O','k','P','j','Q','i','R','h','S','g','T','f','U','e','V','d','W','c','X','b','Y','a','Z');
        $generatedPass = '';
         for($i=0;$i<9;$i++)
         {
          $num = rand(1,53);
          $generatedPass .= $codeAlpha[$num];
         }
     
          return $generatedPass;
      }


      public function activateMembershipAccount($activationcode)
      {
          $sqlQuery = "Select m.id as memberid,m.username,m.password,m.lastname,m.firstname,m.address,m.country,m.photo,m.aboutme,m.activated,a.id as activationid,a.email,a.code,a.date_created from activate_account a inner join members m where code='".$activationcode."'";
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery); 
          $numOfRecords = $result->num_rows;
          $id = '';
          $email = '';
          $code = '';
          $dateCreated = '';
          $response = '';
          $status = '';
          $nextPage = '';

          if ($numOfRecords>0)
          {
               foreach ($result as $row)
               {
                  $memberid = $row['memberid'];
                  $this->_username = $row['username'];
                  $this->_password = $row['password'];
                  $this->_lastname = $row['lastname'];
                  $this->_firstname = $row['firstname'];
                  $this->_address = $row['address'];
                  $this->_country = $row['country'];
                  $this->_photo = $row['photo'];
                  $this->_aboutme = $row['aboutme'];
                  $this->_activated = $row['activated'];
                  $activationid = $row['activationid'];
                  $this->_email = $row['email'];
                  $this->_activationcode  = $row['code'];
                  $dateCreated =  new DateTime($row['date_created']);  
                         
               }
              
                $theDateCreated = strtotime($dateCreated->format('Y-m-d'));
                $today = strtotime('now');          

                $dateDiff = floor(abs($today-$theDateCreated)/(60*60*24));

                //activate if generated code is less than 7 days
                  if ($dateDiff<7)
                  {
                      $sqlQuery = "Update members set activated='y' where email='".$this->_email."'";
                      $result = $QueryExecutor::customQuery($sqlQuery); 
                      
                      $sqlQuery = "Delete from activate_account where code='".$activationcode."'";
                      $result = $QueryExecutor::customQuery($sqlQuery); 
                      
                      $status = 'success';
                      $nextPage = 'dashboard.php';
                      
                      session_start();
                      $this->setUserSessionData($memberid);
                  }
                  else
                  {
                      $status = 'expired';
                      $nextPage = '505.php';


                      
                    
                      $this->createActivation();
                      $this->_subject = "";

                      $this->_mailbody = "Thank you for registering on Covenear. Your account has been created with the credentials given below. <br>You are advised to change your password when logged in to one you can easily remember. Follow the link below to activate your account.<br/><br/>

                              <strong>Username: </strong>&nbsp;&nbsp;&nbsp; ".$this->_email."<br/>
                              <strong>Password: </strong>&nbsp;&nbsp;&nbsp; ".$this->_password."

                              <br/><br/>
                          <a href='http://funaabe-senate.com/tabernacle2/activate_account.php?activationcode=".$this->_activationcode."'>Activate your account here</a> and start creating events, activities and groups.<br/><br/><br/>";

                       

                        $dataArray = array("email"=>$this->_email,"lastname"=>$this->_lastname,"firstname"=>$this->_firstname,"password"=>$this->_password,"message"=>$this->_mailbody,"subject"=>$this->_subject);

                        $mymail = new Email($dataArray);
                        $mailcontent = $mymail->createMessage();
                        
                        $mymail->sendMail($mailcontent);                       
                        

                  }
               
          }
          else
          {
                  $status = 'failed';
                  $nextPage = 'index.php';
                  

          }
             
          $response = array("status"=>$status,"nextPage"=>$nextPage);

          return $response;          
          

      }


      public function getMemberById($memberId)
      {
         $sqlQuery = "Select id,username,password,title,lastname,firstname,location,email,address,country,photo,aboutme,activated,datecreated from members where id=".$memberId;
         $QueryExecutor = new ExecuteQuery();
         $result = $QueryExecutor::customQuery($sqlQuery);  

         $id='';$username='';$password='';$title='';$lastname='';$firstname='';$location='';$email='';$address='';$country='';$photo='';$aboutme='';$activated='';$datecreated='';
         foreach($result as $row)
         {
            $id=$row['id'];
            $username = $row['username'];
            $password = $row['password'];
            $title = $row['title'];
            $lastname = $row['lastname']; 
            $firstname = $row['firstname'];
            $location = $row['location'];
            $email = $row['email'];
            $address = $row['address'];
            $country = $row['country'];
            $photo = $row['photo'];
            $aboutme = $row['aboutme'];
            $activated = $row['activated'];
            $datecreated = $row['datecreated'];

         }

          $response = array("id"=>$id,"username"=>$username,"password"=>$password,"title"=>$title,"lastname"=>$lastname,"firstname"=>$firstname,"location"=>$location,"email"=>$email,"address"=>$address,"country"=>$country,"photo"=>$photo,"aboutme"=>$aboutme,"activated"=>$activated,"datecreated"=>$datecreated);

          //var_dump($response);

          return $response;

      }

  	  private function sendMemberActivationMail()
  	  {

  	  }

  	  private function setRememberMe()
  	  {

  	  }

  	  private function unsetRememberMe()
  	  {
  	  	
  	  }


      public function login($fields)
      {
          $this->_username = $fields['username'];
          $this->_password = $fields['password'];
          $response = "";

          $sqlQuery = "Select id from members where username='".$this->_username."' and password='".$this->_password."'";
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery);  
          $recFound = $result->num_rows;

          //check if record is found
          if ($recFound>0)
          {
              $sqlQuery = "Select id,title,lastname,firstname,location,email,address,country,role,photo,aboutme from members where username='".$this->_username."' and password='".$this->_password."' and activated='y'";
              $QueryExecutor = new ExecuteQuery();
              $result = $QueryExecutor::customQuery($sqlQuery);  
              $recFound = $result->num_rows;

                //record is found and activated 
                if ($recFound>0)
                {
                          $myId = "";
                          $myTitle = "";
                          $myLastname = "";
                          $myFirstname = "";
                          $myLocation = "";
                          $myEmail = "";
                          $myAddress = "";
                          $myCountry = "";
                          $myRole = "";

                          foreach ($result as $row)
                          {
                                 $myId = $row['id'];
                                 $myTitle = $row['title'];
                                 $myLastname = $row['lastname'];
                                 $myFirstname = $row['firstname'];
                                 $myLocation = $row['location'];
                                 $myEmail = $row['email'];
                                 $myAddress = $row['address'];
                                 $myCountry = $row['country'];
                                 $myPhoto = $row["photo"];
                                 $myAboutme = $row["aboutme"];
                                 $myRole = $row['role'];
                          }


                          $status = "success";
                          $response = array("status"=>$status,"id"=>$myId,"title"=>$myTitle,"lastname"=>$myLastname,"firstname"=>$myFirstname,"location"=>$myLocation,"email"=>$myEmail,"address"=>$myAddress,"country"=>$myCountry,"photo"=>$myPhoto,"aboutme"=>$myAboutme,"role"=>$myRole);


                }
                else
                {
                          $status = "error";
                          $response =  array("status"=>$status,"message"=>"");
                }




          }
          else
          {   
              $status = "error";
              $response = array("status"=>$status,"message"=>"");

          }//end of check of user records.
          

                   
          return $response;


      }


      public function updateprofile($fields)
      {
          $memberid = $fields["memberid"];
          $lastname = $fields["lastname"];
          $firstname = $fields["firstname"];
          $location = $fields["location"];
          $country = $fields["country"];
          $aboutme = $fields["aboutme"];
          $memberid = $fields["memberid"];

          $sqlQuery = "Update members set lastname='".$lastname."',firstname='".$firstname."',location='".$location."',country='".$country."',aboutme='".$aboutme."' where id=".$memberid;
           $QueryExecutor = new ExecuteQuery();
           $result = $QueryExecutor::customQuery($sqlQuery); 

           $response = "";
           if ($result>0)
           {
                 $response = array("status"=>"success","message"=>"");
                 $this->setUserSessionData($memberid);
           }
           else
           {
                 $response = array("status"=>"error","message"=>"");
           }

           return $response;
      }


      private function setUserSessionData($memberid)
      {
          $sqlQuery = "Select id,lastname,firstname,location,email,address,country,photo,aboutme from members where id=".$memberid;
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery); 

          foreach ($result as $row)
          {
              $_SESSION['myUserId'] = $row['id'];
              $_SESSION['myLastname'] = $row["lastname"];
              $_SESSION['myFirstname'] = $row["firstname"];
              $_SESSION["myLocation"] = $row["location"];
              $_SESSION['myEmail'] = $row['email'];
              $_SESSION["myAddress"] = $row["address"];
              $_SESSION["myCountry"] = $row["country"];
              $_SESSION["myPhoto"] = $row["photo"];
              $_SESSION['myAboutme'] = $row["aboutme"];
          }
      }   


      public function uploadAvatar()
      {
          if ($_FILES["file"]["name"]!='')
          {
              $fileName = $_FILES['file']['name'];
              $test = explode(".", $fileName);
              $extension = end($test);
              $today = date("Ymd_H_i_s");
              $name = $today.rand(100,999).'.'.$extension;
              $location = '../users photos/'.$name;

              $result = move_uploaded_file($_FILES["file"]["tmp_name"], $location);

              $response = array("status"=>$result,"name"=>$name,"location"=>$location);

              return $response;
          }
      }


      public function updateAvatar($name,$location)
      {
          $myUserID = $_SESSION['myUserId'];
          $myPhoto = $_SESSION['myPhoto'];
          $myOldPhoto = "../users photos/".$myPhoto;

          $sqlQuery = "Update members set photo='".$name."' where id=".$myUserID;
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery);  

          //Delete old photo and rename the new one with the name of the former
          @unlink($myOldPhoto); 


          //Set user photo session to the newly uploaded one
          $_SESSION['myPhoto'] = $name;       
          
      }

      
      public function getTotalNumOfMembers()
      {
          $sqlQuery = "Select count(id) as totalMembers from members";
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery);  
          $numOfMembers = 0;
          foreach ($result as $row)
          {
            $numOfMembers = $row['totalMembers'];
          }
          return $numOfMembers;
      }


      public function getAllMembersRecords()
      {
         $sqlQuery = "Select id as memberid,lastname,firstname,location,email,address,country,photo,
         aboutme,activated,datecreated from members";
         $QueryExecutor = new ExecuteQuery();
         $result = $QueryExecutor::customQuery($sqlQuery);
         return $result;
      }
//      delete user functionality
      public function deleteUser($memberid)
      {
          $sqlQuery = "Delete from members where id=".$memberid;
          $QueryExecutor = new ExecuteQuery();
          $result = $QueryExecutor::customQuery($sqlQuery);

      }
 

 }//end of class





?>