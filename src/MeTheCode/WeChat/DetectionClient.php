<?php

namespace MeTheCode\WeChat;

use MeTheCode\Exception\DetectionException;
use MeTheCode\Http\ClientFactory;
use MeTheCode\Http\ClientInterface;

class DetectionClient
{
	
	const REQUEST_URL = "https://api.zhuolianai.com";
	
	const URL_CHECK_TYPE_WECHAT = 'weixin';
	const URL_CHECK_TYPE_QQ = 'qq';
	const URL_CHECK_TYPE_DOUYIN = 'douyin';
	
	/**
	 * @var string 调用凭证，可前往 https://91.zhuolianai.com/ 获取
	 */
	private $appCode;
	
	/**
	 * @var ClientInterface
	 */
	private $httpClient;
	
	public function __construct ( $appCode )
	{
		$this->httpClient = ClientFactory::createDefault();
		$this->appCode    = $appCode;
	}
	
	protected function createDefaultHeaders ()
	{
		return [
			'Authorization' => 'AppCode/' . $this->appCode
		];
	}
	
	/**
	 * 参考：https://91.zhuolianai.com/item/2
	 *
	 * @param $url
	 * @param $type
	 * @return mixed
	 * @author  methecode
	 * @date    2023/2/7 00:21
	 */
	public function urlCheck ( $url , $type = self::URL_CHECK_TYPE_WECHAT )
	{
		$headers = $this->createDefaultHeaders();
		$resp    = $this->httpClient->request( 'GET' , self::REQUEST_URL . "/91/v1/url/check" , [
			'url'  => $url ,
			'type' => $type ,
		] , $headers );
		
		if ( $resp['http_code'] != 200 ) {
			throw new DetectionException( "Request failed: {$resp['http_code']} - " . $resp['response'] , -2 );
		}
		
		$respJson = json_decode( $resp['response'] , true );
		if ( $respJson['errCode'] !== 0 ) {
			throw new DetectionException( "Invoke failed: " . $respJson['errMsg'] , $respJson['errCode'] );
		}
		
		return $respJson['data'];
	}
	
	/**
	 * 参考：https://91.zhuolianai.com/item/1
	 *
	 * @param $appId
	 * @return mixed
	 * @author  hongyongzhu
	 * @date    2023/2/7 00:23
	 */
	public function queryWechatMpStatus ( $appId )
	{
		$headers = $this->createDefaultHeaders();
		$resp    = $this->httpClient->request( 'GET' , self::REQUEST_URL . "/91/v1/wechat/mp/status" , [
			'appId' => $appId
		] , $headers );
		
		if ( $resp['http_code'] != 200 ) {
			throw new DetectionException( "Request failed: {$resp['http_code']} - " . $resp['response'] , -2 );
		}
		
		$respJson = json_decode( $resp['response'] , true );
		if ( $respJson['errCode'] !== 0 ) {
			throw new DetectionException( "Invoke failed: " . $respJson['errMsg'] , $respJson['errCode'] );
		}
		
		return $respJson['data'];
	}
	
}