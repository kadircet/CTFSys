<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");

if($loggedin===false)
{
	$_SESSION['error'] .= "Sorulari gorebilmeniz icin giris yapmaniz gerekmektedir.";
	header("Location: index.php");
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
							if($loggedin===true && $task->hasSolved($team->id)===true)
								$type .= " btn-success";
							else if(empty($task->realsolvers))
								$type .= " btn-primary";
							else if($loggedin===true)
								$type .= " btn-danger";
							else
								$type .= " btn-default";
								
							if($task->status !== 1)
								$type .= " disabled";
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
		?>
	</div>
<?php
}
else
{
	try
	{
		$task = new Task($_GET['id']);
		if($task->status!==1 && $admin !== true)
			throw new Exception($ltask[0]);
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">
					<div style="float:left;"><?=$task->name?>-<?=$task->point?></div>
					<div style="float:right;"><?=$task->cat?></div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<center><?=nl2br($task->desc)?><br/><a href='<?=$task->link?>'><?=$task->link?></a></center>
				<form action="#" method="POST">
					<input type="hidden" value="<?=$task->id?>" name="id">
					<div class="form-group">
						<label class="col-sm-1 control-label" for="desc"><?=$ltask[2]?></label>
						<div class="col-sm-11 form-inline">
							<input type="text" name="flag" class="form-control" id="flag" placeholder='<?=$ltask[3]?>'>
							<button type="submit" name="action" value="attempt" class="btn btn-primary"><?=$ltask[4]?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="author">Author</label>
			<div class="col-sm-10">
				<p><?=$task->author?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="solvers">Solvers</label>
			<div class="col-sm-10">
				<p>
				<?php
					$solvers = array();
					foreach($task->solvers as $solver)
					{
						try
						{
							$t = new Team($solver);
							$solvers[] = $t->name;
						}
						catch(Exception $e)
						{
						}
					}
					$solvers = array_filter($solvers);
					if(!empty($solvers))
						echo implode(',', $solvers);
					else
						echo $ltask[5];
				?>
				</p>
			</div>
		</div>
	</div>
	<?php
?>
<?php
}
require_once("footer.php");

?>
