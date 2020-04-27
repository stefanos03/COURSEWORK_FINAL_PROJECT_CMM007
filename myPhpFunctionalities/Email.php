<?php
// Import PHPMailer myPhpFunctionalities into the global namespace
				// These must be at the top of your script, not inside a function
				use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\Exception;

class Email
{

	private $_email;
	private $_firstname;
	private $_lastname;
	private $_fullname;
	private $_password;
	private $_message;
	private $_subject;
	private $_mailbody;
	


	public function __construct($fields)
	{
	   $this->_email = $fields['email'];
	   $this->_firstname = $fields['firstname'];
	   $this->_lastname = $fields['lastname'];
	   $this->_password = $fields['password'];
	   $this->_fullname = $this->_lastname." ".$this->_firstname;
	   $this->_message = $fields['message'];
	   $this->_subject = $fields['subject'];	
	   

	   //echo "<br/>".$this->_message;


	}//end of construct


    public function sendMail($mailcontent)
    {
        $this->_message = $mailcontent;


        require 'PHPMailer-master/src/Exception.php';
        require 'PHPMailer-master/src/PHPMailer.php';
        require 'PHPMailer-master/src/SMTP.php';


        $mail = new PHPMailer(true);
        try {

            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'stefanoschatz13@gmail.com';
            $mail->Password = 'panatha';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

//Recipients
            $mail->setFrom('rguresearchpaper@mail.com', 'RGU-RESEARCH-PAPER');
            $mail->addAddress($this->_email, $this->_fullname);     // Add a recipient


            $mail->IsHTML(true);
            $mail->AddAddress("stefanoschatz@gmail.com", "recipient-name");
            $mail->SetFrom("rguresearchpaper@gmail.com", "from-name");
            $mail->AddReplyTo("Stefan@gmail.com", "reply-to-name");
            $mail->AddCC("Projectsupport@gmail.com", "cc-recipient-name");
            $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
            $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
            ob_start();
            $mail->send();
            ob_end_clean();
            echo 'Message has been sent';
        } catch (Exception $e) {

        }
    }










	public function createMessage()
    {
        
        $content='
            <html>
             <head>
               <title>Covenear</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="https://fonts.googleapis.com/css?family=Muli|Nunito|PT+Sans|Source+Sans+Pro|Ubuntu|Pacifico" rel="stylesheet">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.JavaScript"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/JavaScript/bootstrap.min.JavaScript"></script>

             </head>
             <body style="background-color:#f1f1f1;font-family:segoe ui;font-size:13px;">

               <div class="container" style="background-color:#ffffff;" >
                  <div class="rows">
                    <div class="col-sm-2 col-sm-offset-5" style="font-family:pacifico;text-shadow: 4px 4px 4px #aaa;font-size:40px;color:#E13D3D;">
                      PreshApp
                    </div>            
                  </div>
                     
                     <div class="rows">
                        <div class="col-sm-5 col-sm-offset-4" style="font-family:;font-size:15px;font-family:Ubuntu;">
                        <hr size="1px" color="#f1f1f1">
                           <h2 style="font-family:Segoe UI;">Welcome to PreshApp</h2>
                           <em><big>Project Research Sharing Application.</big></em>
                        </div>

                        <div class="rows">
                           <div class="col-sm-5 col-sm-offset-4" style="font-family:;font-size:14px;font-family:Ubuntu">
                              <br/><br/>
                              Dear '.$this->_lastname.' '.$this->_firstname.',<br/><br/>'.$this->_message.'


                           </div>               
                        </div>


                        <div class="rows">
                           <div class="col-sm-5 col-sm-offset-4" style="font-family:;font-size:13px;font-family:Ubuntu">
                              
                              <a href="#">What is PreshApp?</a> &nbsp;&nbsp;&nbsp;<a href="#">Project Constraints</a> &nbsp;&nbsp;&nbsp; <a href="#">Functional Requirements</a>&nbsp;&nbsp;&nbsp; <a href="#">Non-Functional Requirements</a>&nbsp;&nbsp;&nbsp; <a href="#">Work Flow</a>
                           </div>
                        </div>


                        <div class="rows">

                           <div class="col-sm-5 col-sm-offset-4 text-center" style="font-family:;font-size:13px;font-family:Ubuntu">
                           <br/><br/>
                           <hr size="1px" color="#f1f1f1">
                                 Copyright &copy; 2019 PreshApp. All rights reserved.
                                 <br/><br/>
                           </div>
                        </div>

                     </div>
               </div>

             



             </body>
            </html>


            ';

            return $content;
         
    }//end of createMessage method










	
}//end of class

?>