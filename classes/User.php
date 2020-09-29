<?php
namespace Classes;

class User extends QueryExecute
{
	use FileCheck;
	
	// user creating and updating methods ********************************************************
	
	public function checkUserInfo($firstName, $lastName, $username, $email, $password, $rePassword, $captcha)
	{
	    if($captcha != $_SESSION['captcha']) return 'Captcha code didn\'t match.';
	    
		if(empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($rePassword))
		{
			return 'All fields are required.';
		}

		if(strlen($firstName) > 42 || strlen($lastName) > 42 || strlen($username) > 50 || strlen($password) > 72)
		{
			return 'Form field maxlength exceeded.';
		}
		
		if($password != $rePassword) return 'Password didn\'t match.';
		
		if(!preg_match('/^[[:word:].]*$/', $username))
		{
			return 'Use only word characters and dot for username.';
		}
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Enter a valid email.';
		
		$query = "SELECT id FROM users WHERE username = '$username'";
		$result = $this->executeQuery($query);
		
		if(mysqli_num_rows($result)) return 'Username already exist.';
		
		$query = "SELECT id FROM users WHERE email = '$email'";
		$result = $this->executeQuery($query);
		
		if(mysqli_num_rows($result)) return 'Email already exist.';
		
		$_SESSION['userFirstName'] = $firstName;
		$_SESSION['userLastName'] = $lastName;
		$_SESSION['userUsername'] = $username;
		$_SESSION['userEmail'] = $email;
		$_SESSION['userPassword'] = $password;
		
		header('Location: email-validate.php');
		die;
	}
	
	public function saveUserInfo($firstName, $lastName, $username, $email, $password)
	{
		// process and save user info
		$firstName = mysqli_real_escape_string($this->dbLink, $firstName);
		$lastName = mysqli_real_escape_string($this->dbLink, $lastName);
		$password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
		$query = "INSERT INTO users (first_name, last_name, username, email, password) VALUES ('$firstName', '$lastName', '$username', '$email', '$password')";
		$this->executeQuery($query);
		
		// set a session message and go to signin.php page
		$_SESSION['message'] = 'Account created successfully.';
		header('Location: signin.php');
		die;
	}
	
	public function updateUserInfo($firstName, $lastName, $fileName)
	{
	    if(empty($firstName) || empty($lastName))
	    {
	        return 'Text fields are required.';
	    }
	    
		if($_FILES[$fileName]['error'] != 4)
		{
			// check the new image
			$imageResult = $this->checkUploadedFile($fileName, 'image', 2);
			if($imageResult != 1) return $imageResult;
			
			// save the new image
			$fileExtension = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
			$imageName = rand(10000, 99999).date('dmYHis').rand(10000, 99999).'.'.$fileExtension;
			$directory = $_SERVER['DOCUMENT_ROOT'].'/assets/user_images/';
			$targetFile = $directory.$imageName;
			$tempFile = $_FILES[$fileName]['tmp_name'];
			
			if(file_exists($targetFile) || !move_uploaded_file($tempFile, $targetFile))
			{
				return 'Failed to save file, please try again.';
			}
			
			// get the old image
			$query = "SELECT image FROM users WHERE id = $_SESSION[userId]";
			$queryResult = $this->executeQuery($query);
			$oldImage = mysqli_fetch_assoc($queryResult)['image'];
		}
		
		// update user info
		$userId = $_SESSION['userId'];
		$firstName = mysqli_real_escape_string($this->dbLink, $firstName);
		$lastName = mysqli_real_escape_string($this->dbLink, $lastName);
		
		if(isset($imageName))
		{
			$query = "UPDATE users SET first_name = '$firstName', last_name = '$lastName', image = '$imageName' WHERE id = $userId";
		}
		else
		{
			$query = "UPDATE users SET first_name = '$firstName', last_name = '$lastName' WHERE id = $userId";
		}
		
		$this->executeQuery($query);
		
		if(isset($oldImage) && $oldImage != null)
		{
		    unlink($directory.$oldImage);
		}
		
		$_SESSION['message'] = 'Your profile updated successfully.';
		header('Location: /');
		die;
	}
	
