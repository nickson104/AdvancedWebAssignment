<?php
namespace Main\List;

require_once 'Object.php';
require_once 'Config.php';
require_once 'ListFilter.php';

use \Main\BasicObject;


abstract class DataList extends BasicObject
{
	private $_tableName;
	private $_select = "Select * from ";
	private $_filter;
    private $_data;
	
    public function __construct(string $tableName)
    {
		$this->_tableName = $tableName;
		
        $this->_data = $data;
    }
	
    public function GetData()
    {
		$sql = $this->_select + $this->_tableName;
		
		$result = mysqli_query($conn, $sql);
		
        $this->_data = $result;
    }
	
	
    public function Filter()
    {
        
    }
}

class DisplayTable extends DisplayList
{
    public function __construct($data)
    {
        parent::__construct($data);
    }
	
    // Override the abstract method
    public function Show()
    {
        echo "<table border=1>";	
        foreach($this->Data as $item)
        {
            echo "<tr><td>".htmlentities($item)."</td></tr>";
        }
        echo "</table>";	
    }
}

?>
