<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("db.php");

class Teams
{
	private $msg;
	
	function __construct()
	{
		global $lteam;
		
		$this->msg = $lteam;
	}
	
	function register($name, $pass, $mail, $members)
	{
		global $db;
		
		if(preg_match("/\s/", $name) == true) //Whitespace in name
			throw new Exception($this->msg[0]);
		
		if(preg_match("/\s/", $mail) == true) //Whitespace in mail
			throw new Exception($this->msg[1]);
		
		if(is_array($members) == false) //Bad Request
			throw new Exception($this->msg[2]);
			
		if(strlen($name)>30 || strlen($mail)>40 || strlen($pass)>30)
			throw new Exception($this->msg[2]);
		
		$name = $name;
		$mail = $mail;
		
		$sql = "SELECT * FROM `teams` WHERE `name`=? or `mail`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ss", $name, $mail);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows!=0) //Credentials in use
			throw new Exception($this->msg[3]);
		$stmt->close();
		
		$salt = generateSalt();
		$hash = hashPass($salt, $pass);
		$verify = base64_encode(generateSalt());
		$salt = base64_encode($salt);
			
		$members = implode('<%#:#%>', $members);
				
		$sql = "INSERT INTO `teams` (`name`, `mail`, `pass`, `salt`, `members`, `status`, `regdate`, `verification`) ";
		$sql.= "VALUES(?, ?, ?, ?, ?, 0, NOW(), ?);";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssssss", $name, $mail, $hash, $salt, $members, $verify);
		$stmt->execute();
		$stmt->close();
		
		$text = $this->parse($this->msg[7], array("\$name"=>urlencode($name), "\$verify"=>urlencode($verify),"\$pass"=>$pass));
		sendMail($mail, $this->msg[6]/*Validation*/, $text);
		return true;
	}
	
	function login($name, $pass)
	{
		global $db;
		
		if(preg_match("/\s/", $name) == true) //Whitespace in name
			throw new Exception($this->msg[0]);
			
		$id = 0;
		$salt = "";
		$hash = "";
		$status = 0;
		
		$sql = "SELECT `id`, `salt`, `pass`, `status` FROM `teams` WHERE `name`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("s", $name);
		$stmt->bind_result($id, $salt, $hash, $status);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows!=1) //Wrong credential
			throw new Exception($this->msg[4]);
		
		$stmt->fetch();
		$stmt->close();
		
		$salt = base64_decode($salt);
		if(hashPass($salt, $pass)!==$hash) //Wrong credential
			throw new Exception($this->msg[4]);
		
		if($status === 0) //Email verification
			throw new Exception($this->msg[5]);
		
		$salt = generateSalt();
		$hash = hashPass($salt, $pass);
		$salt = base64_encode($salt);
		
		$sql = "UPDATE `teams` SET `pass`=?, `salt`=? WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssi", $hash, $salt, $id);
		$stmt->execute();
		$stmt->close();
		
		return $this->getTeamID($id);
	}
	
	function parse($string, $data)
	{
		$res = $string;
		foreach($data as $key => $value)
			eval($key ." = '".$value."';");
		
		eval("\$res = \"".$string."\";");
		
		return $res;
	}
	
	function getTeamID($id)
	{
		return new Team($id);
	}
	
	function getTeamMail($email)
	{
		global $db;
		global $lang;
		
		$email = $email;
		
		$id = 0;
		$sql = "SELECT `id` FROM `teams` WHERE `mail`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		if($stmt->num_rows!=1)
			throw new Exception($lang['team'][9]);
		$stmt->close();
		
		return $this->getTeamID($id);
	}
	
	function getTeamName($name)
	{
		global $lang;
		global $db;
		
		$id = 0;
		$sql = "SELECT `id` FROM `teams` WHERE `name`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("s", $name);
		$stmt->bind_result($id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		if($stmt->num_rows!=1)
			throw new Exception($lang['team'][10]);
		$stmt->close();
		
		return $this->getTeamID($id);
	}
	
	function getTeams($adm=false)
	{
		global $db;
		
		if($adm)
			$sql = "SELECT `id` FROM `teams` WHERE `status`=1 ORDER BY `realscore` DESC";
		else
			$sql = "SELECT `id` FROM `teams` WHERE `status`=1 ORDER BY `score` DESC";
		$res = $db->query($sql);
		
		$teams = array();
		while($tmp = $res->fetch_array())
			$teams[] = $this->getTeamID($tmp[0]);

		return $teams;
	}
}

