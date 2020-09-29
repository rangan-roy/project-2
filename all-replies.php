<?php
require 'includes/user-check.php';

if(empty($_GET['comment_id']))
{
	header('Location: index.php');
	die;
}

use Classes\Page;
use Classes\App;
use Classes\User;

// get post info
$app = new App();
$commentId = (int)$_GET['comment_id'];
$commentInfo = $app->getCommentInfoById($commentId);

// get page info
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();

if($commentInfo)
{
	if($isUser)
	{
	    $user = new User();
	    
	    if(isset($_POST['reply']))
	    {
		    $reply = trim($_POST['reply']);
		    $user->saveUserReply($reply, $commentId);
	    }
	    else if(isset($_GET['delete_comment']))
	    {
	        $commentId = (int)$_GET['delete_comment'];
	        $user->deleteCommentById($commentId);
	    }
	    else if(isset($_GET['delete_reply']))
	    {
	        $replyId = (int)$_GET['delete_reply'];
	        $user->deleteReplyById($replyId);
	    }
	}
	
	$allReplies = $app->getAllCommentReplies($commentId);
	$totalReplies = mysqli_num_rows($allReplies);
	
	if(isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else $message = 'Total '.$totalReplies.' replies.';
}
else $message = 'Comment not found!';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'All Replies';
	$pageDescription = 'large comment all replies page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<div class="blog-post">
					<h3 class="mt-3 mb-3"><?php echo $message; ?></h3>
					
					<?php if($commentInfo != null) { ?>
					
					<!-- start of comment section -->
					<div class="comment">
						<h5><img src="/assets/<?php if($commentInfo['image']) echo 'user_images/'.$commentInfo['image']; else echo 'images/person.jpg'?>" class="user-image"><?php echo $commentInfo['username']; ?></h5>
						<p><?php echo $commentInfo['comment']; ?></p>
						<p class="time">
							<?php echo $commentInfo['time']; ?>
							<?php echo $app->dateToMonthName($commentInfo['date']); ?>
							<?php echo (int)substr($commentInfo['date'], 8, 2).', '; ?>
							<?php echo (int)$commentInfo['date']; ?>
						</p>
						<?php if($isUser && $commentInfo['user_id'] == $_SESSION['userId']) { ?>
						<a href="/edit-comment.php?comment_id=<?php echo $commentInfo['id']; ?>">Edit</a> |
						<a href="?comment_id=<?php echo $commentId; ?>&delete_comment=<?php echo $commentInfo['id']; ?>" onclick="return confirm('Are you sure to delete the comment?')">Delete</a>
						<?php } ?>
						
						<div class="replies ml-5">
							<?php while($replyInfo = mysqli_fetch_assoc($allReplies)) { ?>
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
        						<a href="?comment_id=<?php echo $commentId; ?>&delete_reply=<?php echo $replyInfo['id']; ?>" onclick="return confirm('Are you sure to delete the reply?')">Delete</a>
        						<?php } ?>
							</div>
							<hr />
							<?php } ?>
						</div>
					</div>
					
					<?php if($isUser) { ?>
					<form method="post" class="reply-form">
						<div class="form-group">
							<textarea class="form-control" name="reply" placeholder="Write a reply..."  rows="7" maxlength="10000" required></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Reply</button>
					</form>
					<?php } else {?>
					<p class="mt-3"><a href="/user/signin.php">Sign in<a> to reply.</p>
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