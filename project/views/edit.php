<div class="container">
	<form method="post" action="">
        <? if ($model->success) :?>
            <div class="alert alert-success" role="alert">
                <?= $model->successMessage()?>
            </div>
        <? endif; ?>
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" name="email" class="form-control<?= $model->hasError('email') ? ' is-invalid': ''?>"
                   placeholder="Enter email" value="<?= $model->email ?>" readonly>
            <div class="invalid-feedback">
                <?= $model->getMessage('email')?>
            </div>
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Your first and last name</label>
			<input type="text" name="name" class="form-control<?= $model->hasError('name') ? ' is-invalid': ''?>"
                   placeholder="Enter first and last name"
				   value="<?= $model->name ?>">
            <div class="invalid-feedback">
                <?= $model->getMessage('name')?>
            </div>
		</div>
		<div class="form-group">
			<label for="exampleSelect1">Gender</label>
			<select class="form-control" id="exampleSelect1" name="gender">
				<?= \app\core\View::getGender($model->gender); ?>
			</select>
		</div>
		<div class="form-group">
			<label for="exampleSelect2">Status</label>
			<select class="form-control" id="exampleSelect2" name="status">
				<?= \app\core\View::getStatus($model->status); ?>
			</select>
		</div>
		<div class="row">
			<div class="col">
				<button type="submit" class="btn btn-primary">Update user</button>
			</div>
			<div class="col">
				<a href="/" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</form>
</div>