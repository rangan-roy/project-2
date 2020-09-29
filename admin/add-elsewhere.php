<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1)
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\Elsewhere;

$message = $elsewhereName = $elsewhereUrl = '';

if(isset($_POST['name'], $_POST['url']))
{
	$elsewhereName = trim($_POST['name']);
	$elsewhereUrl = trim($_POST['url']);
	$elsewhere = new Elsewhere();
	$message = $elsewhere->saveElsewhereInfo($elsewhereName, $elsewhereUrl);
}
?>
<!DOCTYPE html>
<html lang="en-Us">
	<?php
	$pageTitle = 'Add Elsewhere';
	$pageDescription = 'large admin elsewhere adding page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Add elsewhere</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<?php if($message) echo '<br />'; ?>
					<form method="post">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" value="<?php echo $elsewhereName; ?>" maxlength="42" required>
						</div>
						<div class="form-group">
							<label for="url">URL</label>
							<input type="url" class="form-control" id="url" name="url" value="<?php echo $elsewhereUrl; ?>" maxlength="255" required>
						</div>
						<button type="submit" class="btn btn-primary mt-3 mb-5">Add elsewhere</button>
					</form>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>
