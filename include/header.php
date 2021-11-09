<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
	<a href="" class="navbar-brand">StuNet</a>


	<?php
	if(isset($_SESSION['user'])):?>

		<form action="" method="get" class="form-inline mx-auto">
			<input type="search" class="form-control" size="70" placeholder="Find anything" name="">
			<input type="submit" class="btn btn-dark" name="">
		</form>

	<?php endif;?>

	

	<ul class="navbar-nav ml-auto">
		<?php
	if(!isset($_SESSION['user'])):?>
		<li class="nav-item">
			<a href="#login" data-toggle="modal" class="btn btn-danger">Login</a>
		</li>

		<?php else:?>
			<li class="nav-item">
			<a href="logout.php"  class="btn btn-danger">Logout</a>
		</li>
	<?php endif;?>
	</ul>
	
	

</nav>

<div class="modal fade" id="login">
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"><h5>Login Here</h5></div>
		<div class="modal-body">
			<form action="index.php" method="post">
				<div class="form-group">
					<label for="contact">Contact</label>
					<input type="text" name="contact" class="form-control" id="contact">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<input type="submit" name="login" value="login" class="btn btn-success btn-block">
				</div>
			</form>
		</div>
	</div>
    </div>
</div>