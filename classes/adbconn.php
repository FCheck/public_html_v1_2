<?php
class DatabaseConn
{
	public $conn;
	public function __construct ()
	{
		$this->conn = mysqli_connect("196.37.186.218","root","S3nnH3!s3r","fc_webportal");
	}
	
	public function generate_code ($userId, $code, $email = 0)
	{
		$query = $this->conn->query ("SELECT code FROM referralcode WHERE code LIKE '".$code."%'");
		$num = $query->num_rows + 1;
		$num = sprintf("%03d", $num);
		$code = $code.$num;
		$this->insert_code ($userId, $code);
		$this->send_code_ac ($code, $email);
		return $code;
	}
	
	public function insert_code ($userId, $code)
	{
		$this->conn->query ("INSERT INTO referralcode (userId, code, count) VALUES ($userId, '$code', 0)");
		return $this->conn->insert_id;
	}
	
	public function retrieve_code ($userId)
	{
		$query = $this->conn->query ("SELECT code, count FROM referralcode WHERE userId = $userId");
		if ($row = $query->fetch_assoc())
		{
			return $row;
		}
		else
		{
			return 0;
		}
	}
	
	public function insert_codeuse ($refererId, $newuserId, $status)
	{
		/*
		Status values:
			0 = user registered
			1 = user purchased
		*/
		$ip = $_SERVER ['REMOTE_ADDR'];
		$this->conn->query ("INSERT INTO codeuse (refererId, newuserId, status, ip_address) VALUES ($refererId, $newuserId, $status, '$ip')");
		return $this->conn->insert_id;
	}
	
	public function check_ip ()
	{
		$ip = $_SERVER ['REMOTE_ADDR'];
		$query = $this->conn->query ("SELECT COUNT(*) as total FROM codeuse WHERE ip_address LIKE '$ip'");
		$row = $query->fetch_assoc();
		return $row ['total'];
	}
	
	public function update_codeuse ($newuserId, $status)
	{
		$this->conn->query ("UPDATE codeuse SET status = $status WHERE newuserId = $newuserId");
	}
	
	public function retrieve_codeuse ($newuserId)
	{
		$sql = "SELECT codeuseId, refererId, status, updated FROM codeuse WHERE newuserId = $newuserId";
		$query = $this->conn->query ($sql);
		if ($row = $query->fetch_assoc())
		{
			return $row;
		}
		else
		{
			return 0;
		}
	}
	
	public function retrieve_codeuse_list ($refererId)
	{
		$query = $this->conn->query ("SELECT codeuseId, newuserId, status, updated FROM codeuse WHERE refererId = $refererId");
		$arr = array ();
		while ($row = $query->fetch_assoc())
		{
			$arr[] = $row;
		}
		return $arr;
	}
	
	public function insert_holdingcredit ($codeuseId, $userId, $amount, $status)
	{
		/*
		Status values:
			0 = allocated
			1 = available
			2 = redeemed
		*/
		$this->conn->query ("INSERT INTO holdingcredit (codeuseId, userId, amount, status, dateAllocated) VALUES ($codeuseId, $userId, $amount, $status, NOW())");
		return $this->conn->insert_id;
	}
	
	public function update_holdingcredit ($codeuseId, $userId, $status, $dateAllocated = 0, $amountUsed = 0)
	{
		$updateString = "UPDATE holdingcredit SET status = $status";
		if ($dateAllocated != 0)
			$updateString .= ", dateUsed = NOW()";
		if ($amountUsed != 0)
			$updateString .= ", amountUsed = $amountUsed";
		$updateString .= " WHERE codeuseId = $codeuseId AND userId = $userId";
		$this->conn->query ($updateString);
	}
	
	public function retrieve_holdingcredit ($codeuseId, $userId)
	{
		$query = $this->conn->query ("SELECT userId, amount, status, dateAllocated, dateUsed FROM holdingcredit WHERE codeuseId = $codeuseId AND userId = $userId");
		if ($row = $query->fetch_assoc())
		{
			return $row;
		}
		else
		{
			return 0;
		}
	}
	
	public function retrieve_holdingcredit_list ($userId)
	{
		$query = $this->conn->query ("SELECT codeuseId, amount, amountUsed, status, dateAllocated, dateUsed FROM holdingcredit WHERE userId = $userId");
		$arr = array ();
		while ($row = $query->fetch_assoc())
		{
			$arr[] = $row;
		}
		return $arr;
	}
	
