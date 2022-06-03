<?php
	//Tom Doidge 2009
	//www.tomdoidge.com

	if (is_post_set())	//Check that we have received some post data.
	{
		foreach ($_POST as $key => $value)	//Loop through all key value pairs in the $_POST array
		{
			$key = strtolower($key);
			$$key = $value;
			//echo "$key = $value<br />";	//echo the key and value followed by a line break		
		}
			define ( 'WSDL_URL_BAL', 'http://10.99.0.30/PMWEBSERVICES/AppDevService.asmx?WSDL' );
			//include("constants.php");                 
			  $endpoint = WSDL_URL_BAL;
			  $sessionId = '';
			  $client = new SoapClient( $endpoint );			 
            //get loan details
			//ConvertToWords(string amount, string currency, string subcurrency)
						    $params = array('amount'=> $amount, 'currency'=>$currency, 'subcurrency'=>$subcurrency);
							$result = $client->ConvertToWords($params);
							$data = $result->ConvertToWordsResult;						
                            $amtwords = $data; 
			$ret = "|".$amtwords."|";
			echo $ret;			  
	}
	else
	{
		echo "|Missing details|";
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
