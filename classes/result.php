<?php
class Result extends ThreeSixtyReport
{
	protected $ref = "";
	protected $account_name = "";
	protected $name = "";
	protected $surname = "";
	protected $id = "";
	protected $date_received = "";
	protected $date_id_complete = "";
	protected $date_matric_complete = "";
	protected $date_criminal_complete = "";
	protected $comment = "";
	protected $cost_centre_code = "";
	protected $cost_centre_name = "";
	protected $criminal_comment = "";
	protected $display = true;
	
	public function __construct ($row)
	{
		$this->ref = substr($row ['idChkTxnId'],0,5);
		$this->account_name = strtoupper ($row ['accountName']);
		$this->name = ucfirst (strtolower ($row ['candidateFirstName']));
		$this->surname = ucfirst (strtolower ($row ['candidateLastName']));
		$this->id = $row ['candidateIdNumber'];
		$this->date_received = $row ['receivedDateTime'];
		$this->date_id_complete = $row ['idChkCompletedDate'];
		$this->date_matric_complete = $row ['matricCompletedDate'];
		$this->date_criminal_complete = $row ['crimChkCompletedDate'];
		$this->cost_centre_code = $row ['costcentreCode'];
		$this->cost_centre_name = $row ['costcentreName'];
		$this->comment = $row ['comments'];
		if (isset ($row ['crimChkStatus']))
		{
			switch ($row ['crimChkStatus'])
			{
				case 'PROCESSED':
					$this->criminal_comment = "Processed";
				break;
				case 'PENDING_APPROVAL':
					$this->criminal_comment = "Pending Approval";
				break;
				case 'PENDING_UPLOAD':
					$this->criminal_comment = "Pending Upload";
				break;
				case 'PENDING_RESULT':
					$this->criminal_comment = "Pending Result";
				break;
			}
		}
		else
		{
			$this->criminal_comment = "Not Available";
		}
	}
	
	public function getArr ()
	{
		$arr = array ();
		$arr [] = $this->ref;
		$arr [] = $this->name;
		$arr [] = $this->surname;
		$arr [] = $this->id;
		$arr [] = $this->date_received;
		$arr [] = $this->date_id_complete;
		$arr [] = $this->date_matric_complete;
		$arr [] = $this->date_criminal_complete;
		$arr [] = $this->comment;
		return $arr;
	}
}
?>