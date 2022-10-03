<div class="container">
	<form method="post" action="">
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" name="email" class="form-control" placeholder="Enter email">
		</div>
		<? /*
		if (isset($_POST['email']))
			if (!isEmailValid($_POST['email'])) echo('<div class="alert alert-danger">Email is invalid</div>');
		*/ ?>
		<div class="form-group">
			<label for="exampleInputPassword1">Your first and last name</label>
			<input type="text" name="name" class="form-control" placeholder="Enter first and last name">
		</div>
		<? /*
		if (isset($_POST['name']))
			if (!isNameValid($_POST['name'])) echo('<div class="alert alert-danger">Name is invalid</div>');
		*/ ?>
		<div class="form-group">
			<label for="exampleSelect1">Gender</label>
			<select class="form-control" id="exampleSelect1" name="gender">
				<?= \app\core\View::getGender(); ?>
			</select>
		</div>
		<? /*
		if (isset($_POST['gender']))
			if (!isGenderValid($_POST['gender'])) echo('<div class="alert alert-danger">Please make a choice</div>');
		*/ ?>
		<div class="form-group">
			<label for="exampleSelect2">Status</label>
			<select class="form-control" id="exampleSelect2" name="status">
				<?= \app\core\View::getStatus(); ?>
			</select>
		</div>
		<? /*
		if (isset($_POST['status']))
			if (!isStatusValid($_POST['status'])) echo('<div class="alert alert-danger">Please make a choice</div>');
		*/ ?>
		<button type="submit" name="create" class="btn btn-primary">Create user</button>
	</form>
</div>