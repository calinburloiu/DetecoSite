<?php
require_once('admin_config.inc.php');
require_once('../Content.class.php');
require_once('../SimpleImage.class.php');
require_once('../util.inc.php');
define('PICTS_PER_PRJ', 4);
error_reporting(E_ALL | E_STRICT);

if (!ADMIN_ENABLED)
{
	die('Interfata de administrare este dezactivata.');
}

// id from URL.
if(isset($_GET['id']))
	$id = $_GET['id'];
else if(isset($_POST['id']))
	$id = $_POST['id'];
else
	$id = null;
$dbContent = new Content('common');
$languages = $dbContent->getLanguages();

// Submited form
if(isset($_POST['submited']))
{
	$project['name'] = $_POST['name'];
	$project['category_code'] = $_POST['category_code'];
	$project['tags'] =  urlencode(str_replace(' ', '-', 
				trim($_POST['tags'])));
	$project['address'] = $_POST['address'];
	$project['developer'] = $_POST['developer'];
	$project['chief_architect'] = $_POST['chief_architect'];
	$project['whole_area'] = (empty($_POST['whole_area']) ? 'NULL' : $_POST['whole_area']);
	$project['height'] = $_POST['height'];
	$project['phase'] = $_POST['phase'];
	$project['year_begin'] = (empty($_POST['year_begin']) ? 'NULL' : $_POST['year_begin']);
	$project['year_end'] = (empty($_POST['year_end']) ? 'NULL' : $_POST['year_end']);
	
	foreach($languages as $code => $value)
	{
		$project['descriptions'][$code] = stripslashes($_POST['description_'. $code]);
	}
	
	// Adding old images and deleting some of them if necessary.
	if(isset($_POST['default_img']))
		$project['images'][] = $_POST['default_img'];
	for($i = 0; $i < PICTS_PER_PRJ; $i++)
	{
		if(isset($_POST["img_$i"]) && !isset($_POST["del_$i"]) 
				&& $_POST["img_$i"] != $_POST['default_img'])
			$project['images'][] = $_POST["img_$i"];
		if(!isset($_POST["del_$i"]))
			continue;

		// Delete image files from the server.
		deleteImage($_POST["del_$i"]);
	}

	// Uploading images if necessary
	try {
	foreach($_FILES as $file)
	{
		if($file['error'] == 4)
			continue;
		if($file['error'] != 0)
			throw new FileUploadException($file['error']);
		
		// Save the image to the server.
		$filename = $file['name'];
		if (file_exists('../images/portfolio/'. $filename))
			throw new FileUploadException(-1);
		else
		{
			move_uploaded_file($file["tmp_name"],
				'../images/portfolio/'. $filename);
				
			// Create image's thumbnail.
			$thumbImg = new SimpleImage();
			$thumbImg->load('../images/portfolio/'. $filename);
			$thumbImg->saveThumbnail('../images/portfolio/'.
				getThumbFileName($filename), 128, 96);
		}

		// Put image information in DB.
		$project['images'][] = $file['name'];
	}
	} 
	catch(FileUploadException $e) {
		echo $e->errorMessage();
	}
	
	// Updating DB
	if($id == null)
	{
		Content::insertProject($project);
	}
	else
	{
		Content::updateProject($id, $project);
	}
	
	// Redirect to projects listing.
	header('Location: list.php');
	//die();
}
// Form before submit
else
{
	// No id => empty fields
	if($id == null)
	{
		$project['name'] = '';
		$project['category_code'] = 'office';
		$project['tags'] = '';
		$project['address'] = '';
		$project['developer'] = '';
		$project['chief_architect'] = '';
		$project['whole_area'] = '';
		$project['height'] = '';
		$project['phase'] = '';
		$project['year_begin'] = '';
		$project['year_end'] = '';
		foreach($languages as $code => $value)
		{
			$project['descriptions'][$code] = '';
		}
		$project['images'] =  array();
	}
	// Complete the fields with data from DB.
	else
	{
		$project = $dbContent->getProject($id, true);

		// Strip slashes
		//foreach($project['descriptions'] as $code => $description)
		//	$project['descriptions'][$code] = stripslashes($description);
	}
}

