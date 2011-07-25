<?php
require_once('Module.interface.php');


class StaticAdsModule implements Module
{
	protected $dbContent;
	protected $lang;
	
	public function __construct($dbContent)
	{
		$this->dbContent = $dbContent;
		$this->lang = $this->dbContent->getCrtLanguage();
	}
	
	public function getContent()
	{
		$content = '<h1>'. $this->dbContent->header_ads. '</h1>';
		
		$fileContent = file("articles/ads" . "_" . $this->lang . ".html");
		foreach($fileContent as $line)
		{
			$content .= $line. "\n";
		}
		
		return $content;
	}
}


?>