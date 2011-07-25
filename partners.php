<?php
require('ArticlePage.class.php');

$page = new ArticlePage("partners");
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>