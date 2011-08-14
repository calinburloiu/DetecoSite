<?php
require_once('../Content.class.php');
require_once('admin_config.inc.php');
if (!ADMIN_ENABLED)
{
	die('Interfata de administrare este dezactivata.');
}

$dbContent = new Content('common');

if(isset($_GET['del']))
{
	$dbContent->deleteProject($_GET['del'], $dbContent->getProject($_GET['del']));

	header('Location: list.php');
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Listarea Proiectelor</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
	function del(id, name)
	{
		var r = confirm('Proiectul "' + name + '" va fi șters.');
		if(r)
			document.location = 'list.php?del=' + id;
	}
	function edit(id)
	{
		document.location = 'edit.php?id=' + id;
	}
//-->
</script>
</head>
<body>

<?php
include('menu.php');

// Category from URL.
if(isset($_GET['category']))
	$category = $_GET['category'];
else
	$category = "";

echo "<h1>Listarea Proiectelor</h1>";

?>
Categoria: <select name="cat" onchange="window.location = 'list.php?category=' + this.value">
	<option value="" <?php echo ($category=="" ? 'selected="selected"' : '') ?> >Toate categoriile</option>
	<option value="office" <?php echo ($category=="office" ? 'selected="selected"' : '') ?> >Birouri</option>
	<option value="residential" <?php echo ($category=="residential" ? 'selected="selected"' : '') ?> >Rezidențial</option>
	<option value="hotel" <?php echo ($category=="hotel" ? 'selected="selected"' : '') ?> >Hoteluri</option>
	<option value="industrial" <?php echo ($category=="industrial" ? 'selected="selected"' : '') ?> >Industrial</option>
	<option value="commercial" <?php echo ($category=="commercial" ? 'selected="selected"' : '') ?> >Comercial</option>
	<option value="restoration" <?php echo ($category=="restoration" ? 'selected="selected"' : '') ?> >Restaurări</option>
	<option value="hospital" <?php echo ($category=="hospital" ? 'selected="selected"' : '') ?> >Spitale</option>
	<option value="other" <?php echo ($category=="other" ? 'selected="selected"' : '') ?> >Diverse</option>
</select>

<?php

// Lista de proiecte
$summary = $dbContent->getPortfolioSummary($category, null, true);
echo '<table><tr><th>Nr. crt.</th><th>Anul</th><th>Denumirea</th><th>Categoria</th><th>Opțiuni</th><th></th></tr>';
$i = 1;
$alt = 0;
foreach($summary as $prjId => $prj)
{
	echo "<tr". ($alt ? ' class="alt"': ''). "><td>$i</td><td>"
		. $prj['year_begin']. "</td><td>". $prj['name']
		. '</td><td>'. $prj['category']. '</td><td><input type="button" value="Editează" '
		. 'onclick="edit('. $prjId. ')" /> '
		//. '<a href="#" onclick="del('. $prjId. ', \''. $prj['name']. '\')">[Ștergere]</a></td></tr>';
		. '<input type="button" value="Șterge" onclick="del('
		. $prjId. ', \''. $prj['name']. '\')" /></td>'
		. '<td>'. ($prj['incomplete'] ? '<span class="incomplete">Incomplet</span>' : '')
		. '</td></tr>';
	$i++;
	$alt = ($alt + 1) % 2;
}

echo '</table>';

?>

</body>
</html>
<?php
}
?>
