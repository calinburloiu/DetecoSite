<?php
header('Content-Type: text/html; charset=utf-8');

require('PortfolioPage.class.php');

$page = new PortfolioPage();
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>