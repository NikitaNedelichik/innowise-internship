<?php
extract($user);
?>
<div class="container">
	<form method="post" action="">
		<input type="hidden" name="id" value="<?= $id ?>">
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" name="email" class="form-control" placeholder="Enter email" value="<?= $email ?>">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Your first and last name</label>
			<input type="text" name="name" class="form-control" placeholder="Enter first and last name"
				   value="<?= $name ?>">
		</div>
		<div class="form-group">
			<label for="exampleSelect1">Gender</label>
			<select class="form-control" id="exampleSelect1" name="gender">
				<?= \app\core\View::getGender($gender); ?>
			</select>
		</div>
		<div class="form-group">
			<label for="exampleSelect2">Status</label>
			<select class="form-control" id="exampleSelect2" name="status">
				<?= \app\core\View::getStatus($status); ?>
			</select>
		</div>
		<div class="row">
			<div class="col">
				<button type="submit" name="update" class="btn btn-primary">Update user</button>
			</div>
			<div class="col">
				<a href="/" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</form>
</div>