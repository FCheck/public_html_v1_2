<?php
class Referral
{
	public $dbconn;
	
	public function __construct ()
	{
		$this->dbconn = new DatabaseConn ();
	}
}
?>