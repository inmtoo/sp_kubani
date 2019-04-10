<?php
	class Sensitivelists {
	
		function getmodels() {
			$id_car_mark = Form::get('id_car_mark');
			$SensitiveResult = Database::getrows($table = 'car_model', $fields = 'id_car_model, name', $parametr='id_car_mark', $value = $id_car_mark);
			echo '{"type":"success","SensitiveResult":';
			echo json_encode($SensitiveResult);
			echo '}';
			
		}
		
		function getcities() {
			$id_region = Form::get('id_region');
			$SensitiveResult = Database::getrows($table = 'city', $fields = 'id_city, name', $parametr='id_region', $value = $id_region);
			echo '{"type":"success","SensitiveResult":';
			echo json_encode($SensitiveResult);
			echo '}';
		}
		
		function getpoints() {
			$id_city = Form::get('id_city');
			$SensitiveResult = Database::getrows($table = 'sp_tradepoints', $fields = 'id, name', $parametr='id_city', $value = $id_city);
			echo '{"type":"success","SensitiveResult":';
			echo json_encode($SensitiveResult);
			echo '}';
		}
	
	}
?>