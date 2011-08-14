<?php
require_once('Module.interface.php');
require_once('Content.class.php');
require_once('config.inc.php');
require_once('util.inc.php');

define('MAX_DESCR_LEN', 150);

class PortfolioAdsModule implements Module
{
	protected $dbContent;
	
	public function __construct($dbContent)
	{
		$this->dbContent = $dbContent;
	}
	
	public function getAdsContent()
	{
		$content = '';

		$ads = $this->dbContent->getPortfolioAds();

		foreach($ads as $id => $value)
		{
			$href = makeURLSegm($this->dbContent->getCrtLanguage(), getProjectURL($id, $value['tags']));
			$more = false;
			
			$content .= '<div class="ad">';
			// name, year_begin
			$content .= '<a href="'. $href. '"><h2>'. $value['name']. ' ('. $value['year_begin']
				. ')</h2></a>';
			// thumbnail image
			if($value['image'])
				$content .= '<a href="'. $href. '"><img class="floating-pic" src="/images/portfolio/'
					. $value['image']. '" /></a>';
			
			// description
			$descr = $value['description'];
			// Reduce description size to at most MAX_DESCR_LEN chars.
			if(strlen($descr) > MAX_DESCR_LEN)
			{
				$descr = substr($descr, 0, MAX_DESCR_LEN);
				$descr = substr($descr, 0, strrpos($descr, ' '));
				$more = true;
			}
			$content .= $descr;
			// read more link
			if($more)
				$content .= ' <a href="'. $href. '">...('. $this->dbContent->link_more. ')</a>';
				
			$content .= '<div style="clear: both"></div>';
			
			$content .= '</div>';
		}
		
		return $content;
	}
	
	public function getContent()
	{
		$content = "";

		$content .= '<h1>'. $this->dbContent->header_from_portfolio. '</h1>'
			. '<div id="portfolio-ads">';
		
		$content .= $this->getAdsContent();
			
		$content .= '</div><script type="text/javascript"> setTimeout("retrievePortfolioAds()", 30000); </script>';

		return $content;
	}
}


?>