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
$aboutTitle = $aboutInfo['title'];
$aboutDescription = $aboutInfo['description'];
$message = '';

if(isset($_POST['title'], $_POST['description']))
{
	$aboutTitle = trim($_POST['title']);
	$aboutDescription = trim($_POST['description']);
	$message = $about->updateAboutInfo($aboutTitle, $aboutDescription);
}
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
					<h2 class="my-3">Edit about</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<form method="post">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" class="form-control" id="title" name="title" value="<?php echo $aboutTitle; ?>" maxlength="50" required>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" rows="5" name="description" maxlength="500" required><?php echo $aboutDescription; ?></textarea>
						</div>
						<button type="submit" class="btn btn-primary mt-3 mb-5">Update about</button>
					</form>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>
