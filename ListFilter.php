<?php
namespace Main;

require_once 'BasicObject.php';

use \Main\BasicObject;



class ListFilter extends BasicObject
{
	private $_filterColumn;
	private $_filterColumnType;
	private $_filterValue;
	
    public function __construct($filterColumn, $filterColumnType, $filterValue)
    {
        $this->_filterColumn = $filterColumn;
		$this->_filterColumnType = $filterColumnType;
        $this->_filterValue = $filterValue;
    }

	public function GetFilterSQL ()
	{
		switch ($this->_filterColumnType)
		{
			case "StringStrict":
				return "$this->_filterColumn = '$this->_filterValue'";
			break;
			case "String":
				return "$this->_filterColumn like '%$this->_filterValue%'";
			break;
			case "Number":
			case "Bool":
				return "$this->_filterColumn = $this->_filterValue";
			break;
			default:
				return "";
			break;
		}
	}
}


?>