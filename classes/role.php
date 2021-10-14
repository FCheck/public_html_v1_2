<?php
class Role
{
	private $id;
	public $role;
	
	public function __construct ($data)
	{
		$this->id = $data ['id'];
		$this->role = $data ['role'];
	}
}
?>