<?php
require('ProjectPage.class.php');

$page = new ProjectPage();
$page->appendHeader();
$page->appendBody();
$page->appendFooter();
$page->display();

?>