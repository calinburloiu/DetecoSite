<?php
require_once('PortfolioAdsModule.class.php');
//require_once('StaticAdsModule.class.php');
require_once('Content.class.php');
require_once('util.inc.php');

class Page
{
	protected $title = "Page";
	protected $name = "page";
	protected $content = "";
	protected $dbContent;
	protected $lang;
	
	protected $scripts;
	protected $styles;
	
	public function __construct()
	{
		$this->scripts = array("jquery.min.js", "utils.js", "portfolio-ads.js");
		$this->styles = array("main.css");
	}
	
	public function append($str)
	{
		$this->content .= $str;
	}
	
	public function appendHeader()
	{
		$this->content .= '
	<div id="header">';
	
		// Menu
		$this->content .= '
		<ul id="menu">
			<li><a href="index.php"' . ($this->name == 'home' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_home . '</a></li>
			<li><a href="company.php"' . ($this->name == 'company' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_company . '</a></li>
			<li><a href="team.php"' . ($this->name == 'team' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_team . '</a></li>
			<li><a href="portfolio.php"' . ($this->name == 'portfolio' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_portfolio . '</a></li>
			<li><a href="partners.php"' . ($this->name == 'partners' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_partners . '</a></li>
			<li><a href="contact.php"' . ($this->name == 'contact' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_contact . '</a></li>
		</ul>';// . (isset($this->error) ? '<div class="error">'.$this->error . '</div>' : '') .

		// Language links
		$this->content .= '
		<ul id="languages">';
      	foreach($this->dbContent->getLanguages() as $key => $value)
      	{
			$this->content .= '<li><a href="'
				. getURL(array("lang" => $key)). '"><img src="images/flags/'
				. $value['img']. '" /> '. $value['name']. '</a></li>';
      	}      	
		$this->content .= '
		</ul>';
		
		$this->content .= '
	</div>';
	}
	
	public function appendContent()
	{
		
	}
	
	public function appendSide()
	{		
		$this->append('
		<div class="side">');
		
		$modPA = new PortfolioAdsModule($this->dbContent);
		$this->append($modPA->getContent());
		
		//$modSA = new StaticAdsModule($this->dbContent);
		//$this->append($modSA->getContent());
		
		$this->append('
		</div>');
	}
	
	public function appendBody()
	{
		$this->append('
	<div id="body">');
		
		$this->appendContent();
		$this->appendSide();
		$this->append('
		<div style="clear: both; background: rgb(0,91,193);"></div>
	</div>');
	}

	public function appendFooter()
	{
		$this->content .= '
	<div id="footer"><p><ul>';
		$this->content .= '<li><a href="portfolio.php?category=office&page=0">'
			. $this->dbContent->project_category_office. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=residential&page=0">'
			. $this->dbContent->project_category_residential. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=commercial&page=0">'
			. $this->dbContent->project_category_commercial. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=industrial&page=0">'
			. $this->dbContent->project_category_industrial. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=hotel&page=0">'
			. $this->dbContent->project_category_hotel. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=hospital&page=0">'
			. $this->dbContent->project_category_hospital. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=restoration&page=0">'
			. $this->dbContent->project_category_restoration. '</a></li>';
		$this->content .= '<li><a href="portfolio.php?category=other&page=0">'
			. $this->dbContent->project_category_other. '</a></li>';
		$this->content .= '</ul></p><p>Copyright &copy; 2011, S.C. Deteco S.R.L. | Webmaster and Designer: <a href="contact.php#calin-burloiu">Cãlin-Andrei Burloiu</a></p>
	</div>';
	}
	
	public function display()
	{
		// TODO: set charset!
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>' . $this->title . '</title>
<meta name="keywords" content="" />
<meta name="description" content="" />';
		foreach($this->styles as $style)
			echo '<link href="css/'. $style . '" rel="stylesheet" type="text/css" />';
		foreach($this->scripts as $script)
			echo '<script type="text/javascript" src="js/'. $script . '"></script>';
		echo '</head>
<body>
';

		$this->content = '<div id="main_bg"><div id="main">' . $this->content . '</div></div>';
		echo $this->content;
		
		echo '</body></html>';
	}
	
	public function addScript($script)
	{
		$this->scripts[] = $script;
	}
}
