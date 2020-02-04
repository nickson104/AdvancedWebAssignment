<?php

require_once 'ILogger.php';

use \Main\BasicObject, \main\Interfaces\ILogger

class TextLogger extends BasicObject implements ILogger
{
	public function LogAccess()
	{
		//Write Access Details To Text File
	}
}


?>