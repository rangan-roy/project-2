<?php
require 'includes/user-check.php';

use Classes\Page;
use Classes\App;
use Classes\User;

$app = new App();
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Page Not Found!';
	$pageDescription = 'large 404 error page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<div class="blog-post">
					<!-- post title -->
					<h2 class="blog-post-title">404 Error: Page Not Found!</h2>
					<p>The page you're looking for can't be found.</p>
				</div>
			</div>
			<?php include 'includes/aside.php'; ?>
		</div>
	</main>
	<?php include 'includes/footer.php'; ?>
</body>
</html>