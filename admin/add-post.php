<?php
require 'includes/admin-check.php';

use Classes\Page;
use Classes\Post;

$message = $postTitle = $postCategoryName = $postDescription = '';

if(isset($_POST['title'], $_POST['category_name'], $_POST['description'], $_FILES['image']))
{
	$postTitle = trim($_POST['title']);
	$postCategoryName = trim($_POST['category_name']);
	$postDescription = trim($_POST['description']);
	// save post info
	$post = new Post();
	$message = $post->savePostInfo($postTitle, $postCategoryName, $postDescription);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Add Post';
	$pageDescription = 'large admin add post page';
	$pageCss = 'dashboard';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/navbar.php'; ?>
		<div class="container-fluid">
			<div class="row">
				<?php include 'includes/sidebar.php'; ?>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
					<h2 class="my-3">Add post</h2>
					<h5 class="mb-3"><?php echo $message; ?></h5>
					<form method="post" enctype="multipart/form-data" name="post_form">
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
							<input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
						</div>
						<button type="submit" class="btn btn-primary mt-3 mb-5">Add post</button>
					</form>
				</main>
			</div>
		</div>
		<?php include 'includes/scripts.php'; ?>
	</body>
</html>