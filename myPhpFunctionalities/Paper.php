<?php

class Paper
{

    public function submitPaper($fields)
    {
        $projectid = $fields['projectid'];
        $title = $fields['title'];
        $description = $fields['description'];
        $file = $fields['file'];
        $submitedby = $fields['submitedby'];

        $sqlQuery = "Insert into submit_papers(projectid,title,description,file,submitedby)values('".$projectid."','".$title."','".$description."','".$file."','".$submitedby."')";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        $response = '';
        if ($result>0)
        {

            $response = array("status"=>"success","msg"=>"The paper [".$title."] has been submitted successfully.");
        }else{

            $response = array("status"=>"error","msg"=>"An error occurred submitting the paper [".$title."]");
        }
        return $response;

    }



    public function getAllSubmitedPapers()
    {
        $sqlQuery = "Select p.id,pr.name,p.title,p.description,p.file,p.datesubmitted,p.status FROM submit_papers p inner join projects pr on p.projectid=pr.id order by p.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;

    }

    public function SubmitedPapersByMember($userid)
    {
        $sqlQuery = "Select p.id,pr.name,p.title,p.description,p.file,p.datesubmitted,p.status FROM submit_papers p inner join projects pr on p.projectid=pr.id where submitedby=".$userid." order by p.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;
    }

    public function getPaperById($paperid)
    {
        $sqlQuery = "Select p.id,pr.name,p.title,p.description,p.file,m.id as userid,m.lastname,m.firstname, p.datesubmitted,p.status FROM submit_papers p inner join projects pr on p.projectid=pr.id inner join members m on p.submitedby=m.id where p.id=".$paperid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;

    }

    public function AssignReviewer($fields)
    {
        $paperid = $fields['paperid'];
        $userid = $fields['userid'];
        $duration = $fields['duration'];

        $sqlQuery = "Insert into paper_assigned(paperid,userid,duration)values('".$paperid."','".$userid."','".$duration."')";

        $isPaperAssignedToSameUser = $this->checkPaperAssignToSameUser($paperid,$userid);

        if ($isPaperAssignedToSameUser==0)
        {
            $QueryExecutor = new ExecuteQuery();
            $result = $QueryExecutor::customQuery($sqlQuery);
            $response = '';
            if ($result>0)
            {

                $response = array("status"=>"success","msg"=>"The paper has been successfully assigned to the selected reviewer.");


                $parameter='r';
                $this->updatePaperStatus($paperid,$parameter);
            }else{

                $response = array("status"=>"error","msg"=>"An error occurred assigning the paper to the selected reviewer");
            }
        }
        else{
            $response = array("status"=>"error","msg"=>"The paper has already been assigned to the selected reviewer.");
        }

        return $response;

    }

    public function checkPaperAssignToSameUser($paperid,$userid)
    {
        $sqlQuery = "Select * from paper_assigned where paperid=".$paperid." and userid=".$userid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        $recordFound = $result->num_rows;
        return $recordFound;

    }


    public function updatePaperStatus($paperid,$parameter)
    {
        $sqlQuery = "update submit_papers set status='".$parameter."' where id=".$paperid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
    }


    public function getReviewersToPaper($paperid)
    {
        $sqlQuery = "Select pa.id, pa.paperid, m.id as userid,m.lastname,m.firstname,pa.duration,pa.dateassigned from paper_assigned pa inner join members m on pa.userid=m.id where pa.paperid=".$paperid." order by pa.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;
    }


    public function getAllPapersInReview()
    {
        $sqlQuery = "SELECT sp.id,p.name,sp.title,sp.description,sp.file,m.id as memberid,m.lastname,m.firstname,sp.status as submit_status, pa.status as review_status from submit_papers sp inner join projects p on sp.projectid=p.id inner join members m on sp.submitedby=m.id left join paper_assigned pa on sp.id=pa.paperid where sp.status='r' order by sp.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;
    }

    public function MemberAssignedPapersInReview($userid)
    {
        $sqlQuery = "SELECT sp.id,p.name,sp.title,sp.description,sp.file,m.id as memberid,m.lastname,m.firstname,sp.status as submit_status, pa.status as review_status from submit_papers sp inner join projects p on sp.projectid=p.id inner join members m on sp.submitedby=m.id left join paper_assigned pa on sp.id=pa.paperid where pa.userid=".$userid." and pa.status='' order by sp.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);

        return $result;
    }


    public function submitReview($fields)
    {
        $paperid = $fields['paperid'];
        $submitedby = $fields['submitedby'];
        $comment = $fields['comment'];
        $file = $fields['file'];
        $sqlQuery = "Insert into reviews(paperid,submitedby,comment,file)values('".$paperid."','".$submitedby."','".$comment."','".$file."')";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        $response = '';
        if ($result>0)
        {

            $response = array("status"=>"success","msg"=>"The review has been submitted successfully.");
            $this->updatePaperAssignedStatus($paperid,$submitedby);

        }else{

            $response = array("status"=>"error","msg"=>"An error occurred submitting the review");
        }
        return $response;

    }



    public function updatePaperAssignedStatus($paperid,$userid)
    {
        $sqlQuery = "update paper_assigned set status='c' where paperid=".$paperid." and userid=".$userid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);

    }


    public function ReviewedPapersByMember($userid)
    {
        $sqlQuery = "SELECT p.id as paperid,p.id as projectid, pr.name, p.title, p.projectid,p.description,p.file,p.submitedby,p.datesubmitted,m.id as memberid,m.lastname,m.firstname,m.photo,pa.duration,pa.dateassigned,pa.status from paper_assigned pa inner join submit_papers p on pa.paperid=p.id inner join projects pr on p.projectid=pr.id inner join members m on pa.userid=m.id where pa.userid=".$userid." and pa.status='c' order by pa.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;
    }


    public function ReviewedPapers()
    {
        $sqlQuery = "SELECT p.id as paperid,p.id as projectid, pr.name, p.title, p.projectid,p.description,p.file,p.submitedby,p.datesubmitted,m.id as memberid,m.lastname,m.firstname,m.photo,m.role,pa.duration,pa.dateassigned,pa.status,r.comment,r.file as reviewedfile,r.datecreated as reviewdate from paper_assigned pa inner join submit_papers p on pa.paperid=p.id inner join projects pr on p.projectid=pr.id inner join members m on pa.userid=m.id inner join reviews r on p.id=r.paperid where pa.status='c' order by pa.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);
        return $result;
    }


    public function paperReviewByMember($paperid,$userid)
    {

        $sqlQuery = "SELECT r.id as reviewid,p.projectid,p.id as paperid,p.title,p.description,p.file,p.datesubmitted,m.id as memberid,m.lastname,m.firstname,m.photo,r.comment,r.file,r.datecreated from reviews r inner join submit_papers p on  r.paperid=p.id inner join members m on r.submitedby=m.id where r.paperid=".$paperid." and r.submitedby='".$userid."' order by r.id desc";
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);

        return $result;
    }

    //      delete paper functionality
    public function deletePaper($paperid)
    {
        $sqlQuery = "Delete from paper_assigned where id=".$paperid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);

    }
}

?>