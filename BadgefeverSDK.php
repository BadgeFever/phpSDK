<?php

class BadgefeverSDK {
	protected $_apiKey=null;
	protected $_apiSecret=null;
	protected $_curlOptions = array();
	protected $_requestParams = null;

	protected $_endPoint = 'http://badgefever.tomas/api/';

	function __construct($apiKey=null, $apiSecret=null){
		if ($apiKey)
			$this->_apiKey = $apiKey;

		if ($apiSecret)
			$this->_apiSecret = $apiSecret;
	}

	protected function request(){
		$c = curl_init();
		curl_setopt_array($c, $this->_curlOptions);

		$response = curl_exec($c);

		return $response;
	}

	public function getBadges($email=null, $format='json', $params = array()){
		$query = self::createHash($email).'.'.$format;

		if (!empty($params)){
			$query .= '?';
			foreach($params as $key=>$val){
				$query .= $key.'='.$val.'&';
			}
			$query = substr($query,0,-1);
		}

		$this->_curlOptions[CURLOPT_URL] = $this->_bfCalls['display_basic']['url'].$query;

		$this->request();
	}

	public function createHash($email){
		return md5( strtolower( trim($email) ) );
	}
}