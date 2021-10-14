<?php
class Rule
{
	public $ruleId;
	public $category;
	public $override;
	public $overrideReason;
	public $disputeId;
	public $weighting;
	public $tooltip;
	public $ruleData;
	public $ruleName;
	public $overrideComments;
	public $creditData = array ();
	
	public function __construct ($arr)
	{
		if (is_array ($arr))
		{
			$this->ruleId = $arr ['ruleId'];
			$this->category = $arr ['category'];
			$this->override = $arr ['override'];
			$this->overrideReason = $arr ['overrideReason'];
			$this->disputeId = $arr ['disputeId'];
			$this->weighting = $arr ['weighting'];
			$this->tooltip = $arr ['tooltip'];
			$this->ruleData = $arr ['ruleData'];
			$this->ruleName = $arr ['ruleName'];
			$this->overrideComments = $arr ['overrideComments'];
			$this->create_credit_info ();
		}
		else
		{
			//do nothing
		}
	}
	
	public function print_rule ()
	{
		$return = "<tr>";
		if ($this->weighting > 0)
		{
			$return .= "<td><img src=\"../images/dot_positive.png\" /></td>";
		}
		else if ($this->weighting == 0)
		{
			$return .= "<td><img src=\"../images/dot_neutral.png\" /></td>";
		}
		else if ($this->weighting > -10)
		{
			$return .= "<td><img src=\"../images/dot_lowrisk.png\" /></td>";
		}
		else
		{
			$return .= "<td><img src=\"../images/dot_negative.png\" /></td>";
		}
		$return .= " <td>".$this->ruleName;
		if (!empty ($this->ruleData) && strcmp ($this->category, "Credit") != 0)
			$return .= "<br><span style=\"font-size:12px; color:#666; font-style:italic;\">".$this->ruleData."</span>";
		$return .= "</td>"
                . " <td>[".$this->weighting."]</td>"
                . "</tr>";
		if (strcmp ($this->category, "Credit") == 0)
		{
			$return .= $this->print_credit_data ();
		}
		return $return;
	}
	
	public function print_rule_pdf ()
	{
		$return = "<tr>";
		if ($this->weighting > 0)
		{
			$return .= "<td width=\"40\"><img src=\"images/dot_positive.png\" /></td>";
		}
		else if ($this->weighting == 0)
		{
			$return .= "<td width=\"40\"><img src=\"images/dot_neutral.png\" /></td>";
		}
		else if ($this->weighting > -10)
		{
			$return .= "<td width=\"40\"><img src=\"images/dot_lowrisk.png\" /></td>";
		}
		else
		{
			$return .= "<td width=\"40\"><img src=\"images/dot_negative.png\" /></td>";
		}
		$return .= " <td width=\"490\">".$this->ruleName;
		if (!empty ($this->ruleData) && strcmp ($this->category, "Credit") != 0)
			$return .= "<br><font color=\"#666\" size=\"9\">".$this->ruleData."</font>";
		$return .= "</td>"
                . " <td width=\"50\">[".$this->weighting."]</td>"
                . "</tr>";
		if (strcmp ($this->category, "Credit") == 0)
		{
			$return .= $this->print_credit_data_pdf ();
		}
		return $return;
	}
	
	private function create_credit_info ()
	{
		if (strpos($this->ruleData,'|') !== false)
		{
			$data = explode ("|",$this->ruleData);
			foreach ($data as $credit)
			{
				$items = explode (";",$credit);
				if (isset ($items [6]))
				{
					$cd = array ();
					for ($i = 0; $i <= 6; $i++)
					{
						$temp = explode (":",$items[$i]);
						$temp[0] = str_replace (" ", "", $temp[0]);
						$cd [$temp[0]] = $temp [1];
					}
					$temp = str_replace ("Payment History: ","",$items[7]);
					$cd ["PaymentHistory"] = $temp;
					$this->creditData [] = new CreditData ($cd);
				}
			}
		}
	}
	
