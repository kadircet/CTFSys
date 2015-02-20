<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("../base.php");

if($admin !== true)
{
	header("Location: /index.php");
	exit;
}

if(!isset($_GET['id']))
{
	$tMan = new Tasks();
	$tasks = $tMan->tasks;
	$cats = $tMan->cats;
?>
	<div class="container">
		<?php
		foreach($cats as $cat)
		{
		?>
			<div class="panel panel-default">
				<div class="panel-heading"><?=$cat?></div>
				<div class="panel-body">
					<div class="btn-group btn-group-md">
						<?php
						foreach($tasks[$cat] as $task)
						{
							$type = "btn";
							//die(empty($task->solvers));
							if(empty($task->solvers))
								$type .= " btn-primary";
							else if($loggedin===true && $task->hasSolved($team->id)===true)
								$type .= " btn-success";
							else if($loggedin===true)
								$type .= " btn-danger";
							else
								$type .= " btn-default";
						?>
							<a href='?id=<?=$task->id?>' type="button" class='<?=$type?>'><?=$task->name?><br/><?=$task->point?><br/><?=$task->author?></a>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		<?php
		}
		if($admin === true)
		{
		?>
			<a type="button" class="btn btn-primary" href="newTask.php">Add Task</a>
		<?php
		}
		?>
	</div>
<?php
}
else
{
	try
	{
		$task = new Task($_GET['id']);
	}
	catch(Exception $e)
	{
		$error = $e->getMessage()."\n";
		$_SESSION['error'] = $error;
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
	}
	?>
	<div class="container">
		<form action="#" method="POST">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="name">Name</label>
				<div class="col-sm-10">
					<input type="text" name="name" class="form-control" id="name" value="<?=$task->name?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="desc">Description</label>
				<div class="col-sm-10">
					<textarea name="desc" class="form-control" id="desc"><?=$task->desc?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cat">Category</label>
				<div class="col-sm-10">
					<input type="text" name="cat" class="form-control" id="cat" value="<?=$task->cat?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="status">Status</label>
				<div class="col-sm-10">
					<input type="text" name="status" class="form-control" id="status" value="<?=$task->status?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="author">Author</label>
				<div class="col-sm-10">
					<input type="text" name="author" class="form-control" id="author" value="<?=$task->author?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="solvers">Solvers</label>
				<div class="col-sm-10">
					<input type="text" name="solvers" class="form-control" id="solvers" value="<?=implode(',',$task->solvers)?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="point">Point</label>
				<div class="col-sm-10">
					<input type="text" name="point" class="form-control" id="point" value="<?=$task->point?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="desc">Flag</label>
				<div class="col-sm-10">
					<input type="text" name="flag" class="form-control" id="flag" value='<?=$task->flag?>'>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="link">Link</label>
				<div class="col-sm-10">
					<input type="text" name="link" class="form-control" id="link" value='<?=$task->link?>'>
				</div>
			</div>
			<input type="hidden" value="<?=$task->id?>" name="id">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pass">Admin password</label>
				<div class="col-sm-9">
					<input type="password" name="pass" class="form-control" id="pass" placeholder="<?=$profile[6]?>">
				</div>
				<div class="col-sm-1">
					<button type="submit" name="action" value="updtask" class="btn btn-primary">Update that bitch</button>
				</div>
			</div>
			
		</form>
	</div>
<?php
}
require_once("../footer.php");

?>
