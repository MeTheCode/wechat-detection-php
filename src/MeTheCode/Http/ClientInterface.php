<?php

namespace MeTheCode\Http;

interface ClientInterface
{
	
	function request ( $method , $url , $data = [] , $headers = [] , $options = [] );
	
}