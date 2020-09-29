<?php
namespace Classes;

class Post extends QueryExecute
{
	use FileCheck;
	
	// post managing methods ********************************************************
	
	protected function savePostImage($imageName)
	{
		$directory = '../assets/post_images/';
		$targetFile = $directory.$imageName;
		$tempFile = $_FILES['image']['tmp_name'];
		
		if(file_exists($targetFile) || !move_uploaded_file($tempFile, $targetFile))
		{
			return 'Failed to save post image, please try again.';
		}
		
		return 1;
	}
	
	// insert a category and return its id or, if the 
	// category already exist then just return its id
	protected function getCategoryId($categoryName)
	{
		$query = "SELECT id FROM categories WHERE name = '$categoryName'";
		$result = $this->executeQuery($query);
		$resultRow = mysqli_fetch_assoc($result);
		
		if($resultRow == null)
		{
			$query = "INSERT INTO categories (name) VALUES ('$categoryName')";
			$this->executeQuery($query);
			return mysqli_insert_id($this->dbLink);
		}
		else return $resultRow['id'];
	}
	
	public function savePostInfo($postTitle, $postCategoryName, $postDescription)
	{
		// check post info
		if(empty($postTitle) || empty($postCategoryName) || empty($postDescription))
		{
			return 'All fields are required.';
		}
		
		if(strlen($postTitle) > 200 || strlen($postCategoryName) > 50 || strlen($postDescription > 10000))
		{
			return 'Maximum field length exceeded.';
		}
		
		// check and save the post image
		$imageResult = $this->checkUploadedFile('image', 'image', 2);
		if($imageResult != 1) return $imageResult;
		$imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		$imageName = rand(10000, 99999).date('dmYHis').rand(10000, 99999).'.'.$imageExtension;
		$imageResult = $this->savePostImage($imageName);
		if($imageResult != 1) return $imageResult;
		
		// process and save post info
		$title = mysqli_real_escape_string($this->dbLink, $postTitle);
		$categoryName = mysqli_real_escape_string($this->dbLink, $postCategoryName);
		$description = mysqli_real_escape_string($this->dbLink, $postDescription);
		$categoryId = $this->getCategoryId($categoryName);
		date_default_timezone_set('Asia/Dhaka');
		$day = date('j');
		$monthYear = date('Y-m');
		$query = "INSERT INTO posts (title, author_id, category_id, description, image, day, month_year) VALUES ('$title', $_SESSION[adminId], $categoryId, '$description', '$imageName', $day, '$monthYear')";
		$this->executeQuery($query);
		
		// set a session message and return to manage-posts.php page
		$_SESSION['message'] = 'Post added successfully.';
		header('Location: manage-posts.php');
		die;
	}
	
	// delete a category if it has no post
	protected function deleteCategoryById($categoryId)
	{
		$query = "SELECT id FROM posts WHERE category_id = $categoryId";
		$result = $this->executeQuery($query);
		
		if(mysqli_num_rows($result) == 0)
		{
			$query = "DELETE FROM categories WHERE id = $categoryId";
			$this->executeQuery($query);
		}
	}
	
	public function updatePostInfo($postTitle, $postCategoryName, $postDescription, $postId)
	{	
		// check post info
		if(empty($postTitle) || empty($postCategoryName) || empty($postDescription))
		{
			return 'All text fields are required.';
		}

		if(strlen($postTitle) > 200 || strlen($postCategoryName) > 50 || strlen($postDescription > 10000))
		{
			return 'Maximum field length exceeded.';
		}
		
		// check and save post image if uploaded (updated) and
		// also delete the old image 
		if($_FILES['image']['error'] != 4)
		{
			// check uploaded image
			$imageResult = $this->checkUploadedFile('image', 'image', 2);
			if($imageResult != 1) return $imageResult;
			// get the old image name
			$query = "SELECT image FROM posts WHERE id = $postId";
			$result = $this->executeQuery($query);
			$oldImage = mysqli_fetch_assoc($result)['image'];
			// save the uploaded image
			$imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$imageName = rand(10000, 99999).date('dmYHis').rand(10000, 99999).'.'.$imageExtension;
			$imageResult = $this->savePostImage($imageName);
			if($imageResult != 1) return $imageResult;
			// delete old image
			unlink('../assets/post_images/'.$oldImage);
		}
		
		// process post info
		$title = mysqli_real_escape_string($this->dbLink, $postTitle);
		$categoryName = mysqli_real_escape_string($this->dbLink, $postCategoryName);
		$description = mysqli_real_escape_string($this->dbLink, $postDescription);
		$categoryId = $this->getCategoryId($categoryName);
		
		// get the old category
		$query = "SELECT category_id FROM posts WHERE id = $postId";
		$result = $this->executeQuery($query);
		$oldCategoryId = mysqli_fetch_assoc($result)['category_id'];
		
		// save post info
		if(isset($imageName))
		{
			$query = "UPDATE posts SET title = '$title', category_id = '$categoryId', description = '$description', image = '$imageName' WHERE id = $postId";
		}
		else
		{
			$query = "UPDATE posts SET title = '$title', category_id = '$categoryId', description = '$description' WHERE id = $postId";
		}
		
		$this->executeQuery($query);
		
		if($categoryId != $oldCategoryId)
		{
			// delete the old category if it has no post
			$this->deleteCategoryById($oldCategoryId);
		}
		
		// set a session message and return to manage-posts.php page
		$_SESSION['message'] = 'Post updated successfully.';
		header('Location: manage-posts.php');
		die;
	}
	
