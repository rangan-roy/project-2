<?php
namespace Classes;

class Elsewhere extends QueryExecute
{	
	// 'elsewhereId' parameter is needed to update elsewheres
	protected function checkElsewhereInfo($elsewhereName, $elsewhereUrl, $elsewhereId = 0)
	{
		if(empty($elsewhereName) || empty($elsewhereUrl)) return 'All fields are required.';
		
		if(strlen($elsewhereName) > 42 || strlen($elsewhereUrl) > 255) return 'Form field maxlength exceeded.';
	
		if(!filter_var($elsewhereUrl, FILTER_VALIDATE_URL)) return 'Enter a valid url.';
		
		$elsewhereName = mysqli_real_escape_string($this->dbLink, $elsewhereName);
		$query = "SELECT name FROM elsewheres WHERE name = '$elsewhereName' AND id != $elsewhereId";
		$result = $this->executeQuery($query);
	
		if(mysqli_num_rows($result)) return 'Elsewhere name already exist.';

		$query = "SELECT name FROM elsewheres WHERE url = '$elsewhereUrl' AND id != $elsewhereId";
		$result = $this->executeQuery($query);

		if(mysqli_num_rows($result)) return 'Elsewhere url already exist.';
		
		return 1;
	}
	
	public function saveElsewhereInfo($elsewhereName, $elsewhereUrl)
	{	
		// check elsewhere info
		$infoResult = $this->checkElsewhereInfo($elsewhereName, $elsewhereUrl);
		if($infoResult != 1) return $infoResult;
		
		// save elsewhere info
		$elsewhereName = mysqli_real_escape_string($this->dbLink, $elsewhereName);
		$query = "INSERT INTO elsewheres (name, url) VALUES ('$elsewhereName', '$elsewhereUrl')";
		$this->executeQuery($query);
		
		// set a session message and go to 'manage-elsewheres.php' page
		$_SESSION['message'] = 'Elsewhere added successfully.';
		header('Location: manage-elsewheres.php');
		die;
	}
	
	public function updateElsewhereInfo($elsewhereName, $elsewhereUrl, $elsewhereId)
	{
		// check elsewhere info
		$infoResult = $this->checkElsewhereInfo($elsewhereName, $elsewhereUrl, $elsewhereId);
		if($infoResult != 1) return $infoResult;
		
		// save elsewhere info
		$elsewhereName = mysqli_real_escape_string($this->dbLink, $elsewhereName);
		$query = "UPDATE elsewheres SET name = '$elsewhereName', url = '$elsewhereUrl' WHERE id = $elsewhereId";
		$this->executeQuery($query);
		
		// set a session message and go to 'manage-elsewheres.php' page
		$_SESSION['message'] = 'Elsewhere updated successfully.';
		header('Location: manage-elsewheres.php');
		die;
	}
	
	public function deleteElsewhereById($elsewhereId)
	{
		$query = "SELECT id FROM elsewheres WHERE id = $elsewhereId";
		$queryResult = $this->executeQuery($query);
		
		if(mysqli_num_rows($queryResult))
		{
			$query = "DELETE FROM elsewheres WHERE id = $elsewhereId";
			$this->executeQuery($query);
			$_SESSION['message'] = 'Elsewhere deleted successfully.';
		}
		else $_SESSION['message'] = 'Unknown elsewhere to delete.';
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else header('Location: manage-elsewheres.php');
		
		die;
	}
	
	public function getNumberOfElsewheres()
	{
		$query = "SELECT id FROM elsewheres";
		$result = $this->executeQuery($query);
		return mysqli_num_rows($result);
	}
	
	public function getCurrentPageElsewheresInfo($pageNo, $elsewheresPerPage)
	{
		$start = ($pageNo - 1) * $elsewheresPerPage;
		$query = "SELECT * FROM elsewheres LIMIT $start, $elsewheresPerPage";
		return $this->executeQuery($query);
	}
	
	public function getElsewhereInfoById($elsewhereId)
	{
		$query = "SELECT name, url FROM elsewheres WHERE id = $elsewhereId";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
}
?>