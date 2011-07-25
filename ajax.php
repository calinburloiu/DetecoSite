<?php

if(isset($_GET['method']))
	$method = $_GET['method'];
else
	die();

if ($method == 'project-list')
{
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
}

include($method . ".php");

echo $incContent;
