<?php
class CreditData
{
	public $supplier;
	public $accountType;
	public $dateOpened;
	public $openingBalance;
	public $instalment;
	public $currentBalance;
	public $overdueAmount;
	public $years = array ();
	
	public function __construct ($arr)
	{
		if (is_array ($arr))
		{
			$this->supplier = $arr ['Supplier'];
			$this->accountType = $arr ['AccountType'];
			$this->dateOpened = $arr ['DateOpened'];
			if (isset ($arr ['openingBalance']))
				$this->openingBalance = $arr ['OpeningBalance'];
			else
				$this->openingBalance = 0;
			$this->instalment = $arr ['Instalment'];
			$this->currentBalance = $arr ['CurrentBalance'];
			$this->overdueAmount = $arr ['OverdueAmount'];
			$temp = explode (",",$arr ['PaymentHistory']);

			foreach ($temp as $history)
			{
				$keyvalue = explode (":",$history);
				if (isset ($keyvalue[1]))
				{
					$kv = array ();
					$kv [0] = substr ($keyvalue[0],0,5);
					$kv [1] = substr ($keyvalue[0],5);
					$kv [2] = $keyvalue[1];
					$check = false;
					$check2 = false;
					$count = 0;
					foreach ($this->years as $year)
					{
						if (strcmp ($year->year, $kv [0]) == 0)
						{
							$check = $count;
							$check2 = true;
						}
						$count++;
					}
					if (!$check && !$check2)
					{
						$this->years [] = new CreditYear ($kv);
					}
					else
					{
						$this->years [$check]->add_entry ($kv);
					}
				}
			}
		}
		else
		{
			//do nothing
		}
	}
	
	public function print_payment_history ()
	{
		rsort ($this->years);
		$return = "<table style=\"border-spacing: 3px !important;border-collapse: separate;\"><tr>";
		foreach ($this->years as $year)
		{
			$return .= "<td colspan=\"".$year->total_entries()."\"  style=\"border-color:gray; border-style:solid; border-width:2px;\">".$year->print_year ()."</td>";
		}
		$return .= "</tr><tr>";
		foreach ($this->years as $year)
		{
			foreach ($year->entries as $entry)
			{
				$return .= "<td style=\"border-color:gray; border-style:solid; border-width:2px; text-align:center;\">".$entry->month."</td>";
			}
		}
		$return .= "</tr><tr>";
		foreach ($this->years as $year)
		{
			$return .= $year->print_entries ();
		}
		$return .= "</tr></table><br><br>";

		return $return;
	}
	
	public function print_payment_history_pdf ()
	{
		rsort ($this->years);
		$return = "<table style=\"border-spacing: 3px !important;border-collapse: separate;\"><tr>";
		foreach ($this->years as $year)
		{
			$return .= "<td colspan=\"".$year->total_entries()."\"  style=\"border-color:gray; border-style:solid; border-width:2px;\">".$year->print_year_pdf ()."</td>";
		}
		$return .= "</tr><tr>";
		foreach ($this->years as $year)
		{
			foreach ($year->entries as $entry)
			{
				$return .= "<td style=\"border-color:gray; border-style:solid; border-width:2px; text-align:center;\">".$entry->month."</td>";
			}
		}
		$return .= "</tr><tr>";
		foreach ($this->years as $year)
		{
			$return .= $year->print_entries ();
		}
		$return .= "</tr></table><br><br>";

		return $return;
	}
}

class CreditYear
{
	public $year;
	public $entries = array ();
	
	public function __construct ($arr)
	{
		if (is_array ($arr))
		{
			$this->year = $arr[0];
			$this->entries [] = new CreditPaymentHistory ($arr);
			$this->month = $arr[0];
			$this->value = $arr[1];
		}
		else
		{
			//do nothing
		}
	}
	
	public function add_entry ($arr)
	{
		$this->entries [] = new CreditPaymentHistory ($arr);
	}
	
	public function order_entries ()
	{
		usort($this->entries, function($a, $b)
		{
			return strcmp($b->month, $a->month);
		});
	}
	
