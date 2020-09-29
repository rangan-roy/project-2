<?php
require 'includes/admin-check.php';

use Classes\Page;

$message = $email = $remember = '';

if(isset($_POST['email'], $_POST['password']))
{
	$email = trim($_POST['email']);
	$password = $_POST['password']; // password can have space
	$remember = isset($_POST['remember']) ? true : false;
	$message = $login->loginAdmin($email, $password, $remember);
}
else if(isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Admin Login Form';
	$pageDescription = 'large admin login page';
	$pageCss = 'signin';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body class="text-center">
		<form class="form-signin" method="post">
			<img class="mb-4 logo" src="../assets/images/logo.jpg" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
			<p><?php echo $message; ?></p>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email address"  autofocus name="email" value="<?php echo $email; ?>" required>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Password"  name="password" required>
			<div class="checkbox mb-3">
				<label><input type="checkbox" name="remember" <?php if($remember) echo 'checked'; ?>> Remember me</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; 2017-<?php echo date('Y'); ?></p>
		</form>
	</body>
</html>