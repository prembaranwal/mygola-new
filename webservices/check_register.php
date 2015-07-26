<?php 
    /*$json_register_data = '{
                                "RequestData":{
                                        "BaseData":{
                                                "IMEI":"3556660518812999"
                                        },
                                        "AdditionalData":{
                                                "UserData":{
                                                        "Username":"premkrssssdas",
                                                        "Email":"prembaranwalssa@outlook.coms",
                                                        "Password":"tarang123"
                                                }
                                        }
                                }
                            }';*/
	
    $json_register_data = file_get_contents('php://input');
    $user_data = json_decode($json_register_data);
	
    $imei = $user_data->IMEI;
    
    require '../connection.php';
    require 'functions.php';
    
    if($user_data->Username != '' && $user_data->Email != '' && $user_data->Password != '')
    {
        $reg_user = signUp($user_data, $imei, $conn);
        
        
        if($reg_user == 10001)
        {
            $response = array('ResponseCode' => 10001, 'ResponseText' => 'Email already exist');
            echo json_encode($response);
        }
        elseif($reg_user == 10002)
        {
            $response = array('ResponseCode' => 10002, 'ResponseText' => 'Username already exist');
            echo json_encode($response);
        }
		elseif($reg_user == 10010)
        {
            $response = array('ResponseCode' => 10010, 'ResponseText' => 'Device already exist. Please register with some other device.');
            echo json_encode($response);
        }
        elseif($reg_user['ResponseCode'] == 11111)
        {
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
            $response = array('ResponseCode' => 11111, 'ResponseText' => 'Success for registration', 'ID' => $section_id, 'SessionId' => $reg_user['session_id']);
            echo json_encode($response);
        }
        elseif($reg_user == 10005)
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