
<aside class="col-md-4 blog-sidebar">
	<div class="p-4 mb-3 bg-light rounded">
		<h4 class="font-italic"><?php echo $aboutInfo['title']; ?></h4>
		<p class="mb-0"><?php echo $aboutInfo['description']; ?></p>
	</div>
	<div class="p-4">
		<h4 class="font-italic">Month archives</h4>
		<ol class="list-unstyled">
			<?php while($archive = mysqli_fetch_assoc($monthArchives)) { ?>
			<li>
				<a href="archive.php?month_year=<?php echo $archive['month_year']; ?>">
					<?php echo $app->dateToMonthName($archive['month_year']).' '.(int)$archive['month_year']; ?>
				</a>
			</li>
			<?php } ?>
		</ol>
	</div>
	<div class="p-4">
		<h4 class="font-italic">Elsewhere</h4>
		<ol class="list-unstyled">
			<?php while($elsewhereInfo = mysqli_fetch_assoc($allElsewheresInfo)) { ?>
			<li>
				<a href="<?php echo $elsewhereInfo['url']; ?>" target="_blank"><?php echo $elsewhereInfo['name']; ?></a>
			</li>
			<?php } ?>
		</ol>
	</div>
</aside>
