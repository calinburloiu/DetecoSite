<?php
require('ArticlePage.class.php');

$page = new ArticlePage("contact");
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>