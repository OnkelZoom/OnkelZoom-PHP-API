<?php

	/* ************************************************************************************************


	  /$$$$$$            /$$                 /$$       /$$$$$$$$
	 /$$__  $$          | $$                | $$      |_____ $$
	| $$  \ $$ /$$$$$$$ | $$   /$$  /$$$$$$ | $$           /$$/   /$$$$$$   /$$$$$$  /$$$$$$/$$$$
	| $$  | $$| $$__  $$| $$  /$$/ /$$__  $$| $$          /$$/   /$$__  $$ /$$__  $$| $$_  $$_  $$
	| $$  | $$| $$  \ $$| $$$$$$/ | $$$$$$$$| $$         /$$/   | $$  \ $$| $$  \ $$| $$ \ $$ \ $$
	| $$  | $$| $$  | $$| $$_  $$ | $$_____/| $$        /$$/    | $$  | $$| $$  | $$| $$ | $$ | $$
	|  $$$$$$/| $$  | $$| $$ \  $$|  $$$$$$$| $$       /$$$$$$$$|  $$$$$$/|  $$$$$$/| $$ | $$ | $$
	 \______/ |__/  |__/|__/  \__/ \_______/|__/      |________/ \______/  \______/ |__/ |__/ |__/


	Description:
		ONKEL ZOOM - API CLASS (v.1.0)
		This Class will help you to communicate with the Onkel Zoom Marketplace API

	Functions:
		- Add new Marketplace Offers 					SERVICENAME: Offer/Add
		- Update single Marketplace Offer 				SERVICENAME: Offer/Update
		- Get List of your Marketplace Offers 			SERVICENAME: Offer/Get/All
		- Get a single Marketplace-Offer by ID 			SERVICENAME: Offer/Get
		- Get your Account Details 						SERVICENAME: Account/Get
		- Get single Deal-Details						SERVICENAME: Deal/Get (in process)
		- Get List of your Deals						SERVICENAME: Deal/Get/All (in process)

		- More Services to come...

	Documentation:
		http://api.onkel-zoom.com (in process)

  	Copyright:
  		Zoom Social Commerce GmbH
  		Stanlay Forker <forker@zoom-sc.com>
		http://www.onkel-zoom.com

	************************************************************************************************ */

	define('ZOOM_API_ENDPOINT',			'http://api.onkel-zoom.com/api.php');

	class OnkelZoom {

		private $email 				= '';
		private $apiKey				= '';
		private $apiUrl				= '';
		private $debug				= FALSE;
		private $convert_to_utf8	= FALSE;

		public function __construct($_email, $_apiKey, $_apiUrl = ZOOM_API_ENDPOINT){

			if($_email != '' && $_apiKey != ''){
            	$this->email = $_email;
            	$this->apiKey = $_apiKey;
            	$this->apiUrl = $_apiUrl;
            } else {
            	return false;
            }
		}

		public function setConvertToUTF8($_convert_to_utf8 = false){
	        if($_convert_to_utf8 != ''){
	            $this->convert_to_utf8 = $_convert_to_utf8;
	        } else {
	        	return false;
	        }
	    }

    	private function convertToUTF8($_array){
        	foreach($_array AS $key => $val){
	            if(is_array($val)){
	            	$val = $this->convertToUTF8($val);
	            } else {
	            	$val = utf8_encode($val);
	            }
	            $_array[$key] = $val;
	        }
	        return $_array;
    	}

		public function request($_data){
			if($_data) {
				if($this->email != '' && $this->apiKey != '' && $this->apiUrl != '') {
					if($this->convert_to_utf8) { $_data = $this->convertToUTF8($_data); }

					$ch = curl_init();
					$data_string = json_encode($_data);

					$bodyStr = array(
						"httpbody" 	=> $data_string
					);

	                curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
	                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	                	'X-OZ-API-Key: '.base64_encode($this->apiKey),
	                	'X-OZ-API-Vendor: '.base64_encode($this->email)
	                	)
	                );
	                curl_setopt($ch, CURLOPT_POST, 1);
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyStr);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	                curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
	                curl_setopt($ch, CURLOPT_VERBOSE, 1);

	                $exec 	= curl_exec($ch);
	                $result = json_decode($exec,true);
	                curl_close($ch);

	                return $result;

	            } else {
	            	return false;
	            }

	        } else {
	        	return false;
	        }

	    }
	}
?>
