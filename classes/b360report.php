<?php
class ThreeSixtyReport extends Api
{
	public $results = array ();
	public $total_results = 0;
	public $userId = 0;
	public $startDate = "";
	public $endDate = "";
	public $cost_centre = 'NULL';
	public $matric_status = 'NULL';
	public $criminal_status = 'NULL';
	public $id_number = 'NULL';
	public $filter_type = 0;
	public function __construct ()
	{
		
	}
	
	public function display_results ($page = 1, $numperpage = 30)
	{
		$output = "";
		$count = 0;
		$refcount = 0;
		$rowcount = 0;
		$pages = ceil($this->total_results/$numperpage);
		$output .= "<table style=\"padding:10px; font-size:13px; width:100%\"><tr><td align=\"left\">";
		if ($page != 1)
		{
			$prev = $page - 1;
			$output .= "<a href=\"javascript: update_results ($prev)\">";
		}
		$output .= "&lt; Previous";
		if ($page != 1)
			$output .= "</a>";
		$output .= "</td><td align=\"center\">Viewing Page $page of $pages (".$this->total_results." Results Found)</td><td align=\"right\">";
		error_log(print_r($this->total_results,TRUE));
		if ($page != $pages)
		{
			$next = $page + 1;
			$output .= "<a href=\"javascript: update_results ($next)\">";
		}
		$output .= "Next &gt;";
		if ($page != $pages)
		{
			$output .= "</a>";
		}
		$output .= "</td></tr></table>";
		$output .= "<table id=\"reports\" cellspacing=\"0\" cellpadding=\"5\">";
		$output .= "<tr><th>Reference</th>
				<th>Name</th>
				<th>Surname</th>
				<th>ID Number</th>
				<th>Date Received</th>
				<th>Date Matric Complete</th>
				<th>Matric Comment</th>
				<th>Date Criminal Complete</th>
				<th>Criminal Status</th></tr>";
		$num = sizeof ($this->results);

		foreach ($this->results as $result)
		{
			$refcount++;
			if ($result->display == true)
			{
					//$ref = substr ($result->account_name,0,2)."-".$refcount;
					$output .= "<tr class=\"row$rowcount\">";
						$output .= "<td>".$result->ref."</td>"
							."<td>".$result->name."</td>"
							."<td>".$result->surname."</td>"
							."<td>".$result->id."</td>"
							."<td>".$result->date_received."</td>"
							."<td>".$result->date_matric_complete."</td>"
							."<td>".$result->comment."</td>"
							."<td>".$result->date_criminal_complete."</td>"
							."<td>".$result->criminal_comment."</td>";
					$output .= "</tr>";
					if ($rowcount == 0)
						$rowcount = 1;
					else
						$rowcount =0;
				$count++;
			}
		}
		$output .= "</table>";
		$output .= "<div style=\"padding:10px; line-height:25px; text-align:center;\">Pages: ";
			
		for ($i = 1; $i <= $pages; $i++)
		{
			if ($i == 1 || ($i >= ($page - 10) && $i <= ($page + 10)) || $i == $pages)
			{
				if ($i != $page)
					$output .= "<a href=\"javascript: update_results ($i)\">$i</a> ";
				else
					$output .= "$i&nbsp;";
			}
			else if ($i == 2 || $i == $pages - 1)
				$output .= ".. ";
		}
		$output .= "</div>";
		if ($num > 0)
			return $output;
		else
			return "<h2 align=\"center\">No results found</h2>";
	}
	
	public function cost_centre_arr ()
	{
		$costcentre = array ();
		foreach ($this->results as $result)
		{
			$costcentre [$result->cost_centre_code] = $result->cost_centre_name;
		}
		return $costcentre;
	}
	
	public function generate_csv ()
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');

