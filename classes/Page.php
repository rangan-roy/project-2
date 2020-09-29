<?php
namespace Classes;

class Page
{
	static public function htmlHead($title, $description, $css)
	{ ?>
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="<?php echo $description; ?>">
			<meta name="author" content="Rangan Roy">
			<meta name="generator" content="Jekyll v4.1.1">
			<title>Large - <?php echo $title; ?></title>
			
			<!-- favicon -->
			 <link rel="icon" href="/assets/images/logo.jpg" type="image/jpeg" sizes="16x16">
			 
			<!-- Bootstrap core CSS -->
			<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
			
			<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}
			</style>
			
			<!-- Custom styles for this template -->
			<link href="/assets/css/<?php echo $css; ?>.css" rel="stylesheet">
		</head>
		<?php
	}
	
	static protected function printAllPageNumbers($totalPages, $currentPage, $uri, $appendSign)
	{
		for($i = 1; $i <= $totalPages; $i++)
		{
			echo '<li class="page-item">';
			
			if($i == $currentPage)
			{
				echo '<a class="page-link active">';
			}
			else echo '<a class="page-link" href="'.$uri.$appendSign.'page_no='.$i.'">';
			
			echo $i.'</a></li>';
		}
	}
	
	static protected function googlePagination($leftPages, $rightPages, $currentPage, $uri, $appendSign)
	{	
		for($i = $currentPage - $leftPages; $i < $currentPage; $i++)
		{
			echo '<li class="page-item"><a class="page-link" href="'.$uri.$appendSign.'page_no='.$i.'">'.$i.'</a></li>';
		}
		
		echo '<li class="page-item"><a class="page-link active">'.$i.'</a></li>';
		
		for($i = $currentPage + 1; $i <= $currentPage + $rightPages; $i++)
		{
			echo '<li class="page-item"><a class="page-link" href="'.$uri.$appendSign.'page_no='.$i.'">'.$i.'</a></li>';
		}
	}
	
	static public function showPagination($totalPages, $currentPage, $showPages, $uri, $appendSign = '?')
	{
		$cutStart = strpos($uri, '&page_no=');
		
		if($cutStart !== false) $uri = substr($uri, 0, $cutStart);
		
		if($currentPage > 1)
		{
			echo '<li class="page-item"><a class="page-link" href="'.$uri.$appendSign.'page_no='.($currentPage - 1).'">Prev</a></li>';
		}
		
		if($showPages < $totalPages)
		{
			$sidePages = floor($showPages / 2);
			$leftPages = $currentPage - 1;
			$rightPages = $totalPages - $currentPage;
			
			if($leftPages < $sidePages)
			{
				$rightPages = $sidePages + ($sidePages - $leftPages);
			}
			else if($rightPages < $sidePages)
			{
				$leftPages = $sidePages + ($sidePages - $rightPages);
			}
			else $leftPages = $rightPages = $sidePages;
			
			Page::googlePagination($leftPages, $rightPages, $currentPage, $uri, $appendSign);
		}
		else Page::printAllPageNumbers($totalPages, $currentPage, $uri, $appendSign);
		
		if($currentPage < $totalPages)
		{
			echo '<li class="page-item"><a class="page-link" href="'.$uri.$appendSign.'page_no='.($currentPage + 1).'">Next</a></li>';
		}
	}
	
	static public function getPageNo($totalPages)
	{
		if(isset($_GET['page_no']))
		{
			$pageNo = (int)$_GET['page_no'];
			if($pageNo < 1) return 1;
			if($pageNo > $totalPages) return $totalPages;
			return $pageNo;
		}
		
		return 1;
	}
	
	static public function cutWords($s, $n)
	{
	    $wordCount = 0;
	    
	    for($i = 0; @$s[$i]; $i++)
	    {
	        if($s[$i] == ' ') $wordCount++;
	        if($wordCount == $n) break;
	    }
	    
	    return substr($s, 0, $i);
	}
}
?>