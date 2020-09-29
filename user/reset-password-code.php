<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if($isUser) // $isUser is defined in user-check.php
{
    header('Location: /');
    die;
}
else if(!isset($_SESSION['userEmail']))
{
	header('Location: reset-password-email.php');
	die;
}

use Classes\App;
use Classes\Page;
use Classes\User;

$message = 'A code is sent to your email, enter it.';

if(isset($_POST['code'], $_SESSION['passwordResetCode']))
{
    if($_POST['code'] == $_SESSION['passwordResetCode'])
    {
        $_SESSION['resetPassword'] = 1;
		header('Location: reset-password-password.php');
		die;
    }
    else $message = 'Code didn\'t match. A new code is sent to your email, enter it.';
}

// email user a password reset code
$code = $_SESSION['passwordResetCode'] = rand(10000, 99999);
$email = $_SESSION['userEmail'];
$emailSubject = 'Password reset code from large.com';
$emailMessage = 'Use the code to reset your password: '.$code;
mail($email, $emailSubject, $emailMessage);

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
					    <input type="text" class="form-control" name="code" required>
					</div>
					<button type="submit" class="btn btn-primary mt-3 mb-5">Submit Code</button>
				</form>
			</div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/aside.php'; ?>
		</div>
	</main>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>