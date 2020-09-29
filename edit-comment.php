<?php
require 'includes/user-check.php';

if(empty($_GET['comment_id']) || !$isUser)
{
	header('Location: index.php');
	die;
}

use Classes\Page;
use Classes\App;
use Classes\User;

// get comment info
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
	if(isset($_POST['comment']))
	{
		$comment = trim($_POST['comment']);
		$user = new User();
		$user->updateUserComment($comment, $commentId, $commentInfo['user_id']);
	}
	else
	{
		if(isset($_SESSION['message']))
		{
			$message = $_SESSION['message'];
			$comment = $_SESSION['comment'];
			unset($_SESSION['message'], $_SESSION['comment']);
		}
		else
		{
		    $comment = $commentInfo['comment'];
		    $message = '';
		}
	}
}
else $message = 'Comment not found!';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Edit Comment';
	$pageDescription = 'large edit comment page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<div class="blog-post">
					<h2 class="blog-post-title">Edit Comment</h2>
					<h3 class="mt-3"><?php echo $message; ?></h3>
					<?php if($commentInfo != null) { ?>
					<form method="post" class="comment-form">
						<div class="form-group">
							<textarea class="form-control" name="comment" placeholder="Write a comment..."  rows="7" maxlength="10000" required><?php echo $comment; ?></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Comment</button>
					</form>
					<?php } ?>
				</div>
			</div>
			<?php include 'includes/aside.php'; ?>
		</div>
	</main>
	<?php include 'includes/footer.php'; ?>
</body>
</html>