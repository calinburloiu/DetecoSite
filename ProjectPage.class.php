<?php
require('Page.class.php');

class ProjectPage extends Page
{
	protected $title;
	protected $name = 'project';
	protected $error = 0;
	
	protected $id;
	protected $page;
	protected $project;
	
	public function __construct()
	{
		parent::__construct();
		$this->scripts[] = 'picbox.js';
		$this->styles[] = 'picbox.css';

		$this->dbContent = new Content('portfolio');
		$this->lang = $this->dbContent->getCrtLanguage();

		if(isset($_GET['id']))
		{
			$this->id = intval($_GET['id']);
			$this->project = $this->dbContent->getProject($this->id);
			
			// Deducing the page.
			$nRow = $this->dbContent->getRowNumber(intval($_GET['id']), 
				$this->project['category_code']);
			$this->page = floor($nRow / PRJ_PER_PAGE);
		}
		else
		{
			$this->error = ERR_NO_PROJECT_ID;
			$this->page = 0;
		}
			
		$this->title = SITE_NAME. ' - '. $this->project['name'];
	}
	
	public function appendBackLink()
	{
		$this->append('
			<div class="projects-nav"><a href="portfolio.php?category='
			. $this->project['category_code'] . '&page='. $this->page . '">'
			. $this->dbContent->link_back . '</a></div>');
	}

	public function appendContent()
	{
		$this->append('
		<div class="content"><h1>'. $this->project['name']. '</h1>');
		
		// Navigation bar with back link
		$this->appendBackLink();
		
		// Put the images.
		$images = $this->project['images'];
		$this->append('<table class="pictures-table"><tr>');
		for($i=0; $i < count($images); $i++)
		{
			$imgURL = 'images/portfolio/' . getThumbFileName($images[$i]);
			$this->append('<td><a href="images/portfolio/' . $images[''.$i]
				. '" rel="lightbox-group1">'
				. '<img src="'. $imgURL. '" alt="'
				. $i . '" /></a></td>');
		}
		$this->append('</tr></table>');

		// Put the table with project information.
		$this->append('<table class="project-table">');
		$this->append('<tr><th>' . $this->dbContent->project_name . ': </th><td><em>'
				. $this->project['name'] . '</em></td></tr>');
		$this->append('<tr><th>' . $this->dbContent->project_category . ': </th><td>'
				. $this->project['category'] . '</td></tr>');
		if($this->project['address'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_address . ': </th><td>'
					. $this->project['address'] . '</td></tr>');
		if($this->project['developer'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_developer . ': </th><td>'
					. $this->project['developer'] . '</td></tr>');
		if($this->project['chief_architect'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_chief_architect . ': </th><td>'
					. $this->project['chief_architect'] . '</td></tr>');
		if($this->project['whole_area'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_whole_area . ': </th><td>'
					. $this->project['whole_area'] . ' m&sup2;</td></tr>');
		if($this->project['height'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_height . ': </th><td>'
					. $this->project['height'] . '</td></tr>');
		if($this->project['phase'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_phase . ': </th><td>'
					. $this->project['phase'] . '</td></tr>');
		if($this->project['year_begin'] != '')
		{
			$this->append('<tr><th>' . $this->dbContent->project_year . ': </th><td>'
					. $this->project['year_begin']);
			if($this->project['year_end'] != '')
				$this->append('-'
						. $this->project['year_end'] . '</td></tr>');
		}
		if($this->project['description'] != '')
			$this->append('<tr><th>' . $this->dbContent->project_description . ': </th><td>'
					. $this->project['description'] . '</td></tr>');
	
		$this->append('</table>');
		
		// Navigation bar with back link
		$this->appendBackLink();
		
		$this->append('</div>');
	}
}