<?php
class Phone
{
	private $id;
	public $code;
	public $number;
	public $type;
	public $userId;
	
	public function __construct ($data)
	{
		$this->id = $data ['id'];
		$this->code = $data ['code'];
		$this->number = $data ['number'];
		$this->type = $data ['type'];
		$this->userId = $data ['userId'];
	}
}
?>