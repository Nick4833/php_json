<?php 
	
	$id = $_POST['id'];
	$stuJson = file_get_contents("student.json");

	if($stuJson) {
		$data_arr = json_decode($stuJson, true);
		unset($data_arr[$id]);
		$jsonStr = json_encode($data_arr, JSON_PRETTY_PRINT);
		file_put_contents("student.json", $jsonStr);
	}

?>