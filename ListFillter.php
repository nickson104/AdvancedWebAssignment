<?php
namespace Main\List;

require_once Object.php;

use \Main\BasicObject;	

class Filter extends BasicObject
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

	public function GetFilterSQL
	{
		switch ($this->$_filterColumnType)
		{
			case "String":
				return "$_filterColumn like '%$_filterValue%'";
			break;
			case "Number":
			case "Bool":
				return "$_filterColumn = %$_filterValue%";
			break;
			default:
				return "";
			break;
		}
	}
}


?>