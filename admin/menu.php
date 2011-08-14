<?php
require_once('admin_config.inc.php');
if (!ADMIN_ENABLED)
{
	die('Interfata de administrare este dezactivata.');
}?>
<div class="menu"><a href="index.php">Home</a> | <a href="list.php">Listează proiectele</a> | <a href="edit.php">Adaugă proiect</a></div>
