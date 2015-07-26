<?php 
	$json_signin_data = file_get_contents('php://input');
    $user_data = json_decode($json_signin_data);
	$imei = $user_data->IMEI;
	
	require '../connection.php';
	
	$sql_imeiExists = "SELECT * 
						FROM user 
						WHERE device_key = '".$imei."'";
						
	$res_imeiExists = $conn->query($sql_imeiExists);
               
	if ($res_imeiExists->num_rows > 0) 
	{
		while($row = $res_imeiExists->fetch_assoc()) 
		{
			$user = $row;
			break;
		}
		session_start();
		$session_id = session_id();
		
		$sql_checkImeiExists = "UPDATE user 
								SET device_key = NULL 
								WHERE device_key = '".$imei."'";
		
		$res_checkImeiExists = $conn->query($sql_checkImeiExists);
		
		$sql_updateImei = "UPDATE user 
							SET device_key = '$imei', 
							session_id = '$session_id'
							WHERE id = '".$user['id']."'";
		
		$res_updateImei = $conn->query($sql_updateImei);
		
		$sql_getDefaultSection = "SELECT * 
									FROM sections 
									ORDER BY id 
									LIMIT 1";

		$res_getDefaultSection = $conn->query($sql_getDefaultSection);

		$section_id = '';
		while($row = $res_getDefaultSection->fetch_assoc()) 
		{
			$section_id = $row['id'];
			break;
		}
		$response = array('ResponseCode' => 11111, 'ResponseText' => 'Success for login', 'ID' => $section_id, 'SessionId' => $session_id);
		echo json_encode($response);
	}
	else 
	{
		echo json_encode(array('ResponseCode' => 11110, 'ResponseText' => 'User not logged in'));
	}
?>