<?php
require_once('util.inc.php');
?>


<?php
$to = "calin.burloiu@deteco.ro";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "site@deteco.ro";
$headers = "From: " . $from;
mail($to,$subject,$message,$headers);


?>
