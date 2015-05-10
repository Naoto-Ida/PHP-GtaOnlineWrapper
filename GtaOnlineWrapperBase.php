<?php

/**
*
*	GtaOnlineWrapperBase
*	Author:	Naoto Ida
*
**/

class GtaOnlineWrapperBase {

	const API_URL           = "socialclub.rockstargames.com";
    const COOKIEJAR_PATH    = "./public/cookie.txt";

	private $rvt;

	public function __construct()
	{

	}

	protected function getRvt()
	{
		return $this->rvt;
	}

	protected function setRvt($rvt)
	{
		$this->rvt = $rvt;
	}

	protected function extractRvt()
    {
		$ch = curl_init();
		$options = [
			CURLOPT_URL             => "http://".self::API_URL,
			CURLOPT_COOKIEJAR       => self::COOKIEJAR_PATH,
			CURLOPT_RETURNTRANSFER  => 1
		];
		curl_setopt_array($ch, $options);
		$html = curl_exec($ch);
		curl_close($ch);
		unset($ch);

		return str_get_html($html)->find('input[name=__RequestVerificationToken]', 0)->value;
	}
}
