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
		PHP Usage Example (v.1.0)

  	Copyright:
  		Zoom Social Commerce GmbH
  		Stanlay Forker <forker@zoom-sc.com>
		http://www.onkel-zoom.com

	************************************************************************************************ */

	// INCLUDE THE REQUIRED ONKELZOOM API CLASS HELPER
	require("OnkelZoom.class.php");

	// DEFINE YOU AUTH INFO
	define("ZOOM_API_MAIL", "__MY_ZOOM_API_MAIL__");
	define("ZOOM_API_KEY", 	"__MY_ZOOM_API_KEY__");

	// INITIATE THE API CLASS
	$OnkelZoom       = new OnkelZoom(ZOOM_API_MAIL, ZOOM_API_KEY);

	// BUILD THE REQUEST PARAMS

		# Get you Account Infos
		$request_get_account_info = array(
			"SERVICE"	=> "Account/Get"
		);

		# Update your Offer by EAN
		$request_update_offer = array(
			"SERVICE"	=> "Offer/Update",
			"DATA"		=> array(
				"PRODUCT_EAN"		=> "000000000000000",								// Product EAN-Code.				* required
				"PRODUCT_PRICE" 	=> "12.34",											// New product price
				"PRODUCT_LINK" 		=> "http://www.shop.com/product-deeplink.html",		// Deeplink to your Shop
				"DELIVERY_VALUE" 	=> "Lieferbar innerhalb 1-2 Tage",					// Delivery Notice
				"DELIVERY_PRICE" 	=> "4.90",											// Delivery Cost
				"AVAILABLE" 		=> "1"												// Available? 1 = Yes, 0 = No
			)
		);

		# Get single Offer by EAN
		$request_get_offer = array(
			"SERVICE"	=> "Offer/Get",
			"DATA"		=> array(
				"PRODUCT_EAN"	=> "000000000000000"									// Product EAN-Code. 				* required
			)
		);

		# Get all you Offers
		$request_get_all_offer = array(
			"SERVICE"	=> "Offer/Get/All",
			"DATA"		=> array(
				"START"			=> "0",													// START FROM THIS ENTRY
				"LIMIT"			=> "10",												// RESULTS TO RETURN. Default: 10, Max: 50
				"ORDER_BY"		=> "DATE_MOD",											// SORTING BY THIS VALUE
				"ORDER_DESC"	=> "DESC"												// SORT DIRECTION. DESC = Descending, ASC = Ascending
			)
		);

		# Add new Offer
		$request_add_offer = array(
			"SERVICE"	=> "Offer/Add",
			"DATA"		=> array(
				"PRODUCT_EAN"		=> "",												// Product EAN-Code. 					* required
				"PRODUCT_PRICE" 	=> "12.34",											// New price 							* required
				"PRODUCT_PRICE_OLD"	=> "43.21",											// Old price 							- can be empty
				"PRODUCT_AVAILABLE" => "1",												// Available? 1 = Yes, 0 = No 			- can be empty
				"PRODUCT_LINK" 		=> "http://www.shop.com/product-deeplink.html",		// Deeplink to your Shop 				* required
				"DELIVERY_VALUE" 	=> "Lieferbar innerhalb 1-2 Tage",					// Delivery Notice 						- can be empty
				"DELIVERY_PRICE" 	=> "4.90",											// Delivery Cost 						- can be empty
				"TOKEN"				=> ""												// MD5 HASH FOR ALL YOUR DATA 			* required
			)
		);

		# BUILD THE MD5 HASH TOKEN
		$request_add_offer["DATA"]["TOKEN"] = md5(
			$request_add_offer["DATA"]["PRODUCT_EAN"] .
			$request_add_offer["DATA"]["PRODUCT_PRICE"] .
			$request_add_offer["DATA"]["PRODUCT_PRICE_OLD"] .
			$request_add_offer["DATA"]["PRODUCT_AVAILABLE"] .
			$request_add_offer["DATA"]["PRODUCT_LINK"] .
			$request_add_offer["DATA"]["DELIVERY_VALUE"] .
			$request_add_offer["DATA"]["DELIVERY_PRICE"] .
			strrev(ZOOM_API_KEY)
		);

	// RUN THE REQUEST TO ONKEL ZOOM

	echo "SERVICE TEST: Account/Get<br>";
	$api_response     = $OnkelZoom->request($request_get_account_info);
	handle_api_response($api_response);

	echo "<hr>SERVICE TEST: Offer/Update<br>";
	$api_response     = $OnkelZoom->request($request_update_offer);
	handle_api_response($api_response);

	echo "<hr>SERVICE TEST: Offer/Get<br>";
	$api_response     = $OnkelZoom->request($request_get_offer);
	handle_api_response($api_response);

	echo "<hr>SERVICE TEST: Offer/Get/All<br>";
	$api_response     = $OnkelZoom->request($request_get_all_offer);
	handle_api_response($api_response);

	echo "<hr>SERVICE TEST: Offer/Add<br>";
	$api_response     = $OnkelZoom->request($request_add_offer);
	handle_api_response($api_response);


	// HANDLE THE SERVER RESPONSE
	function handle_api_response($api_response){
		switch($api_response["STATUS"]){
			case "200":		{
				echo "Request successfully<br>";
				echo "<pre>Server-Response:<br>"; print_r($api_response); echo "</pre>";
				break;
			}
			case "403":
			case "404":
			case "405":		{
				echo "Something went wrong with Authentification<br>";
				echo "<pre>Server-Response:<br>"; print_r($api_response); echo "</pre>";
				break;
			}
			case "501":
			case "503":
			case "505":
			case "506":
			case "507":
			case "508":		{
				echo "Something went wrong with Service-Request<br>";
				echo "<pre>Server-Response:<br>"; print_r($api_response); echo "</pre>";
				break;
			}
		}
	}


?>
