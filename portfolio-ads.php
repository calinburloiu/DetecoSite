<?php
require_once('Content.class.php');
require_once('config.inc.php');

$incContent = '';

define('MAX_DESCR_LEN', 150);

$dbContent = new Content("portfolio");
$ads = $dbContent->getPortfolioAds();

foreach($ads as $id => $value)
{
	$href = getProjectURL($id, $value['name']);
	$more = false;
	
	$incContent .= '<div class="ad">';
	// name, year_begin
	$incContent .= '<a href="'. $href. '"><h2>'. $value['name']. ' ('. $value['year_begin']
		. ')</h2></a>';
	// thumbnail image
	if($value['image'])
		$incContent .= '<a href="'. $href. '"><img class="floating-pic" src="images/portfolio/'
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
	$incContent .= $descr;
	// read more link
	if($more)
		$incContent .= ' <a href="'. $href. '">...('. $dbContent->link_more. ')</a>';
		
	$incContent .= '<div style="clear: both"></div>';
	
	$incContent .= '</div>';
}
