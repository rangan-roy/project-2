
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-3">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="dashboard.php">
					<span data-feather="home"></span>
					Dashboard <span class="sr-only">(current)</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="add-post.php">
					<span data-feather="file"></span>
					Add post
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="manage-posts.php">
					<span data-feather="file"></span>
					Manage posts
				</a>
			</li>
			<?php if($_SESSION['adminId'] == 1) { ?>
			<li class="nav-item">
				<a class="nav-link" href="add-admin.php">
					<span data-feather="file"></span>
					Add admin
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="manage-admins.php">
					<span data-feather="file"></span>
					Manage admins
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="manage-about.php">
					<span data-feather="file"></span>
					Manage about
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="add-elsewhere.php">
					<span data-feather="file"></span>
					Add elsewhere
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="manage-elsewheres.php">
					<span data-feather="file"></span>
					Manage elsewheres
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</nav>
