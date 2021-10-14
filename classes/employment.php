<?php
class Employment
{
	public $firstReportedDate;
	public $employer;
	public $lastUpdatedDate;
	
	public function __construct ($arr)
	{
		if (is_array ($arr))
		{
			$this->firstReportedDate = $arr['firstReportedDate'];
			$this->employer = $arr['employer'];
			$this->lastUpdatedDate = $arr['lastUpdatedDate'];
		}
		else
		{
			//do nothing
		}
	}
}
?>