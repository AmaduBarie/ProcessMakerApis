<?php
	
	if (is_post_set())	
	{
		foreach ($_POST as $key => $value)	
		{
			$key = strtolower($key);
			$$key = $value;
			
		}
			
define ('WSDL_URL_BAL', 'http://10.99.0.30/PMWEBSERVICES/AppDevService.asmx?WSDL');
			//include("constants.php");
			  $endpoint = WSDL_URL_BAL;
			  $sessionId = '';
			  $client = new SoapClient( $endpoint );	
			  //$params = array('bracode'=> '201', 'cusnum'=> '1001935');
			  $params = array('bracode'=> $bra, 'cusnum'=> $cus, 'curcode'=> $cur, 'ledcode'=>$led, 'subacctcode'=>$sub);
			  $result = $client->GetAccountBalance($params);
			  $data = $result->GetAccountBalanceResult;
			  $xml = json_decode(json_encode((array) simplexml_load_string(str_replace('&', '&amp;',$data))),1);
			//write name to variable  
			  $BOOKBALANCE = $xml['BOOKBALANCE'];
			  $AVAILABLEBALANCE = $xml['AVAILABLEBALANCE'];
			 // convert variables to array
			//  $ret = array('availbal' => $availbal, 'crntbal' => $crntbal, 'cusname' => $cusname);
			$ret = "|".$BOOKBALANCE."|".$AVAILABLEBALANCE."|";
			echo $ret;		
	}
	else
	{
		echo "|Incomplete Account Number";
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
