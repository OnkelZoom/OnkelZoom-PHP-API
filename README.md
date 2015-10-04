OnkelZoom-PHP-API
==================

Die Onkel Zoom API ist als JSON Webserivce angelegt, bei dem alle Ressourcen über eine zentrale URL angesprochen werden. Alle API-Anfragen werden als POST Request mit JSON formatiertem Body an die Service-URL gesendet.

## API-URL
http://api.onkel-zoom.com/api.php

## Verfügbare Services
* Account/Get
* Offer/Get
* Offer/Get/All
* Offer/Update
* Offer/Add

## Account/Get
> Erhalten Sie Informationen zu Ihren Account-Daten

**Sample Request**
```
$request_get_account_info = array(
  "SERVICE"	=> "Account/Get"
);
```

**Sample JSON-Response**
```
{"STATUS":"200","DATA":{"COMPANY":"Your Company","FIRSTNAME":"Firstname","LASTNAME":"Lastname","EMAIL":"me@company.com","WEBSITE":"www.company.com","STREET":"Company Ave. 12","ZIP":"12345","CITY":"Town","ZOOM_URL":"http:\/\/www.onkel-zoom.com\/haendler\/your-company\/","VISITS":1234,"OFFERS":"5678"}}
```

Field | Description
----- | -----------
COMPANY |Firmenname
FIRSTNAME | Vorname
LASTNAME | Nachname
EMAIL | Email-Adresse (wird öffentlich angezeigt)
WEBSITE | Internetadresse (wird öffentlich angezeigt)
STREET | Straße
ZIP | Postleitzahl
CITY | Stadt
ZOOM_URL | Profil-URL bei Onkel-Zoom.com
VISITS | Besucher Ihres Profils
OFFERS | Eingestellte Angebote

## Offer/Get
> Erstellen Sie ein neues Angebot für den Onkel Zoom Marktplatz direkt aus Ihrem Shop-System heraus.

Field | Description
----- | -----------
*PRODUCT_EAN | EAN-Code

*required

**Sample Request**
```
$request_get_offer = array(
  "SERVICE"		=> "Offer/Get",
  "DATA"		=> array(
    "PRODUCT_EAN"	=> "000000000000000"
  )
);
```

**Sample Response**
```
Array(
	[STATUS] => 200
	[DATA] => Array(
		[OFFER_ID] => 99999
		[OFFER_LABEL] => Productname
		[OFFER_EAN] => 12345678900000
		[OFFER_LINK] => http://www.your-shop.com/product-deeplink.html
		[OFFER_CLICKOUTS] => 34
		[OFFER_LAST_MOD] => 2015-10-31 15:00:00
		[OFFER_DATE_END] => 2015-11-07 15:00:00
	)
)
```

Field | Description
----- | -----------
OFFER_ID | Unique Offer-ID
OFFER_LABEL | Productname
OFFER_EAN | EAN-Code (14 Digits)
OFFER_LINK | Shop Deeplink
OFFER_CLICKOUTS | Count recent Clickouts
OFFER_LAST_MOD | Last modification date
OFFER_DATE_END | end daten

## Offer/Get/All
> Get all you recent Marketplace Offers including Clickouts

Field | Description
----- | -----------
START | Start-Wert der Anfrage (Für Navigation notwendig)
LIMIT | Items to return. Default: 10 Items, Max. 50 Items
ORDER_BY | Sortierung nach Kriterium<br>Mögliche Werte:<br>*DATE_ADD*: Erstellungsdatum<br>*DATE_MOD*: Aktualisierungsdatum<br>*DATE_END*: Ablaufdatum<br>*NAME*: Produktname<br>*PRICE*: Preis
ORDER_DESC | DESC (descending), ASC (ascending)

**Sample Request**
```
$request_params = array(
  "SERVICE"	=> "Offer/Get/All",
  "DATA"    	=> array(
    "START"       => "0",
    "LIMIT"       => "10",
    "ORDER_BY"    => "DATE_MOD",
    "ORDER_DESC"  => "DESC",
  )
);
```

**Sample Response**
```
Array(
  [STATUS] => 200
  [TOTAL_OFFERS] => 1709
  [TOTAL_CLICKS] => 1234
  [DATA] => Array(
    [0] => array(
      [OFFER_ID] => 99999
      [OFFER_LABEL] => Productname
      [OFFER_EAN] => 12345678900000
      [OFFER_LINK] => http://www.your-shop.com/product-deeplink.html
      [OFFER_CLICKOUTS] => 34
      [OFFER_LAST_MOD] => 2015-10-31 15:00:00
      [OFFER_DATE_END] => 2015-11-07 15:00:00
    )
  [1] => array(
      [OFFER_ID] => 99998
      [OFFER_LABEL] => Productname
      [OFFER_EAN] => 00001234567890
      [OFFER_LINK] => http://www.your-shop.com/product-deeplink-2.html
      [OFFER_CLICKOUTS] => 1200
      [OFFER_LAST_MOD] => 2015-10-31 14:00:06
      [OFFER_DATE_END] => 2015-11-07 14:00:06
    )
  )
)
```