	public function retrieve_user_by_code ($code)
	{
		$query = $this->conn->query ("SELECT userId, code, count FROM referralcode WHERE code LIKE '$code'");
		if ($row = $query->fetch_assoc())
		{
			return $row;
		}
		else
		{
			return 0;
		}
	}
	
	public function increment_code ($code)
	{
		$query = $this->conn->query ("UPDATE referralcode SET count = count + 1 WHERE code LIKE '$code'");
	}
	
	public function get_active_campaign_user ($email = 0, $return = 0)
	{
		$url = 'https://fraudcheck.api-us1.com';
		
		if ($email === 0)
		{
			$email = $GLOBALS['user']->email;
		}
		
		$params = array(
		  'api_key' => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
		  'api_action' => 'contact_list',
		  'api_output' => 'json',
		  'filters[email]' => $email,
		  'full' => $return,
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
		
		// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		
		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		
		$response = (string)curl_exec($request); // execute curl fetch and store results in $response
		
		// additional options may be required depending upon your server configuration
		// you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close($request); // close curl object

		$result = json_decode ($response, true);
		
		if ($return == 0)
		{
			if (isset ($result[0]['id']))
				return $result[0]['id'];
			else
				return 0;
		}
		else
			return $result[0];
	}
	
	public function send_code_ac ($code, $email = 0)
	{
		$acId = $this->get_active_campaign_user ($email);
		if (!empty ($acId))
		{
			$url = 'https://fraudcheck.api-us1.com';
			$params = array(
				'api_key'      => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
				'api_action'   => 'contact_edit',
				'api_output'   => 'json',
				'overwrite'    =>  0,
			);
			
			// here we define the data we are posting in order to perform an update
			$post = array(
				'id'                      		 => $acId,
				'field[%MY_COUPON_CODE%,0]'   => $code
			);
			
			// This section takes the input fields and converts them to the proper format
			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			
			// This section takes the input data and converts it to the proper format
			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');
			
			// clean up the url
			$url = rtrim($url, '/ ');
			
			// define a final API request - GET
			$api = $url . '/admin/api.php?' . $query;
			
			$request = curl_init($api); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			
			$response = (string)curl_exec($request); // execute curl fetch and store results in $response
			curl_close($request); // close curl object
		}
	}
	
	public function send_friend_code_ac ($code)
	{
		$url = 'https://fraudcheck.api-us1.com';
		$params = array(
			'api_key'      => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
			'api_action'   => 'contact_edit',
			'api_output'   => 'json',
			'overwrite'    =>  0,
		);
		
		// here we define the data we are posting in order to perform an update
		$post = array(
			'id'                      		 => $this->get_active_campaign_user (),
			'field[%FRIENDS_COUPON_CODE%,0]'   => $code
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// This section takes the input data and converts it to the proper format
		$data = "";
		foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
		$data = rtrim($data, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		
		$response = (string)curl_exec($request); // execute curl fetch and store results in $response
		curl_close($request); // close curl object
	}
	
	public function update_use_count ($userId)
	{
		$refUser = new User (intval ($userId));
		$acUser = $this->get_active_campaign_user ($refUser->email, 1);
		$acUserId = $acUser ['id'];
		
		foreach ($acUser['fields'] as $field)
		{
			if (strcmp ($field['tag'], "%COUPON_REDEEM_COUNT%") == 0)
			{
				$redeemCount = intval ($field['val']);
			}
		}
		$redeemCount += 1;
		$url = 'https://fraudcheck.api-us1.com';
		$params = array(
			'api_key'      => '8b528cafb603631b6e2aeb9750adf874132498c691506f45601cbc59adf4d27e7e2f945a',
			'api_action'   => 'contact_edit',
			'api_output'   => 'json',
			'overwrite'    =>  0,
		);
		
		// here we define the data we are posting in order to perform an update
		$post = array(
			'id'                      		 => $acUserId,
			'field[%COUPON_REDEEM_COUNT%,0]'   => $redeemCount
		);
		
		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		// This section takes the input data and converts it to the proper format
		$data = "";
		foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
		$data = rtrim($data, '& ');
		
		// clean up the url
		$url = rtrim($url, '/ ');
		
		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;
		
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		
		$response = (string)curl_exec($request); // execute curl fetch and store results in $response
		curl_close($request); // close curl object
	}
}
?>
