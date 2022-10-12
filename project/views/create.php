<div class="container">
    <? if ($model->success) :?>
        <div class="alert alert-success" role="alert">
            <?= $model->successMessage()?>
        </div>
    <? endif; ?>
	<form method="post" action="">
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email" name="email" placeholder="Enter email" value="<?= $model->email?>"
                   class="form-control<?= $model->hasError('email') ? ' is-invalid': ''?>"
            >
            <div class="invalid-feedback">
                <?= $model->getMessage('email')?>
            </div>
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Your first and last name</label>
			<input type="text" name="name" placeholder="Enter first and last name" value="<?= $model->name?>"
                   class="form-control<?= $model->hasError('name') ? ' is-invalid': ''?>"
            >
            <div class="invalid-feedback">
                <?= $model->getMessage('name')?>
            </div>
		</div>
		<div class="form-group">
			<label for="exampleSelect1">Gender</label>
			<select class="form-control" id="exampleSelect1" name="gender">
				<?= \app\core\View::getGender($model->gender); ?>
			</select>
            <div class="invalid-feedback">
                <?= $model->getMessage('gender')?>
            </div>
		</div>
		<div class="form-group">
			<label for="exampleSelect2">Status</label>
			<select class="form-control" id="exampleSelect2" name="status">
				<?= \app\core\View::getStatus($model->status); ?>
			</select>
            <div class="invalid-feedback">
                <?= $model->getMessage('status')?>
            </div>
		</div>
		<button type="submit" class="btn btn-primary">Create user</button>
	</form>
</div>