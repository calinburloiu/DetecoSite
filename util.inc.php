<?php
require_once('Exceptions.class.php');

function getURL($extraParams = array())
{
	$params = array_merge($_GET, $extraParams);
	
	$tokens = explode("?", $_SERVER['REQUEST_URI']);
	$url = $tokens[0];
	
	if(!empty($params))
	{
		$url .= "?";
		foreach($params as $key => $value)
		{
			$url .= "$key=$value&";
		}
		$url = substr($url, 0, -1);
	}
	
	return $url;
}

function makeURLSegm($lang, $page, $params = array())
{
	$url = "/$lang/$page";
	
	if (count($params) > 0)
	{
		foreach ($params as $param)
			$url .= "/$param";
	}
	
	return $url;
}

function getProjectURL($id, $tags)
{
	// without mod_rewrite.
	//return "project.php?id=" . $id;
	
	return "project/$id/$tags";
}

function getThumbFileName($img)
{
	$ext = strrchr($img, '.');
	$basename = substr($img, 0, strpos($img, $ext));
	$thumb = "${basename}_thumb${ext}";
	
	return $thumb;
}

function deleteImage($img)
{
	// Delete image files from the server.
	try {
		if(!unlink('../images/portfolio/'. $img))
			throw new PHPException(null);
		if(!unlink('../images/portfolio/'. getThumbFileName($img)))
			throw new PHPException(null);
	}
	catch(PHPException $e) {
		echo $e->errorMessage();
	}
}