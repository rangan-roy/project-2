<?php
require 'includes/user-check.php';

if(empty($_GET['reply_id']) || !$isUser)
{
	header('Location: index.php');
	die;
}

use Classes\Page;
use Classes\App;
use Classes\User;

// get comment info
$app = new App();
$replyId = (int)$_GET['reply_id'];
$replyInfo = $app->getReplyInfoById($replyId);

// get page info
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();

if($replyInfo)
{
	if(isset($_POST['reply']))
	{
		$reply = trim($_POST['reply']);
		$user = new User();
		$user->updateUserReply($reply, $replyId, $replyInfo['user_id']);
	}
	else
	{
	    if(isset($_SESSION['message']))
    	{
    		$message = $_SESSION['message'];
    		$reply = $_SESSION['reply'];
    		unset($_SESSION['message'], $_SESSION['reply']);
    	}
    	else
    	{
		    $message = '';
		    $reply = $replyInfo['reply'];
    	}
	}
}
else $message = 'Reply not found!';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Edit Reply';
	$pageDescription = 'large edit reply page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<div class="blog-post">
					<h2 class="blog-post-title">Edit Reply</h2>
					<h3 class="my-3"><?php echo $message; ?></h3>
					<?php if($replyInfo != null) { ?>
					<form method="post" class="reply-form">
						<div class="form-group">
							<textarea class="form-control" name="reply" rows="7" maxlength="10000" required><?php echo $reply; ?></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Update Reply</button>
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