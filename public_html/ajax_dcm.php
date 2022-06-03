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
			define ('WSDL_URL_BAL','http://10.99.0.30/PMWEBSERVICES/AppDevService.asmx?WSDL');
			//include("constants.php");
			  $endpoint = WSDL_URL_BAL;
			  $sessionId = '';
			  $client = new SoapClient( $endpoint );			 
            //get loan details
						    //$params = array('bra_code'=>205, 'cus_num'=>136644, 'cur_code'=>1, 'led_code'=>84, 'sub_acct_code'=>0);	
							$param = array('bra_code'=>201, 'cus_num'=>1001935, 'cur_code'=>1, 'led_code'=>1, 'sub_acct_code'=>0);
							$result = $client->GetBasisLoanDetailsWithReferenceKey($params);
							$data = $result->GetBasisLoanDetailsWithReferenceKeyResult;
							$xml = json_decode(json_encode((array) simplexml_load_string($data)),1);	
							$loanAmt = $xml['LOANDETAILS']['LOAN']['LOAN_AMT'];		
                            $refKey = $xml['LOANDETAILS']['LOAN']['LOAN_REFERENCE_KEY'];	
                            $currentLoanAmt = $xml['LOANDETAILS']['LOAN']['CURRENT_LOAN_BAL'];						
                            $ledgerName = $xml['LOANDETAILS']['LOAN']['LEDGER_TYPE'];                     
							//$dateBooked = $xml['LOANDETAILS']['LOAN']['DATE_BOOKED'];		
                            $lastPayDate = $xml['LOANDETAILS']['LOAN']['LAST_PAYMENT_DATE'];			
                            $nextPayDate = $xml['LOANDETAILS']['LOAN']['NEXT_PAYMENT_DATE'];
                            $cusName = $xml['LOANDETAILS']['LOAN']['ACCT_NAME'];
                            $interestPayInd = $xml['LOANDETAILS']['LOAN']['INTEREST_PAY_IND'];									
			// convert variables to array
			//  $ret = array('availbal' => $availbal, 'crntbal' => $crntbal, 'cusname' => $cusname);
			$ret = "|".$loanAmt."|".$refKey."|".$currentLoanAmt."|".$ledgerName."|".$dateBooked."|".$lastPayDate."|".$nextPayDate."|".$cusName."|".$interestPayInd."|";
			echo $ret;			  
	}
	else
	{
		echo "|Missing Loan Details|Missing Loan Details|Missing Loan Details|Missing Loan Details|Missing Loan Details|Missing Loan Details|Missing Loan Details|";
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
