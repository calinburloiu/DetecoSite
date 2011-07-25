<?php
require_once('Content.class.php');

$incContent = '';

// Pages navigation
function navigation($page, $dbContent, $portfolioCard)
{
	global $incContent;

	$nPages = ceil($portfolioCard / PRJ_PER_PAGE);
	if($nPages <= 1)
		return;

	$incContent .= '
				<div class="projects-nav">';
	
	if($page > 0)
	{
		$incContent .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($page-1) . ', null)"> ' 
			. $dbContent->portfolio_previous. '</a> ';
	}
	
	for($i = 1; $i <= $nPages; $i++)
	{
		if($i - 1 == $page)
			$incContent .= '<span class="crt-page">'. $i. '</span> ';
		else
			$incContent .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($i-1) . ', null)">' 
			. $i . '</a> ';
	}
	
	if(($page + 1) < $nPages)
	{
		$incContent .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($page+1) . ', null)">' 
			. $dbContent->portfolio_next . ' '. '</a>';
	}
	
	$incContent .= '</p>';
}

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

$dbContent = new Content("portfolio");

$portfolio = $dbContent->getPortfolioSummary($category, $page);
if($portfolio == null)
	die();
$portfolioCard = $dbContent->getPortfolioCardinality($category);

navigation($page, $dbContent, $portfolioCard);
	
$i = 0;
$count = 0;
$incContent .= '
				<table class="icons-table">';
foreach($portfolio as $id => $value)
{
	$href = getProjectURL($id, $value['name']);
	if($value['image'] != null)
		$img = "images/portfolio/". $value['image'];
	else
		$img = "";
	
	if($i == 0)
		$incContent .= '
					<tr>';
	
	$incContent .= '<td><a class="icon" href="' . $href . '">';
	if($img != '')
		$incContent .= '<img class="icon-img" src="' . $img . '" />';
	$incContent .= '<div class="icon-title">'
		. $value['name'] . ' (' . $value['year_begin'] . ')</div></a></td>';
			
	$i++;
	if($i == 3)
	{
		$incContent .= '</tr>';
		$i = 0;
	}
	
	$count++;
	if($count == PRJ_PER_PAGE)
		break;
}
$incContent .= '
				</table>';

navigation($page, $dbContent, $portfolioCard);
?>
