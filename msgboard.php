<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef
require_once("base.php");
?>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><?=$msgboard[0]?></div>
			<table class="table">
				<thead>
					<tr>
						<th><?=$msgboard[1]?></th>
						<th><?=$msgboard[2]?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$msgs = (new Messages())->getMsgs();
					
					$id=0;
					if($loggedin === true)
						$id = $team->id;
					foreach($msgs as $cmsg)
					{
						if($cmsg->tid===$id)
							echo '<tr class="active">'."\n";
						else
							echo '<tr>'."\n";
							
						if($cmsg->adm===true)
						{
					?>
							<td style="width:20%">Admin</td>
					<?php
						}
						else
						{
					?>
							<td style="width:20%"><a href='/profile.php?id=<?=$cmsg->tid?>'><?=$cmsg->tName?></a></td>
					<?php
						}
					?>
							<td style="word-wrap: break-all; display:block;"><?=$cmsg->msg?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<form method="post" action="#">
				<div class="form-group">
					<label for="Message">Message</label><br/>
					<textarea name="msg" style="width:100%;"></textarea>
				</div>
				<button type="submit" class="btn btn-default" name="action" value="addMsg">Register</button>
			</form>
		</div>
	</div>

<?php
require_once("footer.php");
?>
