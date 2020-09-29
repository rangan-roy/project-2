<?php
namespace Classes;

class App extends QueryExecute
{
	public function getJumboPostInfo()
	{
		$query = "SELECT id, title, description, image FROM posts WHERE is_jumbo = 1";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
	
	public function getLastPostsOfEveryCategory()
	{
		$query = "SELECT posts.* FROM (SELECT MAX(id) AS post_id FROM posts WHERE is_jumbo != 1 GROUP BY category_id) AS last_ids JOIN posts WHERE last_ids.post_id = posts.id ORDER BY post_id DESC";
		return $this->executeQuery($query);
	}
	
	public function getAllCategoriesInfo()
	{
		$query = "SELECT * FROM categories ORDER BY id ASC";
		return $this->executeQuery($query);
	}
	
	public function getAboutInfo()
	{
		$query = "SELECT * FROM about";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
	
	public function dateToMonthName($date)
	{
		$monthNo = substr($date, 5, 2);
		$allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		return $allMonths[$monthNo - 1];
	}
	
	public function getMonthArchives()
	{
		$query = "SELECT month_year FROM posts GROUP BY month_year ORDER BY id ASC";
		return $this->executeQuery($query);
	}
	
	public function getAllElsewheresInfo()
	{
		$query = "SELECT * FROM elsewheres";
		return $this->executeQuery($query);
	}
	
	public function getPostInfoById($postId)
	{
		$query = "SELECT one_post.*, categories.name AS category_name, admins.username AS author_username FROM (select * FROM posts WHERE id = $postId) AS one_post JOIN categories ON one_post.category_id = categories.id JOIN admins ON one_post.author_id = admins.id";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result);
	}
	
	public function getPostsByColumnValue($column, $value, $pageNo, $postPerPage)
	{
		$value = mysqli_real_escape_string($this->dbLink, $value);
		$start = ($pageNo - 1) * $postPerPage;
		$query = "SELECT selected_posts.*, categories.name AS category_name, admins.username AS author_username FROM (SELECT * FROM posts WHERE $column = '$value') AS selected_posts JOIN categories ON selected_posts.category_id = categories.id JOIN admins ON selected_posts.author_id = admins.id ORDER BY selected_posts.id DESC LIMIT $start, $postPerPage";
		return $this->executeQuery($query);
	}
	
	public function totalPostsByColumnValue($column, $value)
	{
		$value = mysqli_real_escape_string($this->dbLink, $value);
		$query = "SELECT id FROM posts WHERE $column = '$value'";
		$result = $this->executeQuery($query);
		return mysqli_num_rows($result);
	}
	
	public function getCategoryNameById($categoryId)
	{
		$query = "SELECT name FROM categories WHERE id = $categoryId";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result)['name'];
	}
	
	public function getAuthorNameById($adminId)
	{
		$query = "SELECT username FROM admins WHERE id = $adminId";
		$result = $this->executeQuery($query);
		return mysqli_fetch_assoc($result)['username'];
	}
	
	public function getPostsBySearch($search, $pageNo, $postPerPage)
	{
		$startingRowNo = ($pageNo - 1) * $postPerPage;
		$search = mysqli_real_escape_string($this->dbLink, $search);
		$query = "SELECT selected_posts.*, categories.name AS category_name, admins.username AS author_username FROM (SELECT * FROM posts WHERE title LIKE '%$search%') AS selected_posts JOIN categories ON selected_posts.category_id = categories.id JOIN admins ON selected_posts.author_id = admins.id ORDER BY selected_posts.id DESC LIMIT $startingRowNo, $postPerPage";
		return $this->executeQuery($query);
	}
	
	public function totalPostsBySearch($search)
	{
		$search = mysqli_real_escape_string($this->dbLink, $search);
		$query = "SELECT id FROM posts WHERE title LIKE '%$search%'";
		$queryResult = $this->executeQuery($query);
		return mysqli_num_rows($queryResult);
	}
	
	public function getAllPostComments($postId)
	{
		$query = "SELECT post_comments.*, users.username AS commentor, users.image FROM (SELECT * FROM comments WHERE post_id = $postId) AS post_comments JOIN users ON post_comments.user_id = users.id ORDER BY post_comments.id ASC";
		return $this->executeQuery($query);
	}
	
	public function getAllPostLikers($postId)
	{
		$query = "SELECT user_id FROM likes WHERE post_id = $postId";
		return $this->executeQuery($query);
	}
	
	public function getCommentInfoById($commentId)
	{
	    $query = "SELECT selected_comment.*, username, image FROM (SELECT * FROM comments WHERE id = $commentId) AS selected_comment JOIN users ON selected_comment.user_id = users.id";
	    $queryResult = $this->executeQuery($query);
	    return mysqli_fetch_assoc($queryResult);
	}
	
	public function getAllCommentReplies($commentId)
    {
    	$query = "SELECT selected_replies.*, users.username, users.image FROM (SELECT * FROM replies WHERE comment_id = $commentId) AS selected_replies JOIN users ON selected_replies.user_id = users.id ORDER BY selected_replies.id ASC";
    	return $this->executeQuery($query);
    }
    
    public function getReplyInfoById($replyId)
	{
	    $query = "SELECT * FROM replies WHERE id = $replyId";
	    $queryResult = $this->executeQuery($query);
	    return mysqli_fetch_assoc($queryResult);
	}
	
	public function getCommentReplies($commentId, $rows)
	{
	    $query = "SELECT selected_replies.*, users.username, users.image FROM (SELECT * FROM replies WHERE comment_id = $commentId) AS selected_replies JOIN users ON selected_replies.user_id = users.id ORDER BY selected_replies.id ASC LIMIT $rows";
	    return $this->executeQuery($query);
	}
}
?>