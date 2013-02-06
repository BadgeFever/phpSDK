<?php

class BadgefeverSDK {
	protected $_apiKey=null;
	protected $_apiSecret=null;
	protected $_curlOptions = array();
	protected $_requestParams = null;

<<<<<<< HEAD
	protected $_endPoint = 'http://bf.tomasdostal.com/api/';
=======
	protected $_endPoint = 'http://api.badgefever.com/v1/';

	protected $_badgeMap;

	function __construct($badges = null, $apiKey=null, $apiSecret=null){
		$this->_badgeMap = $badges;
>>>>>>> development

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

	public function getBadges($email=null, $params = array()){
		$queryString = $this->getQueryString(
			array(
				 'email='.$this->createHash($email),
			),
			$params
		);

		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'display/?'.$queryString;

		$response = $this->request();

		return $response;
	}

	public function hasBadge($email=null, $badge=null, $params=array()){
		$queryString = $this->getQueryString(
			array(
				 'email='.$this->createHash($email),
				 'badge='.$this->getBadgeId($badge),
			),
			$params
		);

		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign/?'.$queryString;

		$response = $this->request();

		return $response;
	}

	public function getAssignCount($badge=null, $params=array()){
		$queryString = $this->getQueryString(
			array(
				 'badge='.$this->getBadgeId($badge),
			),
			$params
		);

		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign/?'.$queryString;

		$response = $this->request();

		return $response;
	}

	public function assignBadge($badge=null, $email=null, $params=array()){
		$query = array(
			'badge='.$this->getBadgeId($badge),
			'email='.$this->createHash($email),
		);

		$query = array_merge($query,$this->parseParams($params));

		$this->_curlOptions[CURLOPT_URL] = $this->_endPoint.'assign';
		$this->_curlOptions[CURLOPT_POST] = count($query);
		$this->_curlOptions[CURLOPT_POSTFIELDS] = join('&',$query);

		$response = $this->request();

		return $response;
	}


	/* === Helpers === */
	public function createHash($email){
		return md5( strtolower( trim($email) ) );
	}

	public function getQueryString($arr1, $arr2){
		// Second array are parameters values by user, check if they are array and merge them to values form us.
		if (is_array($arr2) && !empty($arr2)){
			$query = array_merge($arr1,$this->parseParams($arr2));
		} else {
			$query = $arr1;
		}

		$query = join('&',$query);

		return $query;
	}

	protected function parseParams($params){
		$output = array();
		if (!empty($params)){
			foreach($params as $key=>$val){
				$output[] = $key.'='.urlencode($val);
			}
		}

		// add apiKey and apiSecret no problem if its empty
		$output[] = 'apiKey='.urlencode($this->_apiKey);
		$output[] = 'apiSecret='.urlencode($this->_apiSecret);

		return $output;
	}

	protected function getBadgeId($alias){
		if (isset($this->_badgeMap[$alias])){
			return $this->_badgeMap[$alias];
		} else {
			return $alias;
		}
	}
}