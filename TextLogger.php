<?php
namespace Interfaces;
require_once "BasicObject.php";
require_once "Ilogger.php";

use \Interfaces\Ilogger;
use \Main\BasicObject;


class TextLogger extends BasicObject implements ILogger
{
	private $_userName;
	
    public function __construct($userName)
    {
        $this->_userName = $userName;
    }

	
	public function LogAccess()
	{
		$date = date('Y-m-d H:i:s');
		//Write Access Details To Text File
		file_put_contents("UserAccessLog", "$this->_userName logged in at $date\r\n", FILE_APPEND | LOCK_EX);
	}
	
	public function LogSearch($table, $filter)
	{
		file_put_contents("SearchLog", "$this->_userName searched the $table table for".str_replace("Where", "", $filter)."\r\n", FILE_APPEND | LOCK_EX);
	}
}


?>