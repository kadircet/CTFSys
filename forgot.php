<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");

if($loggedin===true)
	header("Location: index.php");

if(isset($_GET['action']) && $_GET['action'] === "forgot")
{
?>
	<div class="container">
		<form method="post" action="#">
			<div class="form-group">
				<label for="newpass"><?=$forgot[0]?></label>
				<input type="password" class="form-control" id="newpass" name="newpass" placeholder="new P4$$w0rd">
				<input type="hidden" value='<?=htmlspecialchars($_GET['verify'], ENT_QUOTES)?>' name="verify">
				<input type="hidden" value='<?=htmlspecialchars($_GET['name'], ENT_QUOTES)?>' name="name">
			</div>
			<button type="submit" class="btn btn-default" name="action" value="forgot"><?=$forgot[4]?></button>
		</form>
	</div>
<?php
}
else
{
	?>

	<div class="container">
		<form method="post" action="#">
			<div class="form-group">
				<label for="email"><?=$forgot[0]?></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="winner@hackmetu.com">
			</div>
			<button type="submit" class="btn btn-default" name="action" value="forgot"><?=$forgot[1]?></button>
		</form>
	</div>

	<?php
}
require_once("footer.php");

?>
