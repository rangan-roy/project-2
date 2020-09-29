<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if($isUser) // $isUser is defined in user-check.php
{
    header('Location: /');
    die;
}

if(!isset($_SESSION['userEmail']))
{
	header('Location: signup-form.php');
	die;
}

use Classes\App;
use Classes\Page;
use Classes\User;

// required page infos
$app = new App();
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();

$message = 'A code is sent to your email, enter it.';

// email validation starts from here
if(isset($_POST['code'], $_SESSION['emailValidationCode']))
{
    if($_POST['code'] == $_SESSION['emailValidationCode'])
    {
        $user = new User();
        $user->saveUserInfo($_SESSION['userFirstName'], $_SESSION['userLastName'], $_SESSION['userUsername'], $_SESSION['userEmail'], $_SESSION['userPassword']);
    }
    else $message = 'Code didn\'t match. A new code is sent to your email, enter it.';
}

// mail user a email validation code
$code = $_SESSION['emailValidationCode'] = rand(10000, 99999);
$email = $_SESSION['userEmail'];
$emailSubject = 'Email validation code from large.com';
$emailMessage = 'Use the code to valide your email: '.$code;
mail($email, $emailSubject, $emailMessage);
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Email Validation';
	$pageDescription = 'large user email validation page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<h2 class="my-3">Email Validation</h2>
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