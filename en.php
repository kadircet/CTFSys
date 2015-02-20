<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

$lang = array();

$lang['team'] = array();
	$lteam = &$lang['team'];
	$lteam[0] = "Teamname cannot contain whitespaces";
	$lteam[1] = "Email adress cannot contain whitespaces";
	$lteam[2] = "Something bad happened while your request is being sent";
	$lteam[3] = "That teamname or mail address is already in use";
	$lteam[4] = "Username/Password combination is invalid";
	$lteam[5] = "This account is waiting for email verification";
	$lteam[6] = "HackMETU CTF Registration";
	$lteam[7] = "<html><body><pre>";
	$lteam[7].= "Hello \${name},\nWe received a registration request from that mail address.\n";
	$lteam[7].= "If you did not make such a request please discard this mail.\n\nOtherwise, to activate your account ";
	$lteam[7].= "<a href='http://ctf.0xdeffbeef.com/?action=verify&name=\${name}&verify=\${verify}'>click here</a> or visit the link below:\n";
	$lteam[7].= "http://ctf.0xdeffbeef.com/?action=verify&name=\${name}&verify=\${verify}";
	$lteam[7].= "\n\nSent from HackMETU CTF Team,\nWe wish you a happy contest :)\n";
	$lteam[7].= "\n\nUsername: \${name}\n";
	$lteam[7].= "Password: \${pass}\n";
	$lteam[7].= "\n0xdeffbeef\nwe hack, you watch\nlove <3\n";
	$lteam[7].= "</pre></body></html>";
	$lteam[8] = "Invalid team ID";
	$lteam[9] = "No team exists with that email address";
	$lteam[10] = "No team exists with that name";
	$lteam[] = "Invalid verification code";
	
$lang['base'] = array();
	$base = &$lang['base'];
	$base[0] = "Teamname/Verification Code combination is invalid";
	$base[1] = "That team has already been verified";
	$base[2] = "Your account has been verified";
	
$lang['header'] = array();
	$header = &$lang['header'];
	$header[0] = "Home";
	$header[1] = "Tasks";
	$header[2] = "Scoreboard";
	$header[3] = "About";
	$header[4] = "Sign Up";
	$header[5] = "Sign In";
	$header[6] = "Login";
	$header[7] = "Forgot Password?";
	$header[8] = "Welcome";
	$header[] = "Change Settings";
	$header[] = "Logout";
	$header[] = "Message Board";
	
$lang['register'] = array();
	$register = &$lang['register'];
	$register[] = "Maximum team size is 3, you cannot add any more members";
	$register[] = "Something bad happened while compeleting your registration, please try again later";
	$register[] = "Your registration has been successfully completed, an email is sent to your mail address";
	$register[] = "You must fill in all the blanks";
	$register[] = "Teamname";
	$register[] = "Email <font color='red'>*</font>";
	$register[] = "Password";
	$register[] = "Members";
	$register[] = "Add Member";
	$register[] = "Register";
	$register[10] = "<font color='red'>*</font> If any problem occurs, your team will be contacted via that mail address";
	
$lang['profile'] = array();
	$profile = &$lang['profile'];
	$profile[] = "Score";
	$profile[] = "Members";
	$profile[] = "Change Password <font color='red'>*</font>";
	$profile[] = "Enter New Password";
	$profile[] = "<font color='red'>*</font> If you do not want to change your password, leave that area blank";
	$profile[] = "Current Password";
	$profile[] = "Enter Current Password";
	$profile[] = "Update";
	$profile[] = "Wrong password";
	$profile[] = "Your profile has been updated succesfully";
	
$lang['forgot'] = array();
	$forgot = &$lang['forgot'];
	$forgot[] = "Email";
	$forgot[] = "Send reset mail";
	$forgot[] = "HackMETU Password Reset Mail";
	$forgot[3] = "<html><body><pre>";
	$forgot[3].= "Hello \${name},\nWe received a password reset request for that mail address.\n";
	$forgot[3].= "If you did not make such a request please discard this mail.\n\nOtherwise, to reset your password ";
	$forgot[3].= "<a href='http://ctf.0xdeffbeef.com/forgot.php?action=forgot&name=\${name}&verify=\${verify}'>click here</a> or visit the link below:\n";
	$forgot[3].= "http://ctf.0xdeffbeef.com/forgot.php?action=forgot&name=\${name}&verify=\${verify}";
	$forgot[3].= "\n\nSent from HackMETU CTF Team,\nWe wish you a happy contest :)\n";
	$forgot[3].= "\n0xdeffbeef\nwe hack, you watch\nlove <3\n";
	$forgot[3].= "</pre></body></html>";
	$forgot[] = "Reset Password";
	$forgot[5] = "An email sent to your mail address to reset the password";
	$forgot[6] = "Your password has been successfully reset";

$lang['board'] = array();
	$board = &$lang['board'];
	$board[] = "HackMETU CTF Scoreboard";
	$board[] = "Team Name";
	$board[] = "Score";

$lang['msg'] = array();
	$msgboard = &$lang['msg'];
	$msgboard[] = "HackMETU CTF Messageboard";
	$msgboard[] = "Team Name";
	$msgboard[] = "Message";
	$msgboard[] = "You need to be logged in to send crazy messages";

	
$lang['task'] = array();
	$ltask = &$lang['task'];
	$ltask[] = "Invalid task ID";
	$ltask[] = "You need to be logged in to send a solution";
	$ltask[] = "Flag";
	$ltask[] = "itCan{}b3_4ny7h1nG";
	$ltask[] = "Got IT!";
	$ltask[] = "No one completed this task yet";
	$ltask[] = "Congz!! You solved it!";
	$ltask[] = "OMG! IT WAS AN INVALID FLAG BRO? ARE U BRUTEFORCING ME???";
?>
