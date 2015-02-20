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
		<div class="panel panel-default">
			<div class="panel-heading"><?=$board[0]?></div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th><?=$board[1]?></th>
						<th><?=$board[2]?></th>
						<th>profile</th>
						<th>update</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$teams = (new Teams())->getTeams(true);
					
					foreach($teams as $cteam)
					{
					?>
						<tr>
							<form class="panel-form" method="POST" action="#">
								<input type="hidden" value='<?=$cteam->id?>' name="id" />
								<td><?=$cteam->rank?></td>
								<td><input class="form-control" type="text" name="name" value='<?=$cteam->name?>' /></td>
								<td><input class="form-control" type="text" name="score" value='<?=$cteam->realscore?>' /></td>
								<td><a href='profile.php?id=<?=$cteam->id?>'>team profile</a></td>
								<td><div class="form-inline"><input class="form-control" type="password" name="pass" placeholder="admin-pass"><button type="submit" name="action" class="btn btn-primary" value="updteam">Update</button></div></td>
							</form>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php
require_once("../footer.php");

?>