	private function print_credit_data ()
	{
		$return = "";
		if (strpos($this->ruleData,'|') !== false)
		{		
			foreach ($this->creditData as $credit)
			{
				$return .= "<tr><td colspan=\"3\"><table width=\"100%\">";
				$return .= "<tr><th width=\"15%\">Supplier</th><th width=\"14%\">Account Type</th><th width=\"14%\">Date Opened</th><th width=\"14%\">Opening Balance</th><th width=\"14%\">Instalment</th><th width=\"14%\">Current Balance</th><th width=\"14%\">Overdue Amount</th></tr><tr>";
					
				$return .= "<td>".$credit->supplier."</td>";
				$return .= "<td>".$credit->accountType."</td>";
				$return .= "<td>".$credit->dateOpened."</td>";
				$return .= "<td>".number_format ($credit->openingBalance, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->instalment, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->currentBalance, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->overdueAmount, 2, '.', ' ')."</td>";
				$return .= "</tr></table>";
				$return .= $credit->print_payment_history ();
			}
			$return .= "<span style=\"font-size:16px;\">Total Current Balance: R ".number_format ($this->total_current_balance (), 2, '.', ' ')."";
			$return .= "<br><br>Total Instalment: R ".number_format ($this->total_instalment (), 2, '.', ' ')."</span><br><br></td></tr>";
		}
		else if (strpos($this->ruleName,'Empirica') !== false)
		{
			$return .= "<tr><td colspan=\"3\" style=\"font-size:28px;\">";
			$return .= "Empirica Score: ".number_format ($this->ruleData, 0, '.', ' ')."<br><br>";
			$return .= "</td></tr>";
		}
		return $return;
	}
	
	private function print_credit_data_pdf ()
	{
		$return = "";
		if (strpos($this->ruleData,'|') !== false)
		{		
			foreach ($this->creditData as $credit)
			{
				$return .= "<tr><td colspan=\"3\">";
				$return .= "<table style=\"width:100%\">";
				$return .= "<tr><th style=\"width:20%\">Supplier</th><th style=\"width:16%\">Date Opened</th><th style=\"width:16%\">Opening Balance</th><th style=\"width:16%\">Instalment</th><th style=\"width:16%\">Current Balance</th><th style=\"width:16%\">Overdue Amount</th></tr><tr>";
					
				$return .= "<td>".$credit->supplier."</td>";
				//$return .= "<td>".$credit->accountType."</td>";
				$return .= "<td>".$credit->dateOpened."</td>";
				$return .= "<td>".number_format ($credit->openingBalance, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->instalment, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->currentBalance, 2, '.', ' ')."</td>";
				$return .= "<td>".number_format ($credit->overdueAmount, 2, '.', ' ')."</td>";
				$return .= "</tr></table>";
				
				
				//$return .= $credit->print_payment_history_pdf ();
				$return .= "</td></tr>";
			}
			$return .= "<tr><td colspan=\"3\"><font size=\"13\">Total Current Balance: R ".number_format ($this->total_current_balance (), 2, '.', ' ')."";
			$return .= "<br><br>Total Instalment: R ".number_format ($this->total_instalment (), 2, '.', ' ')."</font><br><br></td></tr>";
		}
		else if (strpos($this->ruleName,'Empirica') !== false)
		{
			$return .= "<tr><td colspan=\"3\" style=\"font-size:18px;\">";
			$return .= "Empirica Score: ".number_format ($this->ruleData, 0, '.', ' ')."<br><br>";
			$return .= "</td></tr>";
		}
		return $return;
	}
	
	
	private function total_current_balance ()
	{
		$total = 0;
		foreach ($this->creditData as $credit)
		{
			$total += $credit->currentBalance;
		}
		return $total;
	}
	
	private function total_instalment ()
	{
		$total = 0;
		foreach ($this->creditData as $credit)
		{
			$total += $credit->instalment;
		}
		return $total;
	}
}
?>