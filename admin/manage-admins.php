<?php
require 'includes/admin-check.php';

if($_SESSION['adminId'] != 1)
{
	header('Location: dashboard.php');
	die;
}

use Classes\Page;
use Classes\Admin;

$admin = new Admin();

// delete admin if delete_id is set and delete key's get matched
if(isset($_POST['delete_id'], $_POST['delete_key'], $_SESSION['adminDeleteKey']))
{
	$admin->deleteAdminInfo($_POST['delete_id'], $_POST['delete_key']);
}

$_SESSION['adminDeleteKey'] = rand(10000, 99999);

// get admins info for the current page, page no & number of pages
$totalAdmins = $admin->getNumberOfAdmins();
$adminPerPage = 7;
$totalPages = ceil($totalAdmins / $adminPerPage);
$pageNo = Page::getPageNo($totalPages);
$pageAdmins = $admin->getCurrentPageAdminsInfo($pageNo, $adminPerPage);

if(isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}
else $message = 'Total '.$totalAdmins.' admins are added.';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Manage Admins';
	$pageDescription = 'large admin manage page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<br /><h2>Manage admins</h2><br />
					<h5><?php echo $message; ?></h5>
					<br />
					<?php if($totalAdmins != 0) { ?>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Username</th>
									<th>Email</th>
									<th>Total Posts</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php for($i = ($pageNo - 1) * $adminPerPage + 1; $currentAdminInfo = mysqli_fetch_assoc($pageAdmins); $i++) { ?>
								<tr>
									<td><?php echo $i; ?></td>
						            <td><img src="/assets/<?php if($currentAdminInfo['image']) echo 'admin_images/'.$currentAdminInfo['image']; else echo 'images/person.jpg'?>" style="object-fit:cover" width="60" height="60"></td>
									<td><?php echo $currentAdminInfo['first_name']; ?></td>
									<td><?php echo $currentAdminInfo['last_name']; ?></td>
									<td><?php echo $currentAdminInfo['username']; ?></td>
									<td><?php echo $currentAdminInfo['email']; ?></td>
									<td><?php echo $admin->getNumberOfPostsOfOneAdmin($currentAdminInfo['id']); ?></td>
									<td>
										<a href="edit-admin.php?admin_id=<?php echo $currentAdminInfo['id']; ?>">Edit</a>
										<?php if($currentAdminInfo['id'] != 1) { ?>
										<form method="post" class="delete-form">
											<input type="hidden" name="delete_id" value="<?php echo $currentAdminInfo['id']; ?>">
											<input type="hidden" name="delete_key" value="<?php echo $_SESSION['adminDeleteKey']; ?>">
											| <input class="delete-btn" type="submit" value="Delete" onclick="return confirm('All post of this admin will be deleted, are you sure to delete the admin?')">
										</form>
										<?php } ?>
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