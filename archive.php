<?php
require 'includes/user-check.php';

$pageNo = 1;
$postPerPage = 5;

if(isset($_GET['page_no'])) $pageNo = (int)$_GET['page_no'];

use Classes\App;
use Classes\Page;

if(isset($_GET['category_id']))
{
	$app = new App();
	$categoryId = (int)$_GET['category_id'];
	$posts = $app->getPostsByColumnValue('category_id', $categoryId, $pageNo, $postPerPage);
	$totalPosts = $app->totalPostsByColumnValue('category_id', $categoryId);
	$categoryName = $app->getCategoryNameById($categoryId);
	$archiveNo = 1;
	
	if($totalPosts != 0)
	{
		$message = 'Total '.$totalPosts.' posts found for <b>'.$categoryName.'</b> category';
	}
	else $message = 'Unknown category';
}
else if(isset($_GET['author_id']))
{
	$app = new App();
	$authorId = (int)$_GET['author_id'];
	$posts = $app->getPostsByColumnValue('author_id', $authorId, $pageNo, $postPerPage);
	$totalPosts = $app->totalPostsByColumnValue('author_id', $authorId);
	$authorName = $app->getAuthorNameById($authorId);
	$archiveNo = 2;
	
	if($totalPosts != 0)
	{
		$message = 'Total '.$totalPosts.' posts found of <b>'.$authorName.'</b>';
	}
	else $message = 'Unknown author';
}
else if(isset($_GET['month_year']))
{
	$app = new App();
	$monthYear = $_GET['month_year'];
	$posts = $app->getPostsByColumnValue('month_year', $monthYear, $pageNo, $postPerPage);
	$totalPosts = $app->totalPostsByColumnValue('month_year', $monthYear);
	$archiveNo = 3;
	
	if($totalPosts != 0)
	{
		$message = 'Total '.$totalPosts.' posts found in <b>'.$app->dateToMonthName($monthYear).' '.(int)$monthYear.'</b>';
	}
	else $message = 'Unknown date';
}
else if(isset($_GET['search']))
{
	$app = new App();
	$search = $_GET['search'];
	$posts = $app->getPostsBySearch($search, $pageNo, $postPerPage);
	$totalPosts = $app->totalPostsBySearch($search);
	$message = 'Total '.$totalPosts.' posts found for <b>'.htmlentities($search).'</b>';
	$archiveNo = 4;
}
else
{
	header('Location: index.php');
	die;
}

$totalPages = ceil($totalPosts / $postPerPage);
$allCategoriesInfo = $app->getAllCategoriesInfo();
$aboutInfo = $app->getAboutInfo();
$monthArchives = $app->getMonthArchives();
$allElsewheresInfo = $app->getAllElsewheresInfo();
?>
<!DOCTYPE html>
<html lang="en-US">
	<?php
	$pageTitle = 'Archive Page';
	$pageDescription = 'large archive page';
	$pageCss = 'blog';
	Page::htmlHead($pageTitle, $pageDescription, $pageCss);
	?>
<body>
	<?php include 'includes/header.php'; ?>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-8 blog-main">
				<h3 class="pb-4 mb-4 font-italic border-bottom"><?php echo $message; ?></h3>
				<?php while($postInfo = mysqli_fetch_assoc($posts)) { ?>
				<div class="blog-post">
					<h2 class="blog-post-title"><?php echo $postInfo['title']; ?></h2>
					
					<p class="blog-post-meta"><?php echo $app->dateToMonthName($postInfo['month_year']).' '.$postInfo['day'].', '.(int)$postInfo['month_year']; ?>
					<?php if($archiveNo == 1) { ?>
					by <a href="?author_id=<?php echo $postInfo['author_id']; ?>"><?php echo $postInfo['author_username']; ?></a>
					<?php } else if($archiveNo == 2) { ?>
					in <a href="?category_id=<?php echo $postInfo['category_id']; ?>"><?php echo $postInfo['category_name']; ?></a>
					<?php } else { ?>
					by <a href="?author_id=<?php echo $postInfo['author_id']; ?>"><?php echo $postInfo['author_username']; ?></a>
					in <a href="?category_id=<?php echo $postInfo['category_id']; ?>"><?php echo $postInfo['category_name']; ?></a>
					<?php } ?>
					</p>

					<p><?php echo Page::cutWords($postInfo['description'], 50); ?>...</p>
					<a href="single.php?post_id=<?php echo $postInfo['id']; ?>">Continue reading</a>
				</div>
				<?php } ?>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<?php Page::showPagination($totalPages, $pageNo, 5, $_SERVER['REQUEST_URI'], '&'); ?>
					</ul>
				</nav>
			</div>
			<?php include 'includes/aside.php'; ?>
		</div>
	</main>
	<?php include 'includes/footer.php'; ?>
</body>
</html>