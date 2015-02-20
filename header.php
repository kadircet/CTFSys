<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef
$file = basename($_SERVER['PHP_SELF']);
?>
<!-- Author: Kadir CETINKAYA - breakv0id@0xdeffbeef -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="/favicon.ico">
		<title>HackMETU CTF</title>
		<meta name="description" content="HackMETU CTF">
		<meta name="keywords" content="hackmetu, ctf, hack, metu">
		<meta property="og:type" content="website">
		<meta property="og:image" content="/images/share.jpg">
		<meta property="og:title" content="HackMETU CTF">
		<meta property="og:site_name" content="HackMETU">
		<meta property="og:description" content="HackMETU CTF">
		<meta property="og:url" content="http://hackmetu.com/">

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/ctf.css">
	</head>

	<body style="padding-top: 50px;">		
		<!--- NAVBAR -->
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-links">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><img src="http://hackmetu.com/images/hackmetu_solid2.png" style="width:100px"/></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-links">
				<ul class="nav navbar-nav navbar-left">
					<li<?=($file==="index.php"?' class="active"':'')?>><a href="index.php"><?=$header[0]?></a></li>
					<li<?=($file==="tasks.php"?' class="active"':'')?>><a href="tasks.php"><?=$header[1]?></a></li>
					<li<?=($file==="board.php"?' class="active"':'')?>><a href="board.php"><?=$header[2]?></a></li>
					<li<?=($file==="msgboard.php"?' class="active"':'')?>><a href="msgboard.php"><?=$header[11]?></a></li>
					<li<?=($file==="about.php"?' class="active"':'')?>><a href="about.php"><?=$header[3]?></a></li>
					<?php
					if($admin===true)
						echo '<li class="active"><a href="/admin/index.php">Admin</a></li>';
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if($loggedin===false)
					{
					?>
						<li><a href="/register.php"><?=$header[4]?></a></li>
						<li class="divider-vertical"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$header[5]?> <b class="caret"></b></a>
							<div class="dropdown-menu" style="padding-right: 10px; padding-bottom: 0px;">
								<form class="navbar-form navbar-right" style="width:240px;" method="POST" action="#">
									<input type="text" class="form-control" style="margin-bottom: 15px;width:90%;" placeholder="Teamname" name="teamname" /><br/>
									<input type="password" class="form-control" style="margin-bottom: 15px;width:90%;" placeholder="Password" name="password" /><br/>
									<button type="submit" class="btn btn-primary" name="action" value="login"><?=$header[6]?></button>
									<a href="/forgot.php" class="btn btn-danger"><?=$header[7]?></a>
								</form>
							</div>
						</li>
					<?php
					}
					else
					{
					?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$header[8]?>, <?=$team->name?> <b class="caret"></b></a>
							<div class="dropdown-menu" style="padding-left: 10px; width:230px;">
								<a href="/profile.php" class="btn btn-primary"><?=$header[9]?></a>
								<a href="#" class="btn btn-danger" onclick="logout();"><?=$header[10]?></a>
							</div>
						</li>
					<?php
					}
					?>
					<li class="divider-vertical"></li>
					<div class="nav navbar-nav navbar-right" style="padding-right: 30px; padding-bottom: 0px;">
						<?php
							foreach($langs as $locale)
								echo '<li '.($locale==$options['lang']?'class="active"':'').'><a href="#" onclick="setLocale(\''.$locale.'\');">'.$locale.'</a></li>';
						?>
					</div>
				</ul>
			</div>
		</div>
		<!--- //NAVBAR -->
		
		<?php
		if($error!="" || $success!="")
		{
		?>
			<!--- Alert -->
			<?php
				$errors = explode("\n", $error);
				foreach($errors as $error)
					if($error!="")
						echo "<div class='alert alert-danger'>".$error."</div>";
				
				$successs = explode("\n", $success);
				foreach($successs as $success)
					if($success!="")
						echo "<div class='alert alert-success'>".$success."</div>";
			?>
			<!--- //Alert -->
		<?php
		}
		?>

