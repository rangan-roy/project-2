<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if($isUser) // $isUser is defined in user-check.php
{
	$_SESSION['message'] = 'You are signed up already.';
	header('Location: index.php');
	die;
}

use Classes\App;
use Classes\Page;
use Classes\User;

$app = new App();
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();

$message = $firstName = $lastName = $username = $email = $password = '';

if(isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['re_password'], $_POST['captcha']))
{
	$firstName = trim($_POST['first_name']);
	$lastName = trim($_POST['last_name']);
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$rePassword = trim($_POST['re_password']);
	$captcha = $_POST['captcha'];
	// save user information
	$user = new User();
	$message = $user->checkUserInfo($firstName, $lastName, $username, $email, $password, $rePassword, $captcha);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Signup Form';
	$pageDescription = 'large user signup form';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<h2 class="my-3">Signup Form</h2>
				<h5 class="mb-3"><?php echo $message; ?></h5>
				<form method="post">
					<div class="form-group">
						<label for="first-name">First Name</label>
						<input type="text" class="form-control" id="first-name" name="first_name" value="<?php echo $firstName; ?>" maxlength="42" required>
					</div>
					<div class="form-group">
						<label for="last-name">Last Name</label>
						<input type="text" class="form-control" id="last-name" name="last_name" value="<?php echo $lastName; ?>" maxlength="42" required>
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" maxlength="50" title="Use only word characters and dot." pattern="^[\w.]{1,}$" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" maxlength="72" required>
					</div>
					<div class="form-group">
						<label for="re-password">Retype Password</label>
						<input type="password" class="form-control" id="re-password" name="re_password" required>
					</div>
					<div class="form-group">
					    <img src="/includes/captcha.php"><br />
						<label for="captcha">Type The Code</label>
						<input type="text" size="10" class="form-control" id="captcha" name="captcha" required>
					</div>
					<button type="submit" class="btn btn-primary mt-3 mb-5">Signup</button>
				</form>
			</div>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/aside.php'; ?>
		</div>
	</main>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>