
<div class="container">
	<header class="blog-header py-3">
		<div class="row flex-nowrap justify-content-between align-items-center">
			<div class="col-4 pt-1">
				<?php if($isUser) { // $isUser is defined in user-check.php ?>
				<a class="btn btn-sm btn-outline-secondary" href="/user/edit-user.php">Edit Profile</a>
				<a class="btn btn-sm btn-outline-secondary" href="/user/signout.php">Sign out</a>
				<?php } else { ?>
				<a class="btn btn-sm btn-outline-secondary" href="/user/signup-form.php">Sign up</a>
				<a class="btn btn-sm btn-outline-secondary" href="/user/signin.php">Sign in</a>
				<?php } ?>
			</div>
			<div class="col-4 text-center">
				<a class="blog-header-logo text-dark" href="/">Large</a>
			</div>
			<div class="col-4 d-flex justify-content-end align-items-center">
				<form class="form-inline" action="archive.php">
					<div class="form-group mx-sm-3 mb-2">
						<input type="text" name="search" class="form-control" required>
					</div>
					<button type="submit" class="btn btn-secondary mb-2">Search</button>
				</form>
			</div>
		</div>
	</header>
	<div class="nav-scroller py-1 mb-2">
		<nav class="nav d-flex justify-content-between">
			<?php while($categoryInfo = mysqli_fetch_assoc($allCategoriesInfo)) { ?>
				<a class="p-2 text-muted" href="archive.php?category_id=<?php echo $categoryInfo['id']; ?>"><?php echo $categoryInfo['name']; ?></a>
			<?php } ?>
		</nav>
	</div>
</div>
