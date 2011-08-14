<?php
require('Page.class.php');

class ProjectPage extends Page
{
	protected $title;
	protected $name = 'project';
	protected $error = 0;
	
	protected $id;
	protected $tags;
	protected $page = 0;
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
			try
			{
				$this->project = $this->dbContent->getProject($this->id);
				if ($this->project === NULL)
					throw new Exception('');
				
				// Deducing the page.
				$nRow = $this->dbContent->getRowNumber(intval($_GET['id']), 
					$this->project['category_code']);
				$this->page = floor($nRow / PRJ_PER_PAGE);
			}
			catch (Exception $e)
			{
				$this->error = ERR_NO_PROJECT_ID;
			}
		}
		else
		{
			$this->error = ERR_NO_PROJECT_ID;
			$this->page = 0;
		}
		
		if($this->project && isset($_GET['tags']))
		{
			$this->tags = $_GET['tags'];
			if ($this->tags != $this->project['tags'])
			{
				$this->error = ERR_WRONG_PROJECT_TAGS;
				//echo $this->tags.'//'.$this->project['tags'];
			}
		}
			
		$this->title = $this->project['name'] .' - '. $this->dbContent->title;
		$this->description = $this->dbContent->project_category . ': '. $this->project['category'] . '; ' . $this->dbContent->project_address . ': '. $this->project['address'] . '; ' . $this->dbContent->project_developer . ': '. $this->project['developer'] . '; ' . $this->dbContent->project_year. ': '. $this->project['year_begin'];
	}
	
	public function appendBreadcrumbList()
	{
		$this->append('
			<div class="breadcrumbs-list">
				<a href="'. makeURLSegm($this->lang, 'home'). '">DETECO</a> &gt;
				<a href="'
				. makeURLSegm($this->lang, 'portfolio', 
					array($this->project['category_code'], $this->page))
				. '">'
				. $this->dbContent->menu_portfolio . '</a> &gt;
				<span class="crt-page">'. $this->dbContent->project_page. '</span>
			</div>');
	}

	public function appendContent()
	{
		switch ($this->error)
		{
		case ERR_NO_PROJECT_ID:
			$this->append('<div class="error">Error: Malformed URL: Invalid project ID!</div>');
			return;
		case ERR_WRONG_PROJECT_TAGS:
			$this->append('<div class="error">Error: Malformed URL: Invalid project tags!</div>');
			return;
		}
	
		$this->append('
		<div class="content">');
		
		// Navigation bar with back link
		$this->appendBreadcrumbList();
		
		// Header
		$this->append('
		<h1>'. $this->project['name']. '</h1>');
		
		// Put the images.
		$images = $this->project['images'];
		$this->append('<table class="pictures-table"><tr>');
		for($i=0; $i < count($images); $i++)
		{
			$imgURL = 'images/portfolio/' . getThumbFileName($images[$i]);
			$this->append('<td><a href="/images/portfolio/' . $images[''.$i]
				. '" rel="lightbox-group1">'
				. '<img src="/'. $imgURL. '" alt="'
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
		$this->appendBreadcrumbList();
		
		$this->append('</div>');
	}
}