	public function deletePostById($postId)
	{
		$query = "SELECT author_id, category_id, image FROM posts WHERE id = $postId";
		$queryResult = $this->executeQuery($query);
		$queryRow = mysqli_fetch_assoc($queryResult);
		
		if($queryRow)
		{
			if($queryRow['author_id'] == $_SESSION['adminId'] || $_SESSION['adminId'] == 1)
			{
				// delete post info
				$query = "DELETE FROM posts WHERE id = $postId";
				$this->executeQuery($query);
				// delete post category if it has no post now
				$this->deleteCategoryById($queryRow['category_id']);
				// delete the post image
				unlink('../assets/post_images/'.$queryRow['image']);
				// set a session message
				$_SESSION['message'] = 'Post deleted successfully.';
			}
			else $_SESSION['message'] = 'You don\'t have permission to delete the post.';
		}
		else $_SESSION['message'] = 'Unknown post to delete.';
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else header('Location: manage-posts.php');
		
		die;
	}
	
	public function jumboUnjumboPostById($postId)
	{
		if($_SESSION['adminId'] == 1)
		{
			$postInfo = $this->getPostInfoById($postId);
			
			if($postInfo)
			{
				if($postInfo['is_jumbo'])
				{
					// unjumbo the preferred post
					$query = "UPDATE posts SET is_jumbo = 0 WHERE id = $postId";
					$this->executeQuery($query);
					$_SESSION['message'] = 'Post unjumboed successfully.';
				}
				else
				{
					// unjumbo the current jumbo post
					$query = "SELECT id FROM posts WHERE is_jumbo = 1";
					$queryResult = $this->executeQuery($query);
					$queryRow = mysqli_fetch_assoc($queryResult);
					
					if($queryRow)
					{
						$query = "UPDATE posts SET is_jumbo = 0 WHERE id = $queryRow[id]";
						$this->executeQuery($query);
					}
					
					// now jumbo the preferred post
					$query = "UPDATE posts SET is_jumbo = 1 WHERE id = $postId";
					$this->executeQuery($query);
					$_SESSION['message'] = 'Post jumboed successfully.';
				}
			}
			else $_SESSION['message'] = 'Unknown post to jumbo/unjumbo.';
		}
		else $_SESSION['message'] = 'You\'re not allowed to jumbo/unjumbo post.';
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else header('Location: manage-posts.php');
		
		die;
	}
	
	// post info getter methods ***************************************************
	
	public function getCurrentPagePostsOfCurrentAdmin($pageNo, $postPerPage)
	{
		$start = ($pageNo - 1) * $postPerPage;
		$query = "SELECT selected_posts.*, categories.name AS category_name, admins.username AS author_name FROM (SELECT * FROM posts WHERE posts.author_id = $_SESSION[adminId]) AS selected_posts JOIN categories ON selected_posts.category_id = categories.id JOIN admins ON selected_posts.author_id = admins.id ORDER BY id DESC LIMIT $start, $postPerPage";
		return $this->executeQuery($query);
	}
	
	public function getCurrentPagePostsOfAllAdmins($pageNo, $postPerPage)
	{
		$start = ($pageNo - 1) * $postPerPage;
		$query = "SELECT posts.*, categories.name AS category_name, admins.username AS author_name FROM  posts JOIN categories ON posts.category_id = categories.id JOIN admins ON posts.author_id = admins.id ORDER BY id DESC LIMIT $start, $postPerPage";
		return $this->executeQuery($query);
	}
	
	public function getNumberOfTotalPosts()
	{
		$query = "SELECT id FROM posts";
		$result = $this->executeQuery($query);
		return mysqli_num_rows($result);
	}
	
	public function getPostInfoById($postId)
	{
		$query = "SELECT post.*, categories.name AS category_name FROM (SELECT * FROM posts WHERE id = $postId) AS post JOIN categories ON post.category_id = categories.id";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
}
?>