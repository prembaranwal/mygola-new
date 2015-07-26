<?php 
header('Content-Type: application/json');
	require '../connection.php';
	
	$latitude = $_REQUEST['latitude'];
	$longitude = $_REQUEST['longitude'];
	
	if($latitude == '' || $longitude == '')
	{
		$response = array('ResponseCode' => 10000, 'ResponseText' => 'Empty fields');
		echo json_encode($response);exit;
	}
	else 
	{
		$sql_getRestaurants = "SELECT id, hotel_name, latitude, longitude, SQRT(
									POW(69.1 * (latitude - ".$latitude."), 2) +
									POW(69.1 * (".$longitude." - longitude) * COS(latitude / 57.3), 2)) AS distance
								FROM merchant HAVING distance < 10 ORDER BY distance";
							
		$res_getRestaurants = $conn->query($sql_getRestaurants);
               
        if ($res_getRestaurants->num_rows > 0) 
        {
			$restaurants = array();
            while($row = $res_getRestaurants->fetch_assoc()) 
            {
				$restaurants[] = $row;
			}
			
			$response = array('ResponseCode' => 10013, 'ResponseText' => 'Nearby Restaurants', 'RestaurantsData'=>$restaurants);
			echo json_encode($response);exit;
		}
		else 
		{
			$response = array('ResponseCode' => 10014, 'ResponseText' => 'No Restaurants found');
			echo json_encode($response);exit;
		}
	}
?>