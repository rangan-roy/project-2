<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1 || empty($_GET['admin_id']))
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\Admin;

$adminId = (int)$_GET['admin_id'];
$admin = new Admin();
$adminInfo = $admin->getAdminInfoById($adminId);
$image = $adminInfo['image'];
$message = '';

if($adminInfo)
{
	if(isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['re_password']))
	{
		$firstName = trim($_POST['first_name']);
		$lastName = trim($_POST['last_name']);
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$password = $_POST['password'];
		$rePassword = $_POST['re_password'];

		$message = $admin->updateAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword, $adminId);
	}
	else
	{
		$firstName = $adminInfo['first_name'];
		$lastName = $adminInfo['last_name'];
		$username = $adminInfo['username'];
		$email = $adminInfo['email'];
	}
}
else $message = 'Unknown admin to edit.';
?>
<!DOCTYPE html>
<html lang="en-Us">
	<?php
	$pageTitle = 'Edit Admin';
	$pageDescription = 'large admin edit page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="mt-3">Edit Admin Info</h2>
					<h5 class="my-3"><?php echo $message; ?></h5>
					<?php if($adminInfo) { ?>
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
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" maxlength="50" required>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" maxlength="72" required>
						</div>
						<div class="form-group">
							<label for="re-password">Retype Password</label>
							<input type="password" class="form-control" id="re-password" name="re_password" required>
						</div>
						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" class="form-control-file" id="image" name="image" accept="image/*">
							<?php if($image) { ?>
							<img src="/assets/admin_images/<?php echo $image; ?>" width="300" height="200" style="object-fit:cover">
							<?php } ?>
						</div>
						<button type="submit" class="btn btn-primary mt-2 mb-5">Update Admin Info</button>
					</form>
					<?php } ?>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>
