<?php 
	header('Content-Type: application/json');
	require '../connection.php';
    require 'functions.php';
	
	$merchant_id = $_REQUEST['merchant_id'];
	
	if($merchant_id == '') 
	{
		$response = array('ResponseCode' => 10010, 'ResponseText' => 'Merchant id is empty');
		echo json_encode($response);exit;
	}
	else 
	{
		$points = getMerchantPoints($merchant_id, $conn);
		
		if($points['ResponseCode'] == 10012)
		{
			$response = array('ResponseCode' => 10012, 'ResponseText' => 'Success', 'Points' => $points['points_data']);
			
			echo json_encode($response);exit;
		}
	}
?>