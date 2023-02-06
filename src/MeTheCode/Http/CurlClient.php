<?php

namespace MeTheCode\Http;

use MeTheCode\Exception\DetectionException;

class CurlClient implements \MeTheCode\Http\ClientInterface
{
	const DEFAULT_TIMEOUT = 10;
	
	public function request ( $method , $url , $data = [] , $headers = [] , $options = [] )
	{
		
		$ch = curl_init();
		curl_setopt( $ch , CURLOPT_URL , $url );
		curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $ch , CURLOPT_HEADER , 0 );
		curl_setopt( $ch , CURLOPT_CUSTOMREQUEST , $method );
		curl_setopt( $ch , CURLOPT_POSTFIELDS , $data );
		
		$curlHeaders = [];
		foreach ( $headers as $headerKey => $headerValue ) {
			$curlHeaders[] = $headerKey . ': ' . $headerValue;
		}
		
		curl_setopt( $ch , CURLOPT_HTTPHEADER , $curlHeaders );
		
		curl_setopt( $ch , CURLOPT_TIMEOUT , 10 );
		curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , 10 );
		curl_setopt( $ch , CURLOPT_SSL_VERIFYPEER , false );
		curl_setopt( $ch , CURLOPT_SSL_VERIFYHOST , false );
		curl_setopt( $ch , CURLOPT_USERAGENT , 'MeTheCode-PHP-Client' );
		curl_setopt( $ch , CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch , CURLOPT_IPRESOLVE , CURL_IPRESOLVE_V4 );
		
		// 设置超时时间
		$timeout = isset( $options['timeout'] ) ? $options['timeout'] : self::DEFAULT_TIMEOUT;
		curl_setopt( $ch , CURLOPT_TIMEOUT , $timeout );
		
		$response = curl_exec( $ch );
		
		$errno = curl_errno( $ch );
		$error = curl_error( $ch );
		$info  = curl_getinfo( $ch );
		
		curl_close( $ch );
		
		if ( $errno ) {
			throw new DetectionException( 'Curl error: ' . $error , -2 );
		}
		
		return [
			'http_code' => $info['http_code'] ,
			'response'  => $response ,
		];
		
	}
	
}