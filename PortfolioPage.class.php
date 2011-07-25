<?php
require('Page.class.php');

class PortfolioPage extends Page
{
	protected $title = 'Portfolio';
	protected $name = 'portfolio';
	
	protected $dbContent;
	protected $page;
	protected $category;
	
	public function __construct()
	{
		parent::__construct();
		$this->scripts[] = 'portfolio.js';
		
		$this->dbContent = new Content("portfolio");
		$this->lang = $this->dbContent->getCrtLanguage();
		
		$this->title = SITE_NAME. ' - '. $this->dbContent->getContent('menu_' . $this->name, $this->lang);
		
		// category from URL
		if(isset($_GET['category']))
			$this->category = $_GET['category'];
		else
			$this->category = 'office';
		
		// ID from URL (used for deducing the page)
		if(isset($_GET['id']))
		{
			$nRow = $this->dbContent->getRowNumber(intval($_GET['id']), $this->category);
			$this->page = floor($nRow / PRJ_PER_PAGE);
		}
		else
			$this->page = 0;
	}	
	
	public function appendContent()
	{
		// Category from URL.
		if(isset($_GET['category']))
			$category = $_GET['category'];
		else
			$category = 'office';
	
		$this->append('
		<div class="content container">');
		
		$this->append('
			<div class="sub-menu-container">
				<ul id="sub-menu">
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'office\')" title="office"'
						. ($category == 'office' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_office. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'residential\')" title="residential"'
						. ($category == 'residential' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_residential. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'commercial\')" title="commercial"'
						. ($category == 'commercial' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_commercial. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'industrial\')" title="industrial"'
						. ($category == 'industrial' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_industrial. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'hotel\')" title="hotel"'
						. ($category == 'hotel' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_hotel. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'hospital\')" title="hospital"'
						. ($category == 'hospital' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_hospital. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'restoration\')" title="restoration"'
						. ($category == 'restoration' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_restoration. '</a></li>
					<li><a href="javascript: void(0)" onclick="retrieveProjects(0, \'other\')" title="other"'
						. ($category == 'other' ? ' class="but_pressed"' : ''). '>'
						. $this->dbContent->project_category_other. '</a></li>
				</ul>
			</div>
		');
		
		// AJAX
		$this->append('
			<div class="sub-content"><div id="project-list">');
			
		include('project-list.php');
		$this->append($incContent);
			
		$this->append('</div></div>
			<div style="clear: both"></div>
			<!--<script type="text/javascript"> retrieveProjects('
			. $this->page . ', "'. $this->category . '"); </script>-->');
		
		$this->append('
		</div>');
	}
	
}