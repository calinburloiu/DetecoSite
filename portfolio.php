<?php
require('PortfolioPage.class.php');

$page = new PortfolioPage();
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>