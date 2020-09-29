<?php
require 'includes/admin-check.php';

use Classes\Page;
use Classes\Post;
use Classes\Admin;
use Classes\Elsewhere;
use Classes\User;

$post = new Post();
$admin = new Admin();
$elsewhere = new Elsewhere();
$user = new User();

$totalPosts = $post->getNumberOfTotalPosts();
$totalAdmins = $admin->getNumberOfAdmins();
$totalElsewheres = $elsewhere->getNumberOfElsewheres();
$totalUsers = $user->getNumberOfUsers();
$totalComments = $user->getNumberOfComments();
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Admin Dashboard';
	$pageDescription = 'large admin dashboard';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<br /><br />
					<div class="container">
						<div class="row">
							<div class="col-md-4 col-12 col-sm-6 counter">
								<div class="count-box"><?php echo $totalPosts; ?></div>
								<h3>Posts</h3>
							</div>
							<div class="col-md-4 col-12 col-sm-6 counter">
								<div class="count-box"><?php echo $totalAdmins; ?></div>
								<h3>Admins</h3>
							</div>
							<div class="col-md-4 col-12 col-sm-6 counter">
								<div class="count-box"><?php echo $totalElsewheres; ?></div>
								<h3>Elsewheres</h3>
							</div>
							<div class="col-md-4 col-12 col-sm-6 counter">
								<div class="count-box"><?php echo $totalUsers; ?></div>
								<h3>Users</h3>
							</div>
							<div class="col-md-4 col-12 col-sm-6 counter">
								<div class="count-box"><?php echo $totalComments; ?></div>
								<h3>Comments</h3>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>