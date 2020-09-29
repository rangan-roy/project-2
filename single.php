<?php
require 'includes/user-check.php';

if(empty($_GET['post_id']))
{
	header('Location: index.php');
	die;
}

use Classes\Page;
use Classes\App;
use Classes\User;

// get post info
$app = new App();
$postId = (int)$_GET['post_id'];
$postInfo = $app->getPostInfoById($postId);
// get page info
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();

if($postInfo)
{
	$message = $postInfo['title'];
	
	if($isUser) // $isUser is defined in user-check.php
	{
		$userManager = new User();
		
		if(isset($_POST['comment']))
		{
		    $comment = trim($_POST['comment']);
			$userManager->saveUserComment($comment, $postId);
		}
		else if(isset($_GET['like']))
		{
			$userManager->addPostLike($postId);
		}
		else if(isset($_GET['unlike']))
		{
			$userManager->removePostLike($postId);
		}
		else if(isset($_GET['delete_comment']))
		{
		    $commentId = (int)$_GET['delete_comment'];
		    $userManager->deleteCommentById($commentId);
		}
		else if(isset($_GET['delete_reply']))
		{
		    $replyId = (int)$_GET['delete_reply'];
		    $userManager->deleteReplyById($replyId);
		}
	}

	$allComments = $app->getAllPostComments($postId);
	$allLikers = $app->getAllPostLikers($postId);
	$totalLikes = mysqli_num_rows($allLikers);
}
else $message = 'Post not found!';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = $message;
	$pageDescription = 'large single post view page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<div class="blog-post">
					<!-- post title -->
					<h2 class="blog-post-title"><?php echo $message; ?></h2>
					<?php if($postInfo != null) { ?>
					<!-- post meta -->
					<p class="blog-post-meta">
						<?php echo $app->dateToMonthName($postInfo['month_year']).' '.$postInfo['day'].', '.(int)$postInfo['month_year']; ?>
						by <a href="/archive.php?author_id=<?php echo $postInfo['author_id']; ?>"><?php echo $postInfo['author_username']?></a>
						in <a href="/archive.php?category_id=<?php echo $postInfo['category_id']; ?>"><?php echo $postInfo['category_name']?></a>
						| <?php echo $totalLikes; ?> Likes
						<?php if($isUser) { if($userManager->isLiked($allLikers)) { ?>
						| <a href="?post_id=<?php echo $postId; ?>&unlike">Unlike</a>
						<?php } else { ?>
						| <a href="?post_id=<?php echo $postId; ?>&like">Like</a>
						<?php } } ?>
					</p>
					<!-- post image -->
					<img class="img-fluid post-img" src="/includes/watermark-image.php?image=<?php echo $postInfo['image']; ?>">
					<!-- post description -->
					<p class="mt-4"><?php echo nl2br($postInfo['description']); ?></p>
					
					<!-- start of comment section -->
					<h3 class="mt-5"><?php echo mysqli_num_rows($allComments); ?> comments</h3>
					<hr />
					
					<?php while($commentInfo = mysqli_fetch_assoc($allComments)) { ?>
					<div class="comment">
						<h5><img src="/assets/<?php if($commentInfo['image']) echo 'user_images/'.$commentInfo['image']; else echo 'images/person.jpg'?>" class="user-image"><?php echo $commentInfo['commentor']; ?></h5>
						<p><?php echo $commentInfo['comment']; ?></p>
						<p class="time">
						    <?php echo $commentInfo['time']; ?>
						    <?php echo $app->dateToMonthName($commentInfo['date']); ?>
						    <?php echo (int)substr($commentInfo['date'], 8, 2).', '; ?>
						    <?php echo (int)$commentInfo['date']; ?>
						</p>
						<?php if($isUser && $commentInfo['user_id'] == $_SESSION['userId']) { ?>
						<a href="/edit-comment.php?comment_id=<?php echo $commentInfo['id']; ?>">Edit</a> |
						<a href="?post_id=<?php echo $postId; ?>&delete_comment=<?php echo $commentInfo['id']; ?>" onclick="return confirm('Are you sure to delete the comment?')">Delete</a> |
						<?php } ?>
						<?php if($isUser) { ?>
						<a href="/all-replies.php?comment_id=<?php echo $commentInfo['id']; ?>">Reply</a>
						<?php } ?>
						
						<?php $threeReplies = $app->getCommentReplies($commentInfo['id'], 3); ?>
						
						<div class="replies ml-5">
							<?php for($i = 0; $i < 2 && $replyInfo = mysqli_fetch_assoc($threeReplies); $i++) { ?>
							<div class="single-reply">
								<h5><img src="/assets/<?php if($replyInfo['image']) echo 'user_images/'.$replyInfo['image']; else echo 'images/person.jpg'?>" class="user-image"><?php echo $replyInfo['username']; ?></h5>
								<p><?php echo $replyInfo['reply']; ?></p>
								<p class="time">
        							<?php echo $replyInfo['time']; ?>
        							<?php echo $app->dateToMonthName($replyInfo['date']); ?>
        							<?php echo (int)substr($replyInfo['date'], 8, 2).', '; ?>
        							<?php echo (int)$replyInfo['date']; ?>
        						</p>
								<?php if($isUser && $replyInfo['user_id'] == $_SESSION['userId']) { ?>
        						<a href="/edit-reply.php?reply_id=<?php echo $replyInfo['id']; ?>">Edit</a> |
        						<a href="?post_id=<?php echo $postId; ?>&delete_reply=<?php echo $replyInfo['id']; ?>" onclick="return confirm('Are you sure to delete the reply?')">Delete</a>
        						<?php } ?>
							</div>
							<hr />
							<?php } ?>
						</div>
						
						<?php if(mysqli_fetch_assoc($threeReplies)) { ?>
						<a href="/all-replies.php?comment_id=<?php echo $commentInfo['id']; ?>">View all replies</a>
						<?php } ?>
					</div>
					<hr />
					<?php } ?>
					
					<?php if($isUser) { ?>
					<form method="post" class="comment-form">
						<div class="form-group">
							<textarea class="form-control" name="comment" placeholder="Write a comment..."  rows="7" maxlength="10000" required></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Comment</button>
					</form>
					<?php } else {?>
					<p class="mt-3"><a href="/user/signin.php">Sign in<a> to comment.</p>
					<?php } ?>
					<!-- end of comment section -->
					
					<?php } ?>
				</div>
			</div>
			<?php include 'includes/aside.php'; ?>
		</div>
	</main>
	<?php include 'includes/footer.php'; ?>
</body>
</html>