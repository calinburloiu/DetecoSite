<?php
require('ArticlePage.class.php');

$page = new ArticlePage("home");
$page->addScript('imagePreloader.js');
$page->addScript('imageSlideshow.js');
$page->addScript('runSlideshow.js');
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>