<?php
class Api
{
	public function submit_api_request ($request, $url, $type = 0)
	{
		$url = str_replace (" ", "%20", $url);
		//$url = "http://fc-php-api-svr:8181/fraudcheck3-php-portal-api/rest/".$url;
		$url = "http://154.0.170.13:8080/fraudcheck3-php-portal-api/rest/".$url;
		$ch = curl_init($url);
		if ($type == 1)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$output = curl_exec($ch);
		//$output = "";
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($output === false)
			$return =  'Curl error: ' . curl_error($ch);
		else
			$return =  $output;
		if(curl_errno($ch) || $httpcode != 200)
		{
			if($httpcode != 204)
			{
				$message = "URL: $url\n\n"
						."Request: $request\n\n"
						."Response: $output\n\n"
						."HTTP Code: $httpcode\n\n"
						."CURL Error: ".curl_error($ch)."\n\n\n";
			
				//$this->log_api_error ($message);
			}
		}
		else
		{
			$message = "URL: $url\n\n"
					."Request: $request\n\n"
					."Response: $output\n\n"
					."HTTP Code: $httpcode\n\n"
					."CURL Error: ".curl_error($ch)."\n\n\n";
		
			//$this->log_api_error ($message); //for debugging purposes
		}
		curl_close($ch);
		//echo $url;
		
		return $return;
	}
	
	public function submit_sharpspring_request ($url, $data)
	{
		$data = json_encode($data);                                                                   
	   	$ch = curl_init($url);                                                                        
	   	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                              
	   	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                  
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                               
	   	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                   
		   'Content-Type: application/json',                                                         
		   'Content-Length: ' . strlen($data)                                                        
	   	));                                                                                           
																									 
	   	$result = curl_exec($ch);                                                                     
	   	curl_close($ch);                                                                              
				
		$response = json_decode ($result, true);
		return $response;
	}
	
	public function log_api_error ($message)//I foresee a love-hate relationship with this Slack integration.
	{
		//$url = "https://hooks.slack.com/services/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"; //development
		/*$url = "https://hooks.slack.com/services/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"; //live
		$data = json_encode(array ('text'=>$message));                                                                  
	   	$ch = curl_init($url); 
                                                   
	   	curl_setopt($ch, CURLOPT_POST, 1);                                           
	   	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                  
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                                      
																									 
	   	$result = curl_exec($ch); 
		if(curl_errno($ch))
		{
			echo 'error:' . curl_error($ch);
		}                                                                    
	   	curl_close($ch);                                                                              
				
		$response = json_decode ($result, true);
		echo $response;*/
	}
}
    ?>
