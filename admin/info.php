<?php 
require_once('admin_config.inc.php');
if (!ADMIN_ENABLED)
{
	die('Interfata de administrare este dezactivata.');
}

phpinfo();