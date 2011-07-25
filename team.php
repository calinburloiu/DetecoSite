<?php
require('ArticlePage.class.php');

$page = new ArticlePage("team");
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>