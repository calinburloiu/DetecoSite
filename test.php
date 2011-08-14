<?php

//header( "HTTP/1.1 301 Moved Permanently" );
//header('Location: /deteco/test2.php');

if (isset($_COOKIE['language']))
	echo $_COOKIE['language'];
else
	echo 'no cookie';