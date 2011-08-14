<?php
require('Page.class.php');

class ArticlePage extends Page
{
	protected $title;
	protected $name = 'article';
	protected $lang;
	
	public function __construct($name)
	{
		parent::__construct();
		
		$this->name = $name;

		$this->dbContent = new Content('article');
		$this->lang = $this->dbContent->getCrtLanguage();
		
		// 301 Redirect
		if (!isset($_GET['lang']))
		{
			header('Cache-Control: no-store');
			header( "HTTP/1.1 301 Moved Permanently" );
			header('Location: '. makeURLSegm($this->lang, $name));
		}
		
		$this->title = $this->dbContent->getContent('menu_' . $this->name, $this->lang) .' - '. $this->dbContent->title;
		$this->description =  $this->dbContent->getContent('description_' . $this->name, $this->lang);

		//if(isset($_GET['lang'])
			//$this->lang = $_GET['lang'];
		//else
		//	$this->lang = "ro";
	}

	public function appendContent()
	{
		$this->append('
		<div class="content">');
		
		$opts = array( 
			'http' => array( 
				'method'=>"GET", 
				'header'=>"Content-Type: text/html; charset=utf-8" 
			) 
		); 
		$fn = "articles/".$this->name ."_".$this->lang .".html";
		$context = stream_context_create($opts);
		$fileContent = file_get_contents($fn, false, $context);
		$fileContent = mb_convert_encoding($fileContent, 'UTF-8', 'UTF-8');
		$this->append($fileContent);
		
		/*$articleContent = file("articles/".$this->name ."_".$this->lang .".html");
		foreach($articleContent as $line)
		{
			$this->append($line);
		}*/		
		
		$db = SingletonDB::connect();		
		
		$this->append('</div>');
	}
}

?>