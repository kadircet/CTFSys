<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("db.php");
require_once("team.php");

class Message
{
	public $tName = "";
	public $msg = "";
	public $id = 0;
	public $tid = 0;
	public $time = 0;
	public $adm = false;
	
	private $msgT;
	
	function __construct($id=0)
	{
		global $db;
		global $lang;
		global $options;
		
		if($id===0)
			return;
		
		$this->msgT = $lang['msg'];
		$this->id = (int)$id;
		$sql = "SELECT `teamID`, `msg`, `time` FROM `msgBoard` WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->bind_result($this->tid, $this->msg, $this->time);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		$id = (int)$id;
		if($stmt->num_rows!=1 || $id!==$this->id)
			throw new Exception($this->msgT[0]);
		$stmt->close();
		
		$team = new Team($this->tid);
		$this->tName = $team->name;
		$this->adm = $team->status===3;
	}
	
	
	function insert()
	{
		global $db;
		
		$this->msg = htmlspecialchars($this->msg, ENT_QUOTES);
		
		$sql = "INSERT INTO `msgBoard` (`teamID`, `msg`) ";
		$sql.= "VALUES (?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("is", $this->tid, $this->msg);
		$stmt->execute();
	}
}

class Messages
{
	private $msg;
	public $msgs = NULL;
	
	function __construct()
	{
		global $lang;
		
		$this->msg = $lang['msg'];
		$this->msgs = $this->getMsgs();
	}
	
	function getMsgs()
	{
		global $db;
		
		if($this->msgs !== NULL)
			return $this->msgs;
		
		$sql = "SELECT `id` FROM `msgBoard` ORDER BY `id` DESC";
		$res = $db->query($sql);
		
		$this->msgs = array();
		while($tmp = $res->fetch_array())
			$this->msgs[] = new Message($tmp[0]);
		
		return $this->msgs;
	}
}

?>

