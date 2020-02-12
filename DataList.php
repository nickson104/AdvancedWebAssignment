<?php
namespace Main;

require_once 'ListFilter.php';
require_once 'ListAction.php';
require_once "Logger.php";
require_once "TextLogger.php";

use \Interfaces\Logger;
use \Interfaces\TextLogger;
use \Main\ListFilter;

class DataList
{
	private $_currentUser;
	private $_conn;
	private $_tableName;
	private $_identityColumn;
	private $_select = "Select * from ";
	private $_filter = "";
    private $_data;
	private $_actions = [];
	private $_logger;
	
    public function __construct($currentUser, $tableName, $identityColumn,  $conn)
    {
		$this->_currentUser = $currentUser;
		$this->_tableName = $tableName;
		$this->_identityColumn = $identityColumn;
		$this->_conn = $conn;
		$this->_logger = new Logger();
		$this->_logger->attach(new TextLogger($username));
    }
	
    public function GetData()
    {
		$sql = $this->_select.$this->_tableName.$this->_filter;
		if($this->_filter != "")
		{
			$this->_logger->LogSearch($this->_tableName, $this->_filter);
		}
		$result = mysqli_query($this->_conn, $sql);
        $this->_data = $result;
		$this->Display();
    }
	
	public function GetDataManualSQL($sql)
	{
		$result = mysqli_query($this->_conn, $sql);
        $this->_data = $result;
		$this->Display();
	}
	
	
    public function BuildFilter($filters)
    {
		if(!empty($filters))
		{
			$this->_filter = " Where ";
			$i = 0;
			foreach ($filters as $filter)
			{
				$filterVal = $filter->GetFilterSQL();
				$this->_filter = $i > 0 ? "$this->_filter And $filterVal" : "$this->_filter $filterVal";
				$i+=1;
			}
		}
    }
	
	public function PopulateActions($actions)
	{
		$this->_actions = $actions;
	}
	
	
	private function Display()
	{
        echo "<table style='margin:20px' border=1>";	
		if(!empty($this->_data) && $this->_data->num_rows > 0)
		{
			$i = 0;
			foreach($this->_data as $item)
			{
				$identity;
				if($i == 0)
				{
					echo "<tr>";
					foreach ($item as $key => $value) {
						if($key !== "Id")
						{
							echo "<th>".htmlentities($key)."</th>";
						}
					}
					echo "</tr>";
				}
				echo "<tr>";
				foreach ($item as $key => $value) {
					if($key === $this->_identityColumn)
					{
						$identity = $value;
					}
					
					if($key !== "Id")
					{
						if($key === "Password"){
							echo "<td>".htmlentities(str_repeat("*", strlen($value)))."</td>";
						}
						else
						{
							echo "<td>".htmlentities($value)."</td>";
						}
					}		
				}
				foreach($this->_actions as $action)
				{
					$elem = $action->GetActionElement($identity);
					echo "<td>$elem</td>";
				}
				echo "</tr>";
				$i+=1;
			}
		}
		else
		{
			echo "<tr><td>No Results</td></tr>";
		}
        echo "</table>";	
	}
}
?>
