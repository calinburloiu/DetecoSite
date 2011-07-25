<?php
require('ArticlePage.class.php');

$page = new ArticlePage("company");
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>