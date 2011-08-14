<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>Upload Log</title>
</head>

<body>

<?php
require_once('admin_config.inc.php');
if (!ADMIN_ENABLED)
{
	die('Interfata de administrare este dezactivata.');
}

	if(isset($_FILES['file']))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			$filename = $_FILES['file']['name'];

			/*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";*/
			if (file_exists($filename))
			{
				echo $filename . " already exists!";
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
					'../images/portfolio/'.$filename);
				//echo "Stored in: " . "upload-log/" . $filename;
				echo "Thank you for uploading the log file.";
			}
		}
	}
	else
	{
?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<br />
		<input type="file" name="file" id="file" />
		<br />
		<input type="submit" name="submit" value="Upload" />
	</form>
<?php
	}
?>

</body>
</html>
