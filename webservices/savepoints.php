<?php 
/*{"merchant_id":1,"points":[{"latitude":"12.543","longitude":"32.432","text":"Buy 1 get 1"},{"latitude":"22.543","longitude":"33.432","text":"50% off"}]}*/
	header('Content-Type: application/json');
	require '../connection.php';
    require 'functions.php';
	//$json_data = '{"merchant_id":1,"points":[{"latitude":"12.543","longitude":"32.432","text":"Buy 1 get 1"},{"latitude":"22.543","longitude":"33.432","text":"50% off"}]}';
	$json_data = file_get_contents('php://input');
	$json_data = str_replace('merchant_id=','"merchant_id":',$json_data);
	$json_data = str_replace('points=','"points":',$json_data);
	
	$json_savepoints_data = json_decode($json_data);
	
    //print_r($json_savepoints_data);
	//$merchant_id	= $json_savepoints_data->merchant_id;
	//$points_arr		= $json_savepoints_data->points;
	
	//$points[] = array('p1' => array('latitude' => 12.543, 'longitude' => 32.432, 'text':'turn right at saloon'));
	
	//$merchant_id = $_REQUEST['merchant_id'];
	//$points_arr = $_REQUEST['points'];
	//$merchant_id = $json_savepoints_data->merchant_id;
	$merchant_id = $json_savepoints_data->points[0]->merchant_id;
	$points_arr = $json_savepoints_data->points;
	
	if($merchant_id == '') 
	{
		$response = array('ResponseCode' => 10010, 'ResponseText' => 'Merchant id is empty');
		echo json_encode($response);exit;
	}
	elseif($points_arr == '' || count($points_arr) == 0) 
	{
		$response = array('ResponseCode' => 10011, 'ResponseText' => 'Points are empty');
		echo json_encode($response);exit;
	}
	else 
	{
		
		foreach($points_arr as $eachPoint)
		{
			$savePointData = savePoint($merchant_id, $eachPoint, $conn);
		}
		if($savePointData = 11111)
		{
			$response = array('ResponseCode' => 11111, 'ResponseText' => 'Points saved');
			echo json_encode($response);exit;
		}
	}
?>