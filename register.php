<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");

if($loggedin===true)
	header("Location: index.php");
?>
<script>
	function addField()
	{
		var area = $('#memberarea');
		var i = $('#memberarea input').size() + 1;
		if(i>=3)
		{
			alert("<?=$register[0]?>");
		}
		else
		{
			$('<input type="text" class="form-control" style="margin-bottom:5px;" id="members" name="members['+i+']" placeholder="Member Name">').appendTo(area);
		}
	}
</script>
<div class="container">
	<form method="post" action="#">
		<div class="form-group">
			<label for="teamname"><?=$register[4]?></label>
			<input type="text" maxlength="30" class="form-control" name="teamname" id="teamname" placeholder="0xdeffbeef">
		</div>
		<div class="form-group">
			<label for="email"><?=$register[5]?></label>
			<input type="email" maxlength="30" class="form-control" id="email" name="email" placeholder="winner@hackmetu.com">
			<p class="help-block"><?=$register[10]?></p>
		</div>
		<div class="form-group">
			<label for="password"><?=$register[6]?></label>
			<input type="password" maxlength="30" class="form-control" id="password" name="password" placeholder="P4$$w0rd">
		</div>
		<div class="form-group">
			<label for="members"><?=$register[7]?></label>
			<input type="text" maxlength="30" class="form-control" style="margin-bottom:5px;" id="members" name="members[0]" placeholder="breakv0id - Kadir CETINKAYA">
			<div id="memberarea">
			</div>
			<a href="#" class="btn btn-primary" onClick="addField();"><?=$register[8]?></a>
		</div>
		<button type="submit" class="btn btn-default" name="action" value="register"><?=$register[9]?></button>
	</form>
</div>
<?php
require_once("footer.php");

?>
