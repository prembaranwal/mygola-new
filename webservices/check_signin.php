<?php header('Content-Type: application/json');
	//$json_signin_data = file_get_contents('php://input');
    //$user_data = json_decode($json_signin_data);
	
	$user_data->Email = $_REQUEST['Email'];
	$user_data->Password = $_REQUEST['Password'];
	
    require '../connection.php';
    require 'functions.php';
    
        if($user_data->Email != '' && $user_data->Password != '')
        {
            $isLoggedIn = validateLogin($user_data, $conn);
            
            if($isLoggedIn == 10003)
            {
                $response = array('ResponseCode' => 10003, 'ResponseText' => 'Wrong Email/Password');
                echo json_encode($response);exit;
            }
            elseif($isLoggedIn == 10007)
            {
                $response = array('ResponseCode' => 10007, 'ResponseText' => 'User has been blocked');
                echo json_encode($response);exit;
            }
            elseif($isLoggedIn['ResponseCode'] == 11111)
            {
				
                $response = array(
									'ResponseCode' => 11111, 
									'ResponseText' => 'Success for login', 
									'Merchantid' => $isLoggedIn['merchant_id'],
									'MerchantName' => $isLoggedIn['merchant_name'],
									'Latitude' => $isLoggedIn['latitude'],
									'Longitude' => $isLoggedIn['longitude'],
									'Points' => $isLoggedIn['points']);
                echo json_encode($response);exit;
            }
        }
        else 
        {
            $response = array('ResponseCode' => 10000, 'ResponseText' => 'Empty fields');
            echo json_encode($response);exit;
        }
    
?>