<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/user-check.php';

if(!$isUser) // $isUser is defined in check-user.php
{
	header('Location: index.php');
	die;
}

use Classes\Page;
use Classes\User;
use Classes\App;

$user = new User();
$userInfo = $user->getCurrentUserInfo();
$image = $userInfo['image'];

if(isset($_POST['first_name'], $_POST['last_name'], $_FILES['image']))
{
	$firstName = trim($_POST['first_name']);
	$lastName = trim($_POST['last_name']);
	$fileName = 'image';
	$message = $user->updateUserInfo($firstName, $lastName, $fileName);
}
else
{
    	
	$firstName = $userInfo['first_name'];
	$lastName = $userInfo['last_name'];
	$message = '';
}

$app = new App();
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();
?>
<!DOCTYPE html>
<html lang="en-Us">
	<?php
	$pageTitle = 'Edit User Info';
	$pageDescription = 'large user info edit page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
		<div class="container">
			<div class="row">
				<div class="col-md-8 blog-main">
					<h2 class="mt-3">Edit User Info</h2>
					<h5 class="my-3"><?php echo $message; ?></h5>
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="first-name">First Name</label>
							<input type="text" class="form-control" id="first-name" name="first_name" value="<?php echo $firstName; ?>" maxlength="42" required>
						</div>
						<div class="form-group">
							<label for="last-name">Last Name</label>
							<input type="text" class="form-control" id="last-name" name="last_name" value="<?php echo $lastName; ?>" maxlength="42" required>
						</div>
						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" class="form-control-file" id="image" name="image" accept="image/*">
							<?php if($image) { ?>
							<br />
							<img src="/assets/user_images/<?php echo $image; ?>" width="300" height="200" style="object-fit:cover">
							<?php } ?>
						</div>
						<button type="submit" class="btn btn-primary mt-2 mb-5">Update User Info</button>
					</form>
				</div>
				<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/aside.php'; ?>
			</div>
		</div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
	</body>
</html>
