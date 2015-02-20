<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("utility.php");
require_once("db.php");
require_once("team.php");
require_once("task.php");
require_once("message.php");

function getLeft()
{
	global $db;
	$startTime = 0;
	$curTime = time();
	$sql = "SELECT `startTime` FROM `contest`";
	$stmt = $db->prepare($sql);
	$stmt->bind_result($startTime);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$stmt->close();
	$startTime = 30*60*60-time()+$startTime;
	if($startTime>0)
		return $startTime;
	return 0;
}

function hasStarted()
{
	global $db;
	$sql = "SELECT `startTime` FROM `contest`";
	$stmt = $db->prepare($sql);
	$stmt->bind_result($startTime);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$res = $stmt->num_rows;
	$stmt->close();
	
	return $res>0;
}

function isActive()
{
	global $db;
	
	$sql = "SELECT * FROM `tasks` WHERE `status`=1 AND ((`point`=500 AND `cat`!='CRYPT') OR (`point`=700 AND `cat`='CRYPT'))";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$res = $stmt->num_rows;
	$stmt->close();
	return $res===0;
}

if(hasStarted())
{
	$passed = 30*60*60-getLeft();
	$sql = "UPDATE `tasks` SET `status`=1 WHERE `point`<=".($passed/36/5+100);
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$stmt->close();
}

session_start();

$_POST = decryptPost($_POST);
logreq($_POST);

$error = "";
if(isset($_SESSION['error']))
{
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
}

$success = "";
if(isset($_SESSION['success']))
{
	$success = $_SESSION['success'];
	unset($_SESSION['success']);
}

//LOCALE
if(!isset($_SESSION['options']))
{
	$_SESSION['options'] = array();
	$_SESSION['options']['lang'] = LOCALE;
}	
$options = &$_SESSION['options'];
	
$langs = array("TR", "EN");
if(!in_array($options['lang'], $langs))
	$options['lang']="EN";
require_once(strtolower($options['lang']).".php");

//USER
$loggedin=false;
$admin = false;
if(isset($_SESSION['team']))
{
	$team = &$_SESSION['team'];
	$team = new Team($team->id);
	$_SESSION['team'] = $team;
	$loggedin = true;	
		
	if($team->status===3)
		$admin = true;
}

