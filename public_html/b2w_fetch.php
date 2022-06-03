<?php
	
	if (is_post_set())	
	{
		foreach ($_POST as $key => $value)	
		{
			$key = strtolower($key);
			$$key = $value;
				
		}
			
define ('WSDL_URL_BAL', 'https://ibank.gtb.sl/GTBTECHAPPDEV/AppDevService.asmx?WSDL');
			//include("constants.php");
			  $endpoint = WSDL_URL_BAL;
			  $sessionId = '';
			  $client = new SoapClient( $endpoint );	
			  $params = array('acct'=> $acct, 'phone'=> $phone);
			  $result = $client->b2wGetbAccountDetails($params);
			  $data = $result->b2wGetbAccountDetailsResult;
			  $xml = json_decode(json_encode((array) simplexml_load_string(str_replace('&', '&amp;',$data))),1);
			 
			  $cusname = $xml['cusname'];
			  $label = $xml['label'];
			  $alias = $xml['alias'];
			 
			$ret = "|".$cusname."|". $label ."|". $alias ."|";
			echo $ret;		
	}
	else
	{
		echo "|Incomplete Account Number";
	}
	
	function is_post_set()	
	{
		foreach ($_POST as $key => $value)	
		{
			if ($value != '')	
			{
				return true;	
			}
		}
		return false;	
	}
?>
