<?php
namespace Main;

require_once 'ListFilter.php';
require_once 'ListAction.php';

use \Main\ListFilter;


class DataList
{
	private $_conn;
	private $_tableName;
	private $_identityColumn;
	private $_select = "Select * from ";
	private $_filter;
    private $_data;
	private $_actions = [];
	
    public function __construct($tableName, $identityColumn,  $conn)
    {
		$this->_tableName = $tableName;
		$this->_identityColumn = $identityColumn;
		$this->_conn = $conn;
    }
	
    public function GetData()
    {
		$sql = $this->_select.$this->_tableName.$this->_filter;
		
		$result = mysqli_query($this->_conn, $sql);
		echo "$sql";
        $this->_data = $result;
		$this->Display();
    }
	
	public function GetDataManualSQL($sql)
	{
		$result = mysqli_query($this->_conn, $sql);
		echo "$sql";
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
						echo "<th>".htmlentities($key)."</th>";
					}
					echo "</tr>";
				}
				echo "<tr>";
				foreach ($item as $key => $value) {
					echo "<td>".htmlentities($value)."</td>";
					if($key === $this->_identityColumn)
					{
						$identity = $value;
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
