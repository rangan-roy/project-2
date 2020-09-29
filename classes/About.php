<?php
namespace Classes;

class About extends QueryExecute
{
	public function updateAboutInfo($title, $description)
	{
		if(empty($title) || empty($description))
		{
			return 'All fields are required.';
		}
		
		if(strlen($title) > 50 || strlen($description) > 500)
		{
			return 'Form filed maxlength exceeded.';
		}

		$title = mysqli_real_escape_string($this->dbLink, $title);
		$description = mysqli_real_escape_string($this->dbLink, $description);
		$query = "UPDATE about SET title = '$title', description = '$description'";
		$this->executeQuery($query);
		$_SESSION['message'] = 'About updated successfully.';
		header('Location: manage-about.php');
		die;
	}
	
	public function getAboutInfo()
	{
		$query = "SELECT * FROM about";
		$queryRresult = $this->executeQuery($query);
		return mysqli_fetch_assoc($queryRresult);
	}
}
?>