<?php
namespace Classes;

class Admin extends QueryExecute
{
	use FileCheck;
	
	// admin managing methods ******************************************
	
	// 'adminId' parameter is needed to update admin information
	protected function checkAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword, $adminId = 0)
	{	
		if(empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($rePassword)) return 'All text fields are required.';
		
		if(strlen($firstName) > 42 || strlen($lastName) > 42 || strlen($username) > 50 || strlen($password) > 72) return 'Form field maxlength exceeded.';
		
		if($password != $rePassword) return 'Password didn\'t match.';
		
		if(!preg_match('/^[[:word:].]*$/', $username)) return 'Use only word characters and dot for username.';
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Enter a valid email.';
		
		$query = "SELECT id FROM admins WHERE username = '$username' AND id != $adminId";
		$queryResult = $this->executeQuery($query);
		
		if(mysqli_num_rows($queryResult)) return 'Username already exist.';
		
		$query = "SELECT id FROM admins WHERE email = '$email' AND id != $adminId";
		$queryResult = $this->executeQuery($query);
		
		if(mysqli_num_rows($queryResult)) return 'Email already exist.';
		
		return 1;
	}
	
	public function saveAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword)
	{
		// check given admin informations
		$infoResult = $this->checkAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword);
		if($infoResult != 1) return $infoResult;
		
		// check and save image if uploaded
		if(isset($_FILES['image']) && $_FILES['image']['error'] != 4)
		{
			// check the image
			$imageResult = $this->checkUploadedFile('image', 'image', 2);
			if($imageResult != 1) return $imageResult;
			// save the image
			$fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$imageName = rand(10000, 99999).date('dmYHis').rand(10000, 99999).'.'.$fileExtension;
			$targetFile = '../assets/admin_images/'.$imageName;
			$tempFile = $_FILES['image']['tmp_name'];
			
			if(file_exists($targetFile) || !move_uploaded_file($tempFile, $targetFile))
			{
				return 'Failed to save file, please try again.';
			}
		}
		
		// save admin information to database
		$firstName = mysqli_real_escape_string($this->dbLink, $firstName);
		$lastName = mysqli_real_escape_string($this->dbLink, $lastName);
		$password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
		
		if(isset($imageName))
		{
			$query = "INSERT INTO admins (first_name, last_name, username, email, password, image) VALUES ('$firstName', '$lastName', '$username', '$email', '$password', '$imageName')";
		}
		else
		{
			$query = "INSERT INTO admins (first_name, last_name, username, email, password) VALUES ('$firstName', '$lastName', '$username', '$email', '$password')";
		}
		
		$this->executeQuery($query);
		
		// return to manage admin page with a message
		$_SESSION['message'] = 'Admin added successfully.';
		header('Location: manage-admins.php');
		die;
	}
	
	public function updateAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword, $adminId)
	{
		// check given admin informations
		$infoResult = $this->checkAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword, $adminId);
		if($infoResult != 1) return $infoResult;
		
		// check and save image if uploaded and delete old image if any
		if(isset($_FILES['image']) && $_FILES['image']['error'] != 4)
		{
			// check the new image
			$imageResult = $this->checkUploadedFile('image', 'image', 2);
			if($imageResult != 1) return $imageResult;
			
			// save the new image
			$fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$imageName = rand(10000, 99999).date('dmYHis').rand(10000, 99999).'.'.$fileExtension;
			$destination = '../assets/admin_images/';
			$targetFile = $destination.$imageName;
			$tempFile = $_FILES['image']['tmp_name'];
			
			if(file_exists($targetFile) || !move_uploaded_file($tempFile, $targetFile))
			{
				return 'Failed to save file, please try again.';
			}
			
			// delete the old image 
			$query = "SELECT image FROM admins WHERE id = $adminId";
			$queryResult = $this->executeQuery($query);
			$oldImage = mysqli_fetch_row($queryResult)[0];
			if($oldImage != null) unlink($destination.$oldImage);
		}
		
		// update admin information on database
		$firstName = mysqli_real_escape_string($this->dbLink, $firstName);
		$lastName = mysqli_real_escape_string($this->dbLink, $lastName);
		$password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
		
		if(isset($imageName))
		{
			$query = "UPDATE admins SET first_name = '$firstName', last_name = '$lastName', username = '$username', email = '$email', password = '$password', image = '$imageName' WHERE id = $adminId";
		}
		else
		{
			$query = "UPDATE admins SET first_name = '$firstName', last_name = '$lastName', username = '$username', email = '$email', password = '$password' WHERE id = $adminId";
		}
		
		$this->executeQuery($query);
		
		// return to 'manage-admins.php' page with a message
		$_SESSION['message'] = 'Admin info updated successfully.';
		header('Location: manage-admins.php');
		die;
	}
	
	public function deleteAdminInfo($deleteId, $deleteKey)
	{
		if($deleteId != 1 && $_SESSION['adminDeleteKey'] == $deleteKey)
		{
			$adminId = (int)$_POST['delete_id'];
			$query = "SELECT image FROM admins WHERE id = $adminId";
			$queryResult = $this->executeQuery($query);
			
			if($queryResult)
			{
				// delete all the posts of the admin
				$query = "DELETE FROM posts WHERE author_id = $adminId";
				$this->executeQuery($query);
				// delete the admin image
				$imageName = mysqli_fetch_row($queryResult)[0];
				if($imageName) unlink('../assets/admin_images/'.$imageName);
				// delete the admin info row
				$query = "DELETE FROM admins WHERE id = $adminId";
				$this->executeQuery($query);
				// set a message to view in 'manage-admins.php' page
				$_SESSION['message'] = 'Admin deleted successfully.';
				header('Location: '.$_SERVER['HTTP_REFERER']);
				die;
			}
			else $_SESSION['message'] = 'Unknown admin to delete.';
		}
		else $_SESSION['message'] = 'Admin can not be deleted.';
	}
	
	// admin info getter methods ************************************************
	
	public function getAdminInfoById($adminId)
	{
		$query = "SELECT first_name, last_name, username, email, image FROM admins WHERE id = $adminId";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
	
	public function getNumberOfAdmins()
	{
		$query = "SELECT id FROM admins";
		$queryResult = $this->executeQuery($query);
		return mysqli_num_rows($queryResult);
	}
	
	public function getCurrentPageAdminsInfo($pageNo, $adminPerPage)
	{
		$start = ($pageNo - 1) * $adminPerPage;
		$query = "SELECT * FROM admins LIMIT $start, $adminPerPage";
		return $this->executeQuery($query);
	}
	
	public function getNumberOfPostsOfOneAdmin($adminId)
	{
		$query = "SELECT id FROM posts WHERE author_id = $adminId";
		$queryResult = $this->executeQuery($query);
		return mysqli_num_rows($queryResult);
	}
}
?>