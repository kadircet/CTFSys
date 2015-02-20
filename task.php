<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("db.php");

if ( !function_exists('getLeft') )
{
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
}

class Task
{
	public $name = "";
	public $desc = "";
	public $solvers = array();
	public $realsolvers = array();
	public $id = 0;
	public $point = 0;
	public $cat = "";
	public $status = 0;
	public $author = "";
	public $link = "";
	public $flag = "";
	public $full = "";
	
	private $msg;
	
	function __construct($id=0)
	{
		global $db;
		global $lang;
		global $options;
		
		if($id===0)
			return;
		
		$this->msg = $lang['task'];
		
		$sql = "SELECT `name`, `desc`, `solvers`, `realsolvers`, `id`, `point`, `cat`, `status`, `author`, `link` FROM `tasks` WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->bind_result($this->name, $this->desc, $this->solvers, $this->realsolvers, $this->id, $this->point, $this->cat, $this->status, $this->author, $this->link);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		$id = (int)$id;
		if($stmt->num_rows!=1 || $id!==$this->id)
			throw new Exception($this->msg[0]);
		$stmt->close();
		
		$team = $_SESSION['team'];
		
		$sql = "SELECT `flag` FROM `flags` WHERE `taskID`=? AND `teamID`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ii", $id, $team->id);
		$stmt->bind_result($this->flag);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$stmt->close();
		
		$this->solvers = array_filter(explode(",", $this->solvers));
		$this->realsolvers = array_filter(explode(",", $this->realsolvers));
		$this->desc = explode("<%#:#%>", $this->desc);
		$this->full = $this->desc;
		if($options['lang'] === "TR")
			$this->desc = $this->desc[1];
		else
			$this->desc = $this->desc[0];
		$this->desc = eval($this->desc);
	}
	
	function update()
	{
		global $db;
		global $team;
		
		$this->name = htmlspecialchars($this->name, ENT_QUOTES);
		$this->cat = htmlspecialchars($this->cat, ENT_QUOTES);
		$this->desc = $this->desc;
		$this->solvers = implode(',', $this->solvers);
		$this->realsolvers = implode(',', $this->realsolvers);
		$this->author = htmlspecialchars($this->author, ENT_QUOTES);
		//$this->flag = htmlspecialchars($this->flag, ENT_QUOTES);
		
		if($team->locale === "TR")
			$this->full[1] = $this->desc;
		else
			$this->full[0] = $this->desc;
		
		$this->desc = implode("<%#:#%>", $this->full);
		$sql = "UPDATE `tasks` SET `name`=?, `desc`=?, `solvers`=?, `realsolvers`=?, `point`=?, `cat`=?, `status`=?, `author`=?, `link`=? WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssssisissi", $this->name, $this->desc, $this->solvers, $this->realsolvers, $this->point, $this->cat, $this->status, $this->author, $this->link, $this->id);
		$stmt->execute();
		$stmt->close();
	}
	
	function insert()
	{
		global $db;
		
		$this->name = htmlspecialchars($this->name, ENT_QUOTES);
		$this->cat = htmlspecialchars($this->cat, ENT_QUOTES);
		$this->solvers = implode(',', $this->solvers);
		$this->realsolvers = implode(',', $this->realsolvers);
		$this->author = htmlspecialchars($this->author, ENT_QUOTES);
		//$this->flag = htmlspecialchars($this->flag, ENT_QUOTES);
		
		$sql = "INSERT INTO `tasks` (`name`, `desc`, `solvers`, `realsolvers`, `point`, `cat`, `status`, `author`, `link`) ";
		$sql.= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssssisiss", $this->name, $this->desc, $this->solvers, $this->realsolvers, $this->point, $this->cat, $this->status, $this->author, $this->link);
		$stmt->execute();
	}
	
	private function checkFlag($flag)
	{
		return $this->flag === $flag;
	}
	
	function hasSolved($id)
	{
		return in_array($id, $this->realsolvers);
	}
	
	function attempt($flag)
	{
		global $db;
		global $admin;
		
		if(getLeft()<=0)
			throw new Exception("Time is up :((");
		
		$team = $_SESSION['team'];
		
		$valid = $this->checkFlag($flag);
		$flag = htmlspecialchars($flag, ENT_QUOTES);
		
		$sql = "INSERT INTO `attempts` (`teamID`, `taskID`, `time`, `flag`, `status`) VALUES (?, ?, NOW(), ?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("iisi", $team->id, $this->id, $flag, $valid);
		$stmt->execute();
		$stmt->close();
		
		if($valid===true && $this->hasSolved($team->id)===false && $admin===false)
			$this->addSolver($team->id);
		
		return $valid;
	}
	
	private function addSolver($id)
	{	
		global $db;
		global $team;
		
		if(isActive())
			$this->solvers[] = $id;
		$this->realsolvers[] = $id;
		$solvers = implode(",", $this->solvers);
		$realsolvers = implode(",", $this->realsolvers);
		
		if(count($this->realsolvers)===1)
			$this->openNext();
		
		$sql = "UPDATE `tasks` SET `solvers`=?, `realsolvers`=? WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("ssi", $solvers, $realsolvers, $this->id);
		$stmt->execute();
		$stmt->close();
		
		$nSolvers = max(4-count($this->realsolvers),0);
		$points = $this->point + $nSolvers*2;
		$team->updScore();
		if(isActive())
			$team->score += $points;
		$team->realscore += $points;
		$team->update();
	}
	
	private function openNext()
	{
		global $db;
		
		$id = 0;
		
		$sql = "SELECT `id` FROM `tasks` WHERE `point`>? AND `cat`=? ORDER BY `point` ASC LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("is", $this->point, $this->cat);
		$stmt->bind_result($id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		
		$sql = "UPDATE `tasks` SET `status`=1 WHERE `id`=?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}
}

class Tasks
{
	private $msg;
	public $tasks = NULL;
	public $cats = NULL;
	
	function __construct()
	{
		global $lang;
		
		$this->msg = $lang['task'];
		$this->tasks = $this->getTasks();
		$this->cats = $this->getCats();
	}
	
	function getTasks()
	{
		global $db;
		
		if($this->tasks !== NULL)
			return $this->tasks;
		
		$sql = "SELECT `id` FROM `tasks` ORDER BY `point` ASC";
		$res = $db->query($sql);
		
		$tasks = array();
		while($tmp = $res->fetch_array())
			$tasks[] = new Task($tmp[0]);
		
		return $tasks;
	}
	
	function getCats()
	{
		if($this->cats !== NULL)
			return $this->cats;
		
		$cats = array();
		foreach($this->tasks as $task)
		{
			if(in_array($task->cat, $cats)===false)
				$cats[] = $task->cat;
			
			$this->tasks[$task->cat][] = $task;
		}
		
		return $cats;
	}
}

?>