Field | Description
----- | -----------
TOTAL_OFFERS | Gesamtanzahl der Angebote
TOTAL_CLICKS | Anzahl der Klicks aller angezeigter Angebote
DATA | Array of Offers
 OFFER_ID | Eindeutige Angebots-ID
 OFFER_LABEL | Name des Produkts
 OFFER_EAN | Produkt EAN-Code (14-stellig)
 OFFER_LINK | Direkter Shop-Link
 OFFER_CLICKOUTS | Anzahl der bisherigen Clickouts
 OFFER_LAST_MOD | Letzte Aktualisierung des Angebots
 OFFER_DATE_END | Ablaufdatum des Angebots


## Offer/Update
> Aktualisieren Sie ein bestehendes Marktplatz-Angebot

Field | Description
----- | -----------
*PRODUCT_EAN | EAN-Code
PRODUCT_PRICE | New Price for your Offer without Delivery Costs
PRODUCT_LINK | Shop Deeplink
DELIVERY_VALUE | Notes on Shipping
DELIVERY_PRICE | delivery costs
AVAILABLE | Availability:<br>1: Yes<br>0: No

*required

**Sample Request**
```
$request_update_offer = array(
  "SERVICE"	=> "Offer/Update",
  "DATA"	=> array(
    "PRODUCT_EAN"     => "000000000000000",
    "PRODUCT_PRICE" 	=> "12.34",
    "PRODUCT_LINK" 		=> "http://www.shop.com/product-deeplink.html",
    "DELIVERY_VALUE" 	=> "Lieferbar innerhalb 1-2 Tage",
    "DELIVERY_PRICE" 	=> "4.90",
    "AVAILABLE" 		  => "1"
  )
);
```

**Sample Response**
```
Array(
	[STATUS] => 200
	[DATA] => Array(
		[OFFER_ID] => 99999
		[OFFER_LABEL] => Productname
		[OFFER_EAN] => 12345678900000
		[OFFER_LINK] => http://www.your-shop.com/product-deeplink.html
		[OFFER_CLICKOUTS] => 34
		[OFFER_LAST_MOD] => 2015-10-31 15:00:00
		[OFFER_DATE_END] => 2015-11-07 15:00:00
	)
)
```

Field | Description
----- | -----------
OFFER_ID | Unique Offer-ID
OFFER_LABEL | Productname
OFFER_EAN | EAN-Code (14 Digits)
OFFER_LINK | Shop Deeplink
OFFER_CLICKOUTS | Count recent Clickouts
OFFER_LAST_MOD | Last modification date
OFFER_DATE_END | end daten

## Offer/Add
> Erstellen Sie ein neues Angebot für den Onkel Zoom Marktplatz direkt aus Ihrem Shop-System heraus.

Field | Description
----- | -----------
*PRODUCT_EAN | EAN-Code
*PRODUCT_PRICE | New Price for your Offer without Delivery Costs
PRODUCT_PRICE_OLD | previous price without delivery costs
PRODUCT_AVAILABLE | Availability:<br>1: Yes<br>0: No
*PRODUCT_LINK | Shop Deeplink
DELIVERY_VALUE | Notes on Shipping
DELIVERY_PRICE | delivery costs
*TOKEN | MD5 hash of all the parameters incl. API Key

*required

**Sample Request**
```
$request_add_offer = array(
"SERVICE"	=> "Offer/Add",
  "DATA"		=> array(
		"PRODUCT_EAN"		    => "000000000000000",
		"PRODUCT_PRICE" 	  => "12.34",
		"PRODUCT_PRICE_OLD"	=> "43.21",
		"PRODUCT_AVAILABLE" => "1",
		"PRODUCT_LINK" 		  => "http://www.shop.com/product-deeplink.html",
		"DELIVERY_VALUE" 	  => "Lieferbar innerhalb 1-2 Tage",
		"DELIVERY_PRICE" 	  => "4.90",
		"TOKEN"             => ""
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
```

**Sample Response**

```
Array(
	[STATUS] => 200
	[DATA] => Array(
		[OFFER_ID] => 99999
		[OFFER_LABEL] => Productname
		[OFFER_EAN] => 12345678900000
		[OFFER_LINK] => http://www.your-shop.com/product-deeplink.html
		[OFFER_CLICKOUTS] => 34
		[OFFER_LAST_MOD] => 2015-10-31 15:00:00
		[OFFER_DATE_END] => 2015-11-07 15:00:00
	)
)
```

Field | Description
----- | -----------
OFFER_ID | Unique Offer-ID
OFFER_LABEL | Productname
OFFER_EAN | EAN-Code (14 Digits)
OFFER_LINK | Shop Deeplink
OFFER_CLICKOUTS | Count recent Clickouts
OFFER_LAST_MOD | Last modification date
OFFER_DATE_END | end daten
