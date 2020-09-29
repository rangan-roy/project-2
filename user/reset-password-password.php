<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if($isUser) // $isUser is defined in user-check.php
{
    header('Location: /');
    die;
}
else if(!isset($_SESSION['resetPassword']))
{
	header('Location: reset-password-code.php');
	die;
}

use Classes\App;
use Classes\Page;
use Classes\User;

$message = 'Enter a new password.';

if(isset($_POST['password'], $_POST['re_password']))
{
    if(empty($_POST['password']))
    {
        $message = 'Password can\'t be empty.';
    }
    else if(strlen($_POST['password']) > 72)
	{
		$message = 'Password length exceeded maxlength.';
	}
	else if($_POST['password'] != $_POST['re_password'])
	{
		$message = 'Password didn\'t match.';
	}
	else
	{
		$user = new User();
		$user->updateUserPasswordByEmail($_SESSION['userEmail'], $_POST['password']);
		unset($_SESSION['userEmail'], $_SESSION['resetPassword']);
		$_SESSION['message'] = 'Password changed successfully.';
		header('Location: signin.php');
		die;
	}
}

// required page infos
$app = new App();
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Password Reset';
	$pageDescription = 'large password reset page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<h2 class="my-3">Password Reset</h2>
				<h5 class="mb-3"><?php echo $message; ?></h5>
				<form method="post">
					<div class="form-group">
					    <input type="password" class="form-control" name="password" maxlength="72" required>
					</div>
					<div class="form-group">
					    <input type="password" class="form-control" name="re_password" maxlength="72" required>
					</div>
					<button type="submit" class="btn btn-primary mt-3 mb-5">Submit Password</button>
				</form>
			</div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/aside.php'; ?>
		</div>
	</main>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>