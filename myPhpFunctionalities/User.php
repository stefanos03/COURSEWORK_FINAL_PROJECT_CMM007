<?php

class User
{
    public function createUser($lastname,$firstname,$email,$password,$role)
    {
        $sqlQuery = "Insert into members(username,password,title,lastname,firstname,location,email,address,country,photo,aboutme,role,activated)values('".$email."','".$password."','','".$lastname."','".$firstname."','','".$email."','','','','','".$role."','y')";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        $response = '';
        if ($result>0)
        {
            $response = array("status"=>"success","msg"=>"User [".$lastname." ".$firstname."] has been successfully created.");
            $this->sendMail($email,$password,$lastname,$firstname);
        }else{
            $response = array("status"=>"error","msg"=>"An error occurred creating the user.");
        }

        return $response;
    }

    private function sendMail($email,$password,$lastname,$firstname)
    {
        $errmsg = "You have been successfully registered. Please try to login or contact the administrator should you have difficulty logging in.";

        $subject = "PreshApp membership registration";

        $mailbody = "Thank you for registering on  RGU Research paper Below are your username and password to access your membership account. <br>You are advised to change your password when logged in to one you can easily remember.<br/><br/>

                              <strong>Username: </strong>&nbsp;&nbsp;&nbsp; ".$email."<br/>
                              <strong>Password: </strong>&nbsp;&nbsp;&nbsp; ".$password."

                              <br/><br/>
                          ";



        $dataArray = array("email"=>$email,"lastname"=>$lastname,"firstname"=>$firstname,"password"=>$password,"message"=>$mailbody,"subject"=>$subject);

        $email = new Email($dataArray);
        $mailcontent = $email->createMessage();

        $email->sendMail($mailcontent);
    }

    public function getAllUsers()
    {
        $sqlQuery = "Select id,lastname,firstname,email,password,location,address,country,photo,role,datecreated from members order by id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;

    }

    public function changePassword($memberid,$current_password,$new_password)
    {
        $response = '';
        $isCurrentPasswordCorrect = $this->checkCurrentPassword($memberid,$current_password);
        if ($isCurrentPasswordCorrect>0)
        {
            $sqlQuery = "Update members set password='".$new_password."' where id=".$memberid;
            $QueryExecutor = new ExecuteQuery();
            $result = $QueryExecutor::customQuery($sqlQuery);


            if ($result>0)
            {
                $response = array("status"=>"success","msg"=>"Your password has been successfully updated.");
            }else{
                $response = array("status"=>"error","msg"=>"An error occurred updating your password. Please contact the administrator.");
            }

        }else
        {
            $response = array("status"=>"error","msg"=>"The current password supplied is wrong.");
        }

        return $response;
    }

    private function checkCurrentPassword($memberid,$current_password)
    {
        $sqlQuery = "Select id from members where id=".$memberid." and password='".$current_password."'";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        $numOfRecords = $result->num_rows;

        return $numOfRecords;

    }


}



?>




}
