<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if($isUser) // $isUser is defined in user-check.php
{
    header('Location: /');
    die;
}

use Classes\App;
use Classes\Page;
use Classes\User;

$message = 'Enter your email.';
$email = '';

if(isset($_POST['email']))
{
	$email = trim($_POST['email']);
	
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$user = new User();
		
		if($user->checkUserByEmail($email))
		{
			$_SESSION['userEmail'] = $email;
			header('Location: reset-password-code.php');
			die;
		}
		else $message = 'No account is associated with the given email.';
	}
	else $message = 'Enter a valid email.';
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
					    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
					</div>
					<button type="submit" class="btn btn-primary mt-3 mb-5">Submit Email</button>
				</form>
			</div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/aside.php'; ?>
		</div>
	</main>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>