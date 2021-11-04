<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait RequestTrait{

	public function apiRequest($method, $parameters=[]){
		$url = 'https://api.telegram.org/bot'.env('TELEGRAM_TOKEN', '855651001:AAEkIjLOgJPY4dDBIjxMUa8TKhp0FFCp6ZI').'/'.$method;

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($handle, CURLOPT_TIMEOUT, 60);
		curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($parameters));
		$response = curl_exec($handle);

		if($response === false){
			curl_close($handle);
			throwException(new \Exception($response['description']));
			return false;
		}
		curl_close($handle);
		$response = json_decode($response, true);
		$response = $response['result'];
		return $response;
	}
}