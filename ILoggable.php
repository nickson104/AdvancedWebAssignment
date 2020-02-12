<?php
namespace Interfaces;

require_once "ILogger.php";

interface Iloggable
{
	public function Attach(Ilogger $logger);
	public function Detach(Ilogger $logger);
	public function LogAccess();
	public function LogSearch($table, $filter);
}
?>