<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("../base.php");
if($admin !== true)
{
	header("Location: /index.php");
	exit;
}

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

<script>
	function addField()
	{
		var area = $('#memberarea');
		var i = $('#memberarea input').size();
		if(i>=3)
		{
			alert("<?=$register[0]?>");
		}
		else
		{
			$('<input type="text" class="form-control" style="margin-bottom:5px;" id="members" name="members[]" placeholder="Member Name">').appendTo(area);
		}
	}
</script>
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
		if($admin===true)
		{
		?>
			<form class="form-horizontal" action="#" method="POST">
				<input type="hidden" name="id" value="<?=$query->id?>">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="name">Teamname</label>
					<div class="col-sm-10 form-inline">
						<input type="text" name="name" class="form-control" id="name" value='<?=$query->name?>'>
						<input type="text" name="status" class="form-control" id="status" value='<?=$query->status?>'>
						<input type="text" name="score" class="form-control" id="score" value='<?=$query->score?>'>
						<input type="text" name="lang" class="form-control" id="lang" value='<?=$query->locale?>'>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="mail">Email:</label>	
					<div class="col-sm-10">
						<input type="text" name="mail" class="form-control" id="mail" value='<?=$query->mail?>'>
					</div>			
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="membername"><?=$profile[1]?>:</label>
					<?php
					$first=true;
					foreach($query->members as $member)
					{
						$type = "col-sm-10";
						if(!$first)
							$type = "col-sm-offset-2 ".$type;
						echo '<div class="'.$type.'" style="margin-top:0px;" id="memberarea"><input type="text" style="margin-bottom:5px;" class="form-control" name="members[]" id="membername" value=\''.$member.'\'></div>'."\n";
						$first = false;
					}
					?>
					<div class="col-sm-offset-2 col-sm-10"><a href="#" type="button" class="btn btn-primary" onclick="addField();">Add Member</a></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="newpass"><?=$profile[2]?></label>
					<div class="col-sm-10">
						<input type="password" name="newpass" class="form-control" id="newpass" placeholder="<?=$profile[3]?>">
					</div>
					<p class="col-sm-12" class="help-block"><?=$profile[4]?></p>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="pass">Admin password</label>
					<div class="col-sm-9">
						<input type="password" name="pass" class="form-control" id="pass" placeholder="<?=$profile[6]?>">
					</div>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-primary" name="action" value="updteam"><?=$profile[7]?></button>
					</div>
				</div>
			</form>
		<?php
		}
		?>
		</div>
	</div>
</div>

<?php
require_once("../footer.php");
?>

