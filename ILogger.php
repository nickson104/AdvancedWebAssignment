<?php
namespace Interfaces;

interface ILogger
{
	public function LogAccess();
	public function LogSearch($table, $filter);

}


?>