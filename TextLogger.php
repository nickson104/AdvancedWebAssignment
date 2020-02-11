<?php

require_once 'ILogger.php';

use \Main\BasicObject, \main\Interfaces\ILogger

class TextLogger extends BasicObject implements ILogger
{
	public function LogAccess($userName)
	{
		$date = date('Y-m-d H:i:s');
		//Write Access Details To Text File
		file_put_contents("UserAccessLog", "$userName logged in at $date")
	}
}


?>