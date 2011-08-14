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
	
	protected $description; // meta
	protected $scripts;
	protected $styles;
	
	public function __construct()
	{
		$this->scripts = array("jquery.min.js", "portfolio-ads.js");
		$this->styles = array("main.css");
	}
	
	/**
	 * Current URL modified to support the new language.
	 */
	public function getLanguageURL($langCode)
	{
		return "/$langCode". strstr(substr($_SERVER['REQUEST_URI'], 1), '/');
	}
	
	public function append($str)
	{
		$this->content .= $str;
	}
	
	public function appendLanguageLinks()
	{
		$this->content .= '
		<ul id="languages">';
      	foreach($this->dbContent->getLanguages() as $key => $value)
      	{
			$url = $this->getLanguageURL($key); 
			$this->content .= '<li><a href="'
				. $url. '"><img src="/images/img_trans.gif" style="'
				. 'background: url(/images/flags.png) 0 '
				. (-12 * $value['img']). 'px no-repeat; '
				. 'width: 22px; height: 11px;" /> '. $value['name']. '</a></li>';
      	}      	
		$this->content .= '
		</ul>';
	}
	
	public function appendHeader()
	{
		$this->content .= '
	<div id="header">';
	
		// Menu
		$this->content .= '
		<ul id="menu">
			<li><a href="'. makeURLSegm($this->lang, 'home'). '"' . ($this->name == 'home' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_home . '</a></li>
			<li><a href="'. makeURLSegm($this->lang, 'company'). '"' . ($this->name == 'company' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_company . '</a></li>
			<li><a href="'. makeURLSegm($this->lang, 'team'). '"' . ($this->name == 'team' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_team . '</a></li>
			<li><a href="'. makeURLSegm($this->lang, 'portfolio', array('office', 0)). '"' . ($this->name == 'portfolio' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_portfolio . '</a></li>
			<li><a href="'. makeURLSegm($this->lang, 'partners'). '"' . ($this->name == 'partners' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_partners . '</a></li>
			<li><a href="'. makeURLSegm($this->lang, 'contact'). '"' . ($this->name == 'contact' ? ' class="but_pressed"' : '') . 
				'>' . $this->dbContent->menu_contact . '</a></li>
		</ul>';
		// . (isset($this->error) ? '<div class="error">'.$this->error . '</div>' : '') .
		
		$this->appendLanguageLinks();
		
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
		if ($this->dbContent->getProjectsCount('office')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('office', 0)). '">'
				. $this->dbContent->project_category_office. '</a></li>';
		if ($this->dbContent->getProjectsCount('residential')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('residential', 0)). '">'
				. $this->dbContent->project_category_residential. '</a></li>';
		if ($this->dbContent->getProjectsCount('commercial')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('commercial', 0)). '">'
				. $this->dbContent->project_category_commercial. '</a></li>';
		if ($this->dbContent->getProjectsCount('industrial')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('industrial', 0)). '">'
				. $this->dbContent->project_category_industrial. '</a></li>';
		if ($this->dbContent->getProjectsCount('hotel')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('hotel', 0)). '">'
				. $this->dbContent->project_category_hotel. '</a></li>';
		if ($this->dbContent->getProjectsCount('hospital')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('hospital', 0)). '">'
				. $this->dbContent->project_category_hospital. '</a></li>';
		if ($this->dbContent->getProjectsCount('restoration')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('restoration', 0)). '">'
				. $this->dbContent->project_category_restoration. '</a></li>';
		if ($this->dbContent->getProjectsCount('other')) 
			$this->content .= '<li><a href="'
				. makeURLSegm($this->lang, 'portfolio', array('other', 0)). '">'
				. $this->dbContent->project_category_other. '</a></li>';
		$this->content .= '</ul></p><p>Copyright &copy; 2011, S.C. Deteco S.R.L. | Webmaster and Designer: <a href="'. makeURLSegm($this->lang, 'contact'). '#calin-burloiu">Cãlin-Andrei Burloiu</a></p>
	</div>';
	}
	
	/**
	 * Returns HTML script tags which include .js file or opens them inline if
	 * are less then 1KiB.
	 */
	public function getJs()
	{
		$content = '';
		
		foreach($this->scripts as $script)
		{
			$script = 'js/'. $script;
			$size = filesize($script);
			//$content .= '<script>/* '. $script. '
//' . file_get_contents($script). '*/</script>';
			if ($size === FALSE)
				continue;
			if ($size > 1024)
				//$content .= '<script type="text/javascript" async="async" src="/'. $script . '"></script>';
				$content .= 
					'<script type="text/javascript" async="async">
	var headId = document.getElementsByTagName("head")[0];
	var node = document.createElement("script");
	node.type = "text/javascript";
	node.async = true;
	node.src = "/'. $script . '";
	headId.appendChild(node);
	</script>';
			else
				$content .= '<script type="text/javascript" async="async">'. file_get_contents($script)
					. '</script>';
		}
			
		return $content;
	}
	
	/**
	 * Returns HTML link tags which include .css file (or inline stylesheets
	 * for .css files which are less than 1KiB **in future**).
	 */
	public function getCss()
	{
		$content = '';
		
		foreach($this->styles as $style)
			$content .= '<link href="/css/'. $style . '" rel="stylesheet" type="text/css" />';
			
		return $content;
	}
	
	public function display()
	{
		// TODO: set charset!
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>' . $this->title . '</title>
<meta name="keywords" content="deteco,design,engineering,installations,constructions,buildings,sanitary,fire,detection,fighting,ventilation,electrical" />
<meta name="description" content="'. $this->description .'" />';
		echo $this->getCss();
		echo $this->getJs();
			
		// ** GOOGLE ANALYTICS
		echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24847246-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
		
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