	public function total_entries ()
	{
		return sizeof ($this->entries);
	}
	
	public function print_entries ()
	{
		$this->order_entries ();
		$return = "";
		foreach ($this->entries as $entry)
		{
			$code = $this->get_colour_code ($entry);
			switch ($code)
			{
				case 0: $colour = "gray";
				break;
				case 1: $colour = "green";
				break;
				case 2: $colour = "orange";
				break;
				case 3: $colour = "red";
				break;
			}
			$return .= "<td style=\"border-color:$colour; border-style:solid; border-width:2px; text-align:center;\">".$entry->value."</td>";
		}
		return $return;
	}
	
	public function print_year ()
	{
		$code = 0;
		/*
		0 = neutral
		1 = good
		2 = caution
		3 = bad
		*/
		foreach ($this->entries as $entry)
		{
			$compare = $this->get_colour_code ($entry);
			if ($compare > $code)
				$code = $compare;
		}
		switch ($code)
		{
			case 0: $return = "<img src=\"../images/dot_neutral.png\" />";
			break;
			case 1: $return = "<img src=\"../images/dot_positive.png\" />";
			break;
			case 2: $return = "<img src=\"../images/dot_lowrisk.png\" />";
			break;
			case 3: $return = "<img src=\"../images/dot_negative.png\" />";
			break;	
		}
		$return .= " ".$this->year;
		return $return;
	}
	
	public function print_year_pdf ()
	{
		$code = 0;
		/*
		0 = neutral
		1 = good
		2 = caution
		3 = bad
		*/
		foreach ($this->entries as $entry)
		{
			$compare = $this->get_colour_code ($entry);
			if ($compare > $code)
				$code = $compare;
		}
		switch ($code)
		{
			case 0: $return = "<img src=\"images/dot_neutral.png\" />";
			break;
			case 1: $return = "<img src=\"images/dot_positive.png\" />";
			break;
			case 2: $return = "<img src=\"images/dot_lowrisk.png\" />";
			break;
			case 3: $return = "<img src=\"images/dot_negative.png\" />";
			break;	
		}
		$return .= " ".$this->year;
		return $return;
	}
	
	public function get_colour_code ($entry)
	{
		/*
		0 = neutral
		1 = good
		2 = caution
		3 = bad
		*/
		$code = 0;
		switch ($entry->value)
		{
			case '=': $code = 0;
			break;
			case '0': $code = 1;
			break;
			case '1': $code = 2;
			break;
			case '2': $code = 2;
			break;
			case '3': $code = 2;
			break;
			case '4': $code = 3;
			break;
			case '5': $code = 3;
			break;
			case '6': $code = 3;
			break;
			case '7': $code = 3;
			break;
			case '8': $code = 3;
			break;
			case '9': $code = 3;
			break;
			case 'C': $code = 1;
			break;
			case 'E': $code = 2;
			break;
			case 'F': $code = 2;
			break;
			case 'G': $code = 1;
			break;
			case 'H': $code = 2;
			break;
			case 'I': $code = 3;
			break;
			case 'J': $code = 3;
			break;
			case 'K': $code = 1;
			break;
			case 'L': $code = 3;
			break;
			case 'M': $code = 1;
			break;
			case 'P': $code = 1;
			break;
			case 'S': $code = 1;
			break;
			case 'T': $code = 1;
			break;
			case 'V': $code = 1;
			break;
			case 'W': $code = 3;
			break;
			case 'X': $code = 2;
			break;
			case 'Z': $code = 2;
			break;
			case 'AA': $code = 3;
			break;
			case 'AC': $code = 3;
			break;
			
		}
		return $code;
	}
}

class CreditPaymentHistory
{
	public $month;
	public $value;
	
	public function __construct ($arr)
	{
		if (is_array ($arr))
		{
			$this->month = $arr[1];
			$this->value = $arr[2];
		}
		else
		{
			//do nothing
		}
	}
}
?>