class Team
{
	public $name = "";
	public $members = "";
	public $id = 0;
	public $score = 0;
	public $realscore = 0;
	public $mail = "";
	public $locale = "";
	public $rank = 0;
	public $status = 0;
	
	function __construct($id)
	{
		global $db;
		global $lang;
		
		$name = "";
		$sql = "SELECT `name`, `members`, `score`, `realscore`, `mail`, `lang`, `status` FROM `teams` WHERE `id` = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->bind_result($this->name, $this->members, $this->score, $this->realscore, $this->mail, $this->locale, $this->status);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		if($stmt->num_rows!=1) //Wrong ID :C
			throw new Exception($lang['team'][8]);
		$stmt->close();
		
		$sql = "SELECT count(`id`) FROM `teams` WHERE `score`>? AND `status`=1";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $this->score);
		$stmt->bind_result($this->rank);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$this->rank++;
		
		$this->id = (int)$id;
		$this->members = explode("<%#:#%>", $this->members);
		foreach($this->members as $key=>$value)
			$this->mebers[$key] = htmlspecialchars($value, ENT_QUOTES);
		$this->name=htmlspecialchars($this->name, ENT_QUOTES);
		$this->mail=htmlspecialchars($this->mail, ENT_QUOTES);
	}
	
	function update($pass="")
	{
		global $db;
		global $lang;
		
		$sql = "UPDATE `teams` SET `score` = ?, `realscore` = ?, `lang` = ?, `members`=? WHERE `id` = ?";
		$stmt = $db->prepare($sql);
		$members = $this->members;
		$members = implode("<%#:#%>", $members);
		$stmt->bind_param("iissi", $this->score, $this->realscore, $this->locale, $members, $this->id);
		$stmt->execute();
		$stmt->close();
		
		if(strlen($pass)>30)
			throw new Exception($lang['team'][3]);		
				
		if(strlen($pass)>0)
		{
			$salt = generateSalt();
			$hash = hashPass($salt, $pass);
			$salt = base64_encode($salt);
		
			$sql = "UPDATE `teams` SET `pass`=?, `salt`=? WHERE `id`=?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("ssi", $hash, $salt, $this->id);
			$stmt->execute();
			$stmt->close();
		}
		
		return true;
	}
	
	function updScore()
	{
		global $db;
		
		$sql = "SELECT `score`, `realscore` FROM `teams` WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $this->id);
		$stmt->bind_result($this->score, $this->realscore);
		$stmt->execute();
		$stmt->close();
	}
	
	function upd($pass="")
	{
		global $db;
		
		$sql = "UPDATE `teams` SET `score` = ?, `realscore` = ?, `lang` = ?, `members`=?, `name`=?, `mail`=?, `status`=? WHERE `id` = ?";
		$stmt = $db->prepare($sql);
		$name = $this->name;
		$members = $this->members;
		$mail = $this->mail;
		$members = implode("<%#:#%>", $members);
		$stmt->bind_param("iissssii", $this->score, $this->realscore, $this->locale, $members, $name, $mail, $this->status, $this->id);
		$stmt->execute();
		$stmt->close();
		
		if(strlen($pass)>0)
		{
			$salt = generateSalt();
			$hash = hashPass($salt, $pass);
			$salt = base64_encode($salt);
		
			$sql = "UPDATE `teams` SET `pass`=?, `salt`=? WHERE `id`=?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("ssi", $hash, $salt, $this->id);
			$stmt->execute();
			$stmt->close();
		}
		
		return true;
	}
	
	function newVerify()
	{
		global $db;
		
		$salt = base64_encode(generateSalt());
		$sql = "UPDATE `teams` SET `verification`=? WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("si", $salt, $this->id);
		$stmt->execute();
		$stmt->close();
		
		return $salt;
	}
	
	function Mail($subject, $text)
	{
		sendMail($this->mail, $subject, $text);
	}
	
	function newPass($pass, $verify)
	{
		global $lang;
		global $db;
		
		$id = 0;
		$sql = "SELECT `id` FROM `teams` WHERE `id`=? AND `verification`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("is", $this->id, $verify);
		$stmt->bind_result($id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		if($stmt->num_rows!=1 || $id !== $this->id)
			throw new Exception($lang['team'][11]);
		$stmt->close();
		
		if(strlen($pass)<1)
			throw new Exception($lang['register'][3]);
		
		$salt = generateSalt();
		$hash = hashPass($salt, $pass);
		$salt = base64_encode($salt);
		
		$sql = "UPDATE `teams` SET `pass`=?, `salt`=? WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssi", $hash, $salt, $this->id);
		$stmt->execute();
		$stmt->close();
		
		return true;
	}
}
?>
