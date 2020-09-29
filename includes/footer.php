
<footer class="blog-footer">
	<p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
	<p><a href="#">Back to top</a></p>
</footer>
<script src="assets/js/bootstrap.min.js"></script>
<?php
if(isset($_SESSION['message']))
{
	echo '<script>alert("'.$_SESSION['message'].'")</script>';
	unset($_SESSION['message']);
}
?>
