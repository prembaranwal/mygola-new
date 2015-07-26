<?php 
    /*$json_forgotpwd_data = '{
                                "RequestData":{
                                        "BaseData":{
                                                "IMEI":"3556660518812999"
                                        },
                                        "AdditionalData":{
                                                "UserData":{
                                                        "Email":"premk@tarangtech.com"
                                                }
                                        }
                                }
                        }';*/
    
    $forgotpwd_data = file_get_contents('php://input');
	$user_data = json_decode($forgotpwd_data);
    
    $imei = $user_data->IMEI;
    
    require '../connection.php';
    require 'functions.php';
    
    if($user_data->Email != '')
    {
        $response_data = sendResetPwdMail($user_data, $imei, $conn);
        
        if($response_data == 10004)
        {
            $response = array('ResponseCode' => 10004, 'ResponseText' => 'You are not a registered user. Please register.');
            echo json_encode($response);
        }
        elseif($response_data == 11111)
        {
            $response = array('ResponseCode' => 11111, 'ResponseText' => 'A mail has been sent to your email address to change your password.');
            echo json_encode($response);
        }
        elseif($response_data == 10008)
        {
            $response = array('ResponseCode' => 10008, 'ResponseText' => 'Mail not sent. SMTP error.');
            echo json_encode($response);
        }
    }
    else 
    {
        $response = array('ResponseCode' => 10000, 'ResponseText' => 'Empty fields');
        echo json_encode($response);
    }
?>