<?php
namespace Classes;

// This class is designed to login admins and users.

class Login extends QueryExecute
{
	// admin login methods  ********************************************************************
	
	protected function setAdminLoginCookie($adminId)
	{
		$cookieName = 'admin_remember';
		$cookieValue = rand(10000, 99999).rand(10000, 99999).date('dmYHis');
		$query = "UPDATE admins SET remember = '$cookieValue' WHERE id = $adminId";
		$this->executeQuery($query);
		setcookie($cookieName, $cookieValue, strtotime('+ 1 week'), null, null, false, true);
	}
	
	protected function setAdminSession($resultRow)
	{
		$_SESSION['adminId'] = $resultRow['id'];
		$_SESSION['adminFirstName'] = $resultRow['first_name'];
		$_SESSION['adminLastName'] = $resultRow['last_name'];
		$_SESSION['adminUsername'] = $resultRow['username'];
		$_SESSION['adminEmail'] = $resultRow['email'];
	}
	
	public function loginAdmin($email, $password, $remember)
	{
		if(empty($email) || empty($password)) return 'All fields are required.';
		
		$email = mysqli_real_escape_string($this->dbLink, $email);
		$query = "SELECT id, first_name, last_name, username, email, password FROM admins WHERE email = '$email'";
		$result = $this->executeQuery($query);
		$resultRow = mysqli_fetch_assoc($result);
		
		if(!$resultRow) return 'Unknown email address.';
		
		if(!password_verify($password, $resultRow['password']))
		{
			return 'Password didn\'t match.';
		}
	
		$this->setAdminSession($resultRow);
		if($remember) $this->setAdminLoginCookie($resultRow['id']);
		header('Location: dashboard.php');
		die;
	}
	
	public function adminLoginCheck()
	{
		$loggedIn = false;
		$indexPage = strpos($_SERVER['SCRIPT_NAME'], 'index.php');
		
		if(isset($_SESSION['adminId']))
		{
			$loggedIn = true;
		}
		else if(isset($_COOKIE['admin_remember']))
		{
			$remember = mysqli_real_escape_string($this->dbLink, $_COOKIE['admin_remember']);
			$query = "SELECT id, first_name, last_name, username, email FROM admins WHERE remember = '$remember'";
			$result = $this->executeQuery($query);
			$resultRow = mysqli_fetch_assoc($result);
			
			if($resultRow)
			{
				$this->setAdminLoginCookie($resultRow['id']); // renew cookie to renew time
				$this->setAdminSession($resultRow);
				$loggedIn = true;
			}
		}
		
		if(!$loggedIn && $indexPage === false)
		{
			header('Location: index.php');
			die;
		}
		else if($loggedIn && $indexPage !== false)
		{
			header('Location: dashboard.php');
			die;
		}
	}
	
	// user login methods ********************************************************************
	
	protected function setUserSession($userInfo)
	{
		$_SESSION['userId'] = $userInfo['id'];
		$_SESSION['userFirstName'] = $userInfo['first_name'];
		$_SESSION['userLastName'] = $userInfo['last_name'];
		$_SESSION['userUsername'] = $userInfo['username'];
		$_SESSION['userEmail'] = $userInfo['email'];
	}
	
	protected function setUserLoginCookie($userId)
	{
		$cookieName = 'user_remember';
		$cookieValue = date('dmYHis').rand(10000, 99999).rand(10000, 99999);
		$query = "UPDATE users SET remember = '$cookieValue' WHERE id = $userId";
		$this->executeQuery($query);
		setcookie($cookieName, $cookieValue, strtotime('+ 1 week'), "/", null, false, true);
	}
	
	public function loginUser($email, $password, $remember)
	{
		// check and get user info
		if(empty($email) || empty($password)) return 'All fields are required.';
		
		$email = mysqli_real_escape_string($this->dbLink, $email);
		$query = "SELECT id, username, first_name, last_name, email, password FROM users WHERE email = '$email'";
		$queryResult = $this->executeQuery($query);
		$queryRow = mysqli_fetch_assoc($queryResult);
		
		if(!$queryRow) return 'Unknown email given.';
		
		if(!password_verify($password, $queryRow['password']))
		{
			return 'Password didn\'t match.';
		}
		
		// set session and cookie
		$this->setUserSession($queryRow);
		if($remember) $this->setUserLoginCookie($queryRow['id']);
		
		// set a session message message and go to home page
		$_SESSION['message'] = 'You\'re signed in successfully.';
		header('Location: /');
		die;
	}
	
	public function userLoginCheck()
	{
		if(isset($_SESSION['userId'])) return true;
		if(!isset($_COOKIE['user_remember'])) return false;

		$remember = mysqli_real_escape_string($this->dbLink, $_COOKIE['user_remember']);
		$query = "SELECT id, first_name, last_name, username, email FROM users WHERE remember = '$remember'";
		$queryResult = $this->executeQuery($query);
		$queryRow = mysqli_fetch_assoc($queryResult);
	
		if(!$queryRow) return false;

		$this->setUserSession($queryRow);
		$this->setUserLoginCookie($queryRow['id']); // renew cookie to renew time
		
		return true;
	}
}
?>