<?php
require_once('PortfolioAdsModule.class.php');
require_once('Content.class.php');

$dbContent = new Content('common');
$portfolioAdsModule = new PortfolioAdsModule($dbContent);

echo $portfolioAdsModule->getAdsContent();