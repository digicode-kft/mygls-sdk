# mygls-sdk
A simple wrapper for the GLS logistics SOAP API, it gives more flexibility then the [original](https://api.mygls.hu/) one.  Our company, the DigiCode Kft. using this package in a custom system for printing the logistic labels with a [Zebra](https://www.digicode.hu/zebra-m1/cimke-vonalkod-nyomtato-c1) printer. But its also usable with [Honeywell](https://www.digicode.hu/honeywell-m4/cimke-vonalkod-nyomtato-c1), [Intermec](https://www.digicode.hu/intermec-m3/cimke-vonalkod-nyomtato-c1), [TSC](https://www.digicode.hu/tsc-m20/cimke-vonalkod-nyomtato-c1) or any classic printers, like HP, Konica, etc..

## Usage

First of all you must check the available methods for creating and printing labels. 

> If your company need any [etiquette label](https://www.digicode.hu/ontapados-etikett-cimke-c8) feel free to contact with us.

```php
require __DIR__ . '/GLS/API.php';

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
	...
	// check in test.php
	$parcels[] = $parcel;

	// First method is PrintLabels, which simply crate a label
	$first_method = $api->PrintLabels($parcels);
	print_r($first_method);	
	
	...
	// check in test.php
}catch (Exception $e){
    print_r($e);
}
```

## Label printers

If you need any device for testing the code feel free to [contact us](https://www.digicode.hu/kapcsolat). You can choose any [barcode label printer](https://www.digicode.hu/cimke-vonalkod-nyomtato-c1) on our website.
