<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");
if(isActive())
	$active = "Active";
else
	$active = "Frozen";

$left = getLeft();
$left = sprintf("%02d:%02d:%02d",(int)($left/3600), ($left/60)%60, $left%60);
?>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?=$board[0]?> [<?=$active?>: <?=$left?>]</div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th><?=$board[1]?></th>
						<th><?=$board[2]?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$teams = (new Teams())->getTeams();
					
					$id=0;
					if($loggedin === true)
						$id = $team->id;
					foreach($teams as $cteam)
					{
						if($cteam->id===$id)
							echo '<tr class="active">'."\n";
						else
							echo '<tr>'."\n";
					?>
							<td><?=$cteam->rank?></td>
							<td><a href='/profile.php?id=<?=$cteam->id?>'><?=$cteam->name?></a></td>
							<td><?=$cteam->score?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php
require_once("footer.php");

?>