if(isset($_POST['action']))
{
	$action = $_POST['action'];
	if($action === "login")
	{
		if($loggedin === false)
		{
			$name = $_POST['teamname'];
			$pass = $_POST['password'];
			
			try
			{
				//throw new Exception("Login is disabled for a while use the scoreboard");
				$team = (new Teams())->login($name, $pass);
				$_SESSION['team'] = $team;
				$options['lang'] = $team->locale;
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($action === "logout")
	{
		if($loggedin === true)
			unset($_SESSION['team']);
	}
	else if($action === "locale")
	{
		$options['lang'] = $_POST['locale'];
		if($loggedin === true)
		{
			$team->locale = $options['lang'];
			$team->update();
		}
	}
	else if($action === "register")
	{
		if($loggedin === false)
		{
			$members = $_POST['members'];
			if(count($members)>3)
				$error .= $register[0]."\n";
			else
			{
				$name = $_POST['teamname'];
				$mail = $_POST['email'];
				$pass = $_POST['password'];
				
				try
				{
					//throw new Exception("Registeration is done manually during the contest, after contest you may register<br/>\n");
					if(count($members)==0)
						throw new Exception($register[3]);
						
					foreach($members as $member)
						if(strlen($member)<1 || strlen($member)>30 || preg_match("<%#:#%>", $member))
							throw new Exception($register[3]);
						
					if(strlen($name)<1 || strlen($mail)<1 || strlen($pass) <1)
						throw new Exception($register[3]);
					
					if((new Teams())->register($name, $pass, $mail, $members)!==true)
						throw new Exception($register[1]);
					
					$success .= $register[2]."\n";
				}
				catch(Exception $e)
				{
					$error .= $e->getMessage()."\n";
				}
			}
		}
	}
	else if($action === "update")
	{
		if($loggedin === true)
		{
			try
			{
				$members = $_POST['members'];
				$pass = $_POST['pass'];
				$newpass = $_POST['newpass'];
			
				if(count($members)>3 || count($team->members)!=count($members))
					throw new Exception($register[0]);
			
				if(count($members)==0)
					throw new Exception($register[3]);
				
				foreach($members as $member)
					if(strlen($member)<1 || preg_match("/<%#:#%>/", $member) || strlen($member)>30)
						throw new Exception($register[3]);
						
				$check = (new Teams())->login(htmlspecialchars_decode($team->name, ENT_QUOTES), $pass);
				if($check->id != $team->id)
					throw new Exception($profile[8]);
		
				$team->members = $members;
		
				$team->update($newpass);
				$success = $profile[9]."\n";
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($action === "forgot")
	{
		if($loggedin === false)
		{
			try
			{
				if(isset($_POST['email']))
				{
					$mail = $_POST['email'];
			
					$team = (new Teams())->getTeamMail($mail);
					$verify = $team->newVerify();
				
					$text = (new Teams())->parse($forgot[3], array("\$name"=>urlencode($team->name), "\$verify"=>urlencode($verify)));
					$team->Mail($forgot[2], $text);
					
					$success = $forgot[5]."\n";
				}
				else if(isset($_POST['verify']))
				{
					$name = $_POST['name'];
					$verify = $_POST['verify'];
					$pass = $_POST['newpass'];
					
					$team = (new Teams())->getTeamName($name);
					$team->newPass($pass, $verify);
					$team->newVerify();
					
					$success = $forgot[6]."\n";
				}
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($_POST['action'] === "updteam")
	{
		if($admin === true)
		{
			try
			{
				(new Teams())->login(htmlspecialchars_decode($team->name), $_POST['pass']);
				
				$cteam = new Team($_POST['id']);
				$cteam->name = $_POST['name'];
				$cteam->score = $_POST['score'];
				
				$pass = "";
				if(isset($_POST['newpass']))
				{
					$pass = $_POST['newpass'];
					
					$cteam->members = $_POST['members'];
					$cteam->mail = $_POST['mail'];
					$cteam->status = $_POST['status'];
					$cteam->lang = $_POST['lang'];
				}
				
				$cteam->upd($pass);
				
				if($team->id === $cteam->id)
					$_SESSION['team'] = new Team($team->id);
				$success = "HELAL LA GUNCELLEDIN HAYIRLARA VESILE OLUR INS";
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($_POST['action'] === "updtask")
	{
		if($admin === true)
		{
			try
			{
				(new Teams())->login(htmlspecialchars_decode($team->name), $_POST['pass']);
				$task = new Task($_POST['id']);
				
				$task->name = $_POST['name'];
				$task->desc = $_POST['desc'];
				$task->cat = $_POST['cat'];
				$task->status = $_POST['status'];
				$task->author = $_POST['author'];
				$task->solvers = explode(',', $_POST['solvers']);
				$task->point = $_POST['point'];
				//$task->flag = $_POST['flag'];
				$task->link = $_POST['link'];
				
				$task->update();
				$success = "HELAL LA GUNCELLEDIN HAYIRLARA VESILE OLUR INS";
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($_POST['action'] === "addtask")
	{
		if($admin === true)
		{
			try
			{
				(new Teams())->login(htmlspecialchars_decode($team->name), $_POST['pass']);
				$task = new Task();
				
				$task->name = $_POST['name'];
				$task->desc = implode("<%#:#%>", $_POST['desc']);
				$task->cat = $_POST['cat'];
				$task->status = $_POST['status'];
				$task->author = $_POST['author'];
				$task->solvers = explode(',', $_POST['solvers']);
				$task->point = $_POST['point'];
				//$task->flag = $_POST['flag'];
				$task->link = $_POST['link'];
				$task->insert();
				$success = "HELAL LA EKLEDIN HAYIRLARA VESILE OLUR INS";
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($_POST['action'] === "attempt")
	{
		if($loggedin === true)
		{
			try
			{
				//throw new Exception("Contest has ended");
				$task = new Task($_POST['id']);
				
				if($task->attempt($_POST['flag'])===true)
					$success = $ltask[6];
				else
					$error = $ltask[7];
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
	}
	else if($_POST['action'] === "addMsg")
	{
		if($loggedin === true)
		{
			try
			{
				$msg = new Message();
				$msg->msg = $_POST['msg'];
				$msg->tid = $team->id;
				$msg->adm = $admin;
				$msg->insert();
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
			}
		}
		else
			$error .= $msgboard[3]."\n";
	}
	$_SESSION['error'] = $error;
	$_SESSION['success'] = $success;
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);
	exit;
}

require_once("header.php");
?>