	public function updateUserPasswordByEmail($email, $newPassword)
    {
    	$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 15]);
    	$query = "UPDATE users SET password = '$passwordHash' WHERE email = '$email'";
    	$this->executeQuery($query);
    }
	
	// user comment managing methods ************************************
	
	public function saveUserComment($comment, $postId)
	{
		if(empty($comment))
		{
		   $_SESSION['message'] = 'Comment can\'t be empty.'; 
		}
		else if(strlen($comment) > 1000)
		{
		    $_SESSION['message'] = 'Comment length exceeded maxlength.';
		}
		else
		{
		    $comment = mysqli_real_escape_string($this->dbLink, $comment);
		    date_default_timezone_set('Asia/Dhaka');
		    $time = date('g:i:sa');
		    $date = date('Y-m-d');
			$query = "INSERT INTO comments (post_id, user_id, comment, time, date) VALUES ($postId, $_SESSION[userId], '$comment', '$time', '$date')";
			$this->executeQuery($query);
			$_SESSION['message'] = 'You have commented successfully.';
		}
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
		die;
	}
	
    public function updateUserComment($comment, $commentId, $userId)
    {
        $_SESSION['comment'] = $comment;
        
    	if($userId != $_SESSION['userId'])
    	{
    		$_SESSION['message'] = 'You don\'t have the right to update the comment.';
    	}
    	else if(empty($comment))
    	{
    		$_SESSION['message'] = 'Comment can\'t be empty.';
    	}
    	else if(strlen($comment) > 1000)
    	{
    		$_SESSION['message'] = 'Comment length exceeded maxlength.';
    	}
    	else
    	{
    	    $comment = mysqli_real_escape_string($this->dbLink, $comment);
    	    $query = "UPDATE comments SET comment = '$comment' WHERE id = $commentId";
    	    $this->executeQuery($query);
    	    $_SESSION['message'] = 'Comment updated successfully.';
    	}
    	
    	header('Location: '.$_SERVER['HTTP_REFERER']);
    	die;
    }
    
    public function saveUserReply($reply, $commentId)
	{
	    if(empty($reply))
	    {
	        $_SESSION['message'] = 'Reply can\'t be empty.';
	    }
	    else if(strlen($reply) > 1000)
	    {
	        $_SESSION['message'] = 'Reply length exceeded maxlength.';
	    }
	    else
	    {
		    $reply = mysqli_real_escape_string($this->dbLink, $reply);
		    date_default_timezone_set('Asia/Dhaka');
		    $time = date('g:i:sa');
		    $date = date('Y-m-d');
			$query = "INSERT INTO replies (comment_id, user_id, reply, time, date) VALUES ($commentId, $_SESSION[userId], '$reply', '$time', '$date')";
			$this->executeQuery($query);
			$_SESSION['message'] = 'You have replied successfully.';
		}
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
		die;
	}
	
	public function updateUserReply($reply, $replyId, $userId)
    {
        $_SESSION['reply'] = $reply;
        
    	if($userId != $_SESSION['userId'])
    	{
    		$_SESSION['message'] = 'You don\'t have the right to update the reply.';
    	}
    	else if(empty($reply))
    	{
    		$_SESSION['message'] =  'Reply can\'t be empty.';
    	}
    	else if(strlen($reply) > 1000)
    	{
    		$_SESSION['message'] =  'Reply length exceeded maxlength.';
    	}
    	else
    	{
    	    $reply = mysqli_real_escape_string($this->dbLink, $reply);
    	    $query = "UPDATE replies SET reply = '$reply' WHERE id = $replyId";
    	    $this->executeQuery($query);
    	    $_SESSION['message'] = 'Reply updated successfully.';
    	}
    	
    	header('Location: '.$_SERVER['HTTP_REFERER']);
    	die;
    }
    
    public function deleteCommentById($commentId)
    {
        $query = "SELECT user_id FROM comments WHERE id = $commentId";
        $queryResult = $this->executeQuery($query);
        $commentInfo = mysqli_fetch_assoc($queryResult);
        
        if($commentInfo)
        {
            if($commentInfo['user_id'] == $_SESSION['userId'])
            {
                $query="DELETE FROM replies WHERE comment_id = $commentId";
                $this->executeQuery($query);
                $query="DELETE FROM comments WHERE id = $commentId";
                $this->executeQuery($query);
                $_SESSION['message'] = 'Comment deleted successfully.';
            }
            else $_SESSION['message'] = 'You don\'t have the right to delete the comment.';
        }
        else $_SESSION['message'] = 'Unknown comment to delete.';
        
        if(isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        else header('Location: /');
        
        die;
    }
    
    public function deleteReplyById($replyId)
    {
        $query = "SELECT user_id FROM replies WHERE id = $replyId";
        $queryResult = $this->executeQuery($query);
        $replyInfo = mysqli_fetch_assoc($queryResult);
        
        if($replyInfo)
        {
            if($replyInfo['user_id'] == $_SESSION['userId'])
            {
                $query="DELETE FROM replies WHERE id = $replyId";
                $this->executeQuery($query);
                $_SESSION['message'] = 'Reply deleted successfully.';
            }
            else $_SESSION['message'] = 'You don\'t have the right to delete the reply.';
        }
        else $_SESSION['message'] = 'Unknown reply to delete.';
        
        if(isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        else header('Location: /');
        
        die;
    }
    	
	// user like managing methods ****************************************
	
	public function addPostLike($postId)
	{
		$userId = $_SESSION['userId'];
		$query = "SELECT post_id FROM likes WHERE post_id = $postId AND user_id = $userId";
		$queryResult = $this->executeQuery($query);
		$queryRow = mysqli_fetch_row($queryResult);
		
		if(!$queryRow)
		{
			$query = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId)";
			$this->executeQuery($query);
		}
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
		    header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else header('Location: single.php?post_id='.$postId);
		
		die;
	}
	
	public function removePostLike($postId)
	{
		$userId = $_SESSION['userId'];
		$query = "DELETE FROM likes WHERE post_id = $postId AND user_id = $userId";
		$this->executeQuery($query);
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
		    header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else header('Location: single.php?post_id='.$postId);
		
		die;
	}
	
	public function isLiked(\mysqli_result $allLikers)
	{
		while($userId = mysqli_fetch_assoc($allLikers)['user_id'])
		{
			if($userId == $_SESSION['userId']) return 1;
		}
		
		return 0;
	}
	
	// user info getter methods *************************************************
	
	public function getCurrentUserInfo()
	{
	    $query = "SELECT * FROM users WHERE id = $_SESSION[userId]";
	    $queryResult = $this->executeQuery($query);
	    return mysqli_fetch_assoc($queryResult);
	}
	
	public function getNumberOfComments()
	{
		$query = "SELECT id FROM comments";
		$queryResult = $this->executeQuery($query);
		return mysqli_num_rows($queryResult);
	}
	
	public function getNumberOfUsers()
	{
		$query = "SELECT id FROM users";
		$queryResult = $this->executeQuery($query);
		return mysqli_num_rows($queryResult);
	}
	
	public function checkUserByEmail($email)
    {
    	$query = "SELECT id FROM users WHERE email = '$email'";
    	$queryResult = $this->executeQuery($query);
    	return mysqli_num_rows($queryResult);
    }
}
?>