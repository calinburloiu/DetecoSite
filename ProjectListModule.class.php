<?php
require_once('Module.interface.php');
require_once('Content.class.php');
require_once('config.inc.php');

class ProjectListModule implements Module
{
	protected $dbContent;
	
	public function __construct($dbContent, $page=0, $category='office')
	{
		$this->dbContent = $dbContent;
		$this->page = $page;
		$this->category = $category;
	}
	
	function getNavigation($page, $portfolioCard)
	{
		$nav = "";
		
		$nPages = ceil($portfolioCard / PRJ_PER_PAGE);
		if($nPages <= 1)
			return "";

		$nav .= '
					<div class="projects-nav">';
		
		if($page > 0)
		{
			$nav .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($page-1) . ', null)"> ' 
				. $this->dbContent->portfolio_previous. '</a> ';
		}
		
		for($i = 1; $i <= $nPages; $i++)
		{
			if($i - 1 == $page)
				$nav .= '<span class="crt-page">'. $i. '</span> ';
			else
				$nav .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($i-1) . ', null)">' 
				. $i . '</a> ';
		}
		
		if(($page + 1) < $nPages)
		{
			$nav .= '<a href="javascript: void(0)" onclick="retrieveProjects(' . ($page+1) . ', null)">' 
				. $this->dbContent->portfolio_next . ' '. '</a>';
		}
		
		$nav .= '</div>';
		
		return $nav;
	}
	
	
	public function getContent()
	{
		$content = '';

		$portfolio = $this->dbContent->getPortfolioSummary($this->category, 
			$this->page);
		if($portfolio == null)
			return '';
		$portfolioCard = $this->dbContent->getPortfolioCardinality(
			$this->category);

		$content .= $this->getNavigation($this->page, $portfolioCard);
			
		$i = 0;
		$count = 0;
		$content .= '
						<table class="icons-table">';
		foreach($portfolio as $id => $value)
		{
			$href = getProjectURL($id, $value['name']);
			if($value['image'] != null)
				$img = "images/portfolio/". $value['image'];
			else
				$img = "";
			
			if($i == 0)
				$content .= '
							<tr>';
			
			$content .= '<td><a class="icon" href="' . $href . '">';
			if($img != '')
				$content .= '<img class="icon-img" src="' . $img . '" />';
			$content .= '<div class="icon-title">'
				. $value['name'] . ' (' . $value['year_begin'] . ')</div></a></td>';
					
			$i++;
			if($i == 3)
			{
				$content .= '</tr>';
				$i = 0;
			}
			
			$count++;
			if($count == PRJ_PER_PAGE)
				break;
		}
		$content .= '
						</table>';

		$content .= $this->getNavigation($this->page, $portfolioCard);


		return $content;
	}
}