		// output the column headings
		fputcsv($output, array('Reference', 'Name', 'Surname', 'ID Number', 'Date Received', 'Date ID Complete', 'Date Matric Complete', 'Date Criminal Complete', 'Comment'));
		$refcount = 0;
		foreach ($this->results as $result)
		{
			$refcount ++;
			if ($result->display == true)
			{
				$arr = $result->getArr ();
				$arr [0] = substr ($result->account_name,0,2)."-".$refcount;
				fputcsv($output,$arr);
			}
		}
		fclose ($output);
		error_log(print_r($results, TRUE));
		error_log(print_r($refcount, TRUE));
	}
	
	public function call_report ($page)
	{
		if ($page > 0)
		{
			$start_row = ($page - 1)*30;
			$num_rows = 30;
		}
		else
		{
			$start_row = 0;
			$num_rows = 10000;
		}
		//$userId = $this->userId;
		$userId = $this->userId;
		$startDate = $this->startDate;
		$endDate = $this->endDate;
		$cost_centre_code = $this->cost_centre;
		$matric_status = $this->matric_status;
		$criminal_status = $this->criminal_status;
		$id_number = $this->id_number;
		$request = "";
		$start = strtotime ($startDate) * 1000;
		$end = strtotime ($endDate) * 1000;
		if ($this->filter_type == 0)
		{
			$url = "statusreport/get/data2?accountId=$userId&from=$start&to=$end";
			if (strcmp ($cost_centre_code, "NULL") != 0)
				$url .= "&costcentreId=$cost_centre_code";
			if (strcmp ($matric_status, "NULL") != 0)
				$url .= "&matricStatus=$matric_status";
			if (strcmp ($id_number, "NULL") != 0)
				$url .= "&idNumber=$id_number";
			if (strcmp ($criminal_status, "NULL") != 0)
				$url .= "&criminalStatus=$criminal_status";
			$url .= "&firstRecord=$start_row&recordCount=$num_rows";
		}//criminal_check_status
		else if ($this->filter_type == 1)
		{
			$url = "statusreport/get/data2Complete?accountId=$userId&from=$start&to=$end";
			if (strcmp ($cost_centre_code, "NULL") != 0)
				$url .= "&costcentreId=$cost_centre_code";			
			if (strcmp ($id_number, "NULL") != 0)
				$url .= "&idNumber=$id_number";
			$url .= "&firstRecord=$start_row&recordCount=$num_rows";
		}
		else
		{
			$url = "statusreport/get/data2InPorgress?accountId=$userId&from=$start&to=$end";
			if (strcmp ($cost_centre_code, "NULL") != 0)
				$url .= "&costcentreId=$cost_centre_code";			
			if (strcmp ($id_number, "NULL") != 0)
				$url .= "&idNumber=$id_number";
			$url .= "&firstRecord=$start_row&recordCount=$num_rows";
		}
		$return = $this->submit_api_request ($request, $url);
		$response = json_decode ($return, true);
		if (sizeof ($response) > 0)
		{
			foreach ($response as $row)
			{
				$this->results[] = new Result ($row);
			}
			if ($this->filter_type == 0)
			{
				$url = "statusreport/get/data2/count?accountId=$userId&from=$start&to=$end";
				if (strcmp ($cost_centre_code, "NULL") != 0)
					$url .= "&costcentreId=$cost_centre_code";
				if (strcmp ($matric_status, "NULL") != 0)
					$url .= "&matricStatus=$matric_status";
				if (strcmp ($id_number, "NULL") != 0)
					$url .= "&idNumber=$id_number";
			}
			else if ($this->filter_type == 1)
			{		
				$url = "statusreport/get/data2Complete/count?accountId=$userId&from=$start&to=$end";
				if (strcmp ($cost_centre_code, "NULL") != 0)
					$url .= "&costcentreId=$cost_centre_code";			
				if (strcmp ($id_number, "NULL") != 0)
					$url .= "&idNumber=$id_number";
			}
			else
			{
				$url = "statusreport/get/data2InPorgress/count?accountId=$userId&from=$start&to=$end";
				if (strcmp ($cost_centre_code, "NULL") != 0)
					$url .= "&costcentreId=$cost_centre_code";			
				if (strcmp ($id_number, "NULL") != 0)
					$url .= "&idNumber=$id_number";
			}
			$return = $this->submit_api_request ($request, $url);
			$row = json_decode ($return, true);
			$this->total_results = $row['count'];
		}
	}

}
?>
