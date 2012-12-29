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
		// Additional options
		$this->_curlOptions[CURLOPT_RETURNTRANSFER] = 1;

		$c = curl_init();
		curl_setopt_array($c, $this->_curlOptions);

		$response = curl_exec($c);

		curl_close($c);

		return $response;
	}

	public function createHash($email){
		return md5( strtolower( trim($email) ) );
	}

	public function getBadges($email=null, $params = array()){
		$query = array(
			'email='.$this->createHash($email),
		);

		$query = array_merge($query,$this->parseParams($params));

		$query = join('&',$query);
		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'display/?'.$query;

		$response = $this->request();

		return $response;
	}

	public function hasBadge($email=null, $badge=null, $params=array()){
		$query = array(
			'email='.$this->createHash($email),
			'badge='.$badge,
		);

		$query = array_merge($query,$this->parseParams($params));

		$query = join('&',$query);
		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign/?'.$query;

		$response = $this->request();

		return $response;
	}

	public function getAssignCount($badge=null, $params=array()){
		$query = array(
			'badge='.$badge,
		);

		$query = array_merge($query,$this->parseParams($params));

		$query = join('&',$query);
		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign/?'.$query;

		$response = $this->request();

		return $response;
	}

	public function assignBadge($badge=null, $email=null, $params=array()){
		$query = array(
			'badge='.$badge,
			'email='.$this->createHash($email),
		);

		$query = array_merge($query,$this->parseParams($params));

		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign';
		$this->_curlOptions[CURLOPT_POST] = count($query);
		$this->_curlOptions[CURLOPT_POSTFIELDS] = join('&',$query);

		$response = $this->request();

		return $response;
	}

	protected function parseParams($params){
		$output = array();
		if (!empty($params)){
			foreach($params as $key=>$val){
				$output[] = $key.'='.urlencode($val);
			}
		}

		// add apiKey and apiSecret
		$output[] = 'apiKey='.urlencode($this->_apiKey);
		$output[] = 'apiSecret='.urlencode($this->_apiSecret);

		return $output;
	}
}