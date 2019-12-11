<?php

require __DIR__ . '/GLS/API.php';

ini_set('memory_limit','1024M');
ini_set('max_execution_time', 600);

try {
	// Create instance
	$api = new GLS\API([
		'username'          => 'myglsapitest@test.mygls.hu',
		'password'          => '1pImY_gls.hu',
		'client_number'     => '100000001',
		'country_code'      => 'HU-TEST',
		'label_paper_size'  => 'A4_2x2'
	]);

	// Create parcel
	$parcels = []; 
	$parcel = new StdClass();
	$parcel->ClientNumber = $api->client_number;
	$parcel->ClientReference = "TEST PARCEL";
	$parcel->CODAmount = 0;
	$parcel->CODReference = "COD REFERENCE";
	$parcel->Content = "CONTENT";
	$parcel->Count = 1;
	$deliveryAddress = new StdClass();
	$deliveryAddress->ContactEmail = "something@anything.hu";
	$deliveryAddress->ContactName = "Contact Name";
	$deliveryAddress->ContactPhone = "+36701234567";
	$deliveryAddress->Name = "Delivery Address";
	$deliveryAddress->Street = "Európa u.";
	$deliveryAddress->HouseNumber = "2";
	$deliveryAddress->City = "Alsónémedi";
	$deliveryAddress->ZipCode = "2351";
	$deliveryAddress->CountryIsoCode = "HU";
	$deliveryAddress->HouseNumberInfo = "/b";
	$parcel->DeliveryAddress = $deliveryAddress;
	
	$pickupAddress = new StdClass();
	$pickupAddress->ContactName = "Contact Name";
	$pickupAddress->ContactPhone = "+36701234567";
	$pickupAddress->ContactEmail = "something@anything.hu";
	$pickupAddress->Name = "Pickup Address";
	$pickupAddress->Street = "Európa u.";
	$pickupAddress->HouseNumber = "2";
	$pickupAddress->City = "Alsónémedi";
	$pickupAddress->ZipCode = "2351";
	$pickupAddress->CountryIsoCode = "HU";
	$pickupAddress->HouseNumberInfo = "/a";
	$parcel->PickupAddress = $pickupAddress;
	
	$parcel->PickupDate = null;
	
	$service1 = new StdClass();
	$service1->Code = "PSD";
	$parameter1 = new StdClass();
	$parameter1->StringValue = "2351-CSOMAGPONT";
	$service1->PSDParameter = $parameter1;
	
	$services = [];
	$services[] = $service1;
	$parcel->ServiceList = $services;
	
	$parcels[] = $parcel;

	// Get PrintLabels
	file_put_contents('PrintLabels.pdf', $api->PrintLabels($parcels));
	
	// Get GetPrintedLabels
	file_put_contents('GetPrintedLabels.pdf', $api->GetPrintedLabels(PrepareLabels($parcels)));
}catch (Exception $e){
    print_r($e);
}