//
// Before submit
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Adăugare/ Editare Proiect</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
	include('menu.php');

	if($id == null)
		echo "<h1>Adăugare proiect</h1>";
	else
		echo "<h1>Editare proiect</h1>";

	echo '<div class="mandatory">* Câmp obligatoriu.</div>
	<div class="mandatory">** Trebuie încărcată cel puțin o imagine.</div>';

	echo '<form action="edit.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="submited" id="submited" />
	';
	
	if($id)
		echo '<input type="hidden" name="id" id="id" value="'. $id. '" />';
	
	echo '
	<p><label for="name">Nume clădire: <br /></label>
	<input type="text" name="name" id="name" value="'. $project['name']. '" class="long-field" /><span class="mandatory">*</span></p>
	
	<p><label for="category_code">Categorie: <br /></label>
	<select name="category_code" id="category_code">
		<option value="office"'. 
			($project['category_code']=='office' ? ' selected="selected"' : ''). '>Birouri</option>
		<option value="residential"'. 
			($project['category_code']=='residential' ? ' selected="selected"' : ''). '>Rezidențial</option>
		<option value="hotel"'. 
			($project['category_code']=='hotel' ? ' selected="selected"' : ''). '>Hotel</option>
		<option value="industrial"'. 
			($project['category_code']=='industrial' ? ' selected="selected"' : ''). '>Industrial</option>
		<option value="commercial"'. 
			($project['category_code']=='commercial' ? ' selected="selected"' : ''). '>Comercial</option>
		<option value="restoration"'. 
			($project['category_code']=='restoration' ? ' selected="selected"' : ''). '>Restaurări</option>
		<option value="hospital"'. 
			($project['category_code']=='hospital' ? ' selected="selected"' : ''). '>Spitale</option>
		<option value="other"'. 
			($project['category_code']=='other' ? ' selected="selected"' : ''). '>Diverse</option>
	</select></p>
	
	<p><label for="tags">Tag-uri: <br />(Tag-urile sunt cuvinte formate din litere sau cifre și trebuie separate de spații sau cratime.)<br /></label>
	<input type="text" name="tags" id="tags" value="'. $project['tags']. '" class="long-field" /><span class="mandatory">*</span></p>
	
	<p><label for="address">Adresă: <br /></label>
	<input type="text" name="address" id="address" value="'. $project['address']. '" class="long-field" /><span class="mandatory">*</span></p>
	
	<p><label for="developer">Dezvoltator: <br /></label>
	<input type="text" name="developer" id="developer" value="'. $project['developer']. '" class="long-field" /><span class="mandatory">*</span></p>
	
	<p><label for="chief_architect">Proiectant general: <br /></label>
	<input type="text" name="chief_architect" id="chief_architect" value="'. $project['chief_architect']. '" class="long-field" /><span class="mandatory">*</span></p>
	
	<p><label for="whole_area">Suprafață desfășurată (m&sup2;): <br /></label>
	<input type="text" name="whole_area" id="whole_area" value="'. $project['whole_area']. '" /><span class="mandatory">*</span></p>
	
	<p><label for="height">Regim de înălțime: <br /></label>
	<input type="text" name="height" id="height" value="'. $project['height']. '" /><span class="mandatory">*</span></p>
	
	<p><label for="phase">Fază: <br /></label>
	<input type="text" name="phase" id="phase" value="'. $project['phase']. '" /><span class="mandatory">*</span></p>
	
	<p><label for="year_begin">Anul execuției: <br /></label>
	<input type="text" name="year_begin" id="year_begin" value="'. $project['year_begin']. '" /><span class="mandatory">*</span> - <input type="text" name="year_end" id="year_end" value="'. $project['year_end']. '" /></p>
	
	<p><label>Descriere: <br /></label><ul>
		';
	foreach($languages as $code => $value)
	{
		echo '<li><label for="description_'. $code. '">'. $value['name']. ': <br /></label>';
		echo '<textarea rows="8" cols="64" name="description_'. $code. '" id="description_'. 
			$code. '">'. 
			$project['descriptions'][$code]. '</textarea><span class="mandatory">*</span></li>
';
	}	
	echo '
	</ul></p>
	
	<p><label>Imagini: <br /></label><span class="mandatory">**</span><ol>
		';
	$count = 0;
	foreach($project['images'] as $img)
	{
		$thumb = getThumbFileName($img);
		
		echo '<li><input type="radio" name="default_img" value="'. $img. '" /><a href="../images/portfolio/'. $img. '" target="_black">'. 
			$img. '<br /><img src="../images/portfolio/'. $thumb. '" alt="'. $img. '" /></a> <input type="checkbox" name="del_'. $count. '" value="'. $img. '" />Șterge'.
			'<input type="hidden" name="img_'. $count. '" value="'. $img. '" /></li>
		';
		
		$count++;
	}
	for($i=0; $i < (PICTS_PER_PRJ - $count); $i++)
	{
		echo '<li><label for="file_'. $i. '">Încarcă fișier: </label><input type="file" name="file_'. $i. '" id="file_'. $i. '" />';
	}
	echo '
	</ol>
	
	<input type="submit" value="Trimite" />
</form>
';



?>

</body>
</html>
