<?php 
	$json_signin_data = file_get_contents('php://input');
    $user_data = json_decode($json_signin_data);
	
    require '../connection.php';
    require 'functions.php';
	
	
        if($user_data->User != '' && $user_data->IMEI != '' && $user_data->Type != '')
        {
			$updateDeviceKey = updateDevice($user_data, $conn);
            
            if($updateDeviceKey == 10012)
			{
				$response = array('ResponseCode' => 10012, 'ResponseText' => 'Device updated successfully');
				echo json_encode($response);
			}
			elseif($updateDeviceKey == 10005)
			{
				$response = array('ResponseCode' => 10005, 'ResponseText' => 'Database error');
				echo json_encode($response);
			}
        }
        else 
        {
            $response = array('ResponseCode' => 10000, 'ResponseText' => 'Empty fields');
            echo json_encode($response);
        }
   
?>