<?php
	
	if (is_post_set())	//Check that we have received some post data.
	{
		foreach ($_POST as $key => $value)	//Loop through all key value pairs in the $_POST array
		{
			$key = strtolower($key);
			$$key = $value;
				
		}
			
define ('WSDL_URL_BAL', 'http://10.99.0.30/PMWEBSERVICES/AppDevService.asmx?WSDL');
			//include("constants.php");
			  $endpoint = WSDL_URL_BAL;
			  $sessionId = '';
			  $client = new SoapClient( $endpoint );	
			  $params = array('cur_code'=> $cur_code);
			  $result = $client->GetRateForProcessMaker($params);
			  $data = $result->GetRateForProcessMakerResult;
			  $xml = json_decode(json_encode((array) simplexml_load_string(str_replace('&', '&amp;',$data))),1);
			  $BUY_RATE = $xml['RATEDETAILS']['BUY_RATE'];
			  $SELL_RATE = $xml['RATEDETAILS']['SELL_RATE'];	
			  $MID_RATE = $xml['RATEDETAILS']['MID_RATE'];	
			 
			$ret = "|".$BUY_RATE."|".$SELL_RATE."|".$MID_RATE."|";
			echo $ret;		
	}
	else
	{
		echo "|Enter Curency Code";
	}
	
	function is_post_set()	//isset does not work on $_POST, so we have to create a custom function
	{
		foreach ($_POST as $key => $value)	//Loop through all key value pairs in the $_POST array
		{
			if ($value != '')	//If the value is not empty
			{
				return true;	//$_POST contains a non empty value
			}
		}
		return false;	//$_POST is empty or contains only empty values
	}
?>
