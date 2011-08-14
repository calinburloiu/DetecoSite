<?php
header('Content-Type: text/html; charset=utf-8');

require('ArticlePage.class.php');

$page = new ArticlePage("team");
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>