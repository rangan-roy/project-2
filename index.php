<?php
require 'includes/user-check.php';

use Classes\App;
use Classes\Page;

$app = new App();
$jumboPostInfo = $app->getJumboPostInfo();
$homePosts = $app->getLastPostsOfEveryCategory();

$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'A Demo Blog Site';
	$pageDescription = 'large home page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
	<body>
		<?php include 'includes/header.php'; ?>
		<div class="container">
			<?php if($jumboPostInfo != null) { ?>
			<div class="jumbotron jumbo-post p-4 p-md-5 text-white rounded bg-dark">
				<img src="/assets/post_images/<?php echo $jumboPostInfo['image']; ?>">
				<div class="col-md-8 px-0">
					<h1 class="display-4 font-italic"><?php echo $jumboPostInfo['title']; ?></h1>
					<p class="lead my-3"><?php echo Page::cutWords($jumboPostInfo['description'], 30); ?>...</p>
					<p class="lead mb-0"><a href="single.php?post_id=<?php echo $jumboPostInfo['id']; ?>" class="text-white font-weight-bold">Continue reading...</a></p>
				</div>
			</div>
			<?php } ?>
			<div class="row mb-2">
				<div class="col-md-8">
					<?php while($postInfo = mysqli_fetch_assoc($homePosts)) { ?>
					<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
						<div class="col p-4 d-flex flex-column position-static">
							<strong class="d-inline-block mb-2 text-primary"><?php echo $postInfo['category_name']; ?></strong>
							<h3 class="mb-0"><?php echo $postInfo['title']; ?></h3>
							<div class="mb-1 text-muted">
							<?php echo $app->dateToMonthName($postInfo['month_year']).' '.$postInfo['day']; ?></div>
							<p class="card-text mb-auto"><?php echo Page::cutWords($postInfo['description'], 20); ?>...</p>
							<a href="single.php?post_id=<?php echo $postInfo['id']; ?>" class="stretched-link">Continue reading</a>
						</div>
						<div class="col-auto d-none d-lg-block">
							<img class="bd-placeholder-img" src="/assets/post_images/<?php echo $postInfo['image']; ?>">
						</div>
					</div>
					<?php } ?>
				</div>
				<?php include 'includes/aside.php'; ?>
			</div>	
		</div>
		<?php include 'includes/footer.php'; ?>
	</body>
</html>
