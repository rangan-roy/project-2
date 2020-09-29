<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1)
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\Elsewhere;

$elsewhere = new Elsewhere();

if(isset($_GET['delete_id']))
{
	$elsewhereId = (int)$_GET['delete_id'];
	$elsewhere->deleteElsewhereById($elsewhereId);
}

$elsewherePerPage = 7;
$totalElsewheres = $elsewhere->getNumberOfElsewheres();
$totalPages = ceil($totalElsewheres / $elsewherePerPage);
$pageNo = Page::getPageNo($totalPages);
$pageElsewheres = $elsewhere->getCurrentPageElsewheresInfo($pageNo, $elsewherePerPage);
$message = '';

if(isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}
else $message = 'Total '.$totalElsewheres.' elsewheres are added.';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Manage Elsewheres';
	$pageDescription = 'large elsewhere manage page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Manage elsewheres</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<br />
					<?php if($totalElsewheres) { ?>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>URL</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php for($i = ($pageNo - 1) * $elsewherePerPage + 1; $elsewhereInfo = mysqli_fetch_assoc($pageElsewheres); $i++) { ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $elsewhereInfo['name']; ?></td>
									<td><?php echo $elsewhereInfo['url']; ?></td>
									<td>
										<a href="edit-elsewhere.php?elsewhere_id=<?php echo $elsewhereInfo['id']; ?>">Edit</a> |
										<a href="?delete_id=<?php echo $elsewhereInfo['id']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<?php } ?>
					<br />
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<?php Page::showPagination($totalPages, $pageNo, 5, $_SERVER['SCRIPT_NAME']); ?>
						</ul>
					</nav>
					<br />
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>