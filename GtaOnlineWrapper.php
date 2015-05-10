<?php

/**
*
*	GtaOnlineWrapper
*	Author:	Naoto Ida
*
**/

require_once("lib/simplehtmldom.php");
require_once("GtaOnlineWrapperBase.php");

class GtaOnlineWrapper extends GtaOnlineWrapperBase {

	//	Login parameters
	private $login;
	private $password;
	private $target;

	public function __construct()
	{
		$rvt = $this->extractRvt();
		$this->setRvt($rvt);
	}

	public function setLogin($login)
	{
		$this->login = $login;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setTarget($target)
	{
		$this->target = $target;
	}

	public function loginToService()
	{
		$ch = curl_init();
		$options = [
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_COOKIEJAR		=> self::COOKIEJAR_PATH,
			CURLOPT_COOKIEFILE		=> self::COOKIEJAR_PATH,
			CURLOPT_URL				=> "https://".self::API_URL."/profile/signin",
			CURLOPT_POST			=> 1,
			CURLOPT_POSTFIELDS		=> "login=".$this->login."&password=".$this->password."&__RequestVerificationToken=".$this->getRvt(),
			CURLOPT_HTTPHEADER		=> [
				'Content-Type: application/x-www-form-urlencoded'
			],
			CURLOPT_FOLLOWLOCATION	=> true
		];
		curl_setopt_array($ch, $options);
		$html = curl_exec ($ch); // execute the curl command
		curl_close ($ch);
		unset($ch);
	}

	public function getCareerOverview()
	{
		$ch = curl_init();
		$options = [
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_ENCODING		=> "gzip",
			CURLOPT_COOKIEFILE		=> self::COOKIEJAR_PATH,
			CURLOPT_URL				=> "http://socialclub.rockstargames.com/games/gtav/career/overviewAjax?character=Freemode&nickname=".$this->target."&slot=Freemode&gamerHandle=&gamerTag=&_=".time()."000",
			CURLOPT_HTTPHEADER		=> [
				'Accept-Encoding: gzip, deflate'
			],
			CURLOPT_FOLLOWLOCATION	=> true
		];
		curl_setopt_array($ch, $options);
        $html = curl_exec ($ch);
        curl_close ($ch);
        unset($ch);
		
		return $html;
	}
}

//	test code

$gta = new GtaOnlineWrapper();
$gta->setLogin($login);
$gta->setPassword($password);
$gta->setTarget($target);
$gta->loginToService();
echo $gta->getCareerOverview();
