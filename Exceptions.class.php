<?php
error_reporting(E_ALL | E_STRICT);

class BasicException extends Exception
{
	protected $name = 'Error';
	
	public function emailException($msg)
	{
		if(EMAIL_EXCEPTION)
		{
			$to = EMAIL_EXCEPTION;
			$subject = SITE_NAME. ' site Exception';
			$from = "site@deteco.ro";
			$headers = "From: " . $from;
			
			$msg .= '<br />URL: ' . getURL(array());
			
			mail($to,$subject,$msg,$headers);
		}
	}
	
	public function errorMessage()
	{
		$msg = $this->name ." '".$this->getMessage()."'";
		
		if(DEBUG)
		{
			$msg .= " in ".$this->getFile()
				. " on line ".$this->getLine().": ";
		}
		
		return $msg;
	}
}

class PHPException extends Exception
{
	protected $name = "PHP Error";

	public function errorMessage()
	{
		$msg = $msgDebug = parent::errorMessage();

		$err = error_get_last();
		if(!empty($err))
		{
			$msgDebug .= "<b>An error of type ". $err['type']. " ocurred in file '".
				$err['file']. "', line ". $err['line']. ": <i>".
				$err['message']. "</i></b>";
		}
		
		$this->emailException($msgDebug);
		
		if(DEBUG)
			return $msgDebug;

		return $msg;
	}
}

class DBException extends BasicException 
{
	protected $name = 'Database Error';
	
	public function errorMessage()
	{
		$msg = $msgDebug = parent::errorMessage();
		
		switch($this->getMessage())
		{
		case 'connect':
			$msgDebug .= "<b>".mysqli_connect_error()."</b>";
			break;
		case 'query':
			$conn = SingletonDB::connect();
			$msgDebug .= "<b>".mysqli_error($conn)."</b>";
			break;
		default:
			$msgDebug .= "<b>Unknown error.</b>";
		}
		
		$this->emailException($msgDebug);
		
		if(DEBUG)
			return $msgDebug;
		
		return $msg;
	}
}

class FileUploadException extends BasicException
{
	protected $name = 'File Upload Error';
	
	public function errorMessage()
	{
		$msg = parent::errorMessage();
		
		$error_types = array(
			-1=>'The file already exists on the server.',
			0=>'There is no error, the file uploaded with success.',
			1=>'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
			'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
			'The uploaded file was only partially uploaded.',
			'No file was uploaded.',
			6=>'Missing a temporary folder.',
			'Failed to write file to disk.',
			'A PHP extension stopped the file upload.'
			);
		
		$msg .= "<b>". $error_types[intval($this->getMessage())]. "</b>";
		
		$this->emailException($msg);

		return $msg;
	}
}

?>
