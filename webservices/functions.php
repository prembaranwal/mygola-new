<?php 
    function signUp($user_data, $imei, $conn)
    {
        $sql_checkEmailExist = "SELECT * 
                                FROM user 
                                WHERE email = '".$user_data->Email."'";
        
        $sql_checkUsernameExist = "SELECT * 
									FROM user 
									WHERE username = '".$user_data->Username."'";
								
		$sql_checkDeviceKeyExist = "SELECT * 
									FROM user 
									WHERE device_key = '".$imei."'";
        
        $res_checkEmailExist = $conn->query($sql_checkEmailExist);
        $res_checkUsernameExist = $conn->query($sql_checkUsernameExist);
		$res_checkDeviceKeyExist = $conn->query($sql_checkDeviceKeyExist);

        if ($res_checkEmailExist->num_rows > 0) 
        {
            return 10001;
            
        }
        elseif($res_checkUsernameExist->num_rows > 0)
        {
            return 10002;
        }
		elseif($res_checkDeviceKeyExist->num_rows > 0)
        {
            return 10010;
        }
        else 
        {
            $sql_insertUser = "INSERT INTO user (username, email, password, role, device_key) VALUES ('$user_data->Username','$user_data->Email', md5('$user_data->Password'), 2, '$imei')";
			if ($conn->query($sql_insertUser))
            {
                $sql_getUser = "SELECT * 
                                FROM user 
                                WHERE email = '".$user_data->Email."' 
                                LIMIT 1";
            
                $res_getUser = $conn->query($sql_getUser);

                while($row = $res_getUser->fetch_assoc()) 
                {
                    $user = $row;
                    break;
                }
                session_start();
                $session_id = session_id();
                
                /*$sql_checkImeiExists = "UPDATE user 
                                        SET device_key = NULL 
                                        WHERE device_key = '".$imei."'";
                
                $res_checkImeiExists = $conn->query($sql_checkImeiExists);
                
				$sql_updateImei = "UPDATE user 
                                    SET device_key = '$imei', session_id = '$session_id'
                                    WHERE id = '".$user['id']."'";
                
                $res_updateImei = $conn->query($sql_updateImei);*/
				
				$sql_updateSession = "UPDATE user 
										SET  
										session_id = '$session_id'
										WHERE id = '".$user['id']."'";
					
				$res_updateSession = $conn->query($sql_updateSession);
                $arr_success = array('ResponseCode' => 11111, 'session_id' => $session_id);
                return $arr_success;
            }
            else 
            {
                return 10005;
            }
        }
    }
    
    function validateLogin($user_data, $conn)
    {
		$sql_validateLogin = "SELECT * 
								FROM merchant 
								WHERE email = '".$user_data->Email."' 
									AND password = md5('".$user_data->Password."')";
        
        
        $res_validateLogin = $conn->query($sql_validateLogin);
               
        if ($res_validateLogin->num_rows > 0) 
        {
            while($row = $res_validateLogin->fetch_assoc()) 
            {
                $user = $row;
                break;
            }
            if($user['status'] == 1)
            {
				
				$points_exist = 'Not Exist';
				$sql_getPoints = "SELECT * 
									FROM points 
									WHERE merchant_id = '".$user['id']."'";
									
				$res_getPoints = $conn->query($sql_getPoints);
				if ($res_getPoints->num_rows > 0) 
				{
					$points_exist = array();
					while($row_points = $res_getPoints->fetch_assoc()) 
					{
						$points_exist[] = $row_points;
					}
					
				}
				
				$arr_success = array(
									'ResponseCode' => 11111, 
									'merchant_id' => $user['id'],
									'merchant_name' => $user['hotel_name'],
									'latitude' => $user['latitude'], 
									'longitude' => $user['longitude'],
									'points' => $points_exist);
				return $arr_success;
				
            }
            else 
            {
                return 10007;
            }
          
        }
        else 
        {
            return 10003;
        }
        
    }
    
    function savePoint($merchant_id, $point, $conn)
	{
		$pointData = array();
		$latitude = $point->latitude;
		$longitude = $point->longitude;
		$text = $point->text;
		
		$pointDataJson = json_encode($pointData);
		$sql_insertPoint = "INSERT INTO points (merchant_id, latitude, longitude, text_msg) VALUES ('$merchant_id','$latitude', '$longitude', '$text')";
		if ($conn->query($sql_insertPoint))
		{
			return 11111;
		}
	}
	
	function getMerchantPoints($merchant_id, $conn)
	{
		$sql_getMerchantPoints = "SELECT * 
									FROM points 
									WHERE merchant_id = '$merchant_id'";
									
		$res_getMerchantPoints = $conn->query($sql_getMerchantPoints);
		if ($res_getMerchantPoints->num_rows > 0) 
		{
			$points = array();
			while($row = $res_getMerchantPoints->fetch_assoc()) 
			{
				$points[] = array(
								'latitude' => $row['latitude'],
								'longitude' => $row['longitude'],
								'text_msg' => $row['text_msg']);
			}
			$arr_success = array(
									'ResponseCode' => 10012, 
									'points_data' => $points);
			return $arr_success;
		}
	}
?>