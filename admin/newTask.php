<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("../base.php");

if($admin !== true)
{
	header("Location: /index.php");
	exit;
}
?>

<div class="container">
	<form action="#" method="POST">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="name">Name</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control" id="name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="desc">Description</label>
			<div class="col-sm-10">
				EN:<textarea name="desc[0]" class="form-control" id="desc"></textarea>
				TR:<textarea name="desc[1]" class="form-control" id="desc"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="cat">Category</label>
			<div class="col-sm-10">
				<input type="text" name="cat" class="form-control" id="cat">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="status">Status</label>
			<div class="col-sm-10">
				<input type="text" name="status" class="form-control" id="status">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="author">Author</label>
			<div class="col-sm-10">
				<input type="text" name="author" class="form-control" id="author">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="solvers">Solvers</label>
			<div class="col-sm-10">
				<input type="text" name="solvers" class="form-control" id="solvers">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="point">Point</label>
			<div class="col-sm-10">
				<input type="text" name="point" class="form-control" id="point">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="link">Link</label>
			<div class="col-sm-10">
				<input type="text" name="link" class="form-control" id="link">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="pass">Admin password</label>
			<div class="col-sm-9">
				<input type="password" name="pass" class="form-control" id="pass" placeholder="<?=$profile[6]?>">
			</div>
			<div class="col-sm-1">
				<button type="submit" name="action" class="btn btn-primary" value="addtask">Insert that bitch</button>
			</div>
		</div>
	</form>
</div>

<?php
require_once("../footer.php");
?>
