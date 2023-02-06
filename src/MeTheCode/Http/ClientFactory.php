<?php

namespace MeTheCode\Http;

class ClientFactory
{
	
	public static function createDefault ()
	{
		return new CurlClient();
	}
	
}