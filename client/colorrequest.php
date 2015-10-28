<?php

/*
 
color-rest-app
Color API wrapper

*/

class ColorRequest {

	const API_URL = 'http://localhost/colorapp/api';

	private $method;
	private $uri;

	public function __construct($method, $uri) {

		$this->method = $method;
		$this->uri = $uri;
	}

	public function request() {

		$curl = curl_init();

		curl_setopt_array($curl, array(

		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $this::API_URL . $this->uri,

		));

		switch($this->method){

			case 'GET':

				curl_setopt($curl, CURLOPT_HTTPGET, true);
				break;

			case 'PUT':

				curl_setopt($curl, CURLOPT_PUT, true);
				break;

			case 'POST':

				curl_setopt($curl, CURLOPT_POST, true);
				break;

			case 'DELETE':
			
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		$response = curl_exec($curl);

		curl_close($curl);

		return json_decode($response);
	}
}