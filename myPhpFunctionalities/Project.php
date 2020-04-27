<?php

class Project
{
	

	public function createproject($longname,$shortname)
	{

		    $nameExist = $this->nameAlreadyExist($longname);
		    $reponse = '';

		    if ($nameExist==0)
		    {
		    	$sqlQuery = "Insert into projects(name,code)values('".$longname."','".$shortname."')";
				$QueryExecutor = new ExecuteQuery();
      			$result = $QueryExecutor::customQuery($sqlQuery);

      			if ($result>0)
      			{
      				$response = array("status"=>"success","msg"=>"Project [<strong>".$longname."</strong>] has been successfully created.");
      			}else{
      				$response = array("status"=>"error","msg"=>"An error occurred creating the project. Please contact the Administrator.");
      			}
      			
      			
		    }else{
		    	$response = array("status"=>"error","msg"=>"A project with that name already exist.");
		    }
			
			return $response;

	}

	private function nameAlreadyExist($longname)
	{
			$sqlQuery = "Select id from projects where name='".$longname."'";
			$QueryExecutor = new ExecuteQuery();
      		$result = $QueryExecutor::customQuery($sqlQuery);
      		$numOfRec = $result->num_rows;
      		
      		return $numOfRec;

	}

	public function getAllProject()
	{
		$sqlQuery = "Select id,name,code,datecreated from projects order by id desc";
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);
      	return $result;

	}

	public function getProductById($projectid)
	{
		$sqlQuery = "Select id,name,code,datecreated from projects where id=".$projectid;
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);
      	return $result;

	}

	public function updateProject($projectid,$name,$code)
	{
		$sqlQuery = "update projects set name='".$name."',code='".$code."' where id=".$projectid;
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);
      	$response = '';
      	if ($result>0)
      	{
      		
      		$response = array("status"=>"success","msg"=>"The project has been successfully updated.");
      	}else{
      		
      		$response = array("status"=>"error","msg"=>"An error occurred updating the project");
      	}
      	return $response;
	}	


	public function assign_project_user($projectid,$userid)
	{

		$sqlQuery = "Insert into projects_users(projectid,userid)values('".$projectid."','".$userid."')";
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);
      	$response = '';
      	if ($result>0)
      	{
      		
      		$response = array("status"=>"success","msg"=>"The selected User has been successfully assigned to the Project.");
      	}else{
      		
      		$response = array("status"=>"error","msg"=>"An error occurred assigning the user to the project");
      	}
      	return $response;
	}



	public function getAllProjectsUsers()
	{
		$sqlQuery = "Select p.id,p.name,p.code,u.id,u.lastname,u.firstname,u.role from projects_users up inner join projects p on up.projectid=p.id inner join members u on up.userid=u.id order by up.id desc";
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);
      	return $result;

	}


	public function deleteProject($projectid)
	{
		$sqlQuery = "Delete from projects where id=".$projectid;
		$QueryExecutor = new ExecuteQuery();
      	$result = $QueryExecutor::customQuery($sqlQuery);

	}
}

?>