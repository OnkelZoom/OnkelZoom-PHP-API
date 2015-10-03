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
Sample-Request:
```
$request_get_account_info = array(
  "SERVICE"	=> "Account/Get"
);
```
Sample JSON-Response:
```
{"STATUS":"200","DATA":{"COMPANY":"Your Company","FIRSTNAME":"Firstname","LASTNAME":"Lastname","EMAIL":"me@company.com","WEBSITE":"www.company.com","STREET":"Company Ave. 12","ZIP":"12345","CITY":"Town","ZOOM_URL":"http:\/\/www.onkel-zoom.com\/haendler\/your-company\/","VISITS":1234,"OFFERS":"5678"}}
```

## Offer/Get
```
$request_get_offer = array(
  "SERVICE"	=> "Offer/Get",
  "DATA"		=> array(
    "PRODUCT_EAN"	=> "000000000000000" // Product EAN-Code. *required
  )
);
```

## Offer/Get/All
```
$request_params = array(
  "SERVICE"	=> "Offer/Get/All",
  "DATA"    => array(
    "START"       => "0",
    "LIMIT"       => "10",
    "ORDER_BY"    => "DATE_MOD",
    "ORDER_DESC"  => "DESC",
  )
);
```
