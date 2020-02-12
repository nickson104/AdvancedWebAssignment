<?php
namespace Interfaces;
require_once "BasicObject.php";
require_once "ILoggable.php";

use \Main\BasicObject;

class Logger extends BasicObject implements ILoggable
{
	private $_observers = [];
	
	public function __construct()
	{
	}
	
	public function Attach(ILogger $observer)
	{
		$this->_observers[] = $observer;
	}
	
	public function Detach(ILogger $observer)
	{
		$index = array_search($observer, $this->_observers, true);
		if($index !== false)
		{
			array_splice($this->_observers, $index, 1);
		}
	}
	
	
	public function LogAccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->LogAccess();
		}
	}
	
	public function LogSearch($table, $filter)
	{
		foreach($this->_observers as $observer)
		{
			$observer->LogSearch($table, $filter);
		}
	}
}
?>