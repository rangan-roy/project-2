<?php
require 'includes/admin-check.php';

use Classes\Page;
use Classes\Post;

if(empty($_GET['post_id']))
{
	header('Location: manage-posts.php');
	die;
}

$post = new Post();
$postId = (int)$_GET['post_id'];
$postInfo = $post->getPostInfoById($postId);
$message = '';
$showEditForm = false;

if($postInfo)
{
	if($postInfo['author_id'] == $_SESSION['adminId'] || $_SESSION['adminId'] == 1)
	{
		$showEditForm = true;
		
		if(isset($_POST['title'], $_POST['category_name'], $_POST['description'], $_FILES['image']))
		{
			$postTitle = trim($_POST['title']);
			$postCategoryName = trim($_POST['category_name']);
			$postDescription = trim($_POST['description']);
			$message = $post->updatePostInfo($postTitle, $postCategoryName, $postDescription, $postId);
		}
		else
		{
			$postTitle = $postInfo['title'];
			$postCategoryName = $postInfo['category_name'];
			$postDescription = $postInfo['description'];
			$postImage = $postInfo['image'];
		}
	}
	else $message = 'You don\'t have permission to edit the post.';
}
else $message = 'Unknown post to edit.';
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Edit Post';
	$pageDescription = 'large admin edit post page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Edit post</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<?php if($showEditForm) { ?>
					<form method="post" enctype="multipart/form-data" name="edit_post_form">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" class="form-control" id="title" name="title" value="<?php echo $postTitle; ?>" maxlength="200" required>
						</div>
						<div class="form-group">
							<label for="category">Category Name</label>
							<input type="text" class="form-control" id="category" name="category_name" value="<?php echo $postCategoryName; ?>" maxlength="50" required>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" rows="10" name="description" maxlength="10000" required><?php echo $postDescription; ?></textarea>
						</div>
						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" class="form-control-file" id="image" name="image" accept="image/*"><br />
							<img src="../assets/post_images/<?php echo $postImage; ?>" width="300" height="200" style="object-fit:cover">
						</div>
						<button type="submit" class="btn btn-primary mt-3 mb-5">Update post</button>
					</form>
					<?php } ?>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>