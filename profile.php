<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");

$query = NULL;
$edit = false;
if(isset($_GET['id']))
{
	try
	{
		$id = (int)$_GET['id'];
		$query = new Team($id);
	}
	catch(Exception $e)
	{
		$error .= $e->getMessage()."\n";
		$_SESSION['error'] = $error;
		header("Location: index.php");
		exit;
	}
}
else if($loggedin===true)
	$query = $team;
else
{
	header("Location: index.php");
	exit;
}

if($loggedin === true && $team->id === $query->id)
	$edit = true;
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<div style="float:left;"><?=$query->name?></div>
				<div style="float:right;"><?=$profile[0].": ".$query->score?></div>
			</h3>
			<div style="clear:both"></div>
		</div>
		<div class="panel-body">
		<?php
		if($edit===true)
		{
		?>
			<form class="form-horizontal" action="#" method="POST">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membername"><?=$profile[1]?>:</label>
					<?php
					$first=true;
					$i=0;
					foreach($query->members as $member)
					{
						$type = "col-sm-10";
						if(!$first)
							$type = "col-sm-offset-2 ".$type;
						echo '<div class="'.$type.'" style="margin-top:0px;" id="memberarea"><input type="text" style="margin-bottom:5px;" class="form-control" name="members['.$i.']" id="membername" value=\''.$member.'\'></div>'."\n";
						$first = false;
						$i++;
					}
					?>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="newpass"><?=$profile[2]?></label>
					<div class="col-sm-10">
						<input type="password" name="newpass" class="form-control" id="newpass" placeholder="<?=$profile[3]?>">
					</div>
					<p class="col-sm-12" class="help-block"><?=$profile[4]?></p>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="pass"><?=$profile[5]?></label>
					<div class="col-sm-9">
						<input type="password" name="pass" class="form-control" id="pass" placeholder="<?=$profile[6]?>">
					</div>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-primary" name="action" value="update"><?=$profile[7]?></button>
					</div>
				</div>
			</form>
		<?php
		}
		else
		{
		?>
			<label class="col-sm-12 control-label" for="membername"><?=$profile[1]?>:</label>
			<ul>
			<?php
			foreach($query->members as $member)
				echo '<li class="col-sm-10">'.$member.'</li>'."\n";
			?>
			</ul>
			<div style="clear:both;"></div>
		<?php
		}
		?>
		</div>
	</div>
</div>

<?php
require_once("footer.php");
?>

