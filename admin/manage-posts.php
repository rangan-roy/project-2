<?php
require 'includes/admin-check.php';

use Classes\Page;
use Classes\Post;
use Classes\Admin;
use Classes\App;

$post = new Post();
$admin = new Admin();
$app = new App();

if(isset($_GET['delete_id']))
{
	$postId = (int)$_GET['delete_id'];
	$post->deletePostById($postId);
}
else if(isset($_GET['jumbo_id']))
{
	$postId = (int)$_GET['jumbo_id'];
	$post->jumboUnjumboPostById($postId);
}

if($_SESSION['adminId'] == 1)
{
	$totalPosts = $post->getNumberOfTotalPosts();
}
else $totalPosts = $admin->getNumberOfPostsOfOneAdmin($_SESSION['adminId']);

$postPerPage = 7;
$totalPages = ceil($totalPosts / $postPerPage);
$pageNo = Page::getPageNo($totalPages);

if($_SESSION['adminId'] == 1)
{
	$pagePosts = $post->getCurrentPagePostsOfAllAdmins($pageNo, $postPerPage);
}
else $pagePosts = $post->getCurrentPagePostsOfCurrentAdmin($pageNo, $postPerPage);

if(isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}
else $message = 'Total '.$totalPosts.' posts available.';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Manage Posts';
	$pageDescription = 'large admin manage posts page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Manage posts</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<br />
					<?php if($totalPosts != 0) { ?>
					<div class="table-responsive">
						<table class="table table-striped table-sm">
							<thead>
								<tr>
									<th>#</th>
									<th>Title</th>
									<th>Author</th>
									<th>Category</th>
									<th>Description</th>
									<th>Image</th>
									<th>Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php for($i = ($pageNo - 1) * $postPerPage + 1; $postInfo = mysqli_fetch_assoc($pagePosts); $i++) { ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo Page::cutWords($postInfo['title'], 5); ?>...</td>
									<td><?php echo $postInfo['author_name']; ?></td>
									<td><?php echo $postInfo['category_name']; ?></td>
									<td><?php echo Page::cutWords($postInfo['description'], 5); ?>...</td>
									<td>
										<img src="../assets/post_images/<?php echo $postInfo['image']; ?>" width="60" height="60" style="object-fit:cover">
									</td>
									<td>
										<?php
										$date = $app->dateToMonthName($postInfo['month_year']);
										$date .= ' '.$postInfo['day'];
										$date .= ', '.(int)$postInfo['month_year'];
										echo $date;
										?>
									</td>
									<td>
										<a target="_blank" href="../single.php?post_id=<?php echo $postInfo['id']; ?>">View</a> |
										<?php if($_SESSION['adminId'] == 1) { ?>
										<a href="?jumbo_id=<?php echo $postInfo['id']?>">
										<?php echo $postInfo['is_jumbo'] ? 'Unjumbo' : 'Jumbo'; ?>
										</a> |
										<?php } ?>
										<a href="edit-post.php?post_id=<?php echo $postInfo['id']; ?>">Edit</a> | 
										<a href="?delete_id=<?php echo $postInfo['id']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
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