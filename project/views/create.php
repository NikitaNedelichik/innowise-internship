<div class="container">
	<form method="post" action="">
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" name="email" class="form-control" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Your first and last name</label>
			<input type="text" name="name" class="form-control" placeholder="Enter first and last name">
		</div>
		<div class="form-group">
			<label for="exampleSelect1">Gender</label>
			<select class="form-control" id="exampleSelect1" name="gender">
				<?= \app\core\View::getGender(); ?>
			</select>
		</div>
		<div class="form-group">
			<label for="exampleSelect2">Status</label>
			<select class="form-control" id="exampleSelect2" name="status">
				<?= \app\core\View::getStatus(); ?>
			</select>
		</div>
		<button type="submit" name="create" class="btn btn-primary">Create user</button>
	</form>
</div>