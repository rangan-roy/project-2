<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1)
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\Admin;

$message = $firstName = $lastName = $username = $email = $password = '';

if(isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['re_password']))
{
	$firstName = trim($_POST['first_name']);
	$lastName = trim($_POST['last_name']);
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	$rePassword = $_POST['re_password'];

	$admin = new Admin();
	$message = $admin->saveAdminInfo($firstName, $lastName, $username, $email, $password, $rePassword);
}
?>
<!DOCTYPE html>
<html lang="en-Us">
	<?php
	$pageTitle = 'Add Admin Form';
	$pageDescription = 'large admin adding page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="mt-3">Add Admin Form</h2>
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
							<label for="image">Image</label>
							<input type="file" class="form-control-file" id="image" name="image" accept="image/*">
						</div>
						<button type="submit" class="btn btn-primary mt-2 mb-5">Add Admin</button>
					</form>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>
