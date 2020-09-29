<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1)
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\About;

$about = new About();
$aboutInfo = $about->getAboutInfo();
$message = '';

if(isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Admin About';
	$pageDescription = 'large admin about page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Manage About</h2>
					<h4 class="mb-3"><?php echo $message; ?></h4>
					<h3>Title</h3>
					<p><?php echo $aboutInfo['title']; ?></p>
					<h3>Description</h3>
					<p><?php echo $aboutInfo['description']; ?></p>
					<a class="btn btn-primary mb-5" href="edit-about.php">Edit</a>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>