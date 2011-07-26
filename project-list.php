<?php
require_once('Content.class.php');
require_once('ProjectListModule.class.php');

// Page from URL.
if(isset($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 0;
// Category from URL.
if(isset($_GET['category']))
	$category = $_GET['category'];
else
	$category = 'office';

$dbContent = new Content('portfolio');
$prjListModule = new ProjectListModule($dbContent, $page, $category);

echo $prjListModule->getContent();