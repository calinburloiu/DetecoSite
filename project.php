<?php
header('Content-Type: text/html; charset=utf-8');

require('ProjectPage.class.php');

$page = new ProjectPage();
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>