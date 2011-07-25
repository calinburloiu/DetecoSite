<?php
require_once('Module.interface.php');


class PortfolioAdsModule implements Module
{
	protected $dbContent;
	
	public function __construct($dbContent)
	{
		$this->dbContent = $dbContent;
	}
	
	public function getContent()
	{
		$content = "";

		$content .= '<h1>'. $this->dbContent->header_from_portfolio. '</h1>'
			. '<div id="portfolio-ads">';
		
		include('portfolio-ads.php');
		$content .= $incContent;
			
		$content .= '</div><script type="text/javascript"> setTimeout("retrievePortfolioAds()", 30000); </script>';

		return $content;
	}
}


?>