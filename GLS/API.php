<?php

namespace GLS;

class API {
	protected $url = NULL;
	protected $url_options = NULL;
	
	public $client_number = NULL;
	public $username = NULL;
	public $pwd = NULL;
	public $password = NULL;
    
    protected $label_size = array("A6", "A6_PP", "A6_ONA4", "A4_2x2", "A4_4x1", "T_85x85");
    protected $config;
	
	protected $urls = [
		'HU-TEST' => 'https://api.test.mygls.hu/ParcelService.svc?singleWsdl',
		'HU' => 'https://api.mygls.hu/ParcelService.svc?singleWsdl',
		'RO' => 'https://api.mygls.ro/ParcelService.svc?singleWsdl',
		'SK' => 'https://api.mygls.sk/ParcelService.svc?singleWsdl',
		'CZ' => 'https://api.mygls.cz/ParcelService.svc?singleWsdl',
		'HR' => 'https://api.mygls.hr/ParcelService.svc?singleWsdl',
		'SI' => 'https://api.mygls.si/ParcelService.svc?singleWsdl',
	];

    /**
     * Request constructor
     * @param $config
     */
    public function __construct($config = array()){
        try {
            $this->config = $config;
			
			$this->client_number = $this->config['client_number'];
			$this->username = $this->config['username'];
			
			$this->pwd = $this->config['password'];
			$this->password = hash('sha512', $this->pwd, true);
			
			$this->url = $this->urls[$this->config['country_code']];
			$this->url_options = array(
				'soap_version'   => SOAP_1_1, 
				'stream_context' => stream_context_create(array(
					'ssl' => array(
						'cafile' => dirname(__FILE__).'/cacert.pem'
					)
				))
			);
        } catch(Exception $e) {
            print_r($e);
        }
    }
		
	public function PrintLabels($parcels){
		$printLabelsRequest = array(
			'Username' => $this->username,
			'Password' => $this->password,
			'ParcelList' => $parcels
		);
									
		$request = array ("printLabelsRequest" => $printLabelsRequest);

		$client = new \SoapClient($this->url, $this->url_options);
		$response = $client->PrintLabels($request);

		return $response;
	}

	public function PrepareLabels($parcels){
		$prepareLabelsRequest = array(
			'Username' => $this->username,
			'Password' => $this->password,
			'ParcelList' => $parcels
		);
									  
		$request = array ("prepareLabelsRequest" => $prepareLabelsRequest);
		
		$client = new \SoapClient($this->url,$this->url_options);
		$response = $client->PrepareLabels($request);
										 
		return $response;
	}

	public function GetPrintedLabels($parcelIdList){
		$getPrintedLabelsRequest = array(
			'Username' => $this->username,
			'Password' => $this->password,
			'ParcelIdList' => $parcelIdList,
			'PrintPosition' => 1,
			'ShowPrintDialog' => 0
		);
		
		$request = array ("getPrintedLabelsRequest" => $getPrintedLabelsRequest);

		$client = new \SoapClient($this->url, $this->url_options);
		$response = $client->GetPrintedLabels($request);
		
		return $response;
	}
	
	public function GetPrintData($parcels){
		$getPrintDataRequest = array(
			'Username' => $this->username,
			'Password' => $this->password,
			'ParcelList' => $parcels
		);
		
		$request = array ("getPrintDataRequest" => $getPrintDataRequest );

		$client = new \SoapClient($this->url, $this->url_options);
		$response = $client->GetPrintData($request);
		
		return $response;
